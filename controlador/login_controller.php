<?php
	class loginModelo
{

    
    public function Restaurar_Password($usuario, $contrasena)
	{

		$cmd = LoginModel::Restaurar_Password($usuario, $contrasena);
	}

	public function Login_Usuario($datos)
	{
		$cmd = LoginModel::Login_Usuario($datos);
	}

	public function guardar_color($datos)
	{
		$cmd = LoginModel::guardar_color($datos);
	}

	public function get_color()
	{
		$cmd = LoginModel::get_color();
	}

}

?>