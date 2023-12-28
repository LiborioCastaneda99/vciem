<?php
	class tipomoinsModelo
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

}

?>