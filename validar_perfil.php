<?php
require_once('modelo/Conexion.php');  // Se carga la clase conexion

class validarPerfil extends Conexion
{

    // Función para verificar si el usuario tiene un permiso específico
    function tienePermiso($usuario, $permisoRequerido)
    {
        $dbconec = Conexion::Conectar();

        // Aquí deberías implementar la lógica para verificar si el usuario tiene el permiso requerido
        // Puedes consultar la base de datos o usar la información almacenada en la sesión, según tu implementación
        // Devuelve true si el usuario tiene el permiso, false en caso contrario
        // Ejemplo simplificado:

        $query = "SELECT `fld_codusuario`, `nombres`, `fld_nomusuario`, `fld_iconsecutivo`, `fld_clave`, `rol_id` 
        FROM `user` WHERE fld_codusuario = $usuario";
        $stmt = $dbconec->prepare($query);
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        $rows_ = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log(json_encode($rows_));
        if ($rows_) {
            $rol_id = $rows_[0]['rol_id'];
            echo ("rol_id => " . $rol_id);
            $query = "SELECT P.nombre FROM `roles_permisos` As RP
            INNER JOIN roles As R ON R.id = RP.`rol_id`
            INNER JOIN permisos As P ON P.id = RP.`permiso_id`
            WHERE RP.rol_id = $rol_id";
            $stmt = $dbconec->prepare($query);
            $stmt->execute();
            // Obtener todos los resultados como un array asociativo
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Devolver el array JSON con todos los tbtallas
            $datos = [];
            for ($i = 0; $i < count($rows); $i++) {
                array_push($datos, $rows[$i]["nombre"]);
            }
        }
        error_log("rows " . json_encode($datos));
        error_log("permisoRequerido " . $permisoRequerido);

        return in_array($permisoRequerido, $datos);
    }
}
