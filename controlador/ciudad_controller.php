<?php
	class ciudadesModelo
{

	public function guardar($datos)
	{
		$cmd = ciudadesModel::guardar($datos);
	}

	public function get()
	{
		$cmd = ciudadesModel::get();
	}

	public function get_id($id)
	{
		$cmd = ciudadesModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = ciudadesModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = ciudadesModel::eliminar($id);
	}

}

?>