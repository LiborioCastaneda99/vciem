<?php
	class menuModelo
{

	public function guardar($datos)
	{
		$cmd = menuModel::guardar($datos);
	}

	public function get()
	{
		$cmd = menuModel::get();
	}

	public function get_id($id)
	{
		$cmd = menuModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = menuModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = menuModel::eliminar($id);
	}

}

?>