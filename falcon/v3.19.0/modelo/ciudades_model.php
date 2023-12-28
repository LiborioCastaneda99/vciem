<?php
	require_once('../modelo/Conexion.php');  // Se carga la clase conexion

    class ciudadesModel extends Conexion
    {

        public static function get()
        {
            $dbconec = Conexion::Conectar();
            
            try {
                $query = "SELECT `id`, `codigo`, `nombre`, `resum`, `activo`, `created_at` FROM `tbciudades` WHERE activo = 1";
                $stmt = $dbconec->prepare($query);
                $stmt->execute();
            
                // Obtener todos los resultados como un array asociativo
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                if ($rows) {
                    // Devolver el array JSON con todos los ciudad
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
                $query = "SELECT `id`, `codigo`, `nombre`, `resum`, `activo`, `created_at` FROM `tbciudades` WHERE id = $id AND activo = 1";
                $stmt = $dbconec->prepare($query);
                $stmt->execute();
            
                // Obtener todos los resultados como un array asociativo
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                if ($rows) {
                    // Devolver el array JSON con todos los ciudad
                    echo json_encode($rows);
                } else {
                    $data = "No hay ciudad";
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
                $nombre = $datos['nombre'];
                $resumen = $datos['resumen'];

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO tbciudades (`codigo`, `nombre`, `resum`) VALUES (:codigo, :nombre, :resumen)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':resumen', $resumen);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Ciudad guardada exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar la ciudad');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);

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
                $nombre = $datos['nombre'];
                $resumen = $datos['resumen'];
                $id = $datos['id'];

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE tbciudades SET codigo=:codigo, nombre=:nombre, resum=:resumen WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':resumen', $resumen);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Ciudad modificada exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la ciudad');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);

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
                $query = "UPDATE tbciudades SET activo=:activo WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':activo', $activo);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Ciudad eliminada exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al eliminar la ciudad');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);

            } catch (Exception $e) {
                $data = "Error";
                echo json_encode($data);
            }
        }
        
    } // Fin de la clase
?>