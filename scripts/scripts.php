<?php
mysqli_query($CONNECT, "SET NAMES utf8");

$time60 = 0; $time300 = 0; $time900 = 0; $time1200 = 0; $time1800 = 0;
$time2100 = 0;  $time7200 = 0; $time10800 = 0; $time86400 = 0;
$SESSION_Time = filemtime("scripts/w_session"); if((time() - $SESSION_Time) >= 30){ $time30 = 1; } # 30 sec
$ONLINE_Time = filemtime("scripts/stats_online"); if((time() - $ONLINE_Time) >= 60){ $time60 = 1; } # 1 min
$MONITORING_Time = filemtime("scripts/s_monitoring"); if((time() - $MONITORING_Time) >= 300){ $time300 = 1; } # 5 min
$TABLES_Time = filemtime("scripts/s_tables"); if((time() - $TABLES_Time) >= 900){ $time900 = 1; } # 15 min
$MAP_Time = filemtime("scripts/s_statemap"); if((time() - $MAP_Time) >= 900){ $time1200 = 1; } # 20 min
$G_ONLINE_Time = filemtime("scripts/graph_online"); if((time() - $G_ONLINE_Time) >= 1800){ $time1800 = 1; } # 30 min
$G_TOPR_Time = filemtime("scripts/graph_toprich"); if((time() - $G_TOPR_Time) >= 2100){ $time2100 = 1; } # 35 min
$TOPRICH_Time = filemtime("scripts/s_toprich"); if((time() - $TOPRICH_Time) >= 7200){ $time7200 = 1; } # 2 hour
$BOOST_Time = filemtime("scripts/s_boost"); if((time() - $BOOST_Time) >= 10800){ $time10800 = 1; } # 3 hour
$OTHER_Time = filemtime("scripts/s_other"); if((time() - $OTHER_Time) >= 86400){ $time86400 = 1; } # 24 hour

if($time60 == 1){
    $online = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `Name` FROM `".MYSQL_TABLE_USERS."` WHERE `pLogin`='1'"));
    mysqli_query($CONNECTP, "INSERT INTO `stats_online`(`date`, `online`) VALUES (NOW(),'$online')");
    file_put_contents("scripts/cache/mt_all_num.cache.php", $online);
    file_put_contents("scripts/stats_online",""); $time60 = 0;
}

