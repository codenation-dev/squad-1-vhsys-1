 <?php 
    session_start();
    $token_session = (isset($_SESSION['token']))?$_SESSION['token']:''; 
    $email_usu= (isset($_SESSION['email']))?$_SESSION['email']:''; 
  