<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface; // <--- OBLIGATORIO

class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    // Nombre de la tabla
    public static function tableName()
    {
        return 'usuarios';
    }

    // Reglas de validación (Gii)
    public function rules()
    {
        return [
            [['nombre', 'email', 'password', 'rol'], 'required'],
            [['rol'], 'string'],
            [['nombre', 'email'], 'string', 'max' => 100],
            [['password', 'access_token'], 'string', 'max' => 255],
            [['num_carnet_conducir'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_usuario' => 'ID',
            'nombre' => 'Nombre Usuario',
            'email' => 'Correo Electrónico',
            'password' => 'Contraseña',
            'rol' => 'Rol',
            'auth_key' => 'Auth Key (Cookie)',
        ];
    }

    // ==================================================
    // LÓGICA DE LOGIN (IdentityInterface)
    // ==================================================

    // 1. Buscar usuario por ID (lo usa Yii en cada recarga de página)
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    // 2. Buscar por Token (Para APIs, aquí no lo usamos pero es obligatorio ponerlo)
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; 
    }

    // 3. Buscar usuario por Nombre (Lo usa el Formulario de Login)
    public static function findByUsername($username)
    {
        // Buscamos por 'nombre'. Si prefieres loguear con email, cambia 'nombre' por 'email'
        return static::findOne(['nombre' => $username]);
    }

    // 4. Obtener el ID del usuario actual
    public function getId()
    {
        return $this->id_usuario; // OJO: Tu clave primaria es 'id_usuario'
    }

    // 5. Obtener el Token (Auth Key)
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    // 6. Validar el Token (Seguridad de Cookies)
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    // 7. Validar Contraseña
    public function validatePassword($password)
    {
        // MODO SIMPLE (Texto plano) - Para prácticas
        return $this->password === $password;
        
        // MODO PRO (Encriptado) - Para el futuro
        // return Yii::$app->security->validatePassword($password, $this->password);
    }
    
    // TRUCO: Generar token automáticamente al crear un usuario o cambiar contraseña
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Genera un string aleatorio de seguridad
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}