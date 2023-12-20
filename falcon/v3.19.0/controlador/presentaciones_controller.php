<?php
	class presentacionesModelo
{

	public function guardar($datos)
	{
		$cmd = presentacionesModel::guardar($datos);
	}

	public function get()
	{
		$cmd = presentacionesModel::get();
	}

	public function get_id($id)
	{
		$cmd = presentacionesModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = presentacionesModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = presentacionesModel::eliminar($id);
	}

}

?>