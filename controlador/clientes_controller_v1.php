<?php
	class clientesModelo
{

	public function guardar($datos)
	{
		$cmd = clientesModel::guardar($datos);
	}

	public function get()
	{
		$cmd = clientesModel::get();
	}

	public function get_id($id)
	{
		$cmd = clientesModel::get_id($id);
	}

	public function get_cod($codigo)
	{
		$cmd = clientesModel::get_cod($codigo);
	}

	public function modificar($datos)
	{
		$cmd = clientesModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = clientesModel::eliminar($id);
	}

	public function combo_departamentos($nombre,$id)
	{
		$cmd = clientesModel::combo_departamentos($nombre, $id);
	}

	public function combo_ciudades($nombre,$id)
	{
		$cmd = clientesModel::combo_ciudades($nombre, $id);
	}

}

?>