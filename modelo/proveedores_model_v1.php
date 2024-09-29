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
                    codigo LIKE :codigo or
                    zona LIKE :zona or
                    subzona LIKE :subzona or
                    nombre LIKE :nombre or
                    direccion LIKE :direccion or
                    correo LIKE :direccion or
                    tel1 LIKE :tel1 or
                    tel2 LIKE :tel2)";
                $searchArray = array(
                    'codigo' => "%$searchValue%",
                    'zona' => "%$searchValue%",
                    'subzona' => "%$searchValue%",
                    'nombre' => "%$searchValue%",
                    'direccion' => "%$searchValue%",
                    'correo' => "%$searchValue%",
                    'tel1' => "%$searchValue%",
                    'tel2' => "%$searchValue%",
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
            $sql .= " AS allcount FROM proveedores";
            $sql .= " WHERE activo = 1 " . $searchQuery . " ";
            error_log("sql => " . $sql);
            $stmt = $conexion->prepare($sql);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            ## Obetener los registros de la tabla.
            $sql = "SELECT id, codigo, sucursal, nombre, zona, subzona, direccion, correo, tel1,  tel2 FROM proveedores";
            $sql .= " WHERE activo = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset";
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
                    'sucursal' => $row['sucursal'],
                    'nombre' => $row['nombre'],
                    'zona' => $row['zona'],
                    'subzona' => $row['subzona'],
                    'direccion' => $row['direccion'],
                    'tel1' => $row['tel1'],
                    'tel2' => $row['tel2'],
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
            $query = "SELECT id, codigo, sucursal, zona, subzona, nombre, direccion, 
            correo, tel1, tel2, legal, fecha_ini, cupo, forma_pago, caract_dev, digito, 
            riva, rfte, rica, estado FROM proveedores WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los proveedores
                echo json_encode($rows);
            } else {
                $data = "No hay proveedores";
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function get_cod($codigo)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT id, codigo, sucursal, zona, subzona, nombre, direccion, tel1,  tel2, 
            correo FROM proveedores WHERE codigo = $codigo";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los proveedores
                // $response = array('status' => 'OK', 'datos' => $rows);
                $response = array('status' => 'Error', 'mensaje' => "El proveedor ya está registrado.");
                echo json_encode($response);
            } else {
                $response = array('status' => 'OK');
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
            $sucursal = $datos['lstSucursal'];
            $nombre = $datos['nombre'];
            $zona = $datos['lstZonas'];
            $subzona = $datos['lstSubzonas'];
            $nombre = $datos['nombre'];
            $direccion = $datos['direccion'];
            $correo = $datos['correo'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $legal = $datos['legal'];
            $cupo = $datos['cupo'];
            $fecha_ini = $datos['fecha_ini'];
            $forma_pago = $datos['forma_pago'];
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
                $query = "INSERT INTO proveedores (codigo, sucursal, nombre, zona, subzona, direccion, correo, tel1, tel2, legal, cupo,
                fecha_ini, forma_pago, caract_dev, digito, riva, rfte, rica, estado) VALUES 
                (:codigo, :sucursal, :nombre, :zona, :subzona, :direccion, :correo, :tel1, :tel2, :legal, :cupo, :fecha_ini, :forma_pago, 
                :caract_dev, :digito, :riva, :rfte, :rica, :estado)";

                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':forma_pago', $forma_pago);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'El proveedor se ha guardado correctamente');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al guardar el proveedor');
                }

                // Devuelve la respuesta en formato JSON
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $data = "Error " . $e;
            echo json_encode($data);
        }
    }

    public static function modificar($datos)
    {
        $dbconec = Conexion::Conectar();

        try {

            $codigo = $datos['codigo_mod'];
            $sucursal = $datos['lstSucursal_mod'];
            $nombre = $datos['nombre_mod'];
            $zona = $datos['lstZonas_mod'];
            $subzona = $datos['lstSubzonas_mod'];
            $direccion = $datos['direccion_mod'];
            $correo = $datos['correo_mod'];
            $tel1 = $datos['tel1_mod'];
            $tel2 = $datos['tel2_mod'];
            $legal = $datos['legal_mod'];
            $cupo = $datos['cupo_mod'];
            $fecha_ini = $datos['fecha_ini_mod'];
            $forma_pago = $datos['forma_pago_mod'];
            $caract_dev = $datos['caract_dev_mod'];
            $digito = $datos['digito_mod'];
            $riva = $datos['riva_mod'];
            $rfte = $datos['rfte_mod'];
            $rica = $datos['rica_mod'];
            $estado = $datos['estado_mod'];
            $id = $datos['id'];
            $activo = 1;

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM proveedores WHERE id = :id AND activo = :activo";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM proveedores WHERE codigo = :codigo AND activo = 1";
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
                    $query = "UPDATE proveedores SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                    direccion=:direccion, correo=:correo, tel1=:tel1, tel2=:tel2, legal=:legal, cupo=:cupo, fecha_ini=:fecha_ini,
                    forma_pago=:forma_pago, caract_dev=:caract_dev, digito=:digito, riva=:riva, rfte=:rfte, rica=:rica, estado=:estado WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':sucursal', $sucursal);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':zona', $zona);
                    $stmt->bindParam(':subzona', $subzona);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':correo', $correo);
                    $stmt->bindParam(':tel1', $tel1);
                    $stmt->bindParam(':tel2', $tel2);
                    $stmt->bindParam(':legal', $legal);
                    $stmt->bindParam(':cupo', $cupo);
                    $stmt->bindParam(':fecha_ini', $fecha_ini);
                    $stmt->bindParam(':forma_pago', $forma_pago);
                    $stmt->bindParam(':caract_dev', $caract_dev);
                    $stmt->bindParam(':digito', $digito);
                    $stmt->bindParam(':riva', $riva);
                    $stmt->bindParam(':rfte', $rfte);
                    $stmt->bindParam(':rica', $rica);
                    $stmt->bindParam(':estado', $estado);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'El proveedor se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la proveedor.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE proveedores SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                    direccion=:direccion, correo=:correo, tel1=:tel1, tel2=:tel2, legal=:legal, cupo=:cupo, fecha_ini=:fecha_ini,
                    forma_pago=:forma_pago, caract_dev=:caract_dev, digito=:digito, riva=:riva, rfte=:rfte, rica=:rica, estado=:estado WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':forma_pago', $forma_pago);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':estado', $estado);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'El proveedor se ha modificado exitosamente.');
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
                $response = array('status' => 'success', 'message' => 'proveedor eliminado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar el proveedor.');
            }

            // Devuelve la respuesta en formato JSON
            echo json_encode($response);
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function combo_departamentos($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id,codigo,nombre FROM tbzonas where codigo=:codigo";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':codigo', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id,codigo,nombre FROM tbzonas ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id,codigo,nombre FROM tbzonas WHERE nombre like :nombre ORDER BY nombre LIMIT :limit";
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
                    "id" => $result['codigo'],
                    "text" => $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }
    public static function combo_ciudades($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbsubzonas where id=:codigo";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':codigo', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas WHERE nombre like :nombre ORDER BY nombre LIMIT :limit";
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
                    "id" => $result['codigo'],
                    "text" => $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }
    public static function combo_proveedores($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM proveedores where id=:id AND activo = 1";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM proveedores where activo = 1 ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM proveedores WHERE nombre like :nombre or codigo AND activo = 1 like :nombre ORDER BY nombre LIMIT :limit";
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
                    "text" => $result['codigo'] . " - " . $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }
    public static function combo_vendedores($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbvendedores where id=:id and activo = 1";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbvendedores where activo = 1 ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbvendedores WHERE nombre like :nombre or codigo and activo = 1 like :nombre ORDER BY nombre LIMIT :limit";
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
                    "text" => $result['codigo'] . " - " . $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }

    public static function combo_ciudades_all($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbsubzonas where zona=:codigo";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':codigo', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas WHERE nombre like :nombre ORDER BY nombre LIMIT :limit";
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
                    "id" => $result['codigo'],
                    "text" => $result['nombre']
                );
            }


            echo json_encode($response);
            $dbconec = NULL; //Cierra la conexion a la Base de datos
        } catch (Exception $e) {

            echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
        }
    }

    public static function combo_ciudades_cod($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbsubzonas where codigo=:codigo";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':codigo', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbsubzonas WHERE nombre like :nombre ORDER BY nombre LIMIT :limit";
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
                    "id" => $result['codigo'],
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