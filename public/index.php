<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//!iniciar sesión
$router->get('/', [LoginController::class, 'login']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->post('/', [LoginController::class, 'login']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->get('/logout', [LoginController::class, 'logout']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos

//! Recuperar password
$router->get('/forgot', [LoginController::class, 'forgot']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->post('/forgot', [LoginController::class, 'forgot']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->get('/recover', [LoginController::class, 'recover']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->post('/recover', [LoginController::class, 'recover']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos

//! Crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->post('/crear-cuenta', [LoginController::class, 'crear']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos

//! Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->get('/mensaje', [LoginController::class, 'mensaje']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos


//! Area privada
$router->get('/cita', [CitaController::class, 'index']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos
$router->get('/admin', [AdminController::class, 'index']); //cuando visitemos el sitio por primera vez seras ese sitio el que visitaremos

//! API de citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

//! CRUD de servicios
$router->get('/servicios',[ServicioController::class, 'index']);
$router->get('/servicios/crear',[ServicioController::class, 'crear']);
$router->post('/servicios/crear',[ServicioController::class, 'crear']);
$router->get('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar',[ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
