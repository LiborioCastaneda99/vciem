<?php
class articulosModelo
{

	public function guardar($datos)
	{
		$cmd = articulosModel::guardar($datos);
	}

	public function get()
	{
		$cmd = articulosModel::get();
	}

	public function get_id($id)
	{
		$cmd = articulosModel::get_id($id);
	}

	public function get_id_productos($id)
	{
		$cmd = articulosModel::get_id_productos($id);
	}

	public function modificar($datos)
	{
		$cmd = articulosModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = articulosModel::eliminar($id);
	}

	public function listado_productos()
	{
		$cmd = articulosModel::listado_productos();
	}
}
