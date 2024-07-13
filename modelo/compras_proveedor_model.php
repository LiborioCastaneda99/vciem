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
            $plazo = $datos["plazo"];
            $documento = $datos['documento'];
            $orden = $datos['orden'];
            $remision = $datos['remision'];
            $nota = $datos["nota"];
            // $total = $datos["total"];

            if (
                isset($proveedor, $vendedor, $transporte, $sucursal, $bodega, $tipo_movimiento, $fecha, $plazo, $orden, 
                    $remision, $documento, $nota)
                && !empty($proveedor) && !empty($vendedor) && !empty($transporte) && !empty($sucursal) && !empty($bodega)
                && !empty($tipo_movimiento) && !empty($plazo) && !empty($orden) && !empty($remision) && !empty($documento)
                && !empty($nota) && !empty($fecha)
            ) {


                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO ventas (fecha, tipo_movimiento, nit, sucursal, plazo, documento, bodega_afectada, vendedor, transporte, 
                    proveedor, remision, orden, total, descuentos, subtotal, numero_orden, remision, nota) VALUES 
                    (:fecha,:tipo_movimiento,:nit,:sucursal,:plazo,:documento,:bodega_afectada,:vendedor,:transporte,:numero_orden,:remision, :nota)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':nit', $proveedor);
                $stmt->bindParam(':vendedor', $vendedor);
                $stmt->bindParam(':transporte', $transporte);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':bodega_afectada', $bodega);
                $stmt->bindParam(':tipo_movimiento', $tipo_movimiento);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':plazo', $plazo);
                $stmt->bindParam(':documento', $documento);
                $stmt->bindParam(':numero_orden', $orden);
                $stmt->bindParam(':remision', $remision);
                $stmt->bindParam(':nota', $nota);
                // $stmt->execute();
                $ultimoIdInsertado = $dbconec->lastInsertId();

                if ($stmt->execute()) {
                    // $fact->actualizarVentaEspera($cliente, '+');
                    $id_encriptado = $fact->encryptID($ultimoIdInsertado, 'clave_secreta');
                    $response = array('status' => 'success', 'message' => 'Guardò bien', 'id' => $id_encriptado);

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
