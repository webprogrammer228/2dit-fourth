<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language');

try {
  $name = $_POST['name'];
  $tel = $_POST['telephone'];
  $email = $_POST['email'];

  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->isSMTP();  
  $mail->Host       = 'ssl://smtp.mail.ru';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'petrenkoemail@mail.ru';                     //SMTP username
  $mail->Password   = 'plu6T41Tb5Lxrj4g3BOk';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
  $mail->Port       = 465; 
    //Recipients
    $mail->setFrom('petrenkoemail@mail.ru', 'Олег Петренко');
    $mail->addAddress('почтовый_ящик_получателя', 'Имя_Получателя');     //Add a recipient

    $mail->Subject = 'Привет! Письмо отправлено';

    $mail->isHTML(true);
    $body = 'Вот и тело письма!';

    if (trim(!empty($_POST['name']))) {
      $body.= "<p><strong>Имя: </strong> ".$name.'</p>';
    }
    if (trim(!empty($_POST['telephone']))) {
      $body.= "<p><strong>Телефон: </strong> ".$tel.'</p>';
    }
    if (trim(!empty($_POST['email']))) {
      $body.= "<p><strong>Почта: </strong> ".$email.'</p>';
    }
    
    $mail->Body = $body;

    if (!$mail->send()) {
      $message = 'Ошибка';
    }
    else {
      $message = 'Данные отправлены';
    }

    $response = ['message' => $message];
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}