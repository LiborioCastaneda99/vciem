<?php
	class tipofactModelo
{

	public function guardar($datos)
	{
		$cmd = tipomoinsModel::guardar($datos);
	}

	public function get()
	{
		$cmd = tipomoinsModel::get();
	}

	public function get_id($id)
	{
		$cmd = tipomoinsModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = tipomoinsModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = tipomoinsModel::eliminar($id);
	}

	public function combo_tipomoins($nombre, $id)
	{
		$cmd = tipomoinsModel::combo_tipomoins($nombre, $id);
	}

	public function combo_tipofact($nombre, $id)
	{
		$cmd = tipomoinsModel::combo_tipofact($nombre, $id);
	}

}

?>