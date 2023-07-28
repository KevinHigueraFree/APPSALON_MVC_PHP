<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion()
    {
        //! Crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('higuerak047@gmail.com'); //aqui va el dominio cuando se hace el deplioment del proyecto
        $mail->addAddress('higuerak047@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Confirmar tu cuenta';
        //! set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has creado tu cuenta en App Salon, solo debes confirmarlo presionando en el siguiente enlace </p>";
        $contenido .= "<p>presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'> Confirmar cuenta</a> </p>";
        $contenido .= "<p> Sí tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //! Enviar email
        $mail->send();
    }
    public function enviarInstrucciones()
    {
        //! Crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('higuerak047@gmail.com'); //aqui va el dominio cuando se hace el deplioment del proyecto
        $mail->addAddress('higuerak047@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Restablece tu password';
        //! set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has solicitado establecer tu password. Sigue el siguiente enlace para continuar</p>";
        $contenido .= "<p>presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recover?token=" . $this->token . "'> Restablecer password</a> </p>";
        $contenido .= "<p> Sí tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //! Enviar email
        $mail->send();
    }
}
