<h1 class="nombre-pagina">Recover password</h1>
<p class="descripcion-pagina">Write your new password to next</p>
<?php
include_once __DIR__ . '/../templates/alertas.php';
?>
<!-- No mostrar formulario si error es true -->
<?php
    if($error) return;
?>
<form class="formulario" method="POST"><!-- Se envia a la misma URL, al mismo input -->
    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Write your new password">
    </div>
    <input type="submit" class="boton" value="Save New Password">
</form>
<div class="acciones">
    <a href="/">Do you have account?, Log in</a>
    <a href="/crear-cuenta">Don't you have account?, Log out</a>
</div>