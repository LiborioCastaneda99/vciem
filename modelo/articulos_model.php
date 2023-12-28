<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion

class articulosModel extends Conexion
{

    public static function get()
    {
        $dbconec = Conexion::Conectar();

        try {
            $query = "SELECT `id`, `codigo`, `homol`, `nombre`, `clase`, `grupo`, `referencia`, `umedida`, 
            `stmin`, `stmax`, `ctostan`, `ctoult`, `fecult`, `nal`, `pv1`, `pv2`, `pv3`, `ubicacion`, `uxemp`, 
            `peso`, `iva`, `impo`, `flete`, `estado`, `canen`, `valen`, `pdes`, `ultpro`, `docpro` FROM tbarticulos WHERE activo = 1";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                // Devolver el array JSON con todos los tbarticulos
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
            $query = "SELECT COUNT(*) as count FROM tbarticulos WHERE codigo=:codigo";
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
} // Fin de la clase
