<?php
include_once 'setting.php';
$wl_enable = 0;
$wl_desc = 'Ожидаем обновление сайта ;)';
$SNOW_MODE = 0;
require_once('modules/google/GoogleAuthenticator.php');
session_start();
$_SESSION['USER_IP'] = GetIP();
$CONNECT = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB); // База сервера
$CONNECTP = mysqli_connect(MYSQL_HOST_SITE, MYSQL_USER_SITE, MYSQL_PASS_SITE, MYSQL_DB_SITE); // База сайта

mysqli_query($CONNECT, "SET NAMES utf8");
mysqli_query($CONNECTP, "SET NAMES utf8");

/*if($_SESSION['USER_LOGIN_IN'] == 1){
	mysqli_query($CONNECT, "SET NAMES utf8");
	mysqli_query($CONNECTP, "SET NAMES utf8");
}*/

if($_SERVER['REQUEST_URI'] == '/') Location('/index');
else {
	$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$URL_Parts = explode('/', trim($URL_Path, ' /'));
	$Page = array_shift($URL_Parts);
	$Module = array_shift($URL_Parts);
	if(!empty($Module)){
		$Param = array();
		for($i = 0; $i < count($URL_Parts); $i++){
			$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
		}
	}
}

include 'scripts/scripts.php';
include 'modules/variables.php'; 

$ss_count = 0;
while($ss_count < count($ss_clear)){
	$ss_count++;
	if($_SESSION['USER_ID'] == $ss_clear[$ss_count]){
		$_SESSION['USER_LOGIN_IN'] = 0;
		$_SESSION['USER_GOOGLE'] = 0;
		$_SESSION['USER_GOOGLE_AUTH'] = 0;
		unset($ss_clear[$ss_count]);
		file_put_contents('scripts/session_clear.txt.php', $ss_clear);
	}
}

header('Content-Type: text/html; charset=utf-8');
if($wl_enable == 1) include('modules/whitelist.php');
else include('modules/page_module.php');

