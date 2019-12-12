<?php


namespace Central\Framework;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class CentralMail
{
    public static function enviarEmail(string $destino, string $conteudo)
    {
        try {
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->Username = 'squad1php@gmail.com';
            $mail->Password = 'lpdiqkembpjzoscu';
            $mail->setFrom('aceleradev.squad@gmail.com', 'Central');
            $mail->addAddress($destino);
            $mail->Subject = 'Recupera senha';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Body    = $conteudo;
            $mail->AltBody = 'teste';

            $mail->send();
        } catch (\Throwable $exception){

        }

    }
}