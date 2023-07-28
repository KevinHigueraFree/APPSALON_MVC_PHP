<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {

        session_start(); //para iniciar session y obtener datos
        //! comprobar si el usuario esta autenticado
       // isAuth();
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'], //creamos la variable nombre para pasarla a el index
            'id' => $_SESSION['id']
        ]);
    }
}
