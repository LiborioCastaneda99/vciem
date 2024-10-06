<?php
$className = "facturacion_compras";
$model = "../modelo/". $className ."_model.php";
$controller = "../controlador/". $className ."_controller.php";
require_once($model);
require_once($controller);

$cl = new comprasProveedorModelo();  //Instanciamiento de clase...

if (!empty($_POST))
{
	session_start(); 

	$proceso = (isset($_POST['proceso'])) ? $_POST['proceso'] : '';
	$id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';
    $nombre = (isset($_POST['searchTerm'])) ? $_POST['searchTerm'] : '';
    $datos = $_POST;
    
    switch ($proceso) {
		case 'get': // consultar registros
            $cl->get();
            break;
        case 'get_id': // consultar registros por id
            $cl->get_id($id);
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
		default:
			$data = "Error";
			echo json_encode($data);
			break;
	}
}
?>