if($time300 == 1){
    $MTA_COUNT = 0; $MTJ_COUNT = 1; $MTT_COUNT = 1; $now_day = date('Y-m-d');
    $table_all = ''; $table_frac_list = ''; $mt_job_list = ''; $mt_top_list = '';

    # mt_all
    $mt_all = mysqli_query($CONNECT, "SELECT `Name`, `pLevel`, `pMember` FROM `".MYSQL_TABLE_USERS."` WHERE `pLogin` = '1'");
    $mt_peak_now = mysqli_fetch_row(mysqli_query($CONNECTP, "SELECT `online` FROM `stats_online` WHERE `date` LIKE '%$now_day%' ORDER BY `online` DESC LIMIT 1"));
    $MTA_CURRENT_PLAYERS = mysqli_num_rows($mt_all);
    while($allRow = mysqli_fetch_array($mt_all)) {
        $MTA_COUNT++;
        switch($allRow['pMember']) {
            case 0: $allRow['pMember'] = 'Гражданский'; break;
            case 1: $allRow['pMember'] = 'LSPD'; break;
            case 2: $allRow['pMember'] = 'ФБР'; break;
            case 3: $allRow['pMember'] = 'Армия СФ'; break;
            case 4: $allRow['pMember'] = 'Медики СФ'; break;
            case 5: $allRow['pMember'] = 'La Cosa Nostra'; break;
            case 6: $allRow['pMember'] = 'Yakuza'; break;
            case 7: $allRow['pMember'] = 'Мэрия'; break;
            case 8: $allRow['pMember'] = 'Casino'; break;
            case 9: $allRow['pMember'] = 'SF News'; break;
            case 10: $allRow['pMember'] = 'SFPD'; break;
            case 11: $allRow['pMember'] = 'Автошкола'; break;
            case 12: $allRow['pMember'] = 'Ballas Gang'; break;
            case 13: $allRow['pMember'] = 'Vagos Gang'; break;
            case 14: $allRow['pMember'] = 'Русская Мафия'; break;
            case 15: $allRow['pMember'] = 'Grove Street'; break;
            case 16: $allRow['pMember'] = 'LS News'; break;
            case 17: $allRow['pMember'] = 'Aztecas Gang'; break;
            case 18: $allRow['pMember'] = 'Rifa Gang'; break;
            case 19: $allRow['pMember'] = 'Армия ЛВ'; break;
            case 20: $allRow['pMember'] = 'LV News'; break;
            case 21: $allRow['pMember'] = 'LVPD'; break;
            case 22: $allRow['pMember'] = 'Медики ЛС'; break;
            case 23: $allRow['pMember'] = 'Медики ЛВ'; break;
            case 24: $allRow['pMember'] = "Hell's Angels MC"; break;
            case 25: $allRow['pMember'] = 'Warlocks MC'; break;
            case 26: $allRow['pMember'] = 'Pagans MC'; break;
            default: $allRow['pMember'] = 'Неизвестно'; break;
        }
        $table_all = $table_all.'<tr>
            <td>'.$MTA_COUNT.'</td>
            <td>'.$allRow['Name'].'</td>
            <td>'.$allRow['pLevel'].'</td>
            <td>'.$allRow['pMember'].'</td>
        </tr>';
    }
    mysqli_free_result($mt_all);
    file_put_contents("scripts/cache/mt_all.cache.php", $table_all);
    file_put_contents("scripts/cache/mt_all_num.cache.php", $MTA_CURRENT_PLAYERS);
    file_put_contents("scripts/cache/mt_peak_now.cache.php", $mt_peak_now[0]);

    # mt_fraction
    $mt_fraction_list = mysqli_query($CONNECT, "SELECT * FROM `s_fraction`");
    while($mfrac = mysqli_fetch_array($mt_fraction_list)) {
		if($mfrac['fID'] == 8) continue;
		$table_frac_list = $table_frac_list.'<form method="POST" class="mtfr">
		<input type="submit" value="'.$mfrac['fName'].'" name="ften" class="mtfr"></form>';
        
        $MTF_COUNT = 0; $table_fraction = '';
        $RSQL = mysqli_query($CONNECT, "SELECT `pLogin`,`Name`,`pRank` FROM `".MYSQL_TABLE_USERS."` WHERE `pMember`='$mfrac[fID]'");
		$MTF_CURRENT_PLAYERS = mysqli_num_rows($RSQL);
        while($fMember = mysqli_fetch_array($RSQL)) {
			$MTF_COUNT++;
			if($fMember['pLogin'] == '1') $pLogin = 'В игре'; else $pLogin = 'Оффлайн';
            $table_fraction = $table_fraction.'
			<tr><td>'.$MTF_COUNT.'</td>
			<td>'.$fMember['Name'].'</td>
            <td>'.$fMember['pRank'].'</td>
            <td>'.$pLogin.'</td></tr>';
        }
        mysqli_free_result($RSQL);
        file_put_contents("scripts/cache/mt_fraction_".$mfrac['fName'].".cache.php", $table_fraction);
        file_put_contents("scripts/cache/mt_fraction_".$mfrac['fName']."_num.cache.php", $MTF_CURRENT_PLAYERS);
    }
	mysqli_free_result($mt_fraction_list);
    file_put_contents("scripts/cache/mt_fraction_list.cache.php", $table_frac_list);

    # mt_job
	while($MTJ_COUNT <= 9) {
		switch ($MTJ_COUNT) {
			case 1: $jbName = 'Водители автобуса'; break;
			case 2: $jbName = 'Таксисты'; break;
			case 3: $jbName = 'Продавцы хотдогов'; break;
			case 4: $jbName = 'Развозчики продуктов'; break;
			case 5: $jbName = 'Механики'; break;
			case 6: $jbName = 'Инкассаторы'; break;
			case 7: $jbName = 'Прорабы'; break;
			case 8: $jbName = 'Тренеры'; break;
			case 9: $jbName = 'Дальнобойщики'; break;
		}
        $mt_job_list = $mt_job_list.'<form method="POST" class="mtfr">
        <input type="submit" value="'.$jbName.'" name="ften" class="mtfr" style="width:150px;"></form>';
        $MTJ_COUNT++;
        
        $MT_J_COUNT = 0; $table_job = '';
        $JSQL = mysqli_query($CONNECT, "SELECT `pLogin`,`Name`,`pPnumber` FROM `".MYSQL_TABLE_USERS."` WHERE `pJob`='$MTJ_COUNT'");
		$MTJ_CURRENT_PLAYERS = mysqli_num_rows($JSQL);
        while($jUser = mysqli_fetch_array($JSQL)) {
			$MT_J_COUNT++;
			if($jUser['pLogin'] == '1') $pLogin = 'В игре'; else $pLogin = 'Оффлайн';
            $table_job = $table_job.'
			<tr><td>'.$MT_J_COUNT.'</td>
			<td>'.$jUser['Name'].'</td>
            <td>'.$jUser['pPnumber'].'</td>
            <td>'.$pLogin.'</td></tr>';
        }
        mysqli_free_result($JSQL);
        file_put_contents("scripts/cache/mt_job_".$jbName.".cache.php", $table_job);
        file_put_contents("scripts/cache/mt_job_".$jbName."_num.cache.php", $MTJ_CURRENT_PLAYERS);
	}
	mysqli_free_result($mt_job_list);
    file_put_contents("scripts/cache/mt_job_list.cache.php", $mt_job_list);

    # mt_top
	while($MTT_COUNT <= 4) {
		switch ($MTT_COUNT) {
			case 1: $topName = 'Самые старые'; break;
			case 2: $topName = 'Самые богатые'; break;
			case 3: $topName = 'ТОП пожертвований'; break;
            case 4: $topName = 'ТОП промокодов'; break;
        }
        $mt_top_list = $mt_top_list.'<form method="POST" class="mtfr">
			<input type="submit" value="'.$topName.'" name="ften" class="mtfr" style="width:150px;"></form>';
        $MTT_COUNT++;

        $table_top = '';
        switch($topName){
            case 'Самые старые': {
                $COUNT = 0;
				$RSQL = mysqli_query($CONNECT, "SELECT `pLogin`,`Name`,`pLevel` FROM `".MYSQL_TABLE_USERS."` ORDER BY `pLevel` DESC LIMIT 0,20");
				while($fJob = mysqli_fetch_array($RSQL)) {
					$COUNT++;
					if($fJob['pLogin'] == '1') $pLogin = 'В игре'; else $pLogin = 'Оффлайн';
					$table_top = $table_top.'
					<tr><td>'.$COUNT.'</td>
					<td>'.$fJob['Name'].'</td>
					<td>'.$fJob['pLevel'].'</td>
					<td>'.$pLogin.'</td></tr>';
				}
				mysqli_free_result($RSQL);
                break;
            }
            case 'Самые богатые': {
                $COUNT = 0;
				$CSQL = mysqli_query($CONNECT, "SELECT `pLogin`,`Name` FROM `".MYSQL_TABLE_USERS."` ORDER BY `pCash` + `pBank` + `pDeposit` DESC LIMIT 0,20");
				while($fCash = mysqli_fetch_array($CSQL)) {
					$COUNT++;
					if($fCash['pLogin'] == '1') $pLogin = 'В игре'; else $pLogin = 'Оффлайн';
					$table_top = $table_top.'
					<tr><td>'.$COUNT.'</td>
					<td>'.$fCash['Name'].'</td>
					<td>'.$pLogin.'</td></tr>';
				}
				mysqli_free_result($CSQL);
                break;
            }
            case 'ТОП пожертвований': {
                $COUNT = 0;
				$DSQL = mysqli_query($CONNECT, "SELECT `pLogin`,`Name` FROM `".MYSQL_TABLE_USERS."` ORDER BY `u_donate_all` DESC LIMIT 0,20");
				while($fDonate = mysqli_fetch_array($DSQL)) {
					$COUNT++;
					if($fDonate['pLogin'] == '1') $pLogin = 'В игре'; else $pLogin = 'Оффлайн';
					$table_top = $table_top.'
					<tr><td>'.$COUNT.'</td>
					<td>'.$fDonate['Name'].'</td>
					<td>'.$pLogin.'</td></tr>';
				}
				mysqli_free_result($DSQL);
                break;
            }
            case 'ТОП промокодов': {
                $COUNT = 0;
				$PSQL = mysqli_query($CONNECT, "SELECT `code`,`owner`,`used_count` FROM `s_promocode` ORDER BY `used_count` DESC LIMIT 0,20");
				while($fPromo = mysqli_fetch_array($PSQL)) {
					$COUNT++;
					$table_top = $table_top.'
					<tr><td>'.$COUNT.'</td>
					<td>'.$fPromo['code'].'</td>
					<td>'.$fPromo['owner'].'</td>
					<td>'.$fPromo['used_count'].'</td></tr>';
				}
				mysqli_free_result($PSQL);
                break;
            }
        }
        file_put_contents("scripts/cache/mt_top_".$topName.".cache.php", $table_top);
	}
    file_put_contents("scripts/cache/mt_top_list.cache.php", $mt_top_list);

    if($mt_all == false) ScriptErr('s_monitoring'); file_put_contents("scripts/s_monitoring",""); $time300 = 0;
}

