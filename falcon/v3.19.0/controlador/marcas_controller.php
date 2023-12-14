<?php
	class marcasModelo
{

	public function guardar($datos)
	{
		$cmd = marcasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = marcasModel::get();
	}

	public function get_id($id)
	{
		$cmd = marcasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = marcasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = marcasModel::eliminar($id);
	}

}

?>