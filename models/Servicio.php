<?php

namespace Model;

class Servicio extends ActiveRecord
{
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    //Hace referencia con la base de datos
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';

    }
    public function  validar(){
        if(!$this->nombre){
            self::$alertas['error'][]='No has ingresado el nombre del servicio';
        }
        if(!$this->precio){
            self::$alertas['error'][]='No has ingresado el precio';
        }elseif(!is_numeric($this->precio)){
            self::$alertas['error'][]='Precio inválido';
        }
        return self::$alertas;
    }
}
