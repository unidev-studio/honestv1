<?PHP
if($_SESSION['USER_LOGIN'] == "") header("Location: https://honest-rp.su/404.php");
//else { $lg = md5($_SESSION['USER_LOGIN']); $dd = md5(date('dmYhi')); $CHECK_ROULETTE_HASH = md5(''.$lg.$dd.''); }
else if(!$_SESSION['ROULETTE_HASH']) header("Location: https://honest-rp.su/404.php");
else {
	if(isset($_POST['itemid'])) $ITEM_ID = $_POST['itemid'];
	if(isset($_POST['login'])){ $usr_login = $_POST['login']; $in = 1; }
	else { $usr_login = $_SESSION['USER_LOGIN']; $in = 0; }
	$RowItem = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `roulette_item` WHERE `id` = '$ITEM_ID'"));
	$RowSql = mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
	$RowPlayer = mysqli_fetch_array($RowSql);
	// Fix Accs
	if($RowPlayer['playerItems'] == ''){
		$RowPlayer['playerItems'] = '0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0';
	}
	//
	if(($RowItem['ownerid'] != $RowPlayer['pID']) && $in == 0) $TEXT = 'ERROR'; // Фикс обхода использования чужих предметов
	else if(!mysqli_num_rows($RowSql)) $TEXT = 'ERROR_USER';
	else if($RowPlayer['pLogin'] == '0'){
		$CH2CAR = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `vModel` FROM `s_vehicle_player` WHERE `vOwner` = '$RowPlayer[pID]'"));
		switch($RowItem['type']){
			case "1": {
				$TEXT = '+ '.$RowItem['amount'].' EXP';
				$EXP = $RowItem['amount'] + $RowPlayer['pExp'];
				$LEVEL = $RowPlayer['pLevel'];
				$pCash = $RowPlayer['pCash'];
				$NEXT_LEVEL = ($RowPlayer['pLevel'] + 1) * 4;
				if($EXP >= $NEXT_LEVEL){
					$EXP = $EXP - $NEXT_LEVEL;
					$LEVEL++;
					if($LEVEL == 4){ $addMoney = 200000; }
					else if($LEVEL == 10){ $addMoney = 300000; }
					else if($LEVEL == 20){ $addMoney = 500000; }
					$pCash = $pCash + $addMoney;
				}
				//
				$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pExp` = '$EXP', `pLevel` = '$LEVEL', `pCash` = '$pCash' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
				AddCashStats($addMoney);
				//Логирование
				if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
				else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
				break;
			}
			case "2": {
				$TEXT = '+ '.$RowItem['amount'].' вирт';
				$MONEY = $RowItem['amount'] + $RowPlayer['pCash'];
				//
				$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pCash` = '$MONEY' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
				AddCashStats($RowItem['amount']);
				//Логирование
				if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
				else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
				break;
			}
			case "3": {
				if (1 == 1){ //$RowPlayer['licenses'] != '1,1,1,1,1,1'
					$TEXT = 'Комплект лицензий';
					$LICTIME = explode("|", $RowPlayer['licensesTime']);
					if($LICTIME[0] == '0'){ $LICTIME[0] = strtotime('+2 week'); }
					else{ $LICTIME[0] = strtotime(date('Y-m-d', $LICTIME[0]).' +2 week'); }
					if($LICTIME[1] == '0'){ $LICTIME[1] = strtotime('+2 week'); }
					else{ $LICTIME[1] = strtotime(date('Y-m-d', $LICTIME[1]).' +2 week'); }
					if($LICTIME[2] == '0'){ $LICTIME[2] = strtotime('+2 week'); }
					else{ $LICTIME[2] = strtotime(date('Y-m-d', $LICTIME[2]).' +2 week'); }
					if($LICTIME[3] == '0'){ $LICTIME[3] = strtotime('+2 week'); }
					else{ $LICTIME[3] = strtotime(date('Y-m-d', $LICTIME[3]).' +2 week'); }
					if($LICTIME[4] == '0'){ $LICTIME[4] = strtotime('+2 week'); }
					else{ $LICTIME[4] = strtotime(date('Y-m-d', $LICTIME[4]).' +2 week'); }
					$licensesTime = ''.$LICTIME[0].'|'.$LICTIME[1].'|'.$LICTIME[2].'|'.$LICTIME[3].'|'.$LICTIME[4].'|0';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `licenses` = '1,1,1,1,1,1', `licensesTime` = '$licensesTime' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORLIC'; break; }
			}
			case "4": {
				if ($RowPlayer['pGunSkills'] != '100,100,100,100,100,100'){
					$TEXT = 'Все скиллы';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pGunSkills` = '100,100,100,100,100,100' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKILL'; break; }
			}
			case "5": {
				$TEXT = ''.$RowItem['amount'].' фриспин рулетки';
				$freespins = $RowItem['amount'] + $RowPlayer['w_rSpins'];
				//
				$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `w_rSpins` = '$freespins' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
				//Логирование
				if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
				else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
				break;
			}
			case "6": {
				$TEXT = 'Кэшбек '.$RowItem['amount'].' рублей';
				$cashback = $RowItem['amount'] + $RowPlayer['u_donate'];
				//
				$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '$cashback' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
				//Логирование
				if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
				else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
				break;
			}
			// ТРАНСПОРТ //
			case "7": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '400';
					$TEXT = 'Транспорт Landstalker.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Landstalker ".$usr_login.""; else $LOGACTION = "Использовал транспорт Landstalker ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Landstalker"; else $LOGACTION = "Использовал транспорт Landstalker [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "8": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '573';
					$TEXT = 'Транспорт Dune.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Dune ".$usr_login.""; else $LOGACTION = "Использовал транспорт Dune ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Dune"; else $LOGACTION = "Использовал транспорт Dune [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "9": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '409';
					$TEXT = 'Транспорт Stretch.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Stretch ".$usr_login.""; else $LOGACTION = "Использовал транспорт Stretch ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Stretch"; else $LOGACTION = "Использовал транспорт Stretch [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "10": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '442';
					$TEXT = 'Транспорт Romero.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Romero ".$usr_login.""; else $LOGACTION = "Использовал транспорт Romero ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Romero"; else $LOGACTION = "Использовал транспорт Romero [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "11": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '421';
					$TEXT = 'Транспорт Washington.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Washington ".$usr_login.""; else $LOGACTION = "Использовал транспорт Washington ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Washington"; else $LOGACTION = "Использовал транспорт Washington [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "12": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '434';
					$TEXT = 'Транспорт Hotknife.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Hotknife ".$usr_login.""; else $LOGACTION = "Использовал транспорт Hotknife ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Hotknife"; else $LOGACTION = "Использовал транспорт Hotknife [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "13": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '587';
					$TEXT = 'Транспорт Euros.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Euros ".$usr_login.""; else $LOGACTION = "Использовал транспорт Euros ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Euros"; else $LOGACTION = "Использовал транспорт Euros [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "14": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '535';
					$TEXT = 'Транспорт Slamvan.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Slamvan ".$usr_login.""; else $LOGACTION = "Использовал транспорт Slamvan ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Slamvan"; else $LOGACTION = "Использовал транспорт Slamvan [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "15": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '483';
					$TEXT = 'Транспорт Camper.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Camper ".$usr_login.""; else $LOGACTION = "Использовал транспорт Camper ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Camper"; else $LOGACTION = "Использовал транспорт Camper [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "16": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '521';
					$TEXT = 'Транспорт FCR-900.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт FCR-900 ".$usr_login.""; else $LOGACTION = "Использовал транспорт FCR-900 ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт FCR-900"; else $LOGACTION = "Использовал транспорт FCR-900 [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "17": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '471';
					$TEXT = 'Транспорт Quad.<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Quad ".$usr_login.""; else $LOGACTION = "Использовал транспорт Quad ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Quad"; else $LOGACTION = "Использовал транспорт Quad [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "18": {
				if(($CH2CAR >= 1) && ($RowPlayer['vip_rank'] <= 1)) { $TEXT = 'ERRORCAR'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 2)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 2) && ($RowPlayer['vip_rank'] == 3)) { $TEXT = 'ERRORCAR2'; break; }
				else if(($CH2CAR >= 3) && ($RowPlayer['vip_rank'] >= 4)) { $TEXT = 'ERRORCAR3'; break; }
				else {
					$carid = '508';
					$TEXT = 'Транспорт Journey (Дом на колёсах).<br>Забрать его Вы можете на штрафстоянке';
					//
					$SQL = mysqli_query($CONNECT, "INSERT INTO `s_vehicle_player`(`vModel`, `vOwner`, `vBuyDate`, `vFine`) VALUES ('$carid','$RowPlayer[pID]',NOW(),'1')");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал транспорт Journey (Дом на колёсах) ".$usr_login.""; else $LOGACTION = "Использовал транспорт Journey (Дом на колёсах) ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал транспорт Journey (Дом на колёсах)"; else $LOGACTION = "Использовал транспорт Journey (Дом на колёсах) [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			// СКИНЫ //
			case "19": {
				$skinid = '46';
				$pChars = $RowPlayer['pChars']; // 126,0,0,0,0,0
				$fmes = stristr($pChars, ',0,'); // ,0,0,0,0,0
				$tmes = stristr($fmes, '0,'); // 0,0,0,0,0
				$tmes = stristr($tmes, ','); // |0,0,0,0
				$fmes2 = stristr($pChars, ',0', true); // 126
				$setskin = ''.$fmes2.','.$skinid.$tmes.''; // 126,46,0,0,0,0
				if ($fmes != ''){
					$TEXT = 'Скин №'.$skinid.'.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pChars` = '$setskin' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал Скин №".$skinid." ".$usr_login.""; else $LOGACTION = "Использовал Скин №".$skinid." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал Скин №".$skinid.""; else $LOGACTION = "Использовал Скин №".$skinid." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKIN'; break; }
			}
			case "20": {
				$skinid = '49';
				$pChars = $RowPlayer['pChars'];
				$fmes = stristr($pChars, ',0,');
				$tmes = stristr($fmes, '0,');
				$tmes = stristr($tmes, ',');
				$fmes2 = stristr($pChars, ',0', true);
				$setskin = ''.$fmes2.','.$skinid.$tmes.'';
				if ($fmes != ''){
					$TEXT = 'Скин №'.$skinid.'.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pChars` = '$setskin' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал Скин №".$skinid." ".$usr_login.""; else $LOGACTION = "Использовал Скин №".$skinid." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал Скин №".$skinid.""; else $LOGACTION = "Использовал Скин №".$skinid." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKIN'; break; }
			}
			case "21": {
				$skinid = '292';
				$pChars = $RowPlayer['pChars'];
				$fmes = stristr($pChars, ',0,');
				$tmes = stristr($fmes, '0,');
				$tmes = stristr($tmes, ',');
				$fmes2 = stristr($pChars, ',0', true);
				$setskin = ''.$fmes2.','.$skinid.$tmes.'';
				if ($fmes != ''){
					$TEXT = 'Скин №'.$skinid.'.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pChars` = '$setskin' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал Скин №".$skinid." ".$usr_login.""; else $LOGACTION = "Использовал Скин №".$skinid." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал Скин №".$skinid.""; else $LOGACTION = "Использовал Скин №".$skinid." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKIN'; break; }
			}
			case "22": {
				$skinid = '293';
				$pChars = $RowPlayer['pChars'];
				$fmes = stristr($pChars, ',0,');
				$tmes = stristr($fmes, '0,');
				$tmes = stristr($tmes, ',');
				$fmes2 = stristr($pChars, ',0', true);
				$setskin = ''.$fmes2.','.$skinid.$tmes.'';
				if ($fmes != ''){
					$TEXT = 'Скин №'.$skinid.'.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pChars` = '$setskin' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал Скин №".$skinid." ".$usr_login.""; else $LOGACTION = "Использовал Скин №".$skinid." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал Скин №".$skinid.""; else $LOGACTION = "Использовал Скин №".$skinid." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKIN'; break; }
			}
			case "23": {
				$skinid = '297';
				$pChars = $RowPlayer['pChars'];
				$fmes = stristr($pChars, ',0,');
				$tmes = stristr($fmes, '0,');
				$tmes = stristr($tmes, ',');
				$fmes2 = stristr($pChars, ',0', true);
				$setskin = ''.$fmes2.','.$skinid.$tmes.'';
				if ($fmes != ''){
					$TEXT = 'Скин №'.$skinid.'.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pChars` = '$setskin' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал Скин №".$skinid." ".$usr_login.""; else $LOGACTION = "Использовал Скин №".$skinid." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал Скин №".$skinid.""; else $LOGACTION = "Использовал Скин №".$skinid." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORSKIN'; break; }
			}
			// АКСЕССУАРЫ //
			case "24": {
				$itemid = '84';
				$pChars = $RowPlayer['playerItems']; // 126|0|0|0|0|0
				$fmes = stristr($pChars, '|0|'); // |0|0|0|0|0
				$tmes = stristr($fmes, '0|'); // 0|0|0|0|0
				$tmes = stristr($tmes, '|'); // |0|0|0|0
				$fmes2 = stristr($pChars, '|0', true); // 126
				$setitem = ''.$fmes2.'|'.$itemid.$tmes.''; // 126|46|0|0|0|0
				if ($fmes != ''){
					$TEXT = 'Уникальная бита.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `playerItems` = '$setitem' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал уникальную биту ".$usr_login.""; else $LOGACTION = "Использовал уникальную биту ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал уникальную биту"; else $LOGACTION = "Использовал уникальную биту [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORITEM'; break; }
			}
			case "25": {
				if ($RowPlayer['pBoombox'] == '0|0|1'){ $TEXT = 'ERRORBOOM'; break; }
				else {
					$TEXT = 'Уникальный бумбокс (/boombox).';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pBoombox` = '0|0|1' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал уникальный бумбокс ".$usr_login.""; else $LOGACTION = "Использовал уникальный бумбокс ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал уникальный бумбокс"; else $LOGACTION = "Использовал уникальный бумбокс [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
			}
			case "26": {
				$itemid = '83';
				$pChars = $RowPlayer['playerItems'];
				$fmes = stristr($pChars, '|0|');
				$tmes = stristr($fmes, '0|');
				$tmes = stristr($tmes, '|');
				$fmes2 = stristr($pChars, '|0', true);
				$setitem = ''.$fmes2.'|'.$itemid.$tmes.'';
				if ($fmes != ''){
					$TEXT = 'Уникальный кий.';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `playerItems` = '$setitem' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал уникальный кий ".$usr_login.""; else $LOGACTION = "Использовал уникальный кий ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал уникальный кий"; else $LOGACTION = "Использовал уникальный кий [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORITEM'; break; }
			}
			// ОСТАЛЬНОЕ //
			case "27": {
				if ($RowPlayer['vip_rank'] <= $RowItem['amount']){
					if($RowPlayer['vip_time'] > 0){
						$now = date('Y-m-d', $RowPlayer['vip_time']);
						$unixdate = strtotime("".$now." +3 day");
					}
					else $unixdate = strtotime("now +3 day");
					$TEXT = 'BRONZE VIP на 3 дня';
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `vip_rank` = '1', `vip_time`='$unixdate' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORVIP'; break; }
			}
			case "28": {
				if ($RowPlayer['boost_rank'] <= $RowItem['amount']){
					if($RowItem['amount'] == 1){ $TEXT = "Стартовый Boost-Pack на 5 дней"; $boost_rank = 1; $time = 5; }
					else { $TEXT = "Профессиональный Boost-Pack на 4 дня"; $boost_rank = 2; $time = 4; }
					if($RowPlayer['boost_rank'] < $boost_rank) $unixdate = strtotime("now +".$time." day");
					else {
						if($RowPlayer['boost_time'] > 0){
							$now = date('Y-m-d', $RowPlayer['boost_time']);
							$unixdate = strtotime("".$now." +".$time." day");
						}
						else $unixdate = strtotime("now +".$time." day");
					}
					//
					$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `boost_rank` = '$boost_rank', `boost_time`='$unixdate' WHERE `".MYSQL_FIELD_LOGIN."` = '$usr_login'");
					//Логирование
					if($in == 1){ if($SQL == true) $LOGACTION = "Передал ".$TEXT." ".$usr_login.""; else $LOGACTION = "Использовал ".$TEXT." ".$usr_login." [ERR]"; }
					else { if($SQL == true) $LOGACTION = "Использовал ".$TEXT.""; else $LOGACTION = "Использовал ".$TEXT." [ERR]"; }
					mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
					break;
				}
				else { $TEXT = 'ERRORBOOST'; break; }
			}
			default: $TEXT = 'WTERROR';
		}
	}
	else $TEXT = 'ERROR';
	if($usr_login != $_SESSION['USER_LOGIN']) $PAY_USER = 1; else $PAY_USER = 0;
	if(($TEXT != "ERRORCAR") && ($TEXT != "ERRORCAR2") && ($TEXT != "ERRORCAR3") && ($TEXT != "ERROR")
		&& ($TEXT != "ERRORLIC") && ($TEXT != "ERRORBOOST") && ($TEXT != "ERRORVIP") && ($TEXT != "ERRORBOOM")
		&& ($TEXT != "ERRORSKIN") && ($TEXT != "ERRORITEM") && ($TEXT != "ERRORSKILL") && ($TEXT != "WTERROR")
		&& ($TEXT != "ERROR_USER")){
		mysqli_query($CONNECT, "DELETE FROM `roulette_item` WHERE `id` = '$ITEM_ID'");
	}
	echo json_encode(['text' => $TEXT, 'pay_user' => $PAY_USER, 'name' => $usr_login]);
}
?>