<?php
	class umedidasModelo
{

	public function guardar($datos)
	{
		$cmd = umedidasModel::guardar($datos);
	}

	public function get()
	{
		$cmd = umedidasModel::get();
	}

	public function get_id($id)
	{
		$cmd = umedidasModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = umedidasModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = umedidasModel::eliminar($id);
	}

	public function combo_umedida($nombre, $id)
	{
		$cmd = umedidasModel::combo_umedida($nombre, $id);
	}

}

?>