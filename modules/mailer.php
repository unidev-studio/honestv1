<?php
//$userMail = 'admin@gmail.com'; # Емайл получателя
//$subjectMail = 'Тема сообщения'; # Тема письма
//$message = 'Сообщение'; # Текст сообщения
$email = 'admin@domain.ru';
$projectName = 'Project';
require_once('modules/mail_model.php');

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0; # 2=ON
$mail->Host = 'localhost';
$mail->Port = 587;
$mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false;
$mail->CharSet = 'utf-8';
$mail->setFrom($email, $projectName);
$mail->addReplyTo($email, $projectName);
$mail->addAddress($userMail);
$mail->Subject = '=?utf-8?B?'.base64_encode($subjectMail).'?=';
$mail->msgHTML($message);
//$mail->addAttachment('test.txt'); # Вложение
$mail->send();