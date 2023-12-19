<?php
	class transportadoresModelo
{

	public function guardar($datos)
	{
		$cmd = transportadoresModel::guardar($datos);
	}

	public function get()
	{
		$cmd = transportadoresModel::get();
	}

	public function get_id($id)
	{
		$cmd = transportadoresModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = transportadoresModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = transportadoresModel::eliminar($id);
	}

}

?>