if($time900 == 1){
    $adm_toprich_list = '';

    # adm_toprich
    $AT_COUNT = 0;
	$adm_toprich = mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` ORDER BY `pCash` + `pBank` + `pDeposit` DESC LIMIT 0,50");
	while($Row = mysqli_fetch_array($adm_toprich)) {
        $chban = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `ID` FROM `s_ban` WHERE `Name` = '$Row[Name]'"));
        if($chban) $tban = ' <b style="color:red;">[BAN]</b>'; else $tban = '';
		$AT_COUNT++;
		$summ = $Row['pCash'] + $Row['pBank'] + $Row['pDeposit'];
		$adm_toprich_list = $adm_toprich_list.'
		<tr><td>'.$AT_COUNT.'</td>
		<td>'.$Row['Name'].$tban.'</td>
		<td>'.$Row['pLevel'].'</td>
		<td>'.$Row['pCash'].'</td>
		<td>'.$Row['pBank'].'</td>
		<td>'.$Row['pDeposit'].'</td>
        <td style="color:#d30d55;">$'.$summ.'</td></tr>';
        mysqli_free_result($chban);
	}
	mysqli_free_result($adm_toprich);
    file_put_contents("scripts/cache/adm_toprich_list.cache.php", $adm_toprich_list);

    if($adm_toprich == false) ScriptErr('s_tables'); file_put_contents("scripts/s_tables",""); $time900 = 0;
}

if($time1200 == 1){
    $statemap_list = '';

    // Дома
    $home = mysqli_query($CONNECT, "SELECT * FROM `house`");
    $class = array('Эконом', 'Средний', 'Высший', 'Элитный', 'Бизнес');
    foreach($home as $home){
        if($home['hOwner'] == 'None'){
            $statemap_list = $statemap_list.'
                houseList[houseList.length] = new Array();
                houseList[houseList.length - 1].x = '.$home['enterx'].';
                houseList[houseList.length - 1].y = '.$home['entery'].';
                houseList[houseList.length - 1].address = "<center>Дом №'.$home['hID'].'</center><br>";
                houseList[houseList.length - 1].owner = "Гос.цена: '.number_format($home['hValue']).'$<br>Класс: '.$class[$home['hKlass']].'";
                houseList[houseList.length - 1].mapIconTypeForSale = "hgreen";
            ';
        }
        else {
            $statemap_list = $statemap_list.'
                houseList[houseList.length] = new Array();
                houseList[houseList.length - 1].x = '.$home['enterx'].';
                houseList[houseList.length - 1].y = '.$home['entery'].';
                houseList[houseList.length - 1].address = "<center>Дом №'.$home['hID'].'</center><br>";
                houseList[houseList.length - 1].owner = "Владелец: '.$home['hOwner'].'<br>Гос.цена: '.number_format($home['hValue']).'$<br>Класс: '.$class[$home['hKlass']].'";
                houseList[houseList.length - 1].mapIconTypeForSale = "hred";
            ';
        }
    }
    // Bellagio
    $bellagio = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '0'");
    foreach($bellagio as $bellagio){
        if($bellagio['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($bellagio['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($bellagio['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($bellagio['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$bellagio['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$bellagio['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$bellagio['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $bellagio['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$bellagio['bBuyPrice'].'<br>Продукты: '.$bellagio['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "bellagio";
        ';
    }
    // 24/7
    $mgzs = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '1'");
    foreach($mgzs as $mgzs){
        if($mgzs['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($mgzs['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($mgzs['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($mgzs['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$mgzs['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$mgzs['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$mgzs['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $mgzs['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$mgzs['bBuyPrice'].'<br>Продукты: '.$mgzs['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "24";
        ';
    }
    // Закусочная Cluckin
    $clucs = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '2'");
    foreach($clucs as $clucs){
        if($clucs['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($clucs['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($clucs['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($clucs['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$clucs['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$clucs['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$clucs['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $clucs['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$clucs['bBuyPrice'].'<br>Продукты: '.$clucs['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "cluckin";
        ';
    }
    // Закусочная Pizza
    $pizza = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '3'");
    foreach($pizza as $pizza){
        if($pizza['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($pizza['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($pizza['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($pizza['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$pizza['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$pizza['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$pizza['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $pizza['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$pizza['bBuyPrice'].'<br>Продукты: '.$pizza['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "pizza";
        ';
    }
    // Закусочная Burger
    $burger = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '4'");
    foreach($burger as $burger){
        if($burger['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($burger['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($burger['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($burger['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$burger['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$burger['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$burger['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $burger['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$burger['bBuyPrice'].'<br>Продукты: '.$burger['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "burger";
        ';
    }
    // Бары
    $bars = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '5'");
    foreach($bars as $bars){
        if($bars['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($bars['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($bars['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($bars['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$bars['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$bars['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$bars['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $bars['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$bars['bBuyPrice'].'<br>Продукты: '.$bars['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "bar";
        ';
    }
    // Клубы
    $clubs = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '6'");
    foreach($clubs as $clubs){
        if($clubs['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($clubs['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($clubs['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($clubs['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$clubs['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$clubs['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$clubs['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $clubs['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$clubs['bBuyPrice'].'<br>Продукты: '.$clubs['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "club";
        ';
    }
    // Аммо
    $ammo = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '7'");
    foreach($ammo as $ammo){
        if($ammo['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($ammo['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($ammo['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($ammo['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$ammo['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$ammo['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$ammo['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $ammo['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$ammo['bBuyPrice'].'<br>Продукты: '.$ammo['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "ammo";
        ';
    }
    // Магазины одежды
    $mo = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '8' OR `bType` = '9' OR `bType` = '10' OR `bType` = '12' OR `bType` = '13'");
    foreach($mo as $mo){
        if($mo['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($mo['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($mo['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        if($mo['bType'] == '8') $motype = 'Victim';
        else if($mo['bType'] == '9') $motype = 'Zip';
        else if($mo['bType'] == '10') $motype = 'Sub Urban';
        else if($mo['bType'] == '11') $motype = 'Binco';
        else if($mo['bType'] == '12') $motype = 'Pro Laps';
        else if($mo['bType'] == '13') $motype = 'Didier Sach';
        else { $mfowner = 'Под контролем: Нет'; }
        if($mo['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$mo['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$mo['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$mo['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $mo['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$mo['bBuyPrice'].'<br>Тип магазина: '.$motype.'<br>Продукты: '.$mo['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "mo";
        ';
    }
    // АЗС
    $azss = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '14'");
    foreach($azss as $azss){
        if($azss['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($azss['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($azss['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($azss['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$azss['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$azss['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$azss['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $azss['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$azss['bBuyPrice'].'<br>Продукты: '.$azss['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "azs";
        ';
    }
    // Автомастерские
    $carcs = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '15'");
    foreach($carcs as $carcs){
        if($carcs['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($carcs['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($carcs['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($carcs['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$carcs['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$carcs['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$carcs['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $carcs['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$carcs['bBuyPrice'].'<br>Продукты: '.$carcs['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "car";
        ';
    }
    // Бизнес 'Дом на колёсах'
    $dnks = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bType` = '16'");
    foreach($dnks as $dnks){
        if($dnks['bMafia'] == '5') { $mfowner = 'Под контролем: Итальянская Мафия'; }
        else if($dnks['bMafia'] == '6') { $mfowner = 'Под контролем: Японская Мафия'; }
        else if($dnks['bMafia'] == '14') { $mfowner = 'Под контролем: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        if($dnks['bOwner'] == 'None') { $owner = 'Владелец: Отсутствует'; }
        else { $owner = 'Владелец: '.$dnks['bOwner'].''; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$dnks['bEntranceX'].';
            houseList[houseList.length - 1].y = '.$dnks['bEntranceY'].';
            houseList[houseList.length - 1].address = "<center>« '.str_replace("\"", " ", $dnks['bName']).' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Гос. Цена: $'.$dnks['bBuyPrice'].'<br>Продукты: '.$dnks['bProducts'].'<br>'.$mfowner.'";
            houseList[houseList.length - 1].mapIconTypeForSale = "dnk";
        ';
    }
    // Фермы
    $farms = mysqli_query($CONNECT, "SELECT * FROM `farms`");
    foreach($farms as $farms){
        if($farms['owner'] == 'None') { $owner = 'Владелец отсутсвует'; }
        else { $owner = 'Владелец: '.$farms['owner'].''; }
        $cordmenu = explode("|", $farms['menu']);
        $farmid = $farms['id'] - 1;
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$cordmenu[0].';
            houseList[houseList.length - 1].y = '.$cordmenu[1].';
            houseList[houseList.length - 1].address = "<center>« Ферма №'.$farmid.' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br>Продукты: '.$farms['prods'].' ед.<br>Зарплата: $'.$farms['zp'].'";
            houseList[houseList.length - 1].mapIconTypeForSale = "farm";
        ';
    }
    // Казино
    $casino = mysqli_query($CONNECT, "SELECT * FROM `casino`");
    foreach($casino as $casino){
        if($casino['Mafia'] == '5') { $owner = 'Владелец: Итальянская Мафия'; }
        else if($casino['Mafia'] == '6') { $owner = 'Владелец: Японская Мафия'; }
        else if($casino['Mafia'] == '14') { $owner = 'Владелец: Русская Мафия'; }
        else { $mfowner = 'Под контролем: Нет'; }
        $statemap_list = $statemap_list.'
            houseList[houseList.length] = new Array();
            houseList[houseList.length - 1].x = '.$casino['posX'].';
            houseList[houseList.length - 1].y = '.$casino['posY'].';
            houseList[houseList.length - 1].address = "<center>« Казино '.$casino['Name'].' »</center><br>";
            houseList[houseList.length - 1].owner = "'.$owner.'<br><br>Менеджер №1: '.$casino['Manager'].'<br>Менеджер №2: '.$casino['Manager2'].'<br>Менеджер №3: '.$casino['Manager3'].'";
            houseList[houseList.length - 1].mapIconTypeForSale = "casino";
        ';
    }
    // Семейные дома
    $familyhouse = mysqli_query($CONNECT, "SELECT * FROM `s_family_house`");
    foreach($familyhouse as $familyhouse){
        $cordmenu = explode("|", $familyhouse['hEnter']);
        if($familyhouse['hOwner'] == 'None'){
            $statemap_list = $statemap_list.'
                houseList[houseList.length] = new Array();
                houseList[houseList.length - 1].x = '.$cordmenu[0].';
                houseList[houseList.length - 1].y = '.$cordmenu[1].';
                houseList[houseList.length - 1].address = "<center>Семейный дом №'.$familyhouse['hID'].'</center><br>";
                houseList[houseList.length - 1].owner = "Стоимость: '.number_format($familyhouse['hCost']).' Family Coins";
                houseList[houseList.length - 1].mapIconTypeForSale = "fhgreen";
            ';
        }
        else {
            $statemap_list = $statemap_list.'
                houseList[houseList.length] = new Array();
                houseList[houseList.length - 1].x = '.$cordmenu[0].';
                houseList[houseList.length - 1].y = '.$cordmenu[1].';
                houseList[houseList.length - 1].address = "<center>Семейный дом №'.$familyhouse['hID'].'</center><br>";
                houseList[houseList.length - 1].owner = "Владелец: Семья '.$familyhouse['hOwner'].'<br>Стоимость: '.number_format($familyhouse['hCost']).' Family Coins";
                houseList[houseList.length - 1].mapIconTypeForSale = "fhred";
            ';
        }
    }

    file_put_contents("scripts/cache/s_statemap.cache.php", $statemap_list);

    if($home == false) ScriptErr('s_statemap'); file_put_contents("scripts/s_statemap",""); $time1200 = 0;
}

if($time1800 == 1){
    # Online Graph
    $json_online = mysqli_query($CONNECTP, "SELECT `date`, `online` FROM `stats_online`");
    while($joRow = mysqli_fetch_row($json_online)){ $joAll[] = array(strtotime($joRow[0]), (float)$joRow[1]); }
    file_put_contents("scripts/cache/graph_online.cache.php", json_encode($joAll));

    $adm_cfoll_list = ''; $c_leaders = 0; $t_gos = 0; $t_gang = 0; $t_maf = 0;
    $lsDate = date_format(date_modify(date_create(), '-1 week'), 'Y-m-d');
    $lsSQL = mysqli_query($CONNECT, "SELECT `fID`,`fName`,`fLeader` FROM `s_fraction`");
    while($lsRow = mysqli_fetch_array($lsSQL)) {
        $dtUsr = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`online_sec`), SUM(`afk_sec`) FROM `s_online` WHERE `accountid` = (SELECT `pID` FROM `s_users` WHERE `Name`='$lsRow[fLeader]') AND `date`>='$lsDate'"));
        include 'modules/lead_activity.php';
        $lOS_m = substr(($dtUsr[0] / 60), 0, 5); $lOS_h = substr(($dtUsr[0] / 3600), 0, 5);
        $lAS_m = substr(($dtUsr[1] / 60), 0, 5); $lAS_h = substr(($dtUsr[1] / 3600), 0, 5);
        $adm_cfoll_list = $adm_cfoll_list.'
        <tr><td>'.$lsRow['fID'].'</td>
        <td>'.$lsRow['fName'].'</td>
        <td>'.$lsRow['fLeader'].'</td>
        <td><b>'.$lOS_m.'</b> минут ('.$lOS_h.'ч.)</td>
        <td><b>'.$lAS_m.'</b> минут ('.$lAS_h.'ч.)</td></tr>';
    } file_put_contents("scripts/cache/adm_cfoll_list.cache.php", $adm_cfoll_list);
    file_put_contents("scripts/cache/adm_cfoll_info.cache.php", "".$c_leaders."\n".$t_gos."\n".$t_gang."\n".$t_maf."");

    if($lsSQL == false) ScriptErr('graph_online'); file_put_contents("scripts/graph_online",""); $time1800 = 0;
}

