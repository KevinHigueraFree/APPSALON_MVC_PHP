<?php

namespace Model;

class Usuario extends ActiveRecord
{
    //!Base de datos
    protected static $tabla = 'usuarios'; //Ctrar una variable con el nombre de una tabla
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    //!Definición del modelo
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }
    //!Mensajes de validación para la creación de una cuenta
    public function validadNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Te hizo falta el Nombre del cliente';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'Te hizo falta el Apellido del cliente';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Te hizo falta el E-mail del cliente';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Te hizo falta el Password del cliente';
        }
        if ($this->password && strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    //! Revisar si usuario existe
    public function existeUsuario()
    {
        $select = "SELECT * FROM " . self::$tabla . " WHERE email= '" . $this->email . "' LIMIT 1 ;";
        $resultado = self::$db->query($select);
        if ($resultado) {
            self::$alertas['error'][] = 'Este usuario ya existe. Utiliza otro correo';
        }
        return $resultado;
    }
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken()
    {
        //? uniqid: genera una combinacion de caracteres;
        $this->token = uniqid();
    }
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'No ingresaste un correo';
        }
        if ($this->password && strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña es de almenos 6 caracteres';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'No ingresaste una contraseña';
        }
        return self::$alertas;
    }
    public function comprobarPasswordAndVerifiqued($password)
    {
        //? password_verify : toma password que nos ha dado el usuario y password HASHEADO que esta en la base de datos
        $resultado = password_verify($password, $this->password);
        /*    if ($password === $this->password) {
            $resultado = true;
        } */

        if (!$resultado) {
            self::$alertas['error'][] = 'Contraseña incorrecta';
        }
        if (!$this->confirmado) {
            self::$alertas['error'][] = 'Cuenta no confirmada';
        } else {
            return true;
        }
    }
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'No ingresaste un correo';
        }
        return self::$alertas;
    }
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if ($this->password && strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El passworddebe tener almenos 6 caracteres';
        }
    }
}
