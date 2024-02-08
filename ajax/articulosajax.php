<?php
$className = "articulos";
$model = "../modelo/". $className ."_model.php";
$controller = "../controlador/". $className ."_controller.php";
require_once($model);
require_once($controller);

$cl = new articulosModelo();  //Instanciamiento de clase...

if (!empty($_POST))
{
	session_start(); 

	$proceso = (isset($_POST['proceso'])) ? $_POST['proceso'] : '';
	$id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $datos = $_POST;

    switch ($proceso) {
		case 'get': // consultar registros
            $cl->get();
            break;
        case 'get_id': // consultar registros por id
            $cl->get_id($id);
            break;
        case 'get_id_productos': // consultar registros por id
            $cl->get_id_productos($id);
            break;
        case 'guardar': // guardar
			$cl->guardar($datos);
			break;
        case 'modificar': // modificar
            $cl->modificar($datos);
            break;
        case 'eliminar': // eliminar
            $cl->eliminar($id);
            break;
        case 'listado_productos': // listado_productos
            $cl->listado_productos();
            break;
		default:
			$data = "Error";
			echo json_encode($data);
			break;
	}
}
?>