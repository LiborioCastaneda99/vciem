<?php
	require_once('../modelo/Conexion.php');  // Se carga la clase conexion

	class loginModel extends Conexion
	{
		public static function Restaurar_Password($usuario, $contrasena)
	{
		$dbconec = Conexion::Conectar();
		try {
			$query = "update ofh_usuarios set fld_clave=md5('" . $contrasena . "') where fld_codusuario='" . $usuario . "'";
			$stmt = $dbconec->prepare($query);
			if ($stmt->execute()) {
				$data = "Validado";
				echo json_encode($data);
			} else {

				$data = "Error";
				echo json_encode($data);
			}

			$dbconec = null;
		} catch (Exception $e) {
			$data = "Error";
			echo json_encode($data);
		}
	}


	public static function Login_Usuario($datos)
	{
		$dbconec = Conexion::Conectar();
		$usuario = $datos["usuario"];
		$password = $datos["password"];
		try {
			$hash_md5 = md5($password);

			$query = "SELECT fld_codusuario,fld_nomusuario,fld_iconsecutivo 
			FROM user 
			WHERE fld_nomusuario='" . $usuario . "' and fld_clave='" . $hash_md5 . "'";
			// echo $query;
			$stmt = $dbconec->prepare($query);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// error_log("row => ".json_encode($row));
			if ($row) {
				$_SESSION['user_id'] = $row['fld_iconsecutivo'];
				$_SESSION['user_name'] = $row['fld_nomusuario'];
				$_SESSION['user_cod'] = $row['fld_codusuario'];
				$_SESSION['user_tipo'] = '1'; // $row['tipo_usuario'];
				$_SESSION['user_empleado'] = $row['fld_nomusuario'];
				session_start();

				$data = "Validado";

				// die();
				echo json_encode($data);
			} else {
				$data = "Usuario no existe o la contraseña esta errada, verifique";
				echo json_encode($data);
			}
		} catch (Exception $e) {
			$data = "Error";
			echo json_encode($data);
		}
	}

	public static function get_color()
	{
		$dbconec = Conexion::Conectar();
		
		try {
			$query = "SELECT `codigo`, `descripcion` FROM colores";
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
	

	public static function guardar_color($datos)
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
	
	} // Fin de la clase
?>