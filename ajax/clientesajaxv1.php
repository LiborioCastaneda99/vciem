<?php
$className = "clientes";
$model = "../modelo/" . $className . "_model_v1.php";
$controller = "../controlador/" . $className . "_controller_v1.php";
require_once($model);
require_once($controller);

$cl = new clientesModelo();  //Instanciamiento de clase...

if (!empty($_POST)) {
    session_start();

    $proceso = (isset($_POST['proceso'])) ? $_POST['proceso'] : '';
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';
    $datos = $_POST;

    switch ($proceso) {
        case 'get': // consultar registros
            $cl->get();
            break;
        case 'get_id': // consultar registros por id
            $cl->get_id($id);
            break;
            break;
        case 'get_cod': // consultar registros por id
            $cl->get_cod($codigo);
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
