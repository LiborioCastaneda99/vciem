<?php
	class tallasModelo
{

	public function guardar($datos)
	{
		$cmd = tallasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = tallasModel::get();
	}

	public function get_id($id)
	{
		$cmd = tallasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = tallasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = tallasModel::eliminar($id);
	}

}

?>