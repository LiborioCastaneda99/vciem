<?php
	class subzonasModelo
{

	public function guardar($datos)
	{
		$cmd = subzonasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = subzonasModel::get();
	}

	public function get_id($id)
	{
		$cmd = subzonasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = subzonasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = subzonasModel::eliminar($id);
	}

}

?>