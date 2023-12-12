<?php
	require_once('../modelo/Conexion.php');  // Se carga la clase conexion

    class colorModel extends Conexion
    {

        public static function get()
        {
            $dbconec = Conexion::Conectar();
            
            try {
                $query = "SELECT `id`, `codigo`, `descripcion` FROM colores WHERE activo = 1";
                $stmt = $dbconec->prepare($query);
                $stmt->execute();
            
                // Obtener todos los resultados como un array asociativo
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                if ($rows) {
                    // Devolver el array JSON con todos los colores
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
                $query = "SELECT `id`, `codigo`, `descripcion` FROM colores WHERE id = $id";
                $stmt = $dbconec->prepare($query);
                $stmt->execute();
            
                // Obtener todos los resultados como un array asociativo
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                if ($rows) {
                    // Devolver el array JSON con todos los colores
                    echo json_encode($rows);
                } else {
                    $data = "No hay colores";
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
                $descripcion = $datos['descripcion'];

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO colores (codigo, descripcion) VALUES (:codigo, :descripcion)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':descripcion', $descripcion);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Color guardado exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el color');
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
                $descripcion = $datos['descripcion'];
                $id = $datos['id'];

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE colores SET codigo=:codigo, descripcion=:descripcion WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':descripcion', $descripcion);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Color modificado exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar el color');
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
                $query = "UPDATE colores SET activo=:activo WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':activo', $activo);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'Color eliminado exitosamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al eliminar el color');
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