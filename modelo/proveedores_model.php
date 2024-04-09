<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class proveedoresModel extends Conexion
{

    public static function get()
    {
        $conexion = Conexion::Conectar();
        try {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value


            // Configuración de las opciones de busqueda
            $searchArray = array();
            # Configuración del parametro de filtro 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = " AND (
                    P.codigo LIKE :codigo OR
                    P.suc LIKE :suc OR
                    S.nombre LIKE :zona OR
                    D.nombre LIKE :subzona OR
                    C.nombre LIKE :nombre OR
                    P.dir LIKE :dir OR
                    P.tel1 LIKE :tel1 OR
                    P.tel2 LIKE :tel2 OR
                    CS.nombre LIKE :ciudad OR
                    P.cupo LIKE :cupo OR
                    P.legal LIKE :legal OR
                    P.fecha_ini LIKE :fecha_ini OR
                    P.forma_pago LIKE :forma_pago OR
                    P.correo LIKE :correo OR
                    P.caract_dev LIKE :caract_dev OR
                    P.digito LIKE :digito OR
                    P.riva LIKE :riva OR
                    P.rfte LIKE :rfte OR
                    P.rica LIKE :rica OR
                    P.estado LIKE :estado
                )";
                $searchArray = array(
                    'codigo' => "%$searchValue%",
                    'suc'  => "%$searchValue%",
                    'zona'  => "%$searchValue%",
                    'subzona'  => "%$searchValue%",
                    'nombre'  => "%$searchValue%",
                    'dir'  => "%$searchValue%",
                    'tel1'  => "%$searchValue%",
                    'tel2'  => "%$searchValue%",
                    'ciudad'  => "%$searchValue%",
                    'cupo'  => "%$searchValue%",
                    'legal'  => "%$searchValue%",
                    'fecha_ini'  => "%$searchValue%",
                    'forma_pago'  => "%$searchValue%",
                    'correo'  => "%$searchValue%",
                    'caract_dev'  => "%$searchValue%",
                    'digito'  => "%$searchValue%",
                    'riva'  => "%$searchValue%",
                    'rfte'  => "%$searchValue%",
                    'rica'  => "%$searchValue%",
                    'estado'  => "%$searchValue%",
                );
            }

            ## Calcular el total numero de registros sin filtro
            $sql = "SELECT COUNT(*) ";
            $sql .= " AS allcount FROM proveedores";
            $sql .= " WHERE activo = 1";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            ## Total numero de registros con filtro
            $sql = "SELECT COUNT(*)";
            $sql .= " AS allcount FROM proveedores As P
            INNER JOIN tbzonas As S ON S.codigo = P.suc
            INNER JOIN tbzonas As D ON D.codigo = P.zona
            INNER JOIN tbsubzonas As C ON C.codigo = P.subzona AND C.zona = P.zona
            INNER JOIN tbciudades As CS ON CS.id = P.ciudad";
            $sql .= " WHERE P.activo = 1 " . $searchQuery . " ";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            ## Obetener los registros de la tabla.
            $sql = "SELECT P.id, P.codigo, S.nombre As suc, D.nombre As zona, C.nombre As subzona, P.nombre, P.dir, P.tel1, 
            P.tel2, CS.nombre AS ciudad, P.cupo, P.legal, P.fecha_ini, P.forma_pago, P.correo, P.caract_dev, 
            P.digito, P.riva, P.rfte, P.rica, P.estado 
            FROM proveedores As P
            INNER JOIN tbzonas As S ON S.codigo = P.suc
            INNER JOIN tbzonas As D ON D.codigo = P.zona
            INNER JOIN tbsubzonas As C ON C.codigo = P.subzona AND C.zona = P.zona
            INNER JOIN tbciudades As CS ON CS.id = P.ciudad
            ";
            $sql .= " WHERE P.activo = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);

            // Bind values
            foreach ($searchArray as $key => $search) {
                $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int) $row, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $rowperpage, PDO::PARAM_INT);
            $stmt->execute();
            $empRecords = $stmt->fetchAll();

            $data = array();

            foreach ($empRecords as $row) {

                # Los titulos de columnas colocados en el formulario deben corresponder exactamente con lo descrito aquí
                // definimos los botones con sus funciones
                $opEditar = "<button class='btn btn-outline-primary btn-sm me-1 mb-1' type='button' onclick=editar({$row['id']})>
                <span class='fas fa-edit me-1' data-fa-transform='shrink-3'></span></button>";
                $opEliminar = "<button class='btn btn-outline-primary btn-sm me-1 mb-1' type='button' onclick=eliminar({$row['id']})>
                <span class='fas fa-trash me-1' data-fa-transform='shrink-3'></span></button>";

                $data[] = array(
                    'codigo' => $row['codigo'],
                    'suc'  => $row['suc'],
                    'zona'  => $row['zona'],
                    'subzona'  => $row['subzona'],
                    'nombre'  => $row['nombre'],
                    'dir'  => $row['dir'],
                    'tel1'  => $row['tel1'],
                    'tel2'  => $row['tel2'],
                    'ciudad'  => $row['ciudad'],
                    'cupo'  => $row['cupo'],
                    'legal'  => $row['legal'],
                    'fecha_ini'  => $row['fecha_ini'],
                    'forma_pago'  => $row['forma_pago'],
                    'correo'  => $row['correo'],
                    'caract_dev'  => $row['caract_dev'],
                    'digito'  => $row['digito'],
                    'riva'  => $row['riva'],
                    'rfte'  => $row['rfte'],
                    'rica'  => $row['rica'],
                    'estado'  => $row['estado'],
                    'editar' => $opEditar,
                    'eliminar' => $opEliminar
                );
            }
            ## respuesta
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            # Devuelve la información al formulario
            echo json_encode($response);
            $conexion = NULL;
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }

    public static function get_id($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT id, codigo, suc, zona, subzona, nombre, dir, tel1, 
            tel2, ciudad, cupo, legal, fecha_ini, forma_pago, correo, caract_dev, 
            digito, riva, rfte, rica, estado FROM proveedores WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los proveedores
                echo json_encode($rows);
            } else {
                $data = "No hay proveedor";
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
            $suc = $datos['suc'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $dir = $datos['dir'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $fpago = $datos['fpago'];
            $correo = $datos['correo'];
            $caract_dev = $datos['caract_dev'];
            $digito = $datos['digito'];
            $riva = $datos['riva'];
            $rfte = $datos['rfte'];
            $rica = $datos['rica'];
            $estado = $datos['estado'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM proveedores WHERE codigo = :codigo";
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
                $query = "INSERT INTO proveedores (codigo, suc, zona, subzona, nombre, dir, tel1, 
                tel2, ciudad, cupo, legal, fecha_ini, forma_pago, correo, caract_dev, 
                digito, riva, rfte, rica, estado) VALUES (:codigo, :suc, :zona, :subzona, :nombre,
                :dir, :tel1, :tel2, :ciudad, :cupo, :legal, :fecha_ini, :fpago, :correo, :caract_dev, :digito, 
                :riva, :rfte, :rica, :estado)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':suc', $suc);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':dir', $dir);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':fpago', $fpago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La proveedor se ha guardado correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el color');
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
            $suc = $datos['suc'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $dir = $datos['dir'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $fpago = $datos['fpago'];
            $correo = $datos['correo'];
            $caract_dev = $datos['caract_dev'];
            $digito = $datos['digito'];
            $riva = $datos['riva'];
            $rfte = $datos['rfte'];
            $rica = $datos['rica'];
            $estado = $datos['estado'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM proveedores WHERE id = :id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM proveedores WHERE codigo = :codigo";
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
                    $query = "UPDATE proveedores SET codigo=:codigo, suc=:suc, zona=:zona, subzona=:subzona, nombre=:nombre, 
                dir=:dir, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, cupo=:cupo, legal=:legal, fecha_ini=:fecha_ini, 
                forma_pago=:fpago, correo=:correo, caract_dev=:caract_dev, digito=:digito, riva=:riva, rfte=:rfte, rica=:rica, 
                estado=:estado WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':suc', $suc);
                    $stmt->bindParam(':zona', $zona);
                    $stmt->bindParam(':subzona', $subzona);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':dir', $dir);
                    $stmt->bindParam(':tel1', $tel1);
                    $stmt->bindParam(':tel2', $tel2);
                    $stmt->bindParam(':ciudad', $ciudad);
                    $stmt->bindParam(':cupo', $cupo);
                    $stmt->bindParam(':legal', $legal);
                    $stmt->bindParam(':fecha_ini', $fecha_ini);
                    $stmt->bindParam(':fpago', $fpago);
                    $stmt->bindParam(':correo', $correo);
                    $stmt->bindParam(':caract_dev', $caract_dev);
                    $stmt->bindParam(':digito', $digito);
                    $stmt->bindParam(':riva', $riva);
                    $stmt->bindParam(':rfte', $rfte);
                    $stmt->bindParam(':rica', $rica);
                    $stmt->bindParam(':estado', $estado);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'La proveedor se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la proveedor.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE proveedores SET codigo=:codigo, suc=:suc, zona=:zona, subzona=:subzona, nombre=:nombre, 
            dir=:dir, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, cupo=:cupo, legal=:legal, fecha_ini=:fecha_ini, 
            forma_pago=:fpago, correo=:correo, caract_dev=:caract_dev, digito=:digito, riva=:riva, rfte=:rfte, rica=:rica, 
            estado=:estado WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':suc', $suc);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':dir', $dir);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':fpago', $fpago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La proveedor se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la proveedor.');
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
            $query = "UPDATE proveedores SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'proveedor eliminada exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar la proveedor.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }
} // Fin de la clase
