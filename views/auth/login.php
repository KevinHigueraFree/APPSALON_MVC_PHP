<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php
//dir hace referencia al archivo actual
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Your Email" name="email" value="<?php
          echo s($auth->email);  
        ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Your Password" name="password">
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión">

</form>
<div class="acciones">
    <a href="/crear-cuenta">¿A un no te has registrado? Crea una aquí</a>
    <a href="/forgot">¿Olvidaste tu contraseña? Cambialo aquí</a>
</div>