<h2 class="nombre-pagina">Panel de administracion</h2>

<?php

use Model\Cita;

include_once __DIR__ . '/../templates/barra.php';
?>
<h2>Buscar Citas</h2>

<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        </div>
    </form>
</div>

<?php
if (count($citas) === 0) {
    echo "<h3>No hay citas en esta fecha</h3>";
}
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as  $key => $cita) {
            if ($idCita !== $cita->id) {
                $total = 0;
                $idCita = $cita->id;
        ?>

                <h3>Cita</h3>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                    <h3>Servicios</h3>
                <?php } //fin if   
            //! suma de precios
            $total += $cita->precio;

                ?>
                <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio;  ?></p>

                <?php
                //todo actual: tendra el id en el que nos encontramos
                //todo proximo: indice del arreglo en la base de datos, idetifica cual es la ultima cita con el mismo id para entonces sumar el precio
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total: <span><?php echo '$' . $total; ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="eliminar">
                    </form>

                    <a href="<?php $_SERVER['HTTP_REFERER'] ?>">Redireccionar</a>
            <?php } //fin if esUltimo
            } // fin foreach 
            ?>

    </ul>
</div>

<?php
$script = "<script src='build/js/buscador.js'></script>";
?>