<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Registro extends Model
{
	public $nombre;
	public $email;
	public $password;
	public $password_repeat;
	public $edad;
	public $dni;
	public $rol;

	public function rules()
	{
		return [
			[['nombre', 'email', 'password', 'password_repeat', 'edad', 'dni'], 'required'],
			
			['email', 'email'],
			['edad', 'integer', 'min' => 18, 'message' => 'Debes ser mayor de 18 años.'],
			
			['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Las contraseñas no coinciden."],
			
			['email', 'unique', 'targetClass' => '\app\models\Usuarios', 'message' => 'Este email ya está registrado.'],
			
			['rol', 'safe']
		];
	}
	
	public function attributeLabels()
	{
		return [
			'nombre' => 'Nombre Completo',
			'email' => 'Correo Electrónico',
			'edad' => 'Edad',
			'dni' => 'DNI',
			'password_repeat' => 'Repetir Contraseña',
		];
	}

	public function registrar()
	{
		if (!$this->validate()) {
			return null;
		}
		
		$user = new Usuarios();
		$user->nombre = $this->nombre;
		$user->email = $this->email;
		$user->dni = $this->dni;
		$user->edad = $this->edad;
		$user->password = $this->password; 
		$user->rol = 'Cliente';
		
		return $user->save() ? $user : null;
	}
}