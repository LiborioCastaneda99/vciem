<?php
$className = "login";
$model = "../modelo/". $className ."_model.php";
$controller = "../controlador/". $className ."_controller.php";
require_once($model);
require_once($controller);

$clLineas = new loginModelo();  //Instanciamiento de clase...

if (!empty($_POST))
{

	$proceso = (isset($_POST['proceso'])) ? $_POST['proceso'] : '';
	session_start(); 
    $datos = $_POST;

	switch($proceso){
		case 'restart':  // Agregar Registro
			$clLineas->Restaurar_Password($codigo,$nombre,$usrProcess,$usrFecha,$usrHora);
			break;
		case 'login': // Modificar Registro
			$clLineas->Login_Usuario($datos);
			break;
		case 'guardar_color': // Modificar Registro
			$clLineas->guardar_color($datos);
			break;
		case 'get_color': // Modificar Registro
			$clLineas->get_color();
			break;
		default:
			$data = "Error";
			echo json_encode($data);
			break;
	}
}
?>