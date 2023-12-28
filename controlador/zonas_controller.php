<?php
	class zonasModelo
{

	public function guardar($datos)
	{
		$cmd = zonasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = zonasModel::get();
	}

	public function get_id($id)
	{
		$cmd = zonasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = zonasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = zonasModel::eliminar($id);
	}

	public function combo_zonas($nombre,$id)
	{
		$cmd = zonasModel::combo_zonas($nombre, $id);
	}
}

?>