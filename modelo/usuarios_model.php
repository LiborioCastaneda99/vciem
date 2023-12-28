<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class usuariosModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();
        $dbconec->exec("SET CHARACTER SET utf8");

        try {
            $query = "SELECT U.fld_codusuario AS id, U.nombres As nombre, U.fld_nomusuario AS correo_electronico, R.id AS id_rol, R.nombre AS rol 
            FROM user U
            INNER JOIN roles R ON R.id  = U.rol_id
            WHERE U.activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbusuarios
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
        $dbconec->exec("SET CHARACTER SET utf8");

        try {
            $query = "SELECT U.fld_codusuario AS id, U.nombres As nombre, U.fld_nomusuario AS correo_electronico, R.id AS id_rol, R.nombre AS rol 
            FROM user U
            INNER JOIN roles R ON R.id  = U.rol_id
            WHERE U.activo = 1 AND U.fld_codusuario = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbusuarios
                echo json_encode($rows);
            } else {
                $data = "No hay usuarios";
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
        $local = new usuariosModel();
        try {
            $correo_electronico = $datos['correo_electronico'];
            $nombre = $datos['nombre'];
            $rol_id = $datos['lstRoles'];
            // Generar una contraseña segura de 8 caracteres
            $contraseñaGenerada = $local->generarContrasena();

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM user WHERE fld_nomusuario = :correo_electronico";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':correo_electronico', $correo_electronico);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // comparamos el codigo que llega y el que está
            if ($result['count'] > 0) {
                $response = array('status' => 'error', 'message' => 'El correo electronico ya existe en la base de datos.');
                echo json_encode($response);
            } else {

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO user (nombres, fld_nomusuario, fld_clave, fld_clave_sin_cifrar, rol_id) VALUES (:nombres, :correo_electronico, MD5(:clave), :nueva_clave, :rol_id)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':nombres', $nombre);
                $stmt->bindParam(':correo_electronico', $correo_electronico);
                $stmt->bindParam(':rol_id', $rol_id);
                $stmt->bindParam(':clave', $contraseñaGenerada);
                $stmt->bindParam(':nueva_clave', $contraseñaGenerada);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'El usuario se ha guardado correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el usuario');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    // Generar una contraseña aleatoria de 8 caracteres
    public static function generarContrasena()
    {
        // Definir caracteres permitidos en la contraseña
        $caracteresPermitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^*()-_';

        // Obtener la longitud del conjunto de caracteres permitidos
        $longitudCaracteres = strlen($caracteresPermitidos);

        // Inicializar la contraseña
        $contraseña = '';

        // Generar la contraseña aleatoria
        for ($i = 0; $i < 8; $i++) {
            $indiceAleatorio = rand(0, $longitudCaracteres - 1);
            $caracterAleatorio = $caracteresPermitidos[$indiceAleatorio];
            $contraseña .= $caracterAleatorio;
        }

        return $contraseña;
    }

    public static function modificar($datos)
    {
        $dbconec = Conexion::Conectar();
        $dbconec->exec("SET CHARACTER SET utf8");

        try {
            error_log(json_encode($datos));
            $codigo = $datos['codigo'];
            $nombre = $datos['nombre'];
            $correo_electronico = $datos['correo_electronico'];
            $rol_id = $datos['lstRoles'];
            $id = $datos['id'];

            // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
            $queryUdt = "UPDATE user SET nombres=:nombre, fld_nomusuario=:correo_electronico, rol_id=:rol_id WHERE fld_codusuario=:id";
            $stmt = $dbconec->prepare($queryUdt);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo_electronico', $correo_electronico);
            $stmt->bindParam(':rol_id', $rol_id);
            error_log(json_encode($stmt));

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'La usuarios se ha modificado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al modificar la usuarios.');
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
            $query = "UPDATE user SET activo=:activo WHERE fld_codusuario=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'Usuario eliminado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar el usuario.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function combo_roles($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id,nombre FROM roles where id=:codigo";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':codigo', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id,nombre FROM roles ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id,nombre FROM roles WHERE nombre like :nombre ORDER BY nombre LIMIT :limit";
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
                    "text" => $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }
} // Fin de la clase
