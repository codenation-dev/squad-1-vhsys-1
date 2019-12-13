<?php


namespace Central\Framework;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class CentralMail
{
    public static function enviarEmail(string $destino, string $conteudo)
    {
        try {

            $mensagemCorpo  = "<a href='".$conteudo."'>Clique aqui para criar uma nova senha.</a>";

            $emailSquad = 'squad1php@gmail.com';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->Username = $emailSquad;
            $mail->Password = 'lpdiqkembpjzoscu';
            $mail->setFrom($emailSquad);
            $mail->addAddress($destino);
            $mail->addCC($emailSquad);

            $mail->Subject = 'Recupera senha';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Body    = $mensagemCorpo;
            $mail->AltBody = 'teste';

            $mail->send();
        } catch (\Throwable $exception){

        }

    }
}