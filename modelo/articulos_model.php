<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class articulosModel extends Conexion
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
                    A.codigo LIKE :codigo or
                    A.homol LIKE :homol or
                    A.nombre LIKE :nombre or
                    C.nombre LIKE :clase or
                    G.nombre LIKE :grupo or
                    A.referencia LIKE :referencia or
                    U.nombre LIKE :umedida or
                    A.stmin LIKE :stmin or
                    A.stmax LIKE :stmax or
                    A.ctostan LIKE :ctostan or
                    A.ctoult LIKE :ctoult or
                    A.fecult LIKE :fecult or
                    A.nal LIKE :nal or
                    A.pv1 LIKE :pv1 or
                    A.pv2 LIKE :pv2 or
                    A.pv3 LIKE :pv3 or
                    A.ubicacion LIKE :ubicacion or
                    A.uxemp LIKE :uxemp or            
                    A.peso LIKE :peso or
                    A.iva LIKE :iva or
                    A.impo LIKE :impo or
                    A.flete LIKE :flete or
                    A.estado LIKE :estado or
                    A.canen LIKE :canen or
                    A.valen LIKE :valen or
                    A.pdes LIKE :pdes or
                    A.ultpro LIKE :ultpro or
                    A.docpro LIKE :docpro
                )";
                $searchArray = array(
                    'codigo' => "%$searchValue%",
                    'homol' => "%$searchValue%",
                    'nombre' => "%$searchValue%",
                    'clase' => "%$searchValue%",
                    'grupo' => "%$searchValue%",
                    'referencia' => "%$searchValue%",
                    'umedida' => "%$searchValue%",
                    'stmin' => "%$searchValue%",
                    'stmax' => "%$searchValue%",
                    'ctostan' => "%$searchValue%",
                    'ctoult' => "%$searchValue%",
                    'fecult' => "%$searchValue%",
                    'nal' => "%$searchValue%",
                    'pv1' => "%$searchValue%",
                    'pv2' => "%$searchValue%",
                    'pv3' => "%$searchValue%",
                    'ubicacion' => "%$searchValue%",
                    'uxemp' => "%$searchValue%",
                    'peso' => "%$searchValue%",
                    'iva' => "%$searchValue%",
                    'impo' => "%$searchValue%",
                    'flete' => "%$searchValue%",
                    'estado' => "%$searchValue%",
                    'canen' => "%$searchValue%",
                    'valen' => "%$searchValue%",
                    'pdes' => "%$searchValue%",
                    'ultpro' => "%$searchValue%",
                    'docpro' => "%$searchValue%",
                );
            }

            ## Calcular el total numero de registros sin filtro
            $sql = "SELECT COUNT(*) ";
            $sql .= " AS allcount FROM tbarticulos";
            $sql .= " WHERE activo = 1";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            ## Total numero de registros con filtro
            $sql = "SELECT COUNT(*)";
            $sql .= " AS allcount FROM tbarticulos As A
            INNER JOIN tbumedidas As U ON U.id = A.umedida
            INNER JOIN tbclases As C ON C.id = A.clase
            INNER JOIN tbgrupos As G ON G.id = A.grupo";
            $sql .= " WHERE A.activo = 1 " . $searchQuery . " ";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            ## Obetener los registros de la tabla.
            $sql = "SELECT A.id, A.codigo, A.homol, A.nombre, C.nombre As clase, G.nombre As grupo, A.referencia, U.nombre As umedida, 
            A.stmin, A.stmax, A.ctostan, A.ctoult, A.fecult, A.nal, A.pv1, A.pv2, A.pv3, A.ubicacion, A.uxemp, 
            A.peso, A.iva, A.impo, A.flete, A.estado, A.canen, A.valen, A.pdes, A.ultpro, A.docpro 
            FROM tbarticulos As A
            INNER JOIN tbumedidas As U ON U.id = A.umedida
            INNER JOIN tbclases As C ON C.id = A.clase
            INNER JOIN tbgrupos As G ON G.id = A.grupo";
            $sql .= " WHERE A.activo = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset";
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
                    'homol' => $row['homol'],
                    'nombre' => $row['nombre'],
                    'clase' => $row['clase'],
                    'grupo' => $row['grupo'],
                    'referencia' => $row['referencia'],
                    'umedida' => $row['umedida'],
                    'stmin' => $row['stmin'],
                    'stmax' => $row['stmax'],
                    'ctostan' => $row['ctostan'],
                    'ctoult' => $row['ctoult'],
                    'fecult' => $row['fecult'],
                    'nal' => $row['nal'],
                    'pv1' => $row['pv1'],
                    'pv2' => $row['pv2'],
                    'pv3' => $row['pv3'],
                    'ubicacion' => $row['ubicacion'],
                    'uxemp' => $row['uxemp'],
                    'peso' => $row['peso'],
                    'iva' => $row['iva'],
                    'impo' => $row['impo'],
                    'flete' => $row['flete'],
                    'estado' => $row['estado'],
                    'canen' => $row['canen'],
                    'valen' => $row['valen'],
                    'pdes' => $row['pdes'],
                    'ultpro' => $row['ultpro'],
                    'docpro' => $row['docpro'],
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

    public static function listado_productos()
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
					codigo LIKE :codigo or 
					nombre LIKE :nombre or 
					uxemp LIKE :uxemp or 
					stmin LIKE :stmin or 
                    stmax LIKE :stmax) ";
                $searchArray = array(
                    'codigo' => "%$searchValue%",
                    'uxemp' => "%$searchValue%",
                    'stmin' => "%$searchValue%",
                    'nombre' => "%$searchValue%",
                    'stmax' => "%$searchValue%"
                );
            }

            ## Calcular el total numero de registros sin filtro
            $sql = "SELECT COUNT(*) AS allcount ";
            $sql .= " FROM tbarticulos";
            $sql .= " WHERE activo = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            ## Total numero de registros con filtro
            $sql = "SELECT COUNT(*) AS allcount ";
            $sql .= " FROM tbarticulos";
            $sql .= " WHERE activo = 1 " . $searchQuery . " ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            ## Obetener los registros de la tabla.
            $sql = "SELECT `id`, `codigo`, `homol`, `nombre`, `clase`, `grupo`, `referencia`, `umedida`, 
            `stmin`, `stmax`, `ctostan`, `ctoult`, `fecult`, `nal`, `pv1`, `pv2`, `pv3`, `ubicacion`, `uxemp`, 
            `peso`, `iva`, `impo`, `flete`, `estado`, `canen`, `valen`, `pdes`, `ultpro`, `docpro` FROM tbarticulos";
            $sql .= " WHERE activo = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset";
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
                $opEditar = "<button class='btn btn-outline-primary btn-sm me-1 mb-1' type='button' onclick=agregar({$row['id']})>
                <span class='fas fa-cart-plus me-1' data-fa-transform='shrink-3'></span></button>";
                // $opEliminar = "<button class='btn btn-outline-primary btn-sm me-1 mb-1' type='button' onclick=eliminar({$row['id']})>
                // <span class='fas fa-trash me-1' data-fa-transform='shrink-3'></span></button>";

                $data[] = array(
                    'codigo' => $row['codigo'],
                    'nombre' => $row['nombre'],
                    'existencia' => $row['uxemp'],
                    'vlr_minimo' => $row['stmin'],
                    'vlr_sugerido' => $row['stmax'],
                    'comprar' => $opEditar
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
            $query = "SELECT `id`, `codigo`, `homol`, `nombre`, `clase`, `grupo`, `referencia`, `umedida`, 
            `stmin`, `stmax`, `ctostan`, `ctoult`, `fecult`, `nal`, `pv1`, `pv2`,  `pv3`, `ubicacion`, `uxemp`, 
            `peso`, `iva`, `impo`, `flete`, `estado`, `canen`, `valen`, `pdes`, `ultpro`, `docpro` FROM tbarticulos WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbarticulos
                echo json_encode($rows);
            } else {
                $data = "No hay articulo";
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function get_id_productos($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `homol`, `nombre`, `clase`, `grupo`, `referencia`, `umedida`, 
            `stmin`, `stmax`, `ctostan`, `ctoult`, `fecult`, `nal`, `pv1`, `pv2`,  `pv3`, `ubicacion`, `uxemp`, 
            `peso`, `iva`, `impo`, `flete`, `estado`, `canen`, `valen`, `pdes`, `ultpro`, `docpro` FROM tbarticulos WHERE codigo = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbarticulos
                $response = array('status' => 'success', 'datos' => $rows);

                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'No hay productos con este codigo.');
                echo json_encode($response);
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
            $homol = $datos['homol'];
            $nombre = $datos['nombre'];
            $clase = $datos['clase'];
            $grupo = $datos['grupo'];
            $referencia = $datos['referencia'];
            $umedida = $datos['umedida'];
            $stmin = $datos['stmin'];
            $stmax = $datos['stmax'];
            $ctostan = $datos['ctostan'];
            $ctoult = $datos['ctoult'];
            $fecult = $datos['fecult'];
            $nal = $datos['nal'];
            $pv1 = $datos['pv1'];
            $pv2 = $datos['pv2'];
            $pv3 = $datos['pv3'];
            $ubicacion = $datos['ubicacion'];
            $uxemp = $datos['uxemp'];
            $peso = $datos['peso'];
            $iva = $datos['iva'];
            $impo = $datos['impo'];
            $flete = $datos['flete'];
            $estado = $datos['estado'];
            $canen = $datos['canen'];
            $valen = $datos['valen'];
            $pdes = $datos['pdes'];
            $ultpro = $datos['ultpro'];
            $docpro = $datos['docpro'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM tbarticulos WHERE codigo = :codigo";
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
                $query = "INSERT INTO tbarticulos (codigo, homol, nombre, clase, grupo, referencia, umedida, 
                stmin, stmax, ctostan, ctoult, fecult, nal, pv1, pv2, pv3, ubicacion, uxemp, peso, iva, impo, 
                flete, estado, canen, valen, pdes, ultpro, docpro) VALUES (:codigo, :homol, :nombre, :clase, :grupo,
                :referencia, :umedida, :stmin, :stmax, :ctostan, :ctoult, :fecult, :nal, :pv1, :pv2, :pv3, 
                :ubicacion, :uxemp, :peso, :iva, :impo, :flete, :estado, :canen, :valen, :pdes, :ultpro, :docpro)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':homol', $homol);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':clase', $clase);
                $stmt->bindParam(':grupo', $grupo);
                $stmt->bindParam(':referencia', $referencia);
                $stmt->bindParam(':umedida', $umedida);
                $stmt->bindParam(':stmin', $stmin);
                $stmt->bindParam(':stmax', $stmax);
                $stmt->bindParam(':ctostan', $ctostan);
                $stmt->bindParam(':ctoult', $ctoult);
                $stmt->bindParam(':fecult', $fecult);
                $stmt->bindParam(':nal', $nal);
                $stmt->bindParam(':peso', $peso);
                $stmt->bindParam(':pv1', $pv1);
                $stmt->bindParam(':pv2', $pv2);
                $stmt->bindParam(':pv3', $pv3);
                $stmt->bindParam(':ubicacion', $ubicacion);
                $stmt->bindParam(':uxemp', $uxemp);
                $stmt->bindParam(':peso', $peso);
                $stmt->bindParam(':iva', $iva);
                $stmt->bindParam(':impo', $impo);
                $stmt->bindParam(':flete', $flete);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':canen', $canen);
                $stmt->bindParam(':valen', $valen);
                $stmt->bindParam(':pdes', $pdes);
                $stmt->bindParam(':ultpro', $ultpro);
                $stmt->bindParam(':docpro', $docpro);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La articulo se ha guardado correctamente');
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
            $homol = $datos['homol'];
            $nombre = $datos['nombre'];
            $clase = $datos['clase'];
            $grupo = $datos['grupo'];
            $referencia = $datos['referencia'];
            $umedida = $datos['umedida'];
            $stmin = $datos['stmin'];
            $stmax = $datos['stmax'];
            $ctostan = $datos['ctostan'];
            $ctoult = $datos['ctoult'];
            $fecult = $datos['fecult'];
            $nal = $datos['nal'];
            $pv1 = $datos['pv1'];
            $pv2 = $datos['pv2'];
            $pv3 = $datos['pv3'];
            $ubicacion = $datos['ubicacion'];
            $uxemp = $datos['uxemp'];
            $peso = $datos['peso'];
            $iva = $datos['iva'];
            $impo = $datos['impo'];
            $flete = $datos['flete'];
            $estado = $datos['estado'];
            $canen = $datos['canen'];
            $valen = $datos['valen'];
            $pdes = $datos['pdes'];
            $ultpro = $datos['ultpro'];
            $docpro = $datos['docpro'];
            $id = $datos['id'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM tbarticulos WHERE id = :id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM tbarticulos WHERE codigo = :codigo";
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
                    $query = "UPDATE tbarticulos SET codigo=:codigo, homol=:homol, nombre=:nombre, clase=:clase, grupo=:grupo, 
                    referencia=:referencia, umedida=:umedida, stmin=:stmin, stmax=:stmax, ctostan=:ctostan, ctoult=:ctoult, fecult=:fecult, 
                    nal=:nal, pv1=:pv1, pv2=:pv2, pv3=:pv3, ubicacion=:ubicacion, uxemp=:uxemp, peso=:peso, iva=:iva, impo=:impo, 
                    flete=:flete, estado=:estado, canen=:canen, valen=:valen, pdes=:pdes, ultpro=:ultpro, docpro=:docpro WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':homol', $homol);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':clase', $clase);
                    $stmt->bindParam(':grupo', $grupo);
                    $stmt->bindParam(':referencia', $referencia);
                    $stmt->bindParam(':umedida', $umedida);
                    $stmt->bindParam(':stmin', $stmin);
                    $stmt->bindParam(':stmax', $stmax);
                    $stmt->bindParam(':ctostan', $ctostan);
                    $stmt->bindParam(':ctoult', $ctoult);
                    $stmt->bindParam(':fecult', $fecult);
                    $stmt->bindParam(':nal', $nal);
                    $stmt->bindParam(':pv1', $pv1);
                    $stmt->bindParam(':pv2', $pv2);
                    $stmt->bindParam(':pv3', $pv3);
                    $stmt->bindParam(':ubicacion', $ubicacion);
                    $stmt->bindParam(':uxemp', $uxemp);
                    $stmt->bindParam(':peso', $peso);
                    $stmt->bindParam(':iva', $iva);
                    $stmt->bindParam(':impo', $impo);
                    $stmt->bindParam(':flete', $flete);
                    $stmt->bindParam(':estado', $estado);
                    $stmt->bindParam(':canen', $canen);
                    $stmt->bindParam(':valen', $valen);
                    $stmt->bindParam(':pdes', $pdes);
                    $stmt->bindParam(':ultpro', $ultpro);
                    $stmt->bindParam(':docpro', $docpro);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'La articulo se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la articulo.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE tbarticulos SET codigo=:codigo, homol=:homol, nombre=:nombre, clase=:clase, grupo=:grupo, 
                referencia=:referencia, umedida=:umedida, stmin=:stmin, stmax=:stmax, ctostan=:ctostan, ctoult=:ctoult, fecult=:fecult, 
                nal=:nal, pv1=:pv1, pv2=:pv2, pv3=:pv3, ubicacion=:ubicacion, uxemp=:uxemp, peso=:peso, iva=:iva, impo=:impo, 
                flete=:flete, estado=:estado, canen=:canen, valen=:valen, pdes=:pdes, ultpro=:ultpro, docpro=:docpro WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':homol', $homol);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':clase', $clase);
                $stmt->bindParam(':grupo', $grupo);
                $stmt->bindParam(':referencia', $referencia);
                $stmt->bindParam(':umedida', $umedida);
                $stmt->bindParam(':stmin', $stmin);
                $stmt->bindParam(':stmax', $stmax);
                $stmt->bindParam(':ctostan', $ctostan);
                $stmt->bindParam(':ctoult', $ctoult);
                $stmt->bindParam(':fecult', $fecult);
                $stmt->bindParam(':nal', $nal);
                $stmt->bindParam(':pv1', $pv1);
                $stmt->bindParam(':pv2', $pv2);
                $stmt->bindParam(':pv3', $pv3);
                $stmt->bindParam(':ubicacion', $ubicacion);
                $stmt->bindParam(':uxemp', $uxemp);
                $stmt->bindParam(':peso', $peso);
                $stmt->bindParam(':iva', $iva);
                $stmt->bindParam(':impo', $impo);
                $stmt->bindParam(':flete', $flete);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':canen', $canen);
                $stmt->bindParam(':valen', $valen);
                $stmt->bindParam(':pdes', $pdes);
                $stmt->bindParam(':ultpro', $ultpro);
                $stmt->bindParam(':docpro', $docpro);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La articulo se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la articulo.');
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
            $query = "UPDATE tbarticulos SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'articulo eliminada exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar la articulo.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }


    public static function get_consecutivo($id_factura)
    {

        $dbconec = Conexion::Conectar();

        try {

            // se obtiene el alias de la factura
            $query = "SELECT id, resumen FROM tipo_facturas WHERE id = :id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id_factura);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $alias = $result['resumen'];


            // se consulta el consecutivo
            $query = "SELECT COUNT(*) as count FROM consecutivo WHERE id_factura = :id_factura";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id_factura', $id_factura);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total = $result['count'] + 1;
            $consecutivo = $alias . $total;
            $proceso = 1;

            // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
            $query = "INSERT INTO consecutivo (id_factura, consecutivo, proceso) VALUES (:id_factura, :consecutivo, :proceso)";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id_factura', $id_factura);
            $stmt->bindParam(':consecutivo', $consecutivo);
            $stmt->bindParam(':proceso', $proceso);
            $stmt->bindParam(':proceso', $proceso);
            $stmt->execute();

            $response = array('status' => 'success', 'datos' => $consecutivo);
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }
} // Fin de la clase
