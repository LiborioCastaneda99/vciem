<?php
class loginModel
{

    public function Listado_Lineas()
    {
        $filas = loginModel::Listado_Lineas();
        return $filas;
    }
    public function Combo_Lineas($searchTerm, $id)
    {

        $filas = loginModel::Combo_Lineas($searchTerm, $id);
        return $filas;
    }
    public function Consultar_Lineas($id)
    {

        $filas = loginModel::Consultar_Lineas($id);
        return $filas;
    }
    public function Insertar_Lineas($codigo, $nombre, $usrProcess, $usrFecha, $usrHora)
    {
        $cmd = loginModel::Insertar_Lineas($codigo, $nombre, $usrProcess, $usrFecha, $usrHora);
        return $cmd;
    }
    public function Modificar_Lineas($codigo, $nombre, $id, $usrProcess, $usrFecha, $usrHora)
    {
        $cmd = loginModel::Modificar_Lineas($codigo, $nombre, $id, $usrProcess, $usrFecha, $usrHora);
        return $cmd;
    }
    public function Eliminar_Lineas($id)
    {
        $cmd = loginModel::Eliminar_Lineas($id);
        return $cmd;
    }

}

?>