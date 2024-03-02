<?php
	class facturacionModelo
{

	public function guardar($datos)
	{
		$cmd = facturacionModel::guardar($datos);
	}

	public function guardar_factura_espera($datos)
	{
		$cmd = facturacionModel::guardar_factura_espera($datos);
	}

	public function get()
	{
		$cmd = facturacionModel::get();
	}

	public function get_id($id)
	{
		$cmd = facturacionModel::get_id($id);
	}

	public function consultar_factura_espera($datos)
	{
		$cmd = facturacionModel::consultar_factura_espera($datos);
	}

	public function modificar($datos)
	{
		$cmd = facturacionModel::modificar($datos);
	}

	public function eliminar($id)
	{
		$cmd = facturacionModel::eliminar($id);
	}

	public function combo_caja($nombre, $id)
	{
		$cmd = facturacionModel::combo_caja($nombre, $id);
	}

	public function combo_factura($nombre, $id)
	{
		$cmd = facturacionModel::combo_factura($nombre, $id);
	}

}

?>