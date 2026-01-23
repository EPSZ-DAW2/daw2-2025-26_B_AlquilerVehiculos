<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id_usuario
 * @property string $nombre
 * @property string $email
 * @property string $password
 * @property int $edad
 * @property string|null $rol
 * @property string|null $dni
 * @property int|null $menor_25
 * @property string|null $auth_key
 */
class Usuarios extends ActiveRecord implements IdentityInterface
{
	const SCENARIO_PERFIL = 'perfil';

	public static function tableName()
	{
		return 'usuarios';
	}

	public function rules()
	{
		return [
			[['nombre', 'email', 'edad', 'dni'], 'required'],
			[['password'], 'required', 'on' => 'default'], 
			[['password'], 'safe', 'on' => self::SCENARIO_PERFIL],
			[['edad', 'menor_25'], 'integer'],
			[['rol'], 'string'],
			[['nombre', 'email'], 'string', 'max' => 100],
			[['password'], 'string', 'max' => 255],
			[['dni'], 'string', 'max' => 50],
			[['auth_key'], 'string', 'max' => 32],
			[['email'], 'unique'],
		];
	}

	public function attributeLabels()
	{
		return [
			'id_usuario' => 'ID',
			'nombre' => 'Nombre Completo',
			'email' => 'Correo Electrónico',
			'password' => 'Contraseña',
			'edad' => 'Edad',
			'rol' => 'Rol',
			'dni' => 'DNI',
			'menor_25' => '¿Es menor de 25?',
			'auth_key' => 'Auth Key',
		];
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			
			$this->menor_25 = ($this->edad < 25) ? 1 : 0;

			if ($this->isNewRecord) {
				$this->auth_key = \Yii::$app->security->generateRandomString();
				
				$this->password = \Yii::$app->security->generatePasswordHash($this->password);
			} else {
				if (!empty($this->password) && strlen($this->password) < 60) {
					 $this->password = \Yii::$app->security->generatePasswordHash($this->password);
				}
			}

			return true;
		}
		return false;
	}

	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['auth_key' => $token]);
	}

	public static function findByUsername($username)
	{
		return static::find()
			->where(['email' => $username])
			->orWhere(['nombre' => $username])
			->one();
	}

	public function getId()
	{
		return $this->id_usuario;
	}

	public function getAuthKey()
	{
		return $this->auth_key;
	}

	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	public function validatePassword($password)
	{
		if (strlen($this->password) < 60) {
			return $this->password === $password;
		}
		return Yii::$app->security->validatePassword($password, $this->password);
	}
}