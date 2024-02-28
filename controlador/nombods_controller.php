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

	public function combo_caja($nombre, $id)
	{
		$cmd = nombodsModel::combo_caja($nombre, $id);
	}

	public function combo_factura($nombre, $id)
	{
		$cmd = nombodsModel::combo_factura($nombre, $id);
	}

}

?>