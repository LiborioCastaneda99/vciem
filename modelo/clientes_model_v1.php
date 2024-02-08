<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class clientesModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `sucursal`, `zona`, `subzona`, `nombre`, `direc`, `tel1`,  `tel2`, 
            `ciudad` FROM tbclientes WHERE activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbclientes
                echo json_encode($rows);
            } else {

                $data = "";
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $data = "Error";
            echo json_encode($data);
        }
    }

    public static function get_id($id)
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `sucursal`, `zona`, `subzona`, `nombre`, `direc`, `tel1`,  `tel2`, 
            `correo` FROM tbclientes WHERE id = $id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbclientes
                echo json_encode($rows);
            } else {
                $data = "No hay clientes";
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
            $query = "SELECT `id`, `codigo`, `sucursal`, `zona`, `subzona`, `nombre`, `direc`, `tel1`,  `tel2`, 
            `correo` FROM tbclientes WHERE codigo = $codigo";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbclientes
                // $response = array('status' => 'OK', 'datos' => $rows);
                $response = array('status' => 'Error', 'mensaje' => "El cliente ya está registrado.");
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
        die();
        try {
            $codigo = $datos['codigo'];
            $sucursal = $datos['lstSucursal'];
            $zona = $datos['lstZonas'];
            $subzona = $datos['lstSubzonas'];
            $nombre = $datos['nombre'];
            $direc = $datos['direc'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $correo = $datos['correo'];
            // $ciudad = $datos['ciudad'];
            $vendedor = $datos['vende'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $forma_pago = $datos['forma_pago'];
            // $correo = $datos['correo'];
            $cod_viejo = $datos['cod_viejo'];
            $caract_dev = $datos['caract_dev'];
            $digito = $datos['digito'];
            $riva = $datos['riva'];
            $rfte = $datos['rfte'];
            $rica = $datos['rica'];
            $alma = $datos['alma'];
            $cali = $datos['cali'];
            $tipo = $datos['tipo'];
            $distri = $datos['distri'];
            $genom = $datos['genom'];
            $geema = $datos['geema'];
            $getel1 = $datos['getel1'];
            $getel2 = $datos['getel2'];
            $conom = $datos['conom'];
            $coema = $datos['coema'];
            $cotel1 = $datos['cotel1'];
            $cotel2 = $datos['cotel2'];
            $panom = $datos['panom'];
            $paema = $datos['paema'];
            $patel1 = $datos['patel1'];
            $patel2 = $datos['patel2'];
            $otnom = $datos['otnom'];
            $otema = $datos['otema'];
            $ottel1 = $datos['ottel1'];
            $ottel2 = $datos['ottel2'];
            $remis = $datos['remis'];
            $fbloq = $datos['fbloq'];
            $diaser = $datos['diaser'];
            $diater = $datos['diater'];
            $vlrarr = $datos['vlrarr'];
            $acta = $datos['acta'];
            $pacta = $datos['pacta'];
            $exclui = $datos['exclui'];
            $person = $datos['person'];
            $regime = $datos['regime'];
            $tipoid = $datos['tipoid'];
            $nomreg = $datos['nomreg'];
            $pais = $datos['pais'];
            $nom1 = $datos['nom1'];
            $nom2 = $datos['nom2'];
            $ape1 = $datos['ape1'];
            $ape2 = $datos['ape2'];
            $ofi = $datos['ofi'];
            $difici = $datos['difici'];
            $remval = $datos['remval'];
            $estado = $datos['estado'];
            $cono = $datos['cono'];
            $emailq = $datos['emailq'];

            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM tbclientes WHERE codigo = :codigo";
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
                $query = "INSERT INTO tbclientes (codigo, sucursal, zona, subzona, nombre, direc, correo, tel1, tel2) VALUES 
                (:codigo, :sucursal, :zona, :subzona, :nombre, :direc, :correo, :tel1, :tel2)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':direc', $direc);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                // $stmt->bindParam(':ciudad', $ciudad);
                // $stmt->bindParam(':vendedor', $vendedor);
                // $stmt->bindParam(':cupo', $cupo);
                // $stmt->bindParam(':legal', $legal);
                // $stmt->bindParam(':fecha_ini', $fecha_ini);
                // $stmt->bindParam(':riva', $riva);
                // $stmt->bindParam(':forma_pago', $forma_pago);
                // $stmt->bindParam(':correo', $correo);
                // $stmt->bindParam(':cod_viejo', $cod_viejo);
                // $stmt->bindParam(':caract_dev', $caract_dev);
                // $stmt->bindParam(':digito', $digito);
                // $stmt->bindParam(':riva', $riva);
                // $stmt->bindParam(':rfte', $rfte);
                // $stmt->bindParam(':rica', $rica);
                // $stmt->bindParam(':alma', $alma);
                // $stmt->bindParam(':cali', $cali);
                // $stmt->bindParam(':tipo', $tipo);
                // $stmt->bindParam(':distri', $distri);
                // $stmt->bindParam(':genom', $genom);
                // $stmt->bindParam(':geema', $geema);
                // $stmt->bindParam(':getel1', $getel1);
                // $stmt->bindParam(':getel2', $getel2);
                // $stmt->bindParam(':conom', $conom);
                // $stmt->bindParam(':coema', $coema);
                // $stmt->bindParam(':cotel1', $cotel1);
                // $stmt->bindParam(':cotel2', $cotel2);
                // $stmt->bindParam(':panom', $panom);
                // $stmt->bindParam(':paema', $paema);
                // $stmt->bindParam(':patel1', $patel1);
                // $stmt->bindParam(':patel2', $patel2);
                // $stmt->bindParam(':otnom', $otnom);
                // $stmt->bindParam(':otema', $otema);
                // $stmt->bindParam(':ottel1', $ottel1);
                // $stmt->bindParam(':ottel2', $ottel2);
                // $stmt->bindParam(':remis', $remis);
                // $stmt->bindParam(':fbloq', $fbloq);
                // $stmt->bindParam(':diaser', $diaser);
                // $stmt->bindParam(':diater', $diater);
                // $stmt->bindParam(':vlrarr', $vlrarr);
                // $stmt->bindParam(':acta', $acta);
                // $stmt->bindParam(':pacta', $pacta);
                // $stmt->bindParam(':exclui', $exclui);
                // $stmt->bindParam(':person', $person);
                // $stmt->bindParam(':regime', $regime);
                // $stmt->bindParam(':tipoid', $tipoid);
                // $stmt->bindParam(':nomreg', $nomreg);
                // $stmt->bindParam(':pais', $pais);
                // $stmt->bindParam(':nom1', $nom1);
                // $stmt->bindParam(':nom2', $nom2);
                // $stmt->bindParam(':ape1', $ape1);
                // $stmt->bindParam(':ape2', $ape2);
                // $stmt->bindParam(':ofi', $ofi);
                // $stmt->bindParam(':difici', $difici);
                // $stmt->bindParam(':remval', $remval);
                // $stmt->bindParam(':estado', $estado);
                // $stmt->bindParam(':cono', $cono);
                // $stmt->bindParam(':emailq', $emailq);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La cliente se ha guardado correctamente');
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
            $sucursal = $datos['sucursal'];
            $nombre = $datos['nombre'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $direc = $datos['direc'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $correo = $datos['correo'];
            $id = $datos['id'];
            $activo = $datos['activo'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count, codigo FROM tbclientes WHERE id = :id AND activo = :activo";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_bd = $result['codigo'];

            // comparamos el codigo que llega y el que está
            if ($codigo != $codigo_bd) {
                $queryC = "SELECT COUNT(*) as count, codigo FROM tbclientes WHERE codigo = :codigo AND activo = 1";
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
                    $query = "UPDATE tbclientes SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                    direc=:direc, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, correo=:correo WHERE id=:id";
                    $stmt = $dbconec->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':sucursal', $sucursal);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':zona', $zona);
                    $stmt->bindParam(':subzona', $subzona);
                    $stmt->bindParam(':direc', $direc);
                    $stmt->bindParam(':tel1', $tel1);
                    $stmt->bindParam(':tel2', $tel2);
                    $stmt->bindParam(':ciudad', $ciudad);
                    $stmt->bindParam(':correo', $correo);
                    // $stmt->bindParam(':vendedor', $vendedor);
                    // $stmt->bindParam(':cupo', $cupo);
                    // $stmt->bindParam(':legal', $legal);
                    // $stmt->bindParam(':fecha_ini', $fecha_ini);
                    // $stmt->bindParam(':forma_pago', $forma_pago);
                    // $stmt->bindParam(':correo', $correo);
                    // $stmt->bindParam(':cod_viejo', $cod_viejo);
                    // $stmt->bindParam(':caract_dev', $caract_dev);
                    // $stmt->bindParam(':digito', $digito);
                    // $stmt->bindParam(':riva', $riva);
                    // $stmt->bindParam(':rfte', $rfte);
                    // $stmt->bindParam(':rica', $rica);
                    // $stmt->bindParam(':alma', $alma);
                    // $stmt->bindParam(':cali', $cali);
                    // $stmt->bindParam(':tipo', $tipo);
                    // $stmt->bindParam(':distri', $distri);
                    // $stmt->bindParam(':genom', $genom);
                    // $stmt->bindParam(':geema', $geema);
                    // $stmt->bindParam(':getel1', $getel1);
                    // $stmt->bindParam(':getel2', $getel2);
                    // $stmt->bindParam(':conom', $conom);
                    // $stmt->bindParam(':coema', $coema);
                    // $stmt->bindParam(':cotel1', $cotel1);
                    // $stmt->bindParam(':cotel2', $cotel2);
                    // $stmt->bindParam(':panom', $panom);
                    // $stmt->bindParam(':paema', $paema);
                    // $stmt->bindParam(':patel1', $patel1);
                    // $stmt->bindParam(':patel2', $patel2);
                    // $stmt->bindParam(':otnom', $otnom);
                    // $stmt->bindParam(':otema', $otema);
                    // $stmt->bindParam(':ottel1', $ottel1);
                    // $stmt->bindParam(':ottel2', $ottel2);
                    // $stmt->bindParam(':remis', $remis);
                    // $stmt->bindParam(':fbloq', $fbloq);
                    // $stmt->bindParam(':diaser', $diaser);
                    // $stmt->bindParam(':diater', $diater);
                    // $stmt->bindParam(':vlrarr', $vlrarr);
                    // $stmt->bindParam(':acta', $acta);
                    // $stmt->bindParam(':pacta', $pacta);
                    // $stmt->bindParam(':exclui', $exclui);
                    // $stmt->bindParam(':person', $person);
                    // $stmt->bindParam(':regime', $regime);
                    // $stmt->bindParam(':tipoid', $tipoid);
                    // $stmt->bindParam(':nomreg', $nomreg);
                    // $stmt->bindParam(':pais', $pais);
                    // $stmt->bindParam(':nom1', $nom1);
                    // $stmt->bindParam(':nom2', $nom2);
                    // $stmt->bindParam(':ape1', $ape1);
                    // $stmt->bindParam(':ape2', $ape2);
                    // $stmt->bindParam(':ofi', $ofi);
                    // $stmt->bindParam(':difici', $difici);
                    // $stmt->bindParam(':remval', $remval);
                    // $stmt->bindParam(':estado', $estado);
                    // $stmt->bindParam(':cono', $cono);
                    // $stmt->bindParam(':emailq', $emailq);

                    if ($stmt->execute()) {
                        // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                        $response = array('status' => 'success', 'message' => 'La cliente se ha modificado exitosamente.');
                    } else {
                        // Si hubo un error en la inserción, devuelve un mensaje de error
                        $response = array('status' => 'error', 'message' => 'Error al modificar la cliente.');
                    }

                    // Devuelve la respuesta en formato JSON
                    echo json_encode($response);
                }
            } else {
                // Realiza la inserción en la base de datos (ajusta esto según tu configuración)
                $query = "UPDATE tbclientes SET codigo=:codigo, sucursal=:sucursal, nombre=:nombre, zona=:zona, subzona=:subzona, 
                direc=:direc, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, correo=:correo WHERE id=:id";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':direc', $direc);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':correo', $correo);

                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                    $response = array('status' => 'success', 'message' => 'La cliente se ha modificado exitosamente.');
                } else {
                    // Si hubo un error en la inserción, devuelve un mensaje de error
                    $response = array('status' => 'error', 'message' => 'Error al modificar la cliente.');
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
            $query = "UPDATE tbclientes SET activo=:activo WHERE id=:id";
            $stmt = $dbconec->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':activo', $activo);

            if ($stmt->execute()) {
                // Si la inserción fue exitosa, devuelve un mensaje o los datos actualizados
                $response = array('status' => 'success', 'message' => 'cliente eliminado exitosamente.');
            } else {
                // Si hubo un error en la inserción, devuelve un mensaje de error
                $response = array('status' => 'error', 'message' => 'Error al eliminar el cliente.');
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

    public static function combo_clientes($searchTerm, $id)
    {
        $dbconec = Conexion::Conectar();
        try {
            $numberofrecords = 5;
            if ($id != '') {
                $search = $id; // Search text

                // Mostrar resultados
                $sql = "SELECT id, codigo, nombre FROM tbclientes where id=:id";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbclientes ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbclientes WHERE nombre like :nombre or codigo like :nombre ORDER BY nombre LIMIT :limit";
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
                    "text" => $result['codigo']." - ".$result['nombre']
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
                $sql = "SELECT id, codigo, nombre FROM tbvendedores where id=:id";
                $stmt = $dbconec->prepare($sql);
                $stmt->bindValue(':id', $search, PDO::PARAM_STR);
                $stmt->execute();
                //Variable en array para ser procesado en el ciclo foreach
                $lstResult = $stmt->fetchAll();
            } else {
                if ($searchTerm == '') {

                    // Obtener registros a tarves de la consulta SQL
                    $sql = "SELECT id, codigo, nombre FROM tbvendedores ORDER BY nombre LIMIT :limit";
                    $stmt = $dbconec->prepare($sql);
                    $stmt->bindValue(':limit', (int) $numberofrecords, PDO::PARAM_INT);
                    $stmt->execute();
                    $lstResult = $stmt->fetchAll();
                } else {
                    $search = $searchTerm; // Search text
                    // Mostrar resultados
                    $sql = "SELECT id, codigo, nombre FROM tbvendedores WHERE nombre like :nombre or codigo like :nombre ORDER BY nombre LIMIT :limit";
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
                    "text" => $result['codigo']." - ".$result['nombre']
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
