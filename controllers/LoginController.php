<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo 'desde post';
            $auth = new Usuario($_POST); //Pasamos el valor de post a auth
            $alertas = $auth->validarLogin();
            if (empty($alertas)) {
                echo 'password y email agregado';
                //!comprobar que el usuario existe
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    //!Verificar el password
                    if ($usuario->comprobarPasswordAndVerifiqued($auth->password)) {
                        //!Inicio de sesión;
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //!Redireccionamiento
                        //admin esta en base de datos 
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }

                    }
                } else {
                    Usuario::setAlerta('error', 'Este usuario no existe');
                }

                $alertas = Usuario::getAlertas();
            }
        }

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout(Router $router)
    {
        session_start(); // inicia sesión

        $_SESSION = []; // limpia la sesion 

        header('Location: /');
    }
    public static function forgot(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    if ($usuario->confirmado === "1") {
                        //! Generar token
                        $usuario->crearToken();
                        $usuario->guardar();
                        //! enviar email
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarInstrucciones();
                        //todo Alerta de exito
                        Usuario::setAlerta('exito', 'Revisa tu email');
                    } else {
                        Usuario::setAlerta('error', 'Existe pero falta confirmación'); //agregafr alertas
                    }
                } else {
                    Usuario::setAlerta('error', 'Este usuario no existe');
                }
            }
            $alertas = Usuario::getAlertas(); //obtener alertas
        }
        $router->render('auth/forgot-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recover(Router $router)
    {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']); //Le asignamos el token que esta en la url
        //! Buscar usuario por token
        $usuario = Usuario::where('token', $token); //informacion de la  base de datos
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //! leer el nuevo password y guardarlo
            $password = new Usuario($_POST); //lo que el usuario escribió
            $alertas = $password->validarPassword();
            if (empty($alertas)) {
                //!borrar el password
                $usuario->password = null;
                //todo: Asignamos el password de la instancia de password al de la instancia de usuario
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null; //borramos el token
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }


            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recover-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        //! Alertas vacias
        $alertas = []; //se llenara cuando se de clic en crear

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validadNuevaCuenta();

            //! Revisar que el arreglo este vacio
            if (empty($alertas)) {
                //! Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas(); //Se llena alertas
                } else {
                    //! hashear password
                    $usuario->hashPassword();
                    //! generar token único
                    $usuario->crearToken();
                    //!Emviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //! Crear usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        //! pasamos varisbles hacia la vista
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            //! Mostrar error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            Usuario::setAlerta('exito', 'Token válido, confirmando usuario...');
            //! Modificar usuario confirmado
            $usuario->confirmado = "1";
            //!Eliminar token
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada exitosamente');
        }
        //!Obtener alertas
        $alertas = Usuario::getAlertas();
        //! Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
