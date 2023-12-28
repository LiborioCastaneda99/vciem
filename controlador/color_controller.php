<?php
	class colorModelo
{

	public function guardar($datos)
	{
		$cmd = colorModel::guardar($datos);
	}

	public function get()
	{
		$cmd = colorModel::get();
	}

	public function get_id($id)
	{
		$cmd = colorModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = colorModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = colorModel::eliminar($id);
	}

}

?>