<?php
	class nombodsModelo
{

	public function guardar($datos)
	{
		$cmd = nombodsModel::guardar($datos);
	}

	public function get()
	{
		$cmd = nombodsModel::get();
	}

	public function get_id($id)
	{
		$cmd = nombodsModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = nombodsModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = nombodsModel::eliminar($id);
	}

}

?>