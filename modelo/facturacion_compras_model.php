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
            $detalles = $datos["detalles"];

            if (isset($datos)) {

                // Supongamos que los datos vienen en un array llamado $datos
                // Preparamos los arrays para almacenar campos y valores
                $columns_table_1 = [];
                $placeholders_table_1 = [];
                $values_table_1 = [];

                // Iteramos sobre todos los datos recibidos en $datos (puede ser $_POST)
                foreach ($datos as $key => $value) {
                    // Verificar si el valor no está vacío y no es "detalles"
                    if (!empty($value) && $key !== "detalles") {
                        $columns_table_1[] = $key; // Guardar el nombre de la columna
                        $placeholders_table_1[] = '?'; // Añadir un marcador de posición para la consulta preparada
                        $values_table_1[] = $value; // Guardar el valor
                    }
                }

                // Convertir los arrays en cadenas para la consulta SQL
                $columns_str_table_1 = implode(", ", $columns_table_1);
                $placeholders_str_table_1 = implode(", ", $placeholders_table_1);

                // Preparar la consulta SQL
                $sql = "INSERT INTO facturas_compras ($columns_str_table_1) VALUES ($placeholders_str_table_1)";

                // Preparar la declaración
                $stmt = $dbconec->prepare($sql);

                // Ejecutar la declaración pasando directamente los valores
                $stmt->execute($values_table_1);

                // Obtener el ID de la factura recién insertada
                $facturas_compras_id = $dbconec->lastInsertId();

                // Ejecutar la declaración pasando directamente los valores
                if ($facturas_compras_id) {

                    // Inserción de los detalles
                    $detalles_columns = ['facturas_compras_id', 'codigo', 'descripcion', 'um', 'cant', 'vlr_unitario', 'descuento', 'imp', 'vlr_total'];
                    $detalles_placeholders = implode(", ", array_fill(0, count($detalles_columns), '?')); // Marcadores de posición
                    $detalles_sql = "INSERT INTO detalles_facturas_compras (" . implode(", ", $detalles_columns) . ") VALUES ($detalles_placeholders)";

                    // Preparar la declaración para los detalles
                    $detalle_stmt = $dbconec->prepare($detalles_sql);

                    // Iterar sobre los detalles y ejecutar la inserción
                    foreach ($detalles as $detalle) {
                        // Crear un array de valores para cada detalle
                        $detalle_values = [
                            $facturas_compras_id, // ID de la factura
                            $detalle['codigo'],
                            $detalle['descripcion'],
                            $detalle['um'],
                            $detalle['cant'],
                            $detalle['vlr_unitario'],
                            $detalle['desc'],
                            $detalle['imp'],
                            $detalle['vlr_total']
                        ];

                        // Ejecutar la inserción
                        $detalle_stmt->execute($detalle_values);

                        // // Realiza la inserción en la base de datos (ajusta diaso según tu configuración)
                        // $valor_promedio = $key['vlrParcial'] / $key['cant'];
                        // $query = "UPDATE tbarticulos SET uxemp=uxemp+{$key['cant']}, ctoult=$valor_promedio, pv1=$valor_promedio WHERE codigo=:codigo";
                        // $stmt = $dbconec->prepare($query);
                        // $stmt->bindParam(':codigo', $key['codigo']);
                        // $stmt->execute();
                    }

                    $id_encriptado = $fact->encryptID($facturas_compras_id, 'clave_secreta');
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