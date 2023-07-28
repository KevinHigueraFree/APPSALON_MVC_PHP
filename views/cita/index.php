<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>


<?php
    include_once __DIR__. '/../templates/barra.php';
?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus Servicios</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion formulario">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Ingresa tus datos y fecha de tu cita</p>
        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Name</label>
                <input type="text" id="nombre" placeholder="Your name" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php
                                                    echo date('Y-m-d', strtotime('+1 day')); // para que la fecha sea 1 dia mas y no el dia actual
                                                    ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>"><!-- Para insertar el id por default -->
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">

        <h2>Resumen</h2>
        <p class="text-center">Asegurate que tu información es la correcta</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div class="paginacion">
        <button type="" id="anterior" class="boton">&laquo; Anterior</button>
        <button type="" id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>

</div>
<?php
$script = "
<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>

    <script src='build/js/app.js'></script>
    ";
?>