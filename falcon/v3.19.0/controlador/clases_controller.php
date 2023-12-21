<?php
	class clasesModelo
{

	public function guardar($datos)
	{
		$cmd = clasesModel::guardar($datos);
	}

	public function get()
	{
		$cmd = clasesModel::get();
	}

	public function get_id($id)
	{
		$cmd = clasesModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = clasesModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = clasesModel::eliminar($id);
	}

}

?>