<?php
	class usuariosModelo
{

	public function guardar($datos)
	{
		$cmd = usuariosModel::guardar($datos);
	}

	public function get()
	{
		$cmd = usuariosModel::get();
	}

	public function get_id($id)
	{
		$cmd = usuariosModel::get_id($id);
	}

	public function combo_roles($nombre,$id)
	{
		$cmd = usuariosModel::combo_roles($nombre, $id);
	}

	public function modificar($datos)
	{
		$cmd = usuariosModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = usuariosModel::eliminar($id);
	}

}

?>