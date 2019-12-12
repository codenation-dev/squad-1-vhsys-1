<?php

session_start();

$email = "";
if (isset($_GET['email'])) {
    $email  = $_GET['email'];
    $_SESSION['email'] = $email;
}

if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];
}

$lembrar = false;

if (isset($_GET['lembrarDeMim'])) {
    $lembrar = $_GET['lembrarDeMim'];    
}

if (($lembrar) && ($email !== ""))
{       
	$cookie_name = 'email';
	$cookie_value = $_GET['email'];	
	setcookie($cookie_name, $cookie_value, time() + 300 /* 5 min */, "/"); 
    $_COOKIE[$cookie_name] = $cookie_value;    
}
