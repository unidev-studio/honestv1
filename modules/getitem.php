<?PHP
if(!$_SESSION['USER_LOGIN']) header("Location: https://honest-rp.su/404.php");
//else { $lg = md5($_SESSION['USER_LOGIN']); $dd = md5(date('dmYhi')); $CHECK_ROULETTE_HASH = md5(''.$lg.$dd.''); }
if(!$_SESSION['ROULETTE_HASH']) header("Location: https://honest-rp.su/404.php");
else {
	$wrCheck = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `w_rStatus` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	if($wrCheck[0] >= 2){
		if(isset($_POST['itemid'])) $item_id = $_POST['itemid'];
		else header("Location: https://honest-rp.su/404.php");
		if($item_id > 0){
			switch($item_id){
				case "1": {
					$ID = 1;
					$sum = rand(1,100);
					if(($sum >= 1) && ($sum <= 35)) $AMOUNT = 1; //35%
					else if(($sum >= 36) && ($sum <= 65)) $AMOUNT = 2; //25%
					else if(($sum >= 66) && ($sum <= 85)) $AMOUNT = 3; //20%
					else if(($sum >= 86) && ($sum <= 95)) $AMOUNT = 4; //15%
					else if(($sum >= 96) && ($sum <= 100)) $AMOUNT = 5; //5%
					$TEXT = '+ '.$AMOUNT.'EXP';
					break;
				}
				case "2":
					$ID = 2; $sum = rand(1,100);
					$rcsum1 = rand(15000, 70000);
					$rcsum2 = rand(75000, 130000);
					$rcsum3 = rand(150000, 250000);
					$rcsum4 = rand(280000, 400000);
					if(($sum >= 1) && ($sum <= 45)) $AMOUNT = $rcsum1; //45%
					else if(($sum >= 46) && ($sum <= 80)) $AMOUNT = $rcsum2; //35%
					else if(($sum >= 81) && ($sum <= 95)) $AMOUNT = $rcsum3; //15%
					else if(($sum >= 96) && ($sum <= 100)) $AMOUNT = $rcsum4; //5%
					$TEXT = $AMOUNT.' вирт';
					break;
				case "3": $ID = 3; $AMOUNT = 1; $TEXT = "Лицензии"; break;
				case "4": $ID = 4; $AMOUNT = 1; $TEXT = "Скиллы"; break;
				case "5":
					$ID = 5; $sum = rand(1,100);
					if(($sum >= 1) && ($sum <= 90)) $AMOUNT = 2; //90%
					else if(($sum >= 91) && ($sum <= 99)) $AMOUNT = 2; //9%
					else if($sum == 100) $AMOUNT = 3; //1%
					$TEXT = $AMOUNT.' фриспин';
					break;
				case "6":
					$ID = 6; $sum = rand(1,100);
					if(($sum >= 1) && ($sum <= 90)) $AMOUNT = 25; //90%
					else if(($sum >= 91) && ($sum <= 99)) $AMOUNT = 55; //9%
					else if($sum == 100) $AMOUNT = 85; //1%
					$TEXT = 'Кэшбек '.$AMOUNT.' рублей';
					break;
				// ТРАНСПОРТ //
				case "7": $ID = 7; $AMOUNT = 1; $TEXT = "Landstalker (400)"; break;
				case "8": $ID = 8; $AMOUNT = 1; $TEXT = "Dune (573)"; break;
				case "9": $ID = 9; $AMOUNT = 1; $TEXT = "Stretch (409)"; break;
				case "10": $ID = 10; $AMOUNT = 1; $TEXT = "Romero (442)"; break;
				case "11": $ID = 11; $AMOUNT = 1; $TEXT = "Washington (421)"; break;
				case "12": $ID = 12; $AMOUNT = 1; $TEXT = "Hotknife (434)"; break;
				case "13": $ID = 13; $AMOUNT = 1; $TEXT = "Euros (587)"; break;
				case "14": $ID = 14; $AMOUNT = 1; $TEXT = "Slamvan (535)"; break;
				case "15": $ID = 15; $AMOUNT = 1; $TEXT = "Camper (483)"; break;
				case "16": $ID = 16; $AMOUNT = 1; $TEXT = "FCR-900 (521)"; break;
				case "17": $ID = 17; $AMOUNT = 1; $TEXT = "Quad (471)"; break;
				case "18": $ID = 18; $AMOUNT = 1; $TEXT = "[ДНК] Journey (508)"; break;
				// СКИНЫ //
				case "19": $ID = 19; $AMOUNT = 1; $TEXT = "Скин №46"; break;
				case "20": $ID = 20; $AMOUNT = 1; $TEXT = "Скин №49"; break;
				case "21": $ID = 21; $AMOUNT = 1; $TEXT = "Скин №292"; break;
				case "22": $ID = 22; $AMOUNT = 1; $TEXT = "Скин №293"; break;
				case "23": $ID = 23; $AMOUNT = 1; $TEXT = "Скин №297"; break;
				// АКСЕССУАРЫ //
				case "24": $ID = 24; $AMOUNT = 1; $TEXT = "Уникальная бита"; break;
				case "25": $ID = 25; $AMOUNT = 1; $TEXT = "Уникальный бумбокс"; break;
				case "26": $ID = 26; $AMOUNT = 1; $TEXT = "Уникальный кий"; break;
				// ОСТАЛЬНОЕ //
				case "27": $ID = 27; $AMOUNT = 1; $TEXT = "BRONZE VIP на 3 дня"; break;
				case "28":
					$ID = 28;
					$sum = rand(1,100);
					if(($sum >= 1) && ($sum <= 95)) $AMOUNT = 1; //95%
					else if(($sum >= 96) && ($sum <= 100)) $AMOUNT = 2; //5%
					if($AMOUNT == 1) $TEXT = "Стартовый Boost-Pack на 5 дней";
					else $TEXT = "Профессиональный Boost-Pack на 4 дня";
					break;
			}
			//$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `u_donate`,`w_rSpins` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
			//if(($Row['u_donate'] < 49) && ($Row['w_rSpins'] == 0)){ $TEXT = 'У Вас недостаточно денег!'; }
			//if($Row['w_rSpins'] > 0){
				if($wrCheck[0] == 3) $type_spin = 1; else $type_spin = 0;
				mysqli_query($CONNECT, "INSERT INTO `roulette_item`(`type`, `amount`, `type_spin`, `ownerid`) VALUES ('$ID', '$AMOUNT', '$type_spin', '$_SESSION[USER_ID]')");
				//Логирование
				$LOGACTION = "Выбил из рулетки предмет ".$TEXT."";
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка','$LOGACTION',NOW())");
				//
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `w_rStatus` = '1' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			//}
			echo json_encode(array('text' => $TEXT));
		}
	}
	else header("Location: https://honest-rp.su/404.php");
}
?>