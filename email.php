<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($pdo)
{
    $userId = $_SESSION['id'];

    $encomenda = $pdo->query("select documento from encomenda where user_id = $userId order by data desc limit 1");
    $encomenda = $encomenda->fetch(PDO::FETCH_OBJ);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = '86385128ec676c';                     // SMTP username
        $mail->Password = 'e5c2acf649f816';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $mail->setFrom('noreply@phonestore.pt');
        $mail->addAddress($_SESSION['email']);
        $mail->addReplyTo('info@phonestore.pt', 'Phone Store');

        $mail->addAttachment($encomenda->documento);

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Confirmaçao de Compra';
        $mail->Body = 'Obrigado pela sua compra, em anexo segue o recibo relativo a sua compra, Phone Store';

        $mail->AltBody = 'Obrigado pela sua compra, em anexo segue o recibo relativo a sua compra, Phone Store';

        $mail->send();
    } catch (Exception $e) {
    }
}