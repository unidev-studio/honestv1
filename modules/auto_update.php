<?PHP
if(!$_SESSION['USER_LOGIN']) header("Location: https://honest-rp.su/404.php");
//else { $lg = md5($_SESSION['USER_LOGIN']); $dd = md5(date('dmYhi')); $CHECK_ROULETTE_HASH = md5(''.$lg.$dd.''); }
else if(!$_SESSION['ROULETTE_HASH']) header("Location: https://honest-rp.su/404.php");
else {
	if(isset($_POST['action'])){
		$ACTION = $_POST['action'];
		$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
	}
	else header("Location: https://honest-rp.su/404.php");
	switch($ACTION){
		case 1: {
			//Обновление баланса |AND| Проверка на вход в игру |AND| Обновление спинов
			$CHSRVX = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `boost_time`,`donate` FROM `s_boost_server`"));
			if($CHSRVX['boost_time'] >= 1) $UpdMoney = $Row['u_donate'] + ($Row['u_nodonate'] * $CHSRVX['donate']);
			else $UpdMoney = $Row['u_donate'] + $Row['u_nodonate'];
			mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_nodonate` = '0', `u_donate` = '$UpdMoney' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			$AJAX_ANSWER_1 = $Row['u_donate']; $AJAX_ANSWER_2 = $Row['pLogin']; $AJAX_ANSWER_3 = $Row['w_rSpins'];
			echo json_encode(array('answer_1' => $AJAX_ANSWER_1, 'answer_2' => $AJAX_ANSWER_2, 'answer_3' => $AJAX_ANSWER_3));
			break;
		}
		case 2: {
			$SQL = mysqli_query($CONNECT, "SELECT * FROM `roulette_item` WHERE `ownerid` = '$_SESSION[USER_ID]'");
			if(mysqli_num_rows($SQL) > 0){
				$AJAX_ANSWER_1 = '<div style="margin-top:10px;display:flow-root;">
				<p style="float:left;color:#d30d55;font-size:30px;font-weight:700;text-transform:uppercase;">Мои предметы</p>
				<span class="sell_item"><button onclick="Sell_AllItem(0);" style="float:right;width:180px;font-weight:505;background:#d30d55;">Продать все предметы</button></div>';
				while($Rows = mysqli_fetch_array($SQL)){
					$NCASH = 0;
					switch($Rows['type']){
						case "1": $IMG = 'exp'; $NMONEY = 0; $TEXT = "".$Rows["amount"]." EXP"; break; // $NMONEY = 5 * $Rows["amount"]
						case "2":
							$IMG = 'money';
							$TEXT = $Rows['amount'].' вирт';
							if(($Rows['amount'] >= 15000) && ($Rows['amount'] <= 70000)) $NMONEY = 0; //35
							else if(($Rows['amount'] >= 75000) && ($Rows['amount'] <= 130000)) $NMONEY = 0; //65
							else if(($Rows['amount'] >= 150000) && ($Rows['amount'] <= 250000)) $NMONEY = 0; //125
							else if(($Rows['amount'] >= 280000) && ($Rows['amount'] <= 400000)) $NMONEY = 0; //195
							break;
						case "3": $IMG = 'licenses'; $NMONEY = 20; $NCASH = 8000; $TEXT = "Лицензии"; break;
						case "4": $IMG = 'skills'; $NMONEY = 20; $NCASH = 8000; $TEXT = "Скиллы"; break;
						case "5": $IMG = 'freespin'; $NMONEY = $Rows['amount'] * 20; $TEXT =  $Rows['amount']." фриспин"; break;
						case "6": $IMG = 'cashback'; $NMONEY = 0; $TEXT = "Кэшбек ".$Rows['amount']." рублей"; break;
						// ТРАНСПОРТ //
						case "7": $IMG = 'landstalker'; $NMONEY = 65; $TEXT = "Landstalker (400)"; break;
						case "8": $IMG = 'dune'; $NMONEY = 25000; $TEXT = "Dune (573)"; break;
						case "9": $IMG = 'stretch'; $NMONEY = 700; $TEXT = "Stretch (409)"; break;
						case "10": $IMG = 'romero'; $NMONEY = 700; $TEXT = "Romero (442)"; break;
						case "11": $IMG = 'washington'; $NMONEY = 115; $TEXT = "Washington (421)"; break;
						case "12": $IMG = 'hotknife'; $NMONEY = 500; $TEXT = "Hotknife (434)"; break;
						case "13": $IMG = 'euros'; $NMONEY = 200; $TEXT = "Euros (587)"; break;
						case "14": $IMG = 'slamvan'; $NMONEY = 250; $TEXT = "Slamvan (535)"; break;
						case "15": $IMG = 'camper'; $NMONEY = 90; $TEXT = "Camper (483)"; break;
						case "16": $IMG = 'fcr900'; $NMONEY = 210; $TEXT = "FCR-900 (521)"; break;
						case "17": $IMG = 'quad'; $NMONEY = 450; $TEXT = "Quad (471)"; break;
						case "18": $IMG = 'journey'; $NMONEY = 500; $TEXT = "[ДНК] Journey (508)"; break;
						// СКИНЫ //
						case "19": $IMG = 'sk46'; $NMONEY = 300; $TEXT = "Скин №46"; break;
						case "20": $IMG = 'sk49'; $NMONEY = 450; $TEXT = "Скин №49"; break;
						case "21": $IMG = 'sk292'; $NMONEY = 120; $TEXT = "Скин №292"; break;
						case "22": $IMG = 'sk293'; $NMONEY = 120; $TEXT = "Скин №293"; break;
						case "23": $IMG = 'sk297'; $NMONEY = 120; $TEXT = "Скин №297"; break;
						// АКСЕССУАРЫ //
						case "24": $IMG = 'bat'; $NMONEY = 25; $TEXT = "Уникальная бита"; break;
						case "25": $IMG = 'boombox'; $NMONEY = 100; $TEXT = "Уникальный бумбокс"; break;
						case "26": $IMG = 'cue'; $NMONEY = 90; $TEXT = "Уникальный кий"; break;
						// ОСТАЛЬНОЕ //
						case "27": $IMG = 'vip'; $NMONEY = 80; $TEXT = "BRONZE VIP на 3 дня"; break;
						case "28":
							$IMG = 'boost';
							if($Rows['amount'] == 1){ $NMONEY = 75; $TEXT = "Старт. Boost на 5 дней"; }
							else { $NMONEY = 150; $TEXT = "Проф. Boost на 4 дня"; }
							break;
					}
					if($Rows['type_spin'] == 1){ $NMONEY = round($NMONEY / 2); $freetext = '<b style="color:#d72566;font-size:10px;display:block;">[FREESPIN]</b>'; }
					else { $NMONEY = $NMONEY; $freetext = '<b style="color:#d72566;font-size:10px;display:block;">-</b>'; }
					if($NMONEY == 0){
						$numsell = '<h5 style="color:#06784e;">-</h5>';
						$sellbutt = '<button>Продажа/Передача не доступна</button>';
					}
					else if($Rows['type_spin'] == 1 AND $NCASH > 0){
						$numsell = '<h5 style="color:#06784e;">Стоимость: <strong>'.$NCASH.'</strong>вирт.</h5>';
						$sellbutt = '<button style="width:44%;" onclick="Sell_Item('.$Rows['id'].');">Продать</button>
						<button style="width:44%;background:crimson;margin:0;" onclick="Pay_Item('.$Rows['id'].');">Передать</button>';
					}
					else {
						$numsell = '<h5 style="color:#06784e;">Стоимость: <strong>'.$NMONEY.'</strong>руб.</h5>';
						$sellbutt = '<button style="width:44%;" onclick="Sell_Item('.$Rows['id'].');">Продать</button>
						<button style="width:44%;background:crimson;margin:0;" onclick="Pay_Item('.$Rows['id'].');">Передать</button>';
					}
					$AJAX_ANSWER_1 = $AJAX_ANSWER_1.'<div class="box_item"><center>
					<div class="b_i_body"><img src="../resource/img/roulette_item/'.$IMG .'.png?v=3" /></div>
					<div class="b_i_footer">
						<h4>'.$TEXT.' '.$freetext.'</h4>
						'.$numsell.'
						<span class="use_item"><button onclick="Use_Item('.$Rows['id'].');">Использовать</button><br>
						<span class="sell_item">'.$sellbutt.'
					</div></center>	
					</div>';
				}
			}
			echo json_encode(array('answer_1' => $AJAX_ANSWER_1));
			break;
		}
		case 4: {
			//Обновление лайва
			$SQLL = mysqli_query($CONNECT, "SELECT `user`,`action` FROM `sl_users` WHERE `action` LIKE '%Выбил из рулетки предмет%' ORDER BY `id` DESC LIMIT 13");
			if(mysqli_num_rows($SQLL) > 0){
				$AJAX_ANSWER_1 = '';
				$COUNT = 0;
				while($Rowsl = mysqli_fetch_array($SQLL)){
					$user = $Rowsl['user'];
					$text = 'Выбил из рулетки предмет ';
					switch($Rowsl['action']){
						case $text."+ 1EXP": $IMG = 'exp'; break;
						case $text."+ 2EXP": $IMG = 'exp'; break;
						case $text."+ 3EXP": $IMG = 'exp'; break;
						case $text."+ 4EXP": $IMG = 'exp'; break;
						case $text."+ 5EXP": $IMG = 'exp'; break;
						case $text."Лицензии": $IMG = 'licenses'; break;
						case $text."Скиллы": $IMG = 'skills'; break;
						case $text."1 фриспин": $IMG = 'freespin'; break;
						case $text."2 фриспин": $IMG = 'freespin'; break;
						case $text."3 фриспин": $IMG = 'freespin'; break;
						case $text."Кэшбек 25 рублей": $IMG = 'cashback'; break;
						case $text."Кэшбек 55 рублей": $IMG = 'cashback'; break;
						case $text."Кэшбек 85 рублей": $IMG = 'cashback'; break;
						// ТРАНСПОРТ //
						case $text."Landstalker (400)": $IMG = 'landstalker'; break;
						case $text."Dune (573)": $IMG = 'dune'; break;
						case $text."Stretch (409)": $IMG = 'stretch'; break;
						case $text."Romero (442)": $IMG = 'romero'; break;
						case $text."Washington (421)": $IMG = 'washington'; break;
						case $text."Hotknife (434)": $IMG = 'hotknife'; break;
						case $text."Euros (587)": $IMG = 'euros'; break;
						case $text."Slamvan (535)": $IMG = 'slamvan'; break;
						case $text."Camper (483)": $IMG = 'camper'; break;
						case $text."FCR-900 (521)": $IMG = 'fcr900'; break;
						case $text."Quad (471)": $IMG = 'quad'; break;
						case $text."[ДНК] Journey (508)": $IMG = 'journey'; break;
						// СКИНЫ //
						case $text."Скин №46": $IMG = 'sk46'; break;
						case $text."Скин №49": $IMG = 'sk49'; break;
						case $text."Скин №292": $IMG = 'sk292'; break;
						case $text."Скин №293": $IMG = 'sk293'; break;
						case $text."Скин №297": $IMG = 'sk297'; break;
						// АКСЕССУАРЫ //
						case $text."Уникальная бита": $IMG = 'bat'; break;
						case $text."Уникальный бумбокс": $IMG = 'boombox'; break;
						case $text."Уникальный кий": $IMG = 'cue'; break;
						// ОСТАЛЬНОЕ //
						case $text."BRONZE VIP на 3 дня": $IMG = 'vip'; break;
						case $text."Стартовый Boost-Pack на 5 дней": $IMG = 'boost'; break;
						case $text."Профессиональный Boost-Pack на 4 дня": $IMG = 'boost'; break;
						default: $IMG = 'money'; break;
					}
					$AJAX_ANSWER_1 = $AJAX_ANSWER_1.'<div style="float:left;"">
						<div class="live_b_item"><img src="../resource/img/roulette_item/'.$IMG .'.png?v=3" style="height:96px;" title="'.$user.'"></div>
					</div>';
					$COUNT++;
				}
			}
			echo json_encode(array('answer_1' => $AJAX_ANSWER_1));
			break;
		}
		case 5: {
			//Обновление подкрутки
			$AJAX_ANSWER_1 = $Row['w_rBoost'];
			echo json_encode(array('answer_1' => $AJAX_ANSWER_1));
			break;
		}
		case 7: {
			//Снятие денег сразу после нажатия
			$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `u_donate`,`w_rSpins` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
			if($Row['w_rSpins'] >= 1){
				$FREESPIN = $Row['w_rSpins']; $FREESPIN -= 1;
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `w_rSpins` = '$FREESPIN',`w_rStatus`='3' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			}
			else if($Row['u_donate'] >= 49){
				$DONATE = $Row['u_donate']; $DONATE -= 49;
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate`='$DONATE',`w_rStatus`='2' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
			}
			else echo json_encode(array('text' => 'error'));
			break;
		}
		case 8: {
			//Проверка на F5 и прочее
			sleep(2);
			$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `w_rStatus` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
			if($Row['w_rStatus'] >= 2){
				//
				$rand = rand(1, 100);
				if(($rand >= 1) && ($rand <= 60)) $item_id = 1; //60%
				else if(($rand >= 61) && ($rand <= 70)) $item_id = 2; //10%
				else if(($rand >= 71) && ($rand <= 85)) $item_id = 3; //15%
				else if(($rand >= 86) && ($rand <= 100)) $item_id = 4; //15%
				//
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
				}
				if($Row['w_rStatus'] == 3) $type_spin = 1; else $type_spin = 0;
				mysqli_query($CONNECT, "INSERT INTO `roulette_item`(`type`, `amount`, `type_spin`, `ownerid`) VALUES ('$ID', '$AMOUNT', '$type_spin', '$_SESSION[USER_ID]')");
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `w_rStatus` = '1' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
				//Логирование
				$LOGACTION = "Выбил из рулетки предмет ".$TEXT."";
				mysqli_query($CONNECT, "INSERT INTO `".MYSQL_TABLE_USERLOG."`(`playerIP`, `user`, `location`, `action`, `date`) VALUES ('$_SESSION[USER_IP]','$_SESSION[USER_LOGIN]','WEB-Рулетка [F5]','$LOGACTION',NOW())");
				//
			}
			$AJAX_ANSWER_1 = 1;
			echo json_encode(array('answer_1' => $AJAX_ANSWER_1));
			break;
		}
	}
}