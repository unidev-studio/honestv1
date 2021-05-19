<?PHP
if($_SESSION['USER_LOGIN'] == "") header("Location: https://honest-rp.su/404.php");
//else { $lg = md5($_SESSION['USER_LOGIN']); $dd = md5(date('dmYhi')); $CHECK_ROULETTE_HASH = md5(''.$lg.$dd.''); }
else if(!$_SESSION['ROULETTE_HASH']) header("Location: https://honest-rp.su/404.php");
else {
	if(isset($_POST['itemid'])) $ITEM_ID = $_POST['itemid'];
	$RowPlayer = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `pID`,`u_donate`,`u_free_donate`,`pCash` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	if($ITEM_ID == 0){
		$TEXT = "Все предметы";
		$RowAllItem = mysqli_query($CONNECT, "SELECT * FROM `roulette_item` WHERE `ownerid` = '$RowPlayer[pID]'");
		$SELL_PRICE = 0; $COUNT_PRICE = 0;
		while($Rows = mysqli_fetch_array($RowAllItem)){
			$NCASH = 0;
			switch($Rows['type']){
				case "1": $NMONEY = 0; break; // $NMONEY = 5 * $Rows["amount"]
				case "2":
					if(($Rows['amount'] >= 15000) && ($Rows['amount'] <= 70000)) $NMONEY = 0; //35
					else if(($Rows['amount'] >= 75000) && ($Rows['amount'] <= 130000)) $NMONEY = 0; //65
					else if(($Rows['amount'] >= 150000) && ($Rows['amount'] <= 250000)) $NMONEY = 0; //125
					else if(($Rows['amount'] >= 280000) && ($Rows['amount'] <= 400000)) $NMONEY = 0; //195
					break;
				case "3": $NMONEY = 20; $NCASH = 8000; break;
				case "4": $NMONEY = 20; $NCASH = 8000; break;
				case "5": $NMONEY = $Rows['amount'] * 35; break;
				case "6": $NMONEY = 0; break;
				// ТРАНСПОРТ //
				case "7": $NMONEY = 65; break;
				case "8": $NMONEY = 25000; break;
				case "9": $NMONEY = 700; break;
				case "10": $NMONEY = 700; break;
				case "11": $NMONEY = 115; break;
				case "12": $NMONEY = 500; break;
				case "13": $NMONEY = 200; break;
				case "14": $NMONEY = 250; break;
				case "15": $NMONEY = 90; break;
				case "16": $NMONEY = 210; break;
				case "17": $NMONEY = 450; break;
				case "18": $NMONEY = 500; break;
				// СКИНЫ //
				case "19": $NMONEY = 300; break;
				case "20": $NMONEY = 450; break;
				case "21": $NMONEY = 120; break;
				case "22": $NMONEY = 120; break;
				case "23": $NMONEY = 120; break;
				// АКСЕССУАРЫ //
				case "24": $NMONEY = 25; break;
				case "25": $NMONEY = 100; break;
				case "26": $NMONEY = 90; break;
				// ОСТАЛЬНОЕ //
				case "27": $NMONEY = 80; break;
				case "28": if($Rows['amount'] == 1) $NMONEY = 75; else $NMONEY = 150; break;
			}
			if($NMONEY == 0) $COUNT_PRICE = 1;
			if($Rows['type_spin'] == 1 AND $NCASH > 0) $COUNT_PRICE = 2;
			if($Rows['type_spin'] == 1) $NMONEY = round($NMONEY / 2); else $NMONEY = $NMONEY;
			$SELL_PRICE = $SELL_PRICE + $NMONEY;
		}
	}
	else {
		$SELL_CASH = 0;
		$RowItem = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `roulette_item` WHERE `id` = '$ITEM_ID'"));
		if($RowItem['ownerid'] != $_SESSION['USER_ID']) $SELL_PRICE = 0; // Фикс обхода продажи чужих предметов
		else switch($RowItem['type']){
			case "1": $SELL_PRICE = 0; $TEXT = "".$RowItem["amount"]." EXP"; break; // $SELL_PRICE = 5 * $RowItem['amount']
			case "2":
				$TEXT = '+ '.$RowItem['amount'].' вирт';
				if(($RowItem['amount'] >= 15000) && ($RowItem['amount'] <= 70000)) $SELL_PRICE = 0; //35
				else if(($RowItem['amount'] >= 75000) && ($RowItem['amount'] <= 130000)) $SELL_PRICE = 0; //65
				else if(($RowItem['amount'] >= 150000) && ($RowItem['amount'] <= 250000)) $SELL_PRICE = 0; //125
				else if(($RowItem['amount'] >= 280000) && ($RowItem['amount'] <= 400000)) $SELL_PRICE = 0; //195
				break;
			case "3": $SELL_PRICE = 20; $SELL_CASH = 8000; $TEXT = "Лицензии"; break;
			case "4": $SELL_PRICE = 20; $SELL_CASH = 8000; $TEXT = "Скиллы"; break;
			case "5":
				$TEXT = $RowItem['amount']." фриспин";
				if($RowItem['amount'] == 1) $SELL_PRICE = 20;
				else if($RowItem['amount'] == 2) $SELL_PRICE = 40;
				else if($RowItem['amount'] == 3) $SELL_PRICE = 60;
				break;
			case "6":
				$TEXT = "Кэшбек ".$AMOUNT." рублей";
				if($RowItem['amount'] == 25) $SELL_PRICE = 0;
				else if($RowItem['amount'] == 55) $SELL_PRICE = 0;
				else if($RowItem['amount'] == 85) $SELL_PRICE = 0;
				break;
			// ТРАНСПОРТ //
			case "7": $SELL_PRICE = 65; $TEXT = "Landstalker (400)"; break;
			case "8": $SELL_PRICE = 25000; $TEXT = "Dune (573)"; break;
			case "9": $SELL_PRICE = 700; $TEXT = "Stretch (409)"; break;
			case "10": $SELL_PRICE = 700; $TEXT = "Romero (442)"; break;
			case "11": $SELL_PRICE = 115; $TEXT = "Washington (421)"; break;
			case "12": $SELL_PRICE = 500; $TEXT = "Hotknife (434)"; break;
			case "13": $SELL_PRICE = 200; $TEXT = "Euros (587)"; break;
			case "14": $SELL_PRICE = 250; $TEXT = "Slamvan (535)"; break;
			case "15": $SELL_PRICE = 90; $TEXT = "Camper (483)"; break;
			case "16": $SELL_PRICE = 210; $TEXT = "FCR-900 (521)"; break;
			case "17": $SELL_PRICE = 450; $TEXT = "Quad (471)"; break;
			case "18": $SELL_PRICE = 500; $TEXT = "[ДНК] Journey (508)"; break;
			// СКИНЫ //
			case "19": $SELL_PRICE = 300; $TEXT = "Скин №46"; break;
			case "20": $SELL_PRICE = 450; $TEXT = "Скин №49"; break;
			case "21": $SELL_PRICE = 120; $TEXT = "Скин №292"; break;
			case "22": $SELL_PRICE = 120; $TEXT = "Скин №293"; break;
			case "23": $SELL_PRICE = 120; $TEXT = "Скин №297"; break;
			// АКСЕССУАРЫ //
			case "24": $SELL_PRICE = 25; $TEXT = "Уникальная бита"; break;
			case "25": $SELL_PRICE = 100; $TEXT = "Уникальный бумбокс"; break;
			case "26": $SELL_PRICE = 90; $TEXT = "Уникальный кий"; break;
			// ОСТАЛЬНОЕ //
			case "27": $SELL_PRICE = 80; $TEXT = "BRONZE VIP на 3 дня"; break;
			case "28":
				if($RowItem['amount'] == 1){ $SELL_PRICE = 75; $TEXT = "Стартовый Boost-Pack на 5 дней"; }
				else { $SELL_PRICE = 150; $TEXT = "Профессиональный Boost-Pack на 4 дня"; }
				break;
		}
		if($RowItem['type_spin'] == 1){ $SELL_PRICE = round($SELL_PRICE / 2); $ts = 1; } else { $SELL_PRICE = $SELL_PRICE; $ts = 0; }
	}
	if(!$SELL_PRICE) $TEXT = 'err1'; // Предметы отсутствуют
	else if($SELL_PRICE == 0) $TEXT = 'err2'; // Предмет не доступен к продаже
	else if($COUNT_PRICE == 1) $TEXT = 'err3'; // Имеется предмет недоступный в продаже
	else if($COUNT_PRICE == 2) $TEXT = 'err3'; // Имеется предмет недоступный в продаже [Вирты]
	else {
		if($ts == 1 AND $SELL_CASH > 0) {
			$TEXT = $TEXT.' за '.$SELL_CASH.' вирт';
			$MONEY = $RowPlayer['pCash'] + $SELL_CASH;
			$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `pCash` = '$MONEY' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			AddCashStats($SELL_CASH);
		} else {
			$TEXT = $TEXT.' за '.$SELL_PRICE.' руб';
			$MONEY = $RowPlayer['u_donate'] + $SELL_PRICE;
			$FREE_MONEY = $RowPlayer['u_free_donate'] + $SELL_PRICE;
			$SQL = mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '$MONEY', `u_free_donate` = '$FREE_MONEY' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
		}
		//Логирование
		if($SQL == true) $LOGACTION = "Продал ".$TEXT.""; else $LOGACTION = "Продал ".$TEXT." [ERR]";
		mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
		//
		if($ITEM_ID == 0) mysqli_query($CONNECT, "DELETE FROM `roulette_item` WHERE `ownerid` = '$RowPlayer[pID]'");
		else mysqli_query($CONNECT, "DELETE FROM `roulette_item` WHERE `id` = '$ITEM_ID'");
	}
	echo json_encode(array('text' => $TEXT));
}
?>