<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}


// funcion que revisa si el usuario esta autenticado
// void es que no retorna nada

function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /'); // redirecciona al usuario
    }
}


//! Verifica que esta logeado
function esUltimo(string $actual, string $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}

//! Verifica que es administrador
function isAdmin(): void
{
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}
