<?php

session_start();

if (isset($_GET['email'])) {
    $_SESSION['email'] = $_GET['email'];
}

if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];
}