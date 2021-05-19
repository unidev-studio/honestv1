<?php
if(isset($_GET['t']) && isset($_GET['s']) && isset($_GET['m'])){ $mail_return = 1; $userMail = $_GET['t']; $subjectMail = $_GET['s']; $message = $_GET['m']; }
else if(isset($_POST['t']) && isset($_POST['s']) && isset($_POST['m'])){ $mail_return = 1; $userMail = $_POST['t']; $subjectMail = $_POST['s']; $message = $_POST['m']; }
else $mail_return = 0;
if($mail_return == 1){
	# $userMail - Емайл получателя
	# $subjectMail - Тема письма
	# $message - Текст сообщения, здесь вы можете вставлять таблицы, рисунки, заголовки, оформление цветом и т.п.
	if(preg_match("/[0-9]/", $message)){
		$sm_check = preg_replace("/[^0-9]/", '', $message); # Оставляем только цифры, составляем текст
		$subjectMail = "Подтверждение e-mail";
		$message = "Код для подтверждения e-mail: ".$sm_check."<br><br>
		Если Вы не отправляли сообщения о подтверждении почты, проигнорируйте это письмо.";
	}
	require_once('modules/mailer.php');
} else include('page/404.php');