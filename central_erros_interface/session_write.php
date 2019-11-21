<?php
/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} else {
    session_destroy();
    session_start();
}
*/
session_start();

if (isset($_GET['email'])) {
    $_SESSION['email'] = $_GET['email'];
}

if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];
}

//header('Location:./tabelaErros.php');