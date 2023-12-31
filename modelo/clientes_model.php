<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class clientesModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `nombre`, `zona`, `subzona`, `ciudad` FROM tbclientes WHERE activo = 1";
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
            `ciudad`, `vendedor`, `cupo`, `legal`, `fecha_ini`, `forma_pago`, `correo`,  `cod_viejo`, `caract_dev`, `digito`, 
            `riva`, `rfte`, `rica`, `alma`, `cali`, `tipo`, `distri`, `genom`, `geema`, `getel1`, `getel2`, `conom`, `coema`, 
            `cotel1`, `cotel2`, `panom`, `paema`, `patel1`, `patel2`, `otnom`, `otema`, `ottel1`, `ottel2`, `remis`, `fbloq`, 
            `diaser`, `diater`, `vlrarr`, `acta`, `pacta`, `exclui`, `person`, `regime`, `tipoid`, `nomreg`, `pais`, `nom1`, 
            `nom2`, `ape1`, `ape2`, `ofi`, `difici`, `remval`, `cali`, `cono`, `emailq` FROM tbclientes WHERE id = $id";
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

    public static function guardar($datos)
    {
        $dbconec = Conexion::Conectar();

        try {
            $codigo = $datos['codigo'];
            $sucursal = $datos['sucursal'];
            $zona = $datos['zona'];
            $subzona = $datos['subzona'];
            $nombre = $datos['nombre'];
            $direc = $datos['direc'];
            $tel1 = $datos['tel1'];
            $tel2 = $datos['tel2'];
            $ciudad = $datos['ciudad'];
            $vendedor = $datos['vendedor'];
            $cupo = $datos['cupo'];
            $legal = $datos['legal'];
            $fecha_ini = $datos['fecha_ini'];
            $forma_pago = $datos['forma_pago'];
            $correo = $datos['correo'];
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
                $query = "INSERT INTO tbclientes (codigo, sucursal, nombre, zona, subzona, direc, tel1, tel2, ciudad, 
                vendedor, cupo, legal, fecha_ini, forma_pago, correo, cod_viejo, caract_dev, digito, riva, rfte, rica, 
                alma, cali, tipo, distri, genom, geema, getel1, getel2, conom, coema, cotel1, cotel2, panom, paema, patel1, 
                patel2, otnom, otema, ottel1, ottel2, remis, fbloq, diaser, diater, vlrarr, acta, pacta, exclui, person, 
                regime, tipoid, nomreg, pais, nom1, nom2, ape1, ape2, ofi, difici, remval, estado, cono, emailq) VALUES 
                (:codigo, :sucursal, :nombre, :zona, :subzona, :direc, :tel1, :tel2, :ciudad, :vendedor, :cupo, :legal, 
                :fecha_ini, :forma_pago, :correo, :cod_viejo, :caract_dev, :digito, :riva, :rfte, :rica, :alma, :cali, 
                :tipo, :distri, :genom, :geema, :getel1, :getel2, :conom, :coema, :cotel1, :cotel2, :panom, :paema, 
                :patel1, :patel2, :otnom, :otema, :ottel1, :ottel2, :remis, :fbloq, :diaser, :diater, :vlrarr, :acta, 
                :pacta, :exclui, :person, :regime, :tipoid, :nomreg, :pais, :nom1, :nom2, :ape1, :ape2, :ofi, :difici, 
                :remval, :estado, :cono, :emailq)";
                $stmt = $dbconec->prepare($query);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':zona', $zona);
                $stmt->bindParam(':subzona', $subzona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':direc', $direc);
                $stmt->bindParam(':tel1', $tel1);
                $stmt->bindParam(':tel2', $tel2);
                $stmt->bindParam(':ciudad', $ciudad);
                $stmt->bindParam(':vendedor', $vendedor);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':forma_pago', $forma_pago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':cod_viejo', $cod_viejo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':alma', $alma);
                $stmt->bindParam(':cali', $cali);
                $stmt->bindParam(':tipo', $tipo);
                $stmt->bindParam(':distri', $distri);
                $stmt->bindParam(':genom', $genom);
                $stmt->bindParam(':geema', $geema);
                $stmt->bindParam(':getel1', $getel1);
                $stmt->bindParam(':getel2', $getel2);
                $stmt->bindParam(':conom', $conom);
                $stmt->bindParam(':coema', $coema);
                $stmt->bindParam(':cotel1', $cotel1);
                $stmt->bindParam(':cotel2', $cotel2);
                $stmt->bindParam(':panom', $panom);
                $stmt->bindParam(':paema', $paema);
                $stmt->bindParam(':patel1', $patel1);
                $stmt->bindParam(':patel2', $patel2);
                $stmt->bindParam(':otnom', $otnom);
                $stmt->bindParam(':otema', $otema);
                $stmt->bindParam(':ottel1', $ottel1);
                $stmt->bindParam(':ottel2', $ottel2);
                $stmt->bindParam(':remis', $remis);
                $stmt->bindParam(':fbloq', $fbloq);
                $stmt->bindParam(':diaser', $diaser);
                $stmt->bindParam(':diater', $diater);
                $stmt->bindParam(':vlrarr', $vlrarr);
                $stmt->bindParam(':acta', $acta);
                $stmt->bindParam(':pacta', $pacta);
                $stmt->bindParam(':exclui', $exclui);
                $stmt->bindParam(':person', $person);
                $stmt->bindParam(':regime', $regime);
                $stmt->bindParam(':tipoid', $tipoid);
                $stmt->bindParam(':nomreg', $nomreg);
                $stmt->bindParam(':pais', $pais);
                $stmt->bindParam(':nom1', $nom1);
                $stmt->bindParam(':nom2', $nom2);
                $stmt->bindParam(':ape1', $ape1);
                $stmt->bindParam(':ape2', $ape2);
                $stmt->bindParam(':ofi', $ofi);
                $stmt->bindParam(':difici', $difici);
                $stmt->bindParam(':remval', $remval);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':cono', $cono);
                $stmt->bindParam(':emailq', $emailq);

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

            $codigo = $datos['codigo_mod'];
            $sucursal = $datos['sucursal_mod'];
            $nombre = $datos['nombre_mod'];
            $zona = $datos['zona_mod'];
            $subzona = $datos['subzona_mod'];
            $direc = $datos['direc_mod'];
            $tel1 = $datos['tel1_mod'];
            $tel2 = $datos['tel2_mod'];
            $ciudad = $datos['ciudad_mod'];
            $vendedor = $datos['vendedor_mod'];
            $cupo = $datos['cupo_mod'];
            $legal = $datos['legal_mod'];
            $fecha_ini = $datos['fecha_ini_mod'];
            $forma_pago = $datos['forma_pago_mod'];
            $correo = $datos['correo_mod'];
            $cod_viejo = $datos['cod_viejo_mod'];
            $caract_dev = $datos['caract_dev_mod'];
            $digito = $datos['digito_mod'];
            $riva = $datos['riva_mod'];
            $rfte = $datos['rfte_mod'];
            $rica = $datos['rica_mod'];
            $alma = $datos['alma_mod'];
            $cali = $datos['cali_mod'];
            $tipo = $datos['tipo_mod'];
            $distri = $datos['distri_mod'];
            $genom = $datos['genom_mod'];
            $geema = $datos['geema_mod'];
            $getel1 = $datos['getel1_mod'];
            $getel2 = $datos['getel2_mod'];
            $conom = $datos['conom_mod'];
            $coema = $datos['coema_mod'];
            $cotel1 = $datos['cotel1_mod'];
            $cotel2 = $datos['cotel2_mod'];
            $panom = $datos['panom_mod'];
            $paema = $datos['paema_mod'];
            $patel1 = $datos['patel1_mod'];
            $patel2 = $datos['patel2_mod'];
            $otnom = $datos['otnom_mod'];
            $otema = $datos['otema_mod'];
            $ottel1 = $datos['ottel1_mod'];
            $ottel2 = $datos['ottel2_mod'];
            $remis = $datos['remis_mod'];
            $fbloq = $datos['fbloq_mod'];
            $diaser = $datos['diaser_mod'];
            $diater = $datos['diater_mod'];
            $vlrarr = $datos['vlrarr_mod'];
            $acta = $datos['acta_mod'];
            $pacta = $datos['pacta_mod'];
            $exclui = $datos['exclui_mod'];
            $person = $datos['person_mod'];
            $regime = $datos['regime_mod'];
            $tipoid = $datos['tipoid_mod'];
            $nomreg = $datos['nomreg_mod'];
            $pais = $datos['pais_mod'];
            $nom1 = $datos['nom1_mod'];
            $nom2 = $datos['nom2_mod'];
            $ape1 = $datos['ape1_mod'];
            $ape2 = $datos['ape2_mod'];
            $ofi = $datos['ofi_mod'];
            $difici = $datos['difici_mod'];
            $remval = $datos['remval_mod'];
            $estado = $datos['estado_mod'];
            $cono = $datos['cono_mod'];
            $emailq = $datos['emailq_mod'];
            $id = $datos['id'];
            // Consulta para verificar la existencia del código
            $query = "SELECT COUNT(*) as count FROM tbclientes WHERE codigo=:codigo";
            $stmt = $dbconec->prepare($query);
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
                direc=:direc, tel1=:tel1, tel2=:tel2, ciudad=:ciudad, vendedor=:vendedor, cupo=:cupo, legal=:legal, fecha_ini=:fecha_ini, 
                forma_pago=:forma_pago, correo=:correo, cod_viejo=:cod_viejo, caract_dev=:caract_dev, digito=:digito, riva=:riva, 
                rfte=:rfte, rica=:rica, alma=:alma, cali=:cali, tipo=:tipo, distri=:distri, genom=:genom, geema=:geema, getel1=:getel1, 
                getel2=:getel2, conom=:conom, coema=:coema, cotel1=:cotel1, cotel2=:cotel2, panom=:panom, paema=:paema, patel1=:patel1, 
                patel2=:patel2, otnom=:otnom, otema=:otema, ottel1=:ottel1, ottel2=:ottel2, remis=:remis, fbloq=:fbloq, diaser=:diaser, 
                diater=:diater, vlrarr=:vlrarr, acta=:acta, pacta=:pacta, exclui=:exclui, person=:person, regime=:regime, tipoid=:tipoid, 
                nomreg=:nomreg, pais=:pais, nom1=:nom1, nom2=:nom2, ape1=:ape1, ape2=:ape2, ofi=:ofi, difici=:difici, remval=:remval, 
                estado=:estado, cono=:cono, emailq=:emailq WHERE id=:id";
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
                $stmt->bindParam(':vendedor', $vendedor);
                $stmt->bindParam(':cupo', $cupo);
                $stmt->bindParam(':legal', $legal);
                $stmt->bindParam(':fecha_ini', $fecha_ini);
                $stmt->bindParam(':forma_pago', $forma_pago);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':cod_viejo', $cod_viejo);
                $stmt->bindParam(':caract_dev', $caract_dev);
                $stmt->bindParam(':digito', $digito);
                $stmt->bindParam(':riva', $riva);
                $stmt->bindParam(':rfte', $rfte);
                $stmt->bindParam(':rica', $rica);
                $stmt->bindParam(':alma', $alma);
                $stmt->bindParam(':cali', $cali);
                $stmt->bindParam(':tipo', $tipo);
                $stmt->bindParam(':distri', $distri);
                $stmt->bindParam(':genom', $genom);
                $stmt->bindParam(':geema', $geema);
                $stmt->bindParam(':getel1', $getel1);
                $stmt->bindParam(':getel2', $getel2);
                $stmt->bindParam(':conom', $conom);
                $stmt->bindParam(':coema', $coema);
                $stmt->bindParam(':cotel1', $cotel1);
                $stmt->bindParam(':cotel2', $cotel2);
                $stmt->bindParam(':panom', $panom);
                $stmt->bindParam(':paema', $paema);
                $stmt->bindParam(':patel1', $patel1);
                $stmt->bindParam(':patel2', $patel2);
                $stmt->bindParam(':otnom', $otnom);
                $stmt->bindParam(':otema', $otema);
                $stmt->bindParam(':ottel1', $ottel1);
                $stmt->bindParam(':ottel2', $ottel2);
                $stmt->bindParam(':remis', $remis);
                $stmt->bindParam(':fbloq', $fbloq);
                $stmt->bindParam(':diaser', $diaser);
                $stmt->bindParam(':diater', $diater);
                $stmt->bindParam(':vlrarr', $vlrarr);
                $stmt->bindParam(':acta', $acta);
                $stmt->bindParam(':pacta', $pacta);
                $stmt->bindParam(':exclui', $exclui);
                $stmt->bindParam(':person', $person);
                $stmt->bindParam(':regime', $regime);
                $stmt->bindParam(':tipoid', $tipoid);
                $stmt->bindParam(':nomreg', $nomreg);
                $stmt->bindParam(':pais', $pais);
                $stmt->bindParam(':nom1', $nom1);
                $stmt->bindParam(':nom2', $nom2);
                $stmt->bindParam(':ape1', $ape1);
                $stmt->bindParam(':ape2', $ape2);
                $stmt->bindParam(':ofi', $ofi);
                $stmt->bindParam(':difici', $difici);
                $stmt->bindParam(':remval', $remval);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':cono', $cono);
                $stmt->bindParam(':emailq', $emailq);

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
} // Fin de la clase
