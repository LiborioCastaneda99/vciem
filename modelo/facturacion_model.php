<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class facturacionModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT id, codigo, nombre, dir, tel, nit FROM tbnombod WHERE activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbnombods
                echo json_encode($rows);
            } else {

                $data = "";
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function get_id($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT id, codigo, nombre, dir, tel, nit FROM tbnombod WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbnombods
                echo json_encode($rows);
            } else {
                $data = "No hay nombods";
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function consultar_factura_espera($datos)
    {
        $dbconec = Conexion::Conectar();

        try {

            $cliente = $datos['cliente'];

            $query = "SELECT id, cliente, factura, consecutivo, atiende, caja, total, descuentos, subtotal, nota 
            FROM ventas_espera 
            WHERE cliente = :cliente AND espera = 1 ORDER BY id DESC LIMIT 1";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':cliente', $cliente);
            $stmt->execute();
            $resp_venta = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resp_venta) {

                $venta_id = $resp_venta['id'];
                $query = "SELECT id, venta_id, codigo, descripcion, um, cantidad As cant, vlr_unitario, 
                descuento As 'desc', vlr_descuento, vlr_unit_final, REPLACE(impuesto, '%', '') AS imp, vlr_impuesto, vlr_parcial 
                FROM detalle_ventas_espera 
                WHERE venta_id = :venta_id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':venta_id', $venta_id);
                $stmt->execute();
                $resp_detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response['venta'] = $resp_venta;
                $response['detalle'] = $resp_detalle;
                $response['status'] = 'success';

                // Obtener todos los resultados como un array asociativo
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'No hay facturas en espera.');
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function guardar($datos)
    {
        $dbconec = Conexion::Conectar();
        $fact = new facturacionModel();

        try {

            // $datos = json_decode($_POST['datos'], true);

            $datos = $datos['datos'];
            $cliente = $datos["cliente"];
            $factura = $datos["factura"];
            $consecutivo = $datos["consecutivo"];
            $atiende = $datos["atiende"];
            $bodega = $datos["bodega"];
            $caja = $datos["caja"];
            $total = $datos["total"];
            $nota = $datos["nota"];
            $subtotal = $datos["subtotal"];
            $descuentos = $datos["descuentos"];
            $detalles = $datos['detalles'];
            $fac_efecti = $datos['fac_efecti'];
            $fac_tdebit = $datos['fac_tdebit'];
            $fac_tcredi = $datos['fac_tcredi'];
            $fac_tchequ = $datos['fac_tchequ'];
            $fac_tvales = $datos['fac_tvales'];
            $fac_tcambi = $datos['fac_tcambi'];

            if (
                isset($cliente, $factura, $consecutivo, $atiende, $bodega, $caja, $total, $subtotal, $descuentos)
                && !empty($cliente) && !empty($factura) && !empty($consecutivo) && !empty($atiende)
                && !empty($caja) && !empty($total) && !empty($subtotal) && !empty($descuentos)
            ) {

                foreach ($detalles as $d) {

                    // Obtener la cantidad disponible del producto desde la base de datos (esto es solo un ejemplo)
                    $cantidad_disponible = $fact->obtenerCantidadDisponible($d['codigo']);
                    $cantidad_disponible_espera = $fact->obtenerCantidadDisponibleEspera($cliente, $d['codigo']);
                    $total_disponible = $cantidad_disponible + $cantidad_disponible_espera;
                    // Verificar si hay suficientes cantidades disponibles
                    if ($total_disponible >= $d['cant']) {

                        if ($cantidad_disponible_espera > 0) {
                            // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                            $query = "UPDATE tbarticulos SET uxemp=uxemp+$cantidad_disponible_espera WHERE codigo=:codigo";
                            $stmt = $dbconec->prepare($query);
                            $stmt->bindParam(':codigo', $d['codigo']);
                            $stmt->execute();
                        }

                        // Realizar la operación, como procesar el pedido, restar la cantidad del inventario, etc.
                        // $response = array('status' => 'error', 'message' => 'Lo sentimos, no hay suficiente cantidad disponible de este producto.');
                    } else {
                        // Mostrar un mensaje de error al usuario
                        $response = array('status' => 'error', 'message' => 'Lo sentimos, no hay suficiente cantidad disponible de este producto,
                        solo hay disponible: ' . $total_disponible . ' unidades, para el producto con el código: ' . $d['codigo'] . '.');
                        echo json_encode($response);
                        return;
                    }
                }

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO ventas (cliente, factura, consecutivo, atiende, bodega, caja, total, descuentos, subtotal, nota) VALUES (:cliente, :factura, :consecutivo, :atiende, :bodega, :caja, :total, :descuentos, :subtotal, :nota)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':cliente', $cliente);
                $stmt->bindParam(':factura', $factura);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->bindParam(':atiende', $atiende);
                $stmt->bindParam(':bodega', $bodega);
                $stmt->bindParam(':caja', $caja);
                $stmt->bindParam(':total', $total);
                $stmt->bindParam(':nota', $nota);
                $stmt->bindParam(':subtotal', $subtotal);
                $stmt->bindParam(':descuentos', $descuentos);
                $stmt->execute();
                $ultimoIdInsertado = $dbconec->lastInsertId();

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO pagos_ventas (id_ventas, fac_efecti, fac_tdebit, fac_tcredi, fac_tchequ, fac_tvales, fac_tcambi) 
                VALUES (:id_ventas, :fac_efecti, :fac_tdebit, :fac_tcredi, :fac_tchequ, :fac_tvales, :fac_tcambi)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id_ventas', $ultimoIdInsertado);
                $stmt->bindParam(':fac_efecti', $fac_efecti);
                $stmt->bindParam(':fac_tdebit', $fac_tdebit);
                $stmt->bindParam(':fac_tcredi', $fac_tcredi);
                $stmt->bindParam(':fac_tchequ', $fac_tchequ);
                $stmt->bindParam(':fac_tvales', $fac_tvales);
                $stmt->bindParam(':fac_tcambi', $fac_tcambi);
                $stmt->execute();

                foreach ($detalles as $key) {

                    // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                    $query = "INSERT INTO detalle_ventas (venta_id, codigo, descripcion, um, cantidad, vlr_unitario, descuento, vlr_descuento, vlr_unit_final, impuesto, vlr_impuesto, vlr_parcial) 
                    VALUES (:venta_id, :codigo, :descripcion, :um, :cantidad, :vlr_unitario, :descuento, :vlr_descuento, :vlr_unit_final, :impuesto, :vlr_impuesto, :vlr_parcial)";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':venta_id', $ultimoIdInsertado);
                    $stmt->bindParam(':codigo', $key['codigo']);
                    $stmt->bindParam(':descripcion', $key['descripcion']);
                    $stmt->bindParam(':um', $key['um']);
                    $stmt->bindParam(':cantidad', $key['cant']);
                    $stmt->bindParam(':vlr_unitario', $key['vlrUnitario']);
                    $stmt->bindParam(':descuento', $key['desc']);
                    $stmt->bindParam(':vlr_descuento', $key['vlrDesc']);
                    $stmt->bindParam(':vlr_unit_final', $key['vlrUnitFinal']);
                    $stmt->bindParam(':impuesto', $key['imp']);
                    $stmt->bindParam(':vlr_impuesto', $key['vlrImp']);
                    $stmt->bindParam(':vlr_parcial', $key['vlrParcial']);
                    $stmt->execute();

                    // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                    $query = "UPDATE tbarticulos SET uxemp=uxemp-{$key['cant']} WHERE codigo=:codigo";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':codigo', $key['codigo']);
                    $stmt->execute();
                }

                // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                $query = "UPDATE consecutivo SET proceso=0, espera=0 WHERE consecutivo=:consecutivo";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->execute();

                // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                $query = "UPDATE ventas_espera SET espera=0 WHERE consecutivo=:consecutivo";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->execute();

                if ($stmt->execute()) {
                    // $fact->actualizarVentaEspera($cliente, '+');
                    $id_encriptado = $fact->encryptID($ultimoIdInsertado, 'clave_secreta');

                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Se ha registrado la factura correctamente, imprimir tu factura aquí. <br> 
                    <a href="pdfs/generar_pdf_pos.php?id=' . $id_encriptado . '" target="_blank">En formato tirilla POS.</a> <br>
                    <a href="pdfs/generar_factura_carta.php?id=' . $id_encriptado . '" target="_blank">En formato carta.</a>');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar la factura');
                }

                // Devuelve la respudiasa en formato JSON
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Error al guardar la factura, por favor llenar todos los datos.');
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error ".$e;
            echo json_encode($data);
        }
    }

    // Función para encriptar el ID
    function encryptID($id, $key)
    {
        $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
        return base64_encode($encrypted);
    }

    public static function guardar_factura_espera($datos)
    {
        $dbconec = Conexion::Conectar();
        $fact = new facturacionModel();

        try {

            // $datos = json_decode($_POST['datos'], true);

            $datos = $datos['datos'];
            $cliente = $datos["cliente"];
            $factura = $datos["factura"];
            $consecutivo = $datos["consecutivo"];
            $atiende = $datos["atiende"];
            $bodega = $datos["bodega"];
            $caja = $datos["caja"];
            $total = $datos["total"];
            $nota = $datos["nota"];
            $subtotal = $datos["subtotal"];
            $descuentos = $datos["descuentos"];
            $detalles = $datos['detalles'];

            if (
                isset($cliente, $factura, $consecutivo, $atiende, $bodega, $caja, $total, $subtotal, $descuentos)
                && !empty($cliente) && !empty($factura) && !empty($consecutivo) && !empty($atiende)
                && !empty($caja) && !empty($total) && !empty($subtotal) && !empty($descuentos)
            ) {

                foreach ($detalles as $d) {

                    // Obtener la cantidad disponible del producto desde la base de datos (esto es solo un ejemplo)
                    $cantidad_disponible = $fact->obtenerCantidadDisponible($d['codigo']);

                    // Verificar si hay suficientes cantidades disponibles
                    if ($cantidad_disponible >= $d['cant']) {
                        // Realizar la operación, como procesar el pedido, restar la cantidad del inventario, etc.
                        // $response = array('status' => 'error', 'message' => 'Lo sentimos, no hay suficiente cantidad disponible de este producto.');
                    } else {
                        // Mostrar un mensaje de error al usuario
                        $response = array('status' => 'error', 'message' => 'Lo sentimos, no hay suficiente cantidad disponible de este producto,
                        solo hay disponible: ' . $cantidad_disponible . ' unidades, para el producto con el código: ' . $d['codigo'] . '.');
                        echo json_encode($response);
                        return;
                    }
                }

                // actualizamos el consecutivo que tenga en espera
                $fact->actualizarVentaEspera($cliente);

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO ventas_espera (cliente, factura, consecutivo, atiende, bodega, caja, total, descuentos, subtotal, nota) VALUES (:cliente, :factura, :consecutivo, :atiende, :bodega, :caja, :total, :descuentos, :subtotal, :nota)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':cliente', $cliente);
                $stmt->bindParam(':factura', $factura);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->bindParam(':atiende', $atiende);
                $stmt->bindParam(':bodega', $bodega);
                $stmt->bindParam(':caja', $caja);
                $stmt->bindParam(':total', $total);
                $stmt->bindParam(':nota', $nota);
                $stmt->bindParam(':subtotal', $subtotal);
                $stmt->bindParam(':descuentos', $descuentos);
                $stmt->execute();
                $ultimoIdInsertado = $dbconec->lastInsertId();

                foreach ($detalles as $key) {

                    // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                    $query = "INSERT INTO detalle_ventas_espera (venta_id, codigo, descripcion, um, cantidad, vlr_unitario, descuento, vlr_descuento, vlr_unit_final, impuesto, vlr_impuesto, vlr_parcial) 
                    VALUES (:venta_id, :codigo, :descripcion, :um, :cantidad, :vlr_unitario, :descuento, :vlr_descuento, :vlr_unit_final, :impuesto, :vlr_impuesto, :vlr_parcial)";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':venta_id', $ultimoIdInsertado);
                    $stmt->bindParam(':codigo', $key['codigo']);
                    $stmt->bindParam(':descripcion', $key['descripcion']);
                    $stmt->bindParam(':um', $key['um']);
                    $stmt->bindParam(':cantidad', $key['cant']);
                    $stmt->bindParam(':vlr_unitario', $key['vlrUnitario']);
                    $stmt->bindParam(':descuento', $key['desc']);
                    $stmt->bindParam(':vlr_descuento', $key['vlrDesc']);
                    $stmt->bindParam(':vlr_unit_final', $key['vlrUnitFinal']);
                    $stmt->bindParam(':impuesto', $key['imp']);
                    $stmt->bindParam(':vlr_impuesto', $key['vlrImp']);
                    $stmt->bindParam(':vlr_parcial', $key['vlrParcial']);
                    $stmt->execute();

                    // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                    $query = "UPDATE tbarticulos SET uxemp=uxemp-{$key['cant']} WHERE codigo=:codigo";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':codigo', $key['codigo']);
                    $stmt->execute();
                }

                // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                $query = "UPDATE consecutivo SET espera=1 WHERE consecutivo=:consecutivo";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':consecutivo', $consecutivo);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Se ha registrado la factura en espera correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar la factura');
                }

                // Devuelve la respudiasa en formato JSON
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Error al guardar la factura, por favor llenar todos los datos.');
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    // Función para obtener la cantidad disponible de un producto específico
    function obtenerCantidadDisponible($producto_id)
    {
        // Conexión a la base de datos (debes completar con tus propios detalles de conexión)
        $dbconec = Conexion::Conectar();

        // Consulta SQL para obtener la cantidad disponible del producto
        $query = "SELECT uxemp As  cantidad_disponible FROM tbarticulos WHERE codigo = :codigo AND activo = 1";
        $stmt = $dbconec->prepare($query);
        $stmt->bindParam(':codigo', $producto_id);
        $stmt->execute();

        // Obtiene el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo un resultado
        if ($result['cantidad_disponible'] > 0) {
            // Obtener el resultado como un arreglo asociativo

            // Obtener y devolver la cantidad disponible del producto
            return $result['cantidad_disponible'];
        } else {
            // Si no se encontró ninguna fila, devolver 0 (o cualquier valor que desees en caso de no encontrar el producto)
            return 0;
        }
    }

    // Función para obtener la cantidad disponible de un producto específico
    function obtenerCantidadDisponibleEspera($cliente, $codigo)
    {
        // Conexión a la base de datos (debes completar con tus propios detalles de conexión)
        $dbconec = Conexion::Conectar();
        error_log("cliente => " . $cliente);
        error_log("codigo => " . $codigo);

        // Consulta SQL para obtener los consecutivos de ventas esperadas
        $query = "SELECT id, consecutivo FROM ventas_espera WHERE cliente = :cliente AND espera = 1 AND activo = 1";
        $stmt = $dbconec->prepare($query);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        $cantidad = 0;
        // Verificar si se obtuvo algún resultado
        if ($rows > 0) {
            // Realizar la actualización en la base de datos
            // foreach ($rows as $value) {

            // Consulta SQL para obtener los consecutivos de ventas esperadas
            $venta_id = $rows['id'];
            $query = "SELECT id, codigo, cantidad FROM detalle_ventas_espera WHERE venta_id = :venta_id AND codigo = :codigo";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':venta_id', $venta_id);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $resp_detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resp_detalle as $valor) {
                // $codigo = $valor['codigo'];
                $cantidad += $valor['cantidad'];
            }
            // }
            error_log("cantidad => " . $cantidad);
            // Devolver true si se actualizaron los registros
            return $cantidad;
        } else {
            // Devolver false si no se encontraron registros para actualizar
            return $cantidad;
        }



        // Consulta SQL para obtener la cantidad disponible del producto
        $query = "SELECT uxemp As  cantidad_disponible FROM tbarticulos WHERE codigo = :codigo AND activo = 1";
        $stmt = $dbconec->prepare($query);
        $stmt->bindParam(':codigo', $producto_id);
        $stmt->execute();

        // Obtiene el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo un resultado
        if ($result['cantidad_disponible'] > 0) {
            // Obtener el resultado como un arreglo asociativo

            // Obtener y devolver la cantidad disponible del producto
            return $result['cantidad_disponible'];
        } else {
            // Si no se encontró ninguna fila, devolver 0 (o cualquier valor que desees en caso de no encontrar el producto)
            return 0;
        }
    }

    // Función para obtener la cantidad disponible de un producto específico
    function actualizarVentaEspera($cliente)
    {
        // Conexión a la base de datos (debes completar con tus propios detalles de conexión)
        $dbconec = Conexion::Conectar();

        // Consulta SQL para obtener los consecutivos de ventas esperadas
        $query = "SELECT id, consecutivo FROM ventas_espera WHERE cliente = :cliente AND espera = 1 AND activo = 1";
        $stmt = $dbconec->prepare($query);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo algún resultado
        if ($rows) {
            // Realizar la actualización en la base de datos
            foreach ($rows as $value) {
                $consecutivo = $value['consecutivo'];
                $query = "UPDATE consecutivo SET espera = 0 WHERE consecutivo = :consecutivo AND espera = 1 AND proceso = 1";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->execute();

                // se actualzia la factura principal
                $id = $value['id'];
                $query = "UPDATE ventas_espera SET espera = 0 WHERE id = :id AND espera = 1";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                // Consulta SQL para obtener los consecutivos de ventas esperadas
                $venta_id = $value['id'];
                $query = "SELECT id, codigo, cantidad FROM detalle_ventas_espera WHERE venta_id = :venta_id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':venta_id', $venta_id);
                $stmt->execute();
                $resp_detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resp_detalle as $valor) {
                    $codigo = $valor['codigo'];
                    $cantidad = $valor['cantidad'];

                    // Se suman los registros
                    $query = "UPDATE tbarticulos SET uxemp=uxemp-$cantidad WHERE codigo=:codigo";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->execute();
                }
            }

            // Devolver true si se actualizaron los registros
            return true;
        } else {
            // Devolver false si no se encontraron registros para actualizar
            return false;
        }
    }

    public static function modificar($datos)
    {
        $dbconec = Conexion::Conectar();

        try {

            $codigo = $datos['codigo'];
            $nombre = $datos['nombre'];
            $direccion = $datos['direccion'];
            $telefono = $datos['telefono'];
            $nit = $datos['nit'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM tbnombod WHERE id = :id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM tbnombod WHERE codigo = :codigo";
                $stmt = $dbconec->prepare($queryC);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->execute();
                // Obtiene el resultado
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica si el código ya existe
                if ($result['count'] > 0) {
                    $response = array('status' => 'error', 'message' => 'El código ya existe en la base de datos.');
                    echo json_encode($response);
                } else {
                    // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                    $query = "UPDATE tbnombod SET codigo=:codigo, nombre=:nombre, dir=:direccion, tel=:telefono, nit=:nit WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':telefono', $telefono);
                    $stmt->bindParam(':nit', $nit);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'El nombod se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar el nombod.');
                    }

                    // Devuelve la respudiasa en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                $query = "UPDATE tbnombod SET codigo=:codigo, nombre=:nombre, dir=:direccion, tel=:telefono, nit=:nit WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':nit', $nit);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'El nombod se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar el nombod.');
                }

                // Devuelve la respudiasa en formato JSON
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function eliminar($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $activo = 0;
            // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
            $query = "UPDATE tbnombod SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'nombod eliminado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar el nombod.');
            }

            // Devuelve la respudiasa en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function combo_caja($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbnombod where id=:id";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbnombod ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbnombod WHERE nombre like :nombre or codigo like :nombre ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':nombre', '%' . $search . '%', PDO::PARAM_STR);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    //Variable en array para ser procesado en el ciclo foreach
                    $lstResult = $stmt->fetchAll();
                }
            }
            $response = array();
            // Leer los datos de MySQL

            foreach ($lstResult as $result) {
                $response[] = array(
                    "id" => $result['id'],
                    "text" => $result['codigo'] . " - " . $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }

    public static function combo_factura($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, resumen, nombre FROM tipo_facturas where id=:id";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, resumen, nombre FROM tipo_facturas ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, resumen, nombre FROM tipo_facturas WHERE nombre like :nombre or resumen like :nombre ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':nombre', '%' . $search . '%', PDO::PARAM_STR);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    //Variable en array para ser procesado en el ciclo foreach
                    $lstResult = $stmt->fetchAll();
                }
            }
            $response = array();
            // Leer los datos de MySQL

            foreach ($lstResult as $result) {
                $response[] = array(
                    "id" => $result['id'],
                    "text" => $result['resumen'] . " - " . $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }
} // Fin de la clase
