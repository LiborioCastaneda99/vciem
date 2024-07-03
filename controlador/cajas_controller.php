<?php
	class cajasModelo
{

	public function guardar($datos)
	{
		$cmd = cajasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = cajasModel::get();
	}

	public function get_id($id)
	{
		$cmd = cajasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = cajasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = cajasModel::eliminar($id);
	}
	
	public function combo_caja($nombre, $id)
	{
		$cmd = cajasModel::combo_caja($nombre, $id);
	}

}

?>