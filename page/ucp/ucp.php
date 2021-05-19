<?PHP
$recaptcha = $_POST['g-recaptcha-response'];
if(!empty($recaptcha)) {
    include('modules/recaptcha.php');
    if($curlData['success']){
		if($_POST['enter']) {
			mysqli_query($CONNECT, "SET NAMES utf8");
			$_POST['login'] = FormChars($_POST['login']);
			if(!$_POST['login'] OR !$_POST['password']) $Message = 'Невозможно обработать форму!';
			else {
				$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pID` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_POST[login]'"));
				if($Row[0]) $FindAcc = $Row[0]; else $FindAcc = 0;

				if($FindAcc != 0) {
					$CHECK_DATA = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `id`, `unixtime` FROM `block_auth` WHERE `login` = '$_POST[login]' AND `ip` = '$_SESSION[USER_IP]' ORDER BY `id` DESC"));
					if($CHECK_DATA[0]) {
						if($CHECK_DATA[1] + (600) >= time()) {}
						else {
							$ID = $CHECK_DATA[0];
							mysqli_query($CONNECT, "DELETE FROM `block_auth` WHERE `id` = '$ID'");
						}
					}
					$_POST['password'] = md5(md5(FormChars($_POST['password'])));
					$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `".MYSQL_FIELD_PASSWORD."` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_POST[login]'"));
					if($Row[0] != $_POST['password']) {
						$DATA = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `id`, `unixtime` FROM `block_auth` WHERE `login` = '$_POST[login]' AND `ip` = '$_SESSION[USER_IP]' ORDER BY `id` DESC"));
						if($DATA[0]) {
							if($DATA[1] + (600) >= time()) {
								$Message = 'Ваш IP был заблокирован на 10 минут для входа в данный аккаунт!';
							} else {	
								CreateLog($_POST['login'], "Неудачная авторизация через сайт");
								$_SESSION['USER_AUTH_ERROR'] ++;
								if($_SESSION['USER_AUTH_ERROR'] >= 3) {
									$_SESSION['USER_AUTH_ERROR'] = 0;
									BlockIPForAcc($_POST['login']);
									$Message = 'Ваш IP был заблокирован на 10 минут для входа в данный аккаунт!';
								} else $Message = 'Неверный логин или пароль!';
							}
						} else {
							CreateLog($_POST['login'], "Неудачная авторизация через сайт");
							$_SESSION['USER_AUTH_ERROR'] ++;
							if($_SESSION['USER_AUTH_ERROR'] >= 3) {
								$_SESSION['USER_AUTH_ERROR'] = 0;
								BlockIPForAcc($_POST['login']);
								$Message = 'Ваш IP был заблокирован на 10 минут для входа в данный аккаунт!';
							} else $Message = 'Неверный логин или пароль!';	
						}
					} else $SUCCES_ENTER = 1;
				} else $Message = 'Неверный логин или пароль!';
			}
			if($SUCCES_ENTER == 1) {
				$_SESSION['USER_AUTH_ERROR'] = 0;
				$_SESSION['USER_LOGIN_IN'] = 1;
				$_SESSION['USER_LOGIN'] = $_POST['login'];
				$_SESSION['USER_ID'] = $FindAcc;
				CreateLog($_SESSION['USER_LOGIN'], "Авторизация через сайт");

				$howPromo = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `code` FROM `s_promocode_used` WHERE `idacca`='$_SESSION[USER_ID]'"));
				$_SESSION['USER_PROMOCODE'] = $howPromo[0];
				
				$SQL = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `u_donate` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
				if($SQL['u_donate'] < 0) {
					mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '0' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
				}
				
				$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `Google` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_POST[login]'"));
				$_SESSION['USER_GOOGLE'] = $Row['Google'];
				$_SESSION['USER_GOOGLE_AUTH'] = 0;
				
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;ucp">';
			}
		}
    } else $Message = 'Капча не пройдена!';
}

if($_POST['enter_code']) {
	if(!$_POST['code']) $Message = 'Невозможно обработать форму!';
	else
	{
		$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pID` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
		if($Row[0]) $FindAcc = 1; 
		else $FindAcc = 0;
		
		if($FindAcc != 0)
		{
			$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `GooglePassword` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
			$ga = new GoogleAuthenticator;
			$GOOGLE_CODE = $ga->getCode($Row['GooglePassword']);
			if($GOOGLE_CODE != $_POST['code']) $Message = 'Неверный 6-ти значный код';
			else $SUCCES_ENTER = 1;
		}
		else $Message = 'Неверный 6-ти значный код';	
	}
	if($SUCCES_ENTER == 1)
	{
		$_SESSION['USER_GOOGLE_AUTH'] = 1;
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;ucp">';
	}
}

if($_POST['generate_google']) {
	$ga = new GoogleAuthenticator;
	$CODE = $ga->generateSecret();
	mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `Google`= '0',`GooglePassword`= '$CODE' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
	exit(header('Location: /ucp?page=protection'));
}

if($_POST['active_google'])
{
	$SQL = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `GooglePassword` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	$ga = new GoogleAuthenticator;
	$GOOGLE_CODE = $ga->getCode($SQL['GooglePassword']);
	if($GOOGLE_CODE == $_POST['code_google'])
	{
		mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `Google`= '1' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
	}
	exit(header('Location: /ucp?page=protection'));
}

if($_POST['changepass'])
{
	$_POST['old_password'] = md5(md5(FormChars($_POST['old_password'])));
	$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `".MYSQL_FIELD_PASSWORD."` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	if($Row[0] != $_POST['old_password']) $_SESSION['ACTION_MESSAGE'] = '<span style="color: red;">Неверный текущий пароль!</span>';
	else {
		if($_POST['new_password'] != $_POST['repeat_password']) $_SESSION['ACTION_MESSAGE'] = '<span style="color: red;">Новый пароль не совпадает!</span>';
		else if((strpos($_POST['new_password'], '&') === true) || (strpos($_POST['new_password'], "'") === true) ||
				(strpos($_POST['new_password'], '"') === true) || (strpos($_POST['new_password'], '<') === true) ||
				(strpos($_POST['new_password'], '>') === true)) {
			$_SESSION['ACTION_MESSAGE'] = '<span style="color: red;">Новый пароль имеет запрещенные символы!</span>';
		}
		else if(strlen($_POST['new_password']) >= 32){ exit(header('Location: /ucp?page=protection')); }
		else $SUCCES_FUNC = 1;
	}
	if($SUCCES_FUNC == 1) {
		$NEW_PASS = md5(md5(FormChars($_POST['new_password'])));
		mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `".MYSQL_FIELD_PASSWORD."` = '$NEW_PASS' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
		
		$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `pEmail` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
		if($Row['pEmail']) {
			$m_mess = "Пароль успешно сменен! Новый пароль: ".$_POST['new_password']."";
			SendMail($Row['pEmail'], "Смена пароля", $m_mess);
		}
		
		$_SESSION['ACTION_MESSAGE'] = '<span style="color:green;">Вы успешно сменили пароль! Перезайдите в личный кабинет.</b></span>';
		ResetSession($_SESSION['USER_ID']);
	}
	exit(header('Location: /ucp?page=protection'));
}

if($_POST['changemail']){
	$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pEmail`, `activate_mail` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	$OLD_EMAIL = $Row[0];
	$EMAIL_ACTIVATE = $Row[1];
	if($OLD_EMAIL){
		if($OLD_EMAIL == $_POST['email']) $SUCCES_FUNC = 0;
		else $SUCCES_FUNC = 1;
	}
	else $SUCCES_FUNC = 1;
	
	if((strpos($_POST['email'], '&') === true) || (strpos($_POST['email'], "'") === true) ||
		(strpos($_POST['email'], '"') === true) || (strpos($_POST['email'], '<') === true) ||
		(strpos($_POST['email'], '>') === true)) { $_SESSION['ACTION_MESSAGE'] = '<span style="color:red;">Имеются запрещенные символы.</span>'; }
	else if(strlen($_POST['email']) >= 28){ $_SESSION['ACTION_MESSAGE'] = '<span style="color:red;">Не более 28 символов.</span>'; }
	else if($SUCCES_FUNC == 1){
		$CHECK_EMAIL = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pID` FROM `".MYSQL_TABLE_USERS."` WHERE `pEmail` = '$_POST[email]'"));
		if(!$CHECK_EMAIL){
			if($OLD_EMAIL && $EMAIL_ACTIVATE){
				$LOGIN_SHA = base64_encode($_SESSION['USER_LOGIN']); 
				$EMAIL_SHA = base64_encode($_POST['email']);
				$HASH = md5($LOGIN_SHA.$EMAIL_SHA);
				mysqli_query($CONNECT, "INSERT INTO `confirm_email`(`hash`, `login`, `email`) VALUES ('$HASH','$LOGIN_SHA','$EMAIL_SHA')");

				$m_mess = "Чтобы сменить E-Mail, перейдите по ссылке: https://honest-rp.su/ucp?action=confirm_mail&hash=".$HASH."";
				SendMail($OLD_EMAIL, "Смена E-Mail", $m_mess);

				$_SESSION['ACTION_MESSAGE'] = '<span style="color: green;">Письмо на смену E-Mail отправлено на <b>'.$OLD_EMAIL.'</b></span>';
			}
			else {
				$_SESSION['ACTION_MESSAGE'] = '<span style="color: green;">Вы успешно сменили e-mail на <b>'.$_POST['email'].'</b></span>';
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pEmail` = '$_POST[email]', `activate_mail` = '0' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			}
		}
		else $_SESSION['ACTION_MESSAGE'] = '<span style="color:red;">Этот e-mail '.$_POST['email'].' <b>уже привязан</b> к другому аккаунту</span>';
	}
	exit(header('Location: /ucp?page=protection'));
}

if($_POST['recovery']) {
	$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pKey`, `pEmail`, `Name`, `activate_mail` FROM `s_users` WHERE `Name` = '$_POST[login]' OR `pEmail` = '$_POST[login]'"));
	$PASS = $Row[0];
	$EMAIL = $Row[1];
	$LOGIN = $Row[2];
	$ACTIVATE_EMAIL = $Row[3];
	if($EMAIL) {
		if(!$ACTIVATE_EMAIL) {
			$LOGIN_SHA = base64_encode($LOGIN); 
			$EMAIL_SHA = base64_encode($EMAIL);

			$m_mess = "Чтобы активировать E-Mail, перейдите по ссылке: https://honest-rp.su/ucp?action=active_mail&login=".$LOGIN_SHA."&email=".$EMAIL_SHA."";
			SendMail($EMAIL, "Активация E-Mail", $m_mess);

			$_SESSION['ACTION_MESSAGE'] = '<span style="color: green;">Для восстановления пароля сначала требуется подтвердить E-mail<br>На привязанный E-Mail отправлено письмо о подтвержении</span>';
		} else {
			$user = base64_encode($LOGIN);
			$hash = md5($user.$PASS);

			$m_mess = "Вы отправили запрос на смену пароля.<br>
			Перейдите по ссылке, чтобы подтвердить действие:<br>
			https://honest-rp.su/ucp?action=recovery_pass&user=".$user."&hash=".$hash;
			SendMail($EMAIL, "Восстановления пароля", $m_mess);

			$_SESSION['ACTION_MESSAGE'] = '<span style="color:green;">На Ваш E-Mail отправлено письмо о восстановлении пароля.</span>';
		}
	} else if($EMAIL) $_SESSION['ACTION_MESSAGE'] = '<span style="color:red;">На Вашем аккаунте отсутствует информация о E-Mail!<br>
	<p style="font-size:0.4em;color:#bd0b4c;">Для восстановления доступа к аккаунту обратитесь в тех. раздел на форуме.</p></b></span>';
	else $_SESSION['ACTION_MESSAGE'] = '<span style="color:red;">Не найдено совпадений с введенными данными!</b></span>';
	exit(header('Location: /ucp?action=recovery'));
}

if(isset($_GET['page'])) $PAGE = $_GET['page'];
else $PAGE = '0';

if(isset($_GET['action'])) $ACTION = $_GET['action'];
else $ACTION = '0';
?>
<?PHP
	include('modules/head.php'); 
	include('modules/header.php');
	if(!$ACTION && !$_SESSION['USER_LOGIN_IN']) include('page/ucp/ucp_login.php');
	else if($_SESSION['USER_GOOGLE'] && !$_SESSION['USER_GOOGLE_AUTH'] && $PAGE != 'logout') include('page/ucp/ucp_google_login.php');
	else if($PAGE)
	{
		switch($PAGE)
		{
			case '0':
			{
				include('page/ucp/ucp_profile.php');
				break;
			}
			case 'profile':
			{
				include('page/ucp/ucp_profile.php');
				break;
			}
			case 'protection':
			{
				include('page/ucp/ucp_protection.php');
				break;
			}
			case 'fracpanel':
			{
				include('page/ucp/ucp_fracpanel.php');
				break;
			}
			case 'roulette':
			{
				include('page/ucp/ucp_roulette.php');
				break;
			}
			case 'offgoogle':
			{
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `GooglePassword` = 'None', `Google` = '0' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
				exit(header('Location: /ucp?page=protection'));
				break;
			}
			case 'logout':
			{
				$_SESSION['USER_LOGIN_IN'] = 0;
				$_SESSION['USER_GOOGLE'] = 0;
				$_SESSION['USER_GOOGLE_AUTH'] = 0;
				exit(header('Location: /ucp'));
				break;
			}
			case 'balance':
			{
				include('page/ucp/ucp_balance.php');
				break;
			}
			/*case 'services':
			{
				include('page/ucp/ucp_services.php');
				break;
			}*/
			case 'adminpanel':
			{
				include('page/ucp/adminpanel.php');
				break;
			}
			default:
			{
				include('page/ucp/ucp_profile.php');
				break;
			}
		}
	}
	else if(!$ACTION && !$PAGE) include('page/ucp/ucp_profile.php');
	else if($ACTION && !$PAGE)
	{
		switch($ACTION)
		{
			case 'recovery':
			{
				include('page/ucp/ucp_recovery.php');
				break;	
			}
			case 'recovery_pass':
			{
				if(isset($_GET['user'])) $user = $_GET['user']; else $user = 0;
				if(isset($_GET['hash'])) $hash = $_GET['hash']; else $hash = 0;
				$nowuser = base64_decode($user);

				$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pKey` FROM `s_users` WHERE `Name` = '$nowuser'"));
				$nowhash = md5($user.$Row[0]);
				
				if($nowhash != $hash) $_SESSION['ACTION_MESSAGE'] = 'Ссылка недействительна!';
				else {
					$newpass = generate_password(7);
					$passforsql = md5(md5($newpass));
					mysqli_query($CONNECT, "UPDATE `s_users` SET `pKey`='$passforsql',`Google`='0' WHERE `Name` = '$nowuser'");
					$_SESSION['ACTION_MESSAGE'] = 'Вы успешно активировали новый пароль: <b style="text-transform:none;">'.$newpass.'</b><br>
					<p style="font-size:0.4em;color:#bd0b4c;">Все методы защиты аккаунта были автоматически отключены.</b>';
				}
				include('page/ucp/ucp_active.php');
				break;	
			}
			case 'confirm_mail':
			{
				if(isset($_GET['hash'])) $HASH = $_GET['hash'];
				else $HASH = 0;
				if(!$HASH ) exit(header('Location: /ucp'));
				$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `login`, `email` FROM `confirm_email` WHERE `hash` = '$HASH'"));
				if(!$HASH || !$Row[0] || !$Row[1]) $_SESSION['ACTION_MESSAGE'] = 'Ссылка недействительна!';
				else {
					$LOGIN = base64_decode($Row[0]);
					$EMAIL = base64_decode($Row[1]);
					mysqli_query($CONNECT, "DELETE FROM `confirm_email` WHERE `hash`='$HASH'");
					mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pEmail` = '$EMAIL', `activate_mail` = '0' WHERE `".MYSQL_FIELD_LOGIN."` = '$LOGIN'");
					$LOGIN_SHA = base64_encode($LOGIN); 
					$EMAIL_SHA = base64_encode($EMAIL);

					$m_mess = "Чтобы активировать E-Mail, перейдите по ссылке: https://honest-rp.su/ucp?action=active_mail&login=".$LOGIN_SHA."&email=".$EMAIL_SHA."";
					SendMail($EMAIL, "Активация E-Mail", $m_mess);

					$_SESSION['ACTION_MESSAGE'] = 'Вы успешно сменили e-mail. Письмо активации нового e-mail было отправлено на почту';
				}
				include('page/ucp/ucp_active.php');
				break;
			}
			case 'active_mail':
			{
				if(isset($_GET['login'])) $LOGIN_SHA = $_GET['login'];
				else $LOGIN_SHA = 0;
				if(isset($_GET['email'])) $EMAIL_SHA = $_GET['email'];
				else $EMAIL_SHA = 0;
				$LOGIN = base64_decode($LOGIN_SHA);
				$EMAIL = base64_decode($EMAIL_SHA);
				if(!$LOGIN_SHA || !$EMAIL_SHA) exit(header('Location: /ucp'));
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pEmail` = '$EMAIL', `activate_mail` = '1' WHERE `".MYSQL_FIELD_LOGIN."` = '$LOGIN'");
				$_SESSION['ACTION_MESSAGE'] = 'E-Mail успешно активирован';
				include('page/ucp/ucp_active.php');
				break;
			}
			case 'return_send':
			{
				$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `pEmail` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
				$LOGIN = $_SESSION['USER_LOGIN'];
				$EMAIL = $Row[0];
				$LOGIN_SHA = base64_encode($LOGIN); 
				$EMAIL_SHA = base64_encode($EMAIL);

				$m_mess = "Чтобы активировать E-Mail, перейдите по ссылке: https://honest-rp.su/ucp?action=active_mail&login=".$LOGIN_SHA."&email=".$EMAIL_SHA."";
				SendMail($EMAIL, "Активация E-Mail", $m_mess);

				$_SESSION['ACTION_MESSAGE'] = 'Письмо активации e-mail было отправлено на почту';
				include('page/ucp/ucp_active.php');
				break;
			}
			default:
			{
				include('page/ucp/ucp_login.php');
				break;
			}
		}
	}		
	include('modules/footer.php');
?>