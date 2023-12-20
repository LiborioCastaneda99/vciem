<?php
	class vendedoresModelo
{

	public function guardar($datos)
	{
		$cmd = vendedoresModel::guardar($datos);
	}

	public function get()
	{
		$cmd = vendedoresModel::get();
	}

	public function get_id($id)
	{
		$cmd = vendedoresModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = vendedoresModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = vendedoresModel::eliminar($id);
	}

}

?>