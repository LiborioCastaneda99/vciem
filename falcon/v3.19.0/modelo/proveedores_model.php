<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class proveedoresModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `suc`, `zona`, `subzona`, `nombre`, `dir`, `tel1`, 
            `tel2`, `ciudad`, `cupo`, `legal`, `fecha_ini`, `forma_pago`, `correo`, `caract_dev`, 
            `digito`, `riva`, `rfte`, `rica`, `estado` FROM proveedores WHERE activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los proveedores
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
            $query = "SELECT `id`, `codigo`, `suc`, `zona`, `subzona`, `nombre`, `dir`, `tel1`, 
            `tel2`, `ciudad`, `cupo`, `legal`, `fecha_ini`, `forma_pago`, `correo`, `caract_dev`, 
            `digito`, `riva`, `rfte`, `rica`, `estado` FROM proveedores WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los proveedores
                echo json_encode($rows);
            } else {
                $data = "No hay proveedor";
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

        try {
            $codigo = $datos['codigo'];
            $suc = $datos['suc'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $dir = $datos['dir'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $fpago = $datos['fpago'];
            $correo = $datos['correo'];
            $caract_dev = $datos['caract_dev'];
            $digito = $datos['digito'];
            $riva = $datos['riva'];
            $rfte = $datos['rfte'];
            $rica = $datos['rica'];
            $estado = $datos['estado'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM proveedores WHERE codigo = :codigo";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();

            // Obtiene el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica si el código ya existe
            if ($result['count'] > 0) {
                $response = array('status' => 'error', 'message' => 'El código ya existe en la base de datos');
                echo json_encode($response);
            } else {

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO proveedores (codigo, suc, zona, subzona, nombre, dir, tel1, 
                tel2, ciudad, cupo, legal, fecha_ini, forma_pago, correo, caract_dev, 
                digito, riva, rfte, rica, estado) VALUES (:codigo, :suc, :zona, :subzona, :nombre,
                :dir, :tel1, :tel2, :ciudad, :cupo, :legal, :fecha_ini, :fpago, :correo, :caract_dev, :digito, 
                :riva, :rfte, :rica, :estado)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':suc', $suc);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':dir', $dir);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':fpago', $fpago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La proveedor se ha guardado correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el color');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function modificar($datos)
    {
        $dbconec = Conexion::Conectar();

        try {

            $codigo = $datos['codigo'];
            $suc = $datos['suc'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $dir = $datos['dir'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $fpago = $datos['fpago'];
            $correo = $datos['correo'];
            $caract_dev = $datos['caract_dev'];
            $digito = $datos['digito'];
            $riva = $datos['riva'];
            $rfte = $datos['rfte'];
            $rica = $datos['rica'];
            $estado = $datos['estado'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM proveedores WHERE codigo=:codigo";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();

            // Obtiene el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica si el código ya existe
            if ($result['count'] > 0) {
                $response = array('status' => 'error', 'message' => 'El código ya existe en la base de datos.');
                echo json_encode($response);
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE proveedores SET codigo=:codigo, suc=:suc, zona=:zona, subzona=:subzona, nombre=:nombre, 
                dir=:dir, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, cupo=:cupo, legal=:legal, fecha_ini=:fecha_ini, 
                forma_pago=:fpago, correo=:correo, caract_dev=:caract_dev, digito=:digito, riva=:riva, rfte=:rfte, rica=:rica, 
                estado=:estado WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':suc', $suc);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':dir', $dir);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':fpago', $fpago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La proveedor se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la proveedor.');
                }

                // Devuelve la respuesta en formato JSON
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
            // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
            $query = "UPDATE proveedores SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'proveedor eliminada exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar la proveedor.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }
} // Fin de la clase
