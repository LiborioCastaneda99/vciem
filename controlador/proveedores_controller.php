<?php
	class proveedoresModelo
{

	public function guardar($datos)
	{
		$cmd = proveedoresModel::guardar($datos);
	}

	public function get()
	{
		$cmd = proveedoresModel::get();
	}

	public function get_id($id)
	{
		$cmd = proveedoresModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = proveedoresModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = proveedoresModel::eliminar($id);
	}

}

?>