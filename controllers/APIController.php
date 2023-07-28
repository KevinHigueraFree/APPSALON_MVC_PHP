<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();
        echo json_encode($servicios); // covierte  sefvicios a codigo json y asi se puede leer por json
    }
    public static function guardar()
    {

        //! Almacena la cita y devuelve ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar(); // lo inserta en la base de datos

        $id = $resultado['id']; // 'id' viene de la base de datos

        //! Almacena la cita y el servicio
        //todo almacena los servicios con el id de la cita
        //? explode(): divide una cadena en partes creando un arreglo
        $idServicios = explode(",", $_POST['servicios']); //arreglo
        foreach ($idServicios as $idServicio) {
            //constructor de citas servicios
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args); // le pasamos los argumentos
            $citaServicio->guardar(); // el foreach ira guardando cada uno de los servicios con la referencia de la cita
        }

        //todo retornamos una respuesta


        echo json_encode(['resultado' => $resultado]); //convierte el texto plano en texto de formato json
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // para que se ejecute solo cuando el metodo sea post
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);//REDIRECCIONA A LA PAGINA actual
        }
    }
}