function FormChars ($p1){ return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false); }
function GenPass ($p1, $p2){ return md5('GEN'.md5('321'.$p1.'123').md5('678'.$p2.'890')); }
function Location ($p1){ if (!$p1) $p1 = $_SERVER['HTTPS_REFERER']; exit(header('Location: '.$p1)); }
function rus_date(){
	$translate = array(
	 "am" => "дп",
	 "pm" => "пп",
	 "AM" => "ДП",
	 "PM" => "ПП",
	 "Monday" => "Понедельник",
	 "Mon" => "Пн",
	 "Tuesday" => "Вторник",
	 "Tue" => "Вт",
	 "Wednesday" => "Среда",
	 "Wed" => "Ср",
	 "Thursday" => "Четверг",
	 "Thu" => "Чт",
	 "Friday" => "Пятница",
	 "Fri" => "Пт",
	 "Saturday" => "Суббота",
	 "Sat" => "Сб",
	 "Sunday" => "Воскресенье",
	 "Sun" => "Вс",
	 "January" => "Января",
	 "Jan" => "Янв",
	 "February" => "Февраля",
	 "Feb" => "Фев",
	 "March" => "Марта",
	 "Mar" => "Мар",
	 "April" => "Апреля",
	 "Apr" => "Апр",
	 "May" => "Мая",
	 "May" => "Мая",
	 "June" => "Июня",
	 "Jun" => "Июн",
	 "July" => "Июля",
	 "Jul" => "Июл",
	 "August" => "Августа",
	 "Aug" => "Авг",
	 "September" => "Сентября",
	 "Sep" => "Сен",
	 "October" => "Октября",
	 "Oct" => "Окт",
	 "November" => "Ноября",
	 "Nov" => "Ноя",
	 "December" => "Декабря",
	 "Dec" => "Дек",
	 "st" => "ое",
	 "nd" => "ое",
	 "rd" => "е",
	 "th" => "ое"
	);
	if(func_num_args() > 1){
		$timestamp = func_get_arg(1);
		return strtr(date(func_get_arg(0), $timestamp), $translate);
	} else { return strtr(date(func_get_arg(0)), $translate); }
}	
function generate_password($number){
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++){
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
}
function GetIP(){
	if(!empty($_SERVER['HTTPS_CLIENT_IP'])){ $ip = $_SERVER['HTTPS_CLIENT_IP']; } 
	else if(!empty($_SERVER['HTTPS_X_FORWARDED_FOR'])){ $ip = $_SERVER['HTTPS_X_FORWARDED_FOR']; } 
	else{ $ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}
function BlockIPForAcc($login){
	global $CONNECT;
	$UNIXTIME = time();
	mysqli_query($CONNECT, "INSERT INTO `block_auth`(`login`, `ip`, `unixtime`) VALUES ('$login', '$_SESSION[USER_IP]', $UNIXTIME)");
}
function UCP_MENU(){
	global $CONNECT;
	$CHECK_LID = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `fID` FROM `frac` WHERE `fLeader` = '$_SESSION[USER_LOGIN]'"));
	$CH_ADM = mysqli_query($CONNECT, "SELECT * FROM `apanel` WHERE `sName` = '$_SESSION[USER_LOGIN]'");
	$CHECK_ADM = mysqli_num_rows($CH_ADM); $CHADP = mysqli_fetch_array($CH_ADM);
	echo '<td width="20%" class="ucp_menu">
		<a href="?page=profile"><label>Профиль</label></a><br><br>
		<!--<a href="?page=services"><label>Услуги</label></a><br><br>-->
		<a href="?page=roulette"><label>Рулетка</label></a><br><br>
		<a href="?page=protection"><label>Защита аккаунта</label></a><br><br>';
	if($CHECK_LID >= 1) echo '<a href="?page=fracpanel"><label>Управление организацией</label></a><br><br>';
	if($CHECK_ADM >= 1) echo '<a href="/adminpanel"><label>Администраторский раздел</label></a><br><br>';
	echo '<a href="?page=logout"><label>Выйти</label></a><br><br>
	</td>';
}
function APANEL_MENU(){
	global $CONNECT;
	$CHADP = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `apanel` WHERE `sName` = '$_SESSION[USER_LOGIN]'"));
	echo '<td width="20%" class="ucp_menu">
		<a href="?page=index"><label style="margin-left:10px;">Главная</label></a><br><br>';
		if($CHADP['sdlMoney'] == 1) echo '<a href="?page=moneylog"><label style="margin-left:10px;">Денежный лог</label></a><br><br>';
		echo '<a href="?page=toprich"><label style="margin-left:10px;">Топ Богачей</label></a><br><br>';
		if($CHADP['sdlFrac'] == 1) echo '<a href="?page=fraclog"><label style="margin-left:10px;">Лог фракций</label></a><br><br>';
		if($CHADP['sdlAdm'] == 1) echo '<a href="?page=adminlog"><label style="margin-left:10px;">Админ лог</label></a><br><br>';
		if($CHADP['sdlUser'] == 1) echo '<a href="?page=userlog"><label style="margin-left:10px;">Действия игроков</label></a><br><br>';
		if($CHADP['sdRoot'] == 1) echo '<a href="?page=achievlog"><label style="margin-left:10px;">Achiev-Лог</label></a><br><br>
										<a href="?page=weblog"><label style="margin-left:10px;">Web-Лог</label></a><br><br>
										<a href="?page=authlog"><label style="margin-left:10px;">История блокировки IP</label></a><br><br>';
		echo '<a href="/ucp"><label style="margin-left:10px;">Назад в ЛК</label></a><br><br>
	</td>';
}
function SendMail($userMail, $subjectMail, $message) {
	require_once('modules/mailer.php');
}
function SendVKM($user_id, $message) {
	return 1;
}
function sendTelegram($tg_id, $mess) {
    return 1;
}
function CreateLog($user, $log) {
	global $CONNECT;
	mysqli_query($CONNECT, "INSERT INTO `weblog`(`nick`, `action`, `date`) VALUES ('$user', '$log', NOW())");
}
function ResetSession($userid) {
	$ss_sc = 'scripts/session_clear.txt.php'; $ss_cl = file_get_contents($ss_sc);
	$ss_cl .= "\r\n".$userid; file_put_contents($ss_sc, $ss_cl);
}
function AddCashStats($sum) {
	global $CONNECT;
	$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `web` FROM `movecash`"));
	$sum = $Row[0] + $sum;
	mysqli_query($CONNECT, "UPDATE `movecash` SET `web` = '$sum'");
}