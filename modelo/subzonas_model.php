<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class subzonasModel extends Conexion
{

    public static function get_id($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT SZ.id, SZ.codigo, Z.codigo As codigo_zona, Z.nombre As nombre_zona, SZ.nombre, SZ.resum, SZ.activo, SZ.created_at FROM `tbsubzonas` AS SZ
            INNER JOIN tbzonas AS Z ON Z.codigo = SZ.zona
            WHERE SZ.activo = 1 AND SZ.id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbsubzonas
                echo json_encode($rows);
            } else {
                $data = "No hay subzonas";
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
            $zona = $datos['zona'];
            $nombre = $datos['nombre'];
            $resumen = $datos['resumen'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM tbsubzonas WHERE codigo = :codigo AND zona = :zona AND activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':zona', $zona);
            $stmt->execute();

            // Obtiene el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $queryNameCod = "SELECT COUNT(*) as count, codigo FROM tbsubzonas WHERE nombre = :nombre AND zona = :zona AND activo = 1";
            $stmt = $dbconec->prepare($queryNameCod);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':zona', $zona);
            $stmt->execute();
            $resultNameCod = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica si el código ya existe
            if ($result['count'] > 0) {
                $response = array('status' => 'error', 'message' => 'El código ya existe en la base de datos para esta zona');
                echo json_encode($response);
            } elseif ($resultNameCod['count'] > 0) {
                $response = array('status' => 'error', 'message' => 'La zona y la subzona ya existe en la base de datos.');
                echo json_encode($response);
            } else {

                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "INSERT INTO tbsubzonas (codigo, zona, nombre, resum) VALUES (:codigo, :zona, :nombre, :resumen)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':resumen', $resumen);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La subzona se ha guardado correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar la subzona');
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
        // die();
        try {
            $codigo = $datos['codigo'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['subzonaName'];
            $resumen = $datos['resumen'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM tbsubzonas WHERE id = :id AND zona = :zona";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':zona', $zona);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM tbsubzonas WHERE codigo = :codigo AND zona = :zona AND activo = 1";
                $stmt = $dbconec->prepare($queryC);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':zona', $zona);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica si el código ya existe
                if ($result['count'] > 0) {
                    $response = array('status' => 'error', 'message' => 'El código ya existe en la base de datos.');
                    echo json_encode($response);
                } else {
                    // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                    $query = "UPDATE tbsubzonas SET codigo=:codigo, zona=:zona, nombre=:nombre, resum=:resumen WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':zona', $zona);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':resumen', $resumen);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'La subzona se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la subzona.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE tbsubzonas SET codigo=:codigo, zona=:zona, nombre=:nombre, resum=:resumen WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':resumen', $resumen);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La subzona se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la subzona.');
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
            $query = "UPDATE tbsubzonas SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'Subzona eliminada exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar la subzona.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

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
					SZ.codigo LIKE :codigo or 
					Z.nombre LIKE :zona or 
					SZ.nombre LIKE :nombre or 
                    SZ.resum LIKE :resum) ";
                $searchArray = array(
                    'codigo' => "%$searchValue%",
                    'zona' => "%$searchValue%",
                    'nombre' => "%$searchValue%",
                    'resum' => "%$searchValue%"
                );
            }

            ## Calcular el total numero de registros sin filtro
            $sql = "SELECT COUNT(*) ";
            $sql .= " AS allcount FROM `tbsubzonas` AS SZ
            INNER JOIN tbzonas AS Z ON Z.codigo = SZ.zona";
            $sql .= " WHERE SZ.activo = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            ## Total numero de registros con filtro
            $sql = "SELECT COUNT(*)";
            $sql .= " AS allcount FROM `tbsubzonas` AS SZ
            INNER JOIN tbzonas AS Z ON Z.codigo = SZ.zona";
            $sql .= " WHERE SZ.activo = 1 " . $searchQuery . " ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            ## Obetener los registros de la tabla.
            $sql = "SELECT SZ.id, SZ.codigo, Z.nombre As zona, SZ.nombre, SZ.resum, SZ.activo, SZ.created_at 
            FROM `tbsubzonas` AS SZ
            INNER JOIN tbzonas AS Z ON Z.codigo = SZ.zona";
            $sql .= " WHERE SZ.activo = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset";
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
                    'zona' => $row['zona'],
                    'nombre' => $row['nombre'],
                    'resum' => $row['resum'],
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
} // Fin de la clase
