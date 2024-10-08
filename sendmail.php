<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
// require_once 'PHPMailer/PHPMailerAutoload.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->isHTML(true);

// От кого письмо
$mail->setFrom('admin@posluhybti.com', 'Користувач з сайту');
// Кому отправить
$mail->addAddress('orders@posluhybti.com');
// Тема письма
$mail->Subject = 'Нове замовлення';

// Тело письма
$body = '<h2>Вам нове повідомлення з сайту</h2>';

if(trim(!empty($_POST['tel']))){
    $body .= '<p><strong>Телефон:</strong> ' .$_POST['tel'].'</p>';
}
if(trim(!empty($_POST['name']))){
    $body .= '<p><strong>Імя:</strong> ' .$_POST['name'].'</p>';
}
 
$mail->Body = $body;

// Отправляем

if(!$mail->send()) {
$message = 'Помилка';
} else {
    $message = 'Дані відправлено!';
}

$response = ['message' => $message];
header('Content-type: application/json');
echo json_encode($response);
?>