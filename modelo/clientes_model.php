<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class clientesModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `sucursal`, `zona`, `subzona`, `nombre`, `direc`, `tel1`,  `tel2`, 
            `ciudad` FROM tbclientes WHERE activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbclientes
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
            $query = "SELECT `id`, `codigo`, `sucursal`, `zona`, `subzona`, `nombre`, `direc`, `tel1`,  `tel2`, 
            `ciudad` FROM tbclientes WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbclientes
                echo json_encode($rows);
            } else {
                $data = "No hay clientes";
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
            $sucursal = $datos['sucursal'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $direc = $datos['direc'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM tbclientes WHERE codigo = :codigo";
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
                $query = "INSERT INTO tbclientes (codigo, sucursal, zona, subzona, nombre, direc, tel1, tel2) VALUES 
                (:codigo, :sucursal, :zona, :subzona, :nombre, :direc, :tel1, :tel2)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':direc', $direc);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);

                if ($stmt->execute()) {
                    $ultimoIdInsertado = $dbconec->lastInsertId();
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La cliente se ha guardado correctamente', 'id' => $ultimoIdInsertado);
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el cliente');
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
            $sucursal = $datos['sucursal'];
            $nombre = $datos['nombre'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $direc = $datos['direc'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM tbclientes WHERE id = :id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM tbclientes WHERE codigo = :codigo";
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
                    // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                    $query = "UPDATE tbclientes SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                    direc=:direc, tel1=:tel1, tel2=:tel2, ciudad=:ciudad WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':sucursal', $sucursal);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':zona', $zona);
                    $stmt->bindParam(':subzona', $subzona);
                    $stmt->bindParam(':direc', $direc);
                    $stmt->bindParam(':tel1', $tel1);
                    $stmt->bindParam(':tel2', $tel2);
                    $stmt->bindParam(':ciudad', $ciudad);
                    // $stmt->bindParam(':vendedor', $vendedor);
                    // $stmt->bindParam(':cupo', $cupo);
                    // $stmt->bindParam(':legal', $legal);
                    // $stmt->bindParam(':fecha_ini', $fecha_ini);
                    // $stmt->bindParam(':forma_pago', $forma_pago);
                    // $stmt->bindParam(':correo', $correo);
                    // $stmt->bindParam(':cod_viejo', $cod_viejo);
                    // $stmt->bindParam(':caract_dev', $caract_dev);
                    // $stmt->bindParam(':digito', $digito);
                    // $stmt->bindParam(':riva', $riva);
                    // $stmt->bindParam(':rfte', $rfte);
                    // $stmt->bindParam(':rica', $rica);
                    // $stmt->bindParam(':alma', $alma);
                    // $stmt->bindParam(':cali', $cali);
                    // $stmt->bindParam(':tipo', $tipo);
                    // $stmt->bindParam(':distri', $distri);
                    // $stmt->bindParam(':genom', $genom);
                    // $stmt->bindParam(':geema', $geema);
                    // $stmt->bindParam(':getel1', $getel1);
                    // $stmt->bindParam(':getel2', $getel2);
                    // $stmt->bindParam(':conom', $conom);
                    // $stmt->bindParam(':coema', $coema);
                    // $stmt->bindParam(':cotel1', $cotel1);
                    // $stmt->bindParam(':cotel2', $cotel2);
                    // $stmt->bindParam(':panom', $panom);
                    // $stmt->bindParam(':paema', $paema);
                    // $stmt->bindParam(':patel1', $patel1);
                    // $stmt->bindParam(':patel2', $patel2);
                    // $stmt->bindParam(':otnom', $otnom);
                    // $stmt->bindParam(':otema', $otema);
                    // $stmt->bindParam(':ottel1', $ottel1);
                    // $stmt->bindParam(':ottel2', $ottel2);
                    // $stmt->bindParam(':remis', $remis);
                    // $stmt->bindParam(':fbloq', $fbloq);
                    // $stmt->bindParam(':diaser', $diaser);
                    // $stmt->bindParam(':diater', $diater);
                    // $stmt->bindParam(':vlrarr', $vlrarr);
                    // $stmt->bindParam(':acta', $acta);
                    // $stmt->bindParam(':pacta', $pacta);
                    // $stmt->bindParam(':exclui', $exclui);
                    // $stmt->bindParam(':person', $person);
                    // $stmt->bindParam(':regime', $regime);
                    // $stmt->bindParam(':tipoid', $tipoid);
                    // $stmt->bindParam(':nomreg', $nomreg);
                    // $stmt->bindParam(':pais', $pais);
                    // $stmt->bindParam(':nom1', $nom1);
                    // $stmt->bindParam(':nom2', $nom2);
                    // $stmt->bindParam(':ape1', $ape1);
                    // $stmt->bindParam(':ape2', $ape2);
                    // $stmt->bindParam(':ofi', $ofi);
                    // $stmt->bindParam(':difici', $difici);
                    // $stmt->bindParam(':remval', $remval);
                    // $stmt->bindParam(':estado', $estado);
                    // $stmt->bindParam(':cono', $cono);
                    // $stmt->bindParam(':emailq', $emailq);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'La cliente se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la cliente.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE tbclientes SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                direc=:direc, tel1=:tel1, tel2=:tel2, ciudad=:ciudad WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':direc', $direc);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La cliente se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la cliente.');
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
            $query = "UPDATE tbclientes SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'cliente eliminado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar el cliente.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }
} // Fin de la clase
