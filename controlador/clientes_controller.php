<?php
	class clientesModelo
{

	public function guardar($datos)
	{
		$cmd = clientesModel::guardar($datos);
	}

	public function get()
	{
		$cmd = clientesModel::get();
	}

	public function get_id($id)
	{
		$cmd = clientesModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = clientesModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = clientesModel::eliminar($id);
	}

}

?>