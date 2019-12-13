 <?php 
    session_start();


  
    $token_session = (isset($_SESSION['token']))?$_SESSION['token']:''; 

    $email_usu= (isset($_SESSION['email']))?$_SESSION['email']:''; 
  
    if ($email_usu === ''){
      if(isset($_COOKIE['email'])) {         
         $email_usu = $_COOKIE['email'];
      }
   } 