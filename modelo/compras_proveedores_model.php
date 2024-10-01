<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class comprasProveedorModel extends Conexion
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

    public static function guardar($datos)
    {
        $dbconec = Conexion::Conectar();
        $fact = new comprasProveedorModel();

        try {
            $datos = $datos['datos'];

            $proveedor = $datos["proveedor"];
            $vendedor = $datos["vendedor"];
            $transporte = $datos["transporte"];
            $sucursal = $datos["sucursal"];
            $bodega = $datos["bodega"];
            $tipo_movimiento = $datos["tipo_movimiento"];
            $fecha = $datos["fecha"];
            $info_tipo_movimiento = $datos["info_tipo_movimiento"];
            $documento = $datos['documento'];
            $orden = $datos['orden'];
            $remision = $datos['remision'];
            $nota = $datos["nota"];
            $valor_parcial = isset($datos["valor_parcial"]) ? $datos["valor_parcial"] : 0;
            $detalles = $datos["detalles"];

            if (
                isset($proveedor, $vendedor, $transporte, $sucursal, $bodega, $tipo_movimiento, $fecha, $info_tipo_movimiento, $orden, $remision, $documento, $nota, $valor_parcial)
                && !empty($proveedor) && !empty($vendedor) && !empty($transporte) && !empty($sucursal) && !empty($bodega)
                && !empty($tipo_movimiento) && !empty($info_tipo_movimiento) && !empty($orden) && !empty($remision) && !empty($documento)
                && !empty($nota) && !empty($fecha)
            ) {

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO compras_proveedores (fecha, tipo_movimiento, nit, sucursal, info_tipo_movimiento, documento, bodega_afectada, vendedor, 
                    transporte, numero_orden, remision, nota, valor_parcial) VALUES 
                (:fecha, :tipo_movimiento, :nit, :sucursal, :info_tipo_movimiento, :documento, :bodega_afectada, :vendedor, :transporte, 
                :numero_orden, :remision, :nota, :valor_parcial)";
                $stmt = $dbconec->prepare($query);

                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':tipo_movimiento', $tipo_movimiento);
                $stmt->bindParam(':nit', $proveedor);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':info_tipo_movimiento', $info_tipo_movimiento);
                $stmt->bindParam(':documento', $documento);
                $stmt->bindParam(':bodega_afectada', $bodega);
                $stmt->bindParam(':vendedor', $vendedor);
                $stmt->bindParam(':transporte', $transporte);
                $stmt->bindParam(':numero_orden', $orden);
                $stmt->bindParam(':remision', $remision);
                $stmt->bindParam(':nota', $nota);
                $stmt->bindParam(':valor_parcial', $valor_parcial);
                $stmt->execute();
                $ultimoIdInsertado = $dbconec->lastInsertId();

                if ($ultimoIdInsertado) {

                    foreach ($detalles as $key) {

                        // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                        $query = "INSERT INTO det_compras_proveedores (id_compras_proveedores, codigo, descripcion, cantidad, vlr_unitario, vlr_unitario_final, vlr_parcial) 
                        VALUES (:id_compras_proveedores, :codigo, :descripcion, :cantidad, :vlr_unitario, :vlr_unitario_final, :vlr_parcial)";
                        $stmt = $dbconec->prepare($query);
                        $stmt->bindParam(':id_compras_proveedores', $ultimoIdInsertado);
                        $stmt->bindParam(':codigo', $key['codigo']);
                        $stmt->bindParam(':descripcion', $key['descripcion']);
                        $stmt->bindParam(':cantidad', $key['cant']);
                        $stmt->bindParam(':vlr_unitario', $key['vlrUnitario']);
                        $stmt->bindParam(':vlr_unitario_final', $key['vlrUnitFinal']);
                        $stmt->bindParam(':vlr_parcial', $key['vlrParcial']);
                        $stmt->execute();

                        // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                        $valor_promedio = $key['vlrParcial'] / $key['cant'];
                        $query = "UPDATE tbarticulos SET uxemp=uxemp+{$key['cant']}, ctoult=$valor_promedio, pv1=$valor_promedio WHERE codigo=:codigo";
                        $stmt = $dbconec->prepare($query);
                        $stmt->bindParam(':codigo', $key['codigo']);
                        $stmt->execute();
                    }

                    $id_encriptado = $fact->encryptID($ultimoIdInsertado, 'clave_secreta');
                    $response = array('status' => 'success', 'message' => 'Factura liquidada correctamente.', 'id' => $id_encriptado);
                } else {
                    $response = array('status' => 'error', 'message' => 'Error al guardar la factura');
                }

                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Error al guardar la factura, por favor llenar todos los datos.');
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error " . $e;
            echo json_encode($data);
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

    function encryptID($id, $key)
    {
        $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
        return base64_encode($encrypted);
    }
} // Fin de la clase
