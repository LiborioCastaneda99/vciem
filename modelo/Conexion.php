<?php
// Desactivar visualización de errores en el navegador
ini_set('display_errors', 'Off');

// Configurar el nivel de error
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class Conexion
{

	public static function Conectar()
	{


		$driver = 'mysql'; //mysql no cambiar
		$host = 'localhost'; //localhost
		$dbname = 'vciem'; //bdd
		$username = 'root'; //usuario
		$passwd = ''; //contra

		$server = $driver . ':dbname=' . $dbname.';host=' . $host ;

		try {

			$conexion = new PDO($server, $username, $passwd);
			$conexion->exec("SET CHARACTER SET utf8");
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "<script>alert('AJCP :Conexión realizada Satisfactoriamente');</script>";

		} catch (Exception $e) {

			$conexion = null;
			echo '<span class="label label-danger label-block">ERROR AL CONECTARSE A LA BASE DE DATOS, PRESIONE F5</span>';
			exit();
		}


		return $conexion;

	}

}
?>