if($time2100 == 1){
    $GTR = mysqli_query($CONNECT, "SELECT * FROM `w_cash_log`");
    $g_all = array(); $g_vechiles = array(); $g_businesses = array(); $g_farms = array();
    $g_banned = array(); $g_mats = array(); $g_drugs = array();
    while($RowGR = mysqli_fetch_array($GTR)) {
        $date = date('Y, n, j', strtotime('-1 months', strtotime($RowGR['date'])));
        $date = 'Date.UTC('.$date.')';
        $g_all[] = '['.$date.', '.$RowGR['c_all'].']';
        $g_vechiles[] = '['.$date.', '.$RowGR['vechiles'].']';
        $g_businesses[] = '['.$date.', '.$RowGR['businesses'].']';
        $g_farms[] = '['.$date.', '.$RowGR['farms'].']';
        $g_banned[] = '['.$date.', '.$RowGR['banned'].']';
        $g_mats[] = '['.$date.', '.$RowGR['mats'].']';
        $g_drugs[] = '['.$date.', '.$RowGR['drugs'].']';
    }
    file_put_contents("scripts/cache/graph_toprich_all.cache.php", json_encode($g_all));
    file_put_contents("scripts/cache/graph_toprich_vechiles.cache.php", json_encode($g_vechiles));
    file_put_contents("scripts/cache/graph_toprich_businesses.cache.php", json_encode($g_businesses));
    file_put_contents("scripts/cache/graph_toprich_farms.cache.php", json_encode($g_farms));
    file_put_contents("scripts/cache/graph_toprich_banned.cache.php", json_encode($g_banned));
    file_put_contents("scripts/cache/graph_toprich_mats.cache.php", json_encode($g_mats));
    file_put_contents("scripts/cache/graph_toprich_drugs.cache.php", json_encode($g_drugs));
    file_put_contents("scripts/graph_toprich",""); $time2100 = 0;
}

