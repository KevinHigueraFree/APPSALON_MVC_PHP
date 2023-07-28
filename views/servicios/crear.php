<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Completar todos los campos para crear un servicio</p>

<?php
//include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php
    include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" name="" class="boton" value="Guardar Servicio">
</form>