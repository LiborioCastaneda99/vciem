<?php
class proveedoresModelo
{

	public function guardar($datos)
	{
		$cmd = proveedoresModel::guardar($datos);
	}

	public function get()
	{
		$cmd = proveedoresModel::get();
	}

	public function get_id($id)
	{
		$cmd = proveedoresModel::get_id($id);
	}

	public function get_cod($codigo)
	{
		$cmd = proveedoresModel::get_cod($codigo);
	}

	public function modificar($datos)
	{
		$cmd = proveedoresModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = proveedoresModel::eliminar($id);
	}

	public function combo_departamentos($nombre, $id)
	{
		$cmd = proveedoresModel::combo_departamentos($nombre, $id);
	}

	public function combo_ciudades($nombre, $id)
	{
		$cmd = proveedoresModel::combo_ciudades($nombre, $id);
	}
	public function combo_ciudades_all($nombre, $id)
	{
		$cmd = proveedoresModel::combo_ciudades_all($nombre, $id);
	}
	public function combo_ciudades_cod($nombre, $id)
	{
		$cmd = proveedoresModel::combo_ciudades_cod($nombre, $id);
	}
	public function combo_proveedores($nombre, $id)
	{
		$cmd = proveedoresModel::combo_proveedores($nombre, $id);
	}
	public function combo_vendedores($nombre, $id)
	{
		$cmd = proveedoresModel::combo_vendedores($nombre, $id);
	}
}
