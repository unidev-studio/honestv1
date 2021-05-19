<?PHP
if($_POST['enter']) {
	if(!$_POST['password']) $Message = 'Невозможно обработать форму!';
	else {
		$Row = mysqli_num_rows(mysqli_query($CONNECT, "SELECT * FROM `sl_apanel` WHERE `sName` = '$_SESSION[USER_LOGIN]'"));
		if($Row >= 1) $FindAcc = 1; else $FindAcc = 0;
		
		if($FindAcc != 0) {
			$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `password` FROM `s_admin` WHERE `Name` = '$_SESSION[USER_LOGIN]'"));
			if($Row[0] != $_POST['password']) $Message = 'Неверный Пароль либо Вы не администратор!';
			else $SUCCES_ENTER = 1;
		}
		else $Message = 'Неверный Пароль либо Вы не администратор!';	
	}
	if($SUCCES_ENTER == 1) {
		$_SESSION['ADM_LOGIN_IN'] = 1;
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;adminpanel">';
	}
}

if(isset($_GET['page'])) $PAGE = $_GET['page']; else $PAGE = '0';
?>
<?PHP
	include('modules/head.php'); 
	include('modules/header.php');
	$chAdmDRow = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `sl_apanel` WHERE `sName` = '$_SESSION[USER_LOGIN]'"));
	if(!$_SESSION['USER_LOGIN_IN']) include('page/ucp/ucp_login.php');
	else if(!$_SESSION['ADM_LOGIN_IN']) include('page/adminpanel/adm_login.php');
	else if($PAGE) {
		switch($PAGE) {
			case '0': { include('page/adminpanel/adm_index.php'); break; }
			case 'index': { include('page/adminpanel/adm_index.php'); break; }
			case 'toprich': { include('page/adminpanel/adm_toprich.php'); break; }
			case 'moneylog': {
				if($chAdmDRow['sdlMoney'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_moneylog.php'); break;
			}
			case 'adminlog': {
				if($chAdmDRow['sdlAdm'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_adminlog.php'); break;
			}
			case 'userlog': {
				if($chAdmDRow['sdlUser'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_userlog.php'); break;
			}
			case 'asetting': {
				if($chAdmDRow['sdAdmins'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_asetting.php'); break;
			}
			case 'usersearch': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_usersearch.php'); break;
			}
			case 'us_historyconnect': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_historyconnect.php'); break;
			}
			case 'us_historyname': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_historyname.php'); break;
			}
			case 'us_historywarn': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_historywarn.php'); break;
			}
			case 'us_historyban': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_historyban.php'); break;
			}
			case 'us_moneylog': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_moneylog.php'); break;
			}
			case 'us_userlog': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_userlog.php'); break;
			}
			case 'us_fraclog': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_fraclog.php'); break;
			}
			case 'us_achievlog': {
				if($chAdmDRow['sdlSearch'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_us_achievlog.php'); break;
			}
			case 'editserver': {
				if($chAdmDRow['sdRoot'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_editserver.php'); break;
			}
			case 'weblog': {
				if($chAdmDRow['sdRoot'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_weblog.php'); break;
			}
			case 'authlog': {
				if($chAdmDRow['sdRoot'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_authlog.php'); break;
			}
			case 'transfer': {
				if($chAdmDRow['sdTransfer'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_transfer.php'); break;
			}
			case 'fraclog': {
				if($chAdmDRow['sdlFrac'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_fraclog.php'); break;
			}
			case 'achievlog': {
				if($chAdmDRow['sdRoot'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_achievlog.php'); break;
			}
			case 'cfoll': {
				if($chAdmDRow['sdCfoll'] == 0) include('page/adminpanel/adm_index.php');
				else include('page/adminpanel/adm_cfoll.php'); break;
			}
			default: { include('page/adminpanel/adm_index.php'); break; }
		}
	}
	else if(!$PAGE) include('page/adminpanel/adm_index.php');
	include('modules/footer.php');
?>