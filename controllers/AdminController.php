<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();// verifica que sea admin
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha); //separar la fecha por guiones
        //? checkdate(mes,dia,año): revisa que  los valores de la fecha sean validos, 
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        //! consultar base de datos
        $consulta = " SELECT citas.id,  citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas ";
        $consulta .= " INNER JOIN usuarios ON citas.usuarioId=usuarios.id  ";
        $consulta .= " INNER JOIN citasservicios ON citasservicios.citaId=citas.id ";
        $consulta .= " INNER JOIN servicios ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha='${fecha}' ";

        $citas = AdminCita::SQL($consulta); // va a active record busca ek metodo SQL y retprma un 

        //variables que pasaremos a la vista de index
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'], // extraemos el nombre de sesion
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
