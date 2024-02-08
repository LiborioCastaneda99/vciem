<?php
	class gruposModelo
{

	public function guardar($datos)
	{
		$cmd = gruposModel::guardar($datos);
	}

	public function get()
	{
		$cmd = gruposModel::get();
	}

	public function get_id($id)
	{
		$cmd = gruposModel::get_id($id);
	}

	public function modificar($datos)
	{
		$cmd = gruposModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = gruposModel::eliminar($id);
	}

	public function combo_clases($nombre,$id)
	{
		$cmd = gruposModel::combo_clases($nombre, $id);
	}


}

?>