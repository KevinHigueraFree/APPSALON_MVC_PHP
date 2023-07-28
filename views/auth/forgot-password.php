<h1 class="nombre-pagina">I Forgot Password</h1>
<p class="descripcion-pagina">Reset your password writting your e-mail to next</p>
<?php
//dir hace referencia al archivo actual
include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/forgot" method="POST" class="formulario">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Your Email">
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
    <a href="/">Do you have a account? Login</a>
    <a href="/crear-cuenta">Don't you have a account? Log up </a>
</div>