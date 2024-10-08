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
$body = "";

if(trim(!empty($_POST['tel']))){
    $body .= "<u>Вам нове повідомлення з сайту</u>%0A";
    $body .= "<b>Телефон:</b> %2B" .$_POST['tel']."%0A";
}
if(trim(!empty($_POST['name']))){
    $body .= "<b>Імя:</b> " .$_POST['name']."%0A";
}
if(trim(!empty($_POST['select']))){
    $body .= "<b>Місцезнаходження:</b> " .$_POST['select'];
}

$mail->Body = $body;

// Отправка в телеграм =====================================================
$token = "6258764392:AAH55OzDD9WFvYhVDVPsM03LEc7QxTVDRy8";
$chat_id_1 = "-4144450350"; // 💰 Интернет лиды

// Отправка в телеграм =====================================================
$trimmed_body = trim($body);

if(!empty($trimmed_body)){
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id_1}&parse_mode=html&text={$body}","r");
}

if($sendToTelegram && $mail->send()) {
    $message = "Дані відправлено!";
} else {
    $message = "Помилка";
}

$response = ['message' => $message];
header('Content-type: application/json');
echo json_encode($response);
?>

