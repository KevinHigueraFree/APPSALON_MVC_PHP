<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>
<?php
//dir hace referencia al archivo actual (creahr-cuenta.php)
include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Name: </label>
        <input type="text" id="nombre" name="nombre" placeholder="Your Name" value="<?php
                                                                                    echo s($usuario->nombre);
                                                                                    ?>">
    </div>
    <div class="campo">
        <label for="apellido">Last name: </label>
        <input type="text" id="apellido" name="apellido" placeholder="Your Last Name" value="<?php
                                                                                                echo s($usuario->apellido);
                                                                                                ?>">
    </div>
    <div class="campo">
        <label for="telefono">Phone number: </label>
        <input type="tel" id="telefono" name="telefono" placeholder="Your Phone Number" value="<?php
                                                                                                echo s($usuario->telefono);
                                                                                                ?>">
    </div>
    <div class="campo">
        <label for="email">E-mail: </label>
        <input type="email" id="email" name="email" placeholder="Your E-mail" value="<?php
                                                                                        echo s($usuario->email);
                                                                                        ?>">
    </div>
    <div class="campo">
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" placeholder="Your Password">
    </div>
    <input type="submit" placeholder="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">Do you have a account? Login</a>
    <a href="/forgot">Did you forget your password? Change here</a>
</div>