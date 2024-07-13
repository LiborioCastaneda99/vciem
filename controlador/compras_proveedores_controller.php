<?php
	class comprasProveedorModelo
{

	public function guardar($datos)
	{
		$cmd = comprasProveedorModel::guardar($datos);
	}

	public function get()
	{
		$cmd = comprasProveedorModel::get();
	}

	public function get_id($id)
	{
		$cmd = comprasProveedorModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = comprasProveedorModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = comprasProveedorModel::eliminar($id);
	}

}

?>