if($time10800 == 1){
    $sboost = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `s_boost_server`"));
    file_put_contents("scripts/cache/s_boost.cache.php", "".$sboost['exp']."\n".$sboost['donate']."\n".$sboost['cash']."\n".$sboost['boost_time']."");

    if($sboost == false) ScriptErr('s_boost'); file_put_contents("scripts/s_boost",""); $time10800 = 0;
}

if($time7200 == 1){
    $allcash = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`pCash` + `pBank` + `pDeposit`) FROM `".MYSQL_TABLE_USERS."`"));
    $acarcash = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`vMoney`) FROM `s_vehicle_player`"));
    $abizcash = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`bBank`) FROM `businesses`"));
    $afarmcash = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`bank`) FROM `farms`"));
    $amats = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`pMats`) FROM `".MYSQL_TABLE_USERS."`"));
    $adrugs = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT SUM(`pDrugs`) FROM `".MYSQL_TABLE_USERS."`"));

    $csallcash = $allcash[0] + $acarcash[0] + $abizcash[0] + $afarmcash[0];
    
    $adban = 0; $i = 0;
    $SQL = mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` ORDER BY `pCash` + `pBank` + `pDeposit` DESC LIMIT 0,100");
    while($Row = mysqli_fetch_array($SQL)){
        $chadm = mysqli_num_rows(mysqli_query($CONNECT, "SELECT * FROM `s_admin`, `s_ban` WHERE s_admin.`Name` = '$Row[Name]' OR s_ban.`Name` = '$Row[Name]'"));
        if($chadm >= 1) {
            $i++;
            $summ = $Row['pCash'] + $Row['pBank'] + $Row['pDeposit'];
            $adban = $adban + $summ;
        } else continue;
    }

    file_put_contents("scripts/cache/s_toprich.cache.php", "".$csallcash."\n".$acarcash[0]."\n".$abizcash[0]."\n".$afarmcash[0]."\n".$adban."\n".$amats[0]."\n".$adrugs[0]."");

    $CashLog = mysqli_query($CONNECT, "INSERT INTO `w_cash_log`(`date`, `c_all`, `vechiles`, `businesses`, `farms`, `banned`, `mats`, `drugs`) VALUES (NOW(),'$csallcash','$acarcash[0]','$abizcash[0]','$afarmcash[0]','$adban','$amats[0]','$adrugs[0]')");
    if($CashLog == false) ScriptErr('s_toprich'); file_put_contents("scripts/s_toprich",""); $time7200 = 0;
}

if($time86400 == 1){
	$old_day = date_format(date_modify(date_create(), '-1 day'), 'Y-m-d');
    $mt_peak_old = mysqli_fetch_row(mysqli_query($CONNECTP, "SELECT `online` FROM `stats_online` WHERE `date` LIKE '%$old_day%' ORDER BY `online` DESC LIMIT 1"));
    file_put_contents("scripts/cache/mt_peak_old.cache.php", $mt_peak_old[0]);
    if($mt_peak_old == false) ScriptErr('s_other'); file_put_contents("scripts/s_other",""); $time86400 = 0;
}

function ScriptErr($script){
    $errorlog = "scripts/errorlog.txt";
    $t_error = file_get_contents($errorlog);
    $t_error .= "\r\n- [Error ".date('d-m-Y h:i:s')."] Script <".$script."> not loaded!";
    file_put_contents($errorlog, $t_error);
}