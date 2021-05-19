<?php
switch($Row['pLogin']) {
    case 0: $pLogin = '<b style="color:red;font-size:10px;vertical-align:top;">[Оффлайн]</b>'; break;
    case 1: $pLogin = '<b style="color:green;font-size:10px;vertical-align:top;">[В игре]</b>'; break;
}
if($Row['pIpReg'] == $Row['pIp']) $subnet = '<b style="color:green;">Совпадает</b>'; else $subnet = '<b style="color:red;">Не совпадает</b>';
if($NSUALVL[0] >= 1) $pstatus = 'Администратор'; else if($chsupp) $pstatus = 'Игровой помощник'; else $pstatus = 'Игрок';
if(!$hPromo[0]) $hPromo[0] = '-';
switch($Row['m_rank']) {
    case 1: $pmedia = 'Ютубер'; break;
    case 2: $pmedia = 'Владелец фамилии'; break;
    case 3: $pmedia = 'Стример'; break;
    default: $pmedia = 'Не состоит'; break;
}
echo '<br><table style="text-align: left; width: 100%; height: auto;" border="0">
<tbody>
    <tr>
        <td width="80%">
            <div class="ageninf">
            <div>
                <p><strong>Поиск игрока по никнейму</strong></p>
                <form method="POST" class="search">
                    <input type="text" name="nsuser" required="" autocomplete="off" maxlength="24" placeholder="Никнейм" title="Введите никнейм по формату Имя_Фамилия." required>
                    <input type="submit" name="nsenter" value="Найти">
                </form>
                <p class="inf">
                    Игрок: <b>'.$nsplayer.'</b> '.$pLogin.'<br><br>
                </p>';
                if(($CHKC == 1) && ($chnsadm != 1)){
                    echo '<p class="tinf" style="font-size:14px;">
                        Номер аккаунта: <b>'.$Row['pID'].'</b><br>
                        Уровень: <b>'.$Row['pLevel'].'</b><br>
                        Очки опыта: <b>'.$Row['pExp'].'/'.$NEXT_LEVEL.'</b><br>
                        Наличные: <b>$'.$Row['pCash'].'</b><br>
                        Деньги в банке: <b>$'.$Row['pBank'].'</b><br>
                        На депозите: <b>$'.$Row['pDeposit'].'</b><br>
                        Номер телефона: <b>'.$Row['pPnumber'].'</b><br>
                        E-mail: <b>'.$Row['pEmail'].'</b><br>
                        Использовал промокод: <b>'.$hPromo[0].'</b><br>
                        Фишек с казино: <b>'.$Row['pCasinoChips'].' шт.</b><br><br>
                        Статус: <b>'.$pstatus.'</b><br>
                        На сотрудничестве: <b>'.$pmedia.'</b><br>
                        Дата регистрации: <b>'.date('Y-m-d H:i:s', $Row['DataReg']).'</b><br>
                        Подсеть: '.$subnet.'<br>
                    </p>
                    <img src="../resource/img/skins/'.$SKIN[0].'.png" />
                    <p class="tinfr" style="font-size:14px;"><br>
                        IP: <b>'.$Row['pIp'].'</b><br>
                        L-IP: <b>'.$Row['pvIp'].'</b><br>
                        R-IP: <b>'.$Row['pIpReg'].'</b><br>
                    </p>';
                }
                if(($CHKC == 1) && ($chnsadm != 1) && (mysqli_num_rows($DoAcc) > 1)){
                    echo'<p class="tinfr" style="font-size:14px;"><br><b>Дубликаты:</b>';
                    while($rowda = mysqli_fetch_row($DoAcc)){
                        echo '<br>['.$rowda[0].'] '.$rowda[1].' |'.$rowda[2].'';
                    }
                    echo'</p>';
                }
            echo '</div>
            </div>
        </td>';
        APANEL_MENU();
        echo '</tr>
  </tbody>
</table>';
// Header
if(($CHKC == 1) && ($chnsadm != 1)){
    $sh_login = mysqli_query($CONNECT, "SELECT * FROM `sh_login` WHERE `pID`='$Row[pID]'");
    $sh_warn = mysqli_query($CONNECT, "SELECT * FROM `sh_warn` WHERE `pID`='$Row[pID]'");
    $sh_ban = mysqli_query($CONNECT, "SELECT * FROM `sh_ban` WHERE `pID`='$Row[pID]'");
    $numbans = mysqli_num_rows($sh_ban);
    $numwarns = mysqli_num_rows($sh_warn);
    $numnames = mysqli_num_rows($sh_login);
    echo '<br><center><div class="us-nav">
        <form method="POST" action="/adminpanel?page=usersearch"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Статистика"></form>
        <form method="POST" action="/adminpanel?page=us_historyconnect"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="История входов"></form>
        <form method="POST" action="/adminpanel?page=us_historyname"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Изменение никнеймов ('.$numnames.')"></form>
        <form method="POST" action="/adminpanel?page=us_historywarn"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="История варнов ('.$numwarns.')"></form>
        <form method="POST" action="/adminpanel?page=us_historyban"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="История блокировок ('.$numbans.')"></form>
        <form method="POST" action="/adminpanel?page=us_moneylog"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Денежные логи"></form>
        <form method="POST" action="/adminpanel?page=us_userlog"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Логи действий"></form>
        <form method="POST" action="/adminpanel?page=us_fraclog"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Фракционные логи"></form>
        <form method="POST" action="/adminpanel?page=us_achievlog"><input type="text" name="nsuser" value="'.$nsplayer.'" required>
        <input type="submit" name="nsenter" value="Логи достижений"></form>
    </div></center>';
}
// Other
switch($PAGE) {
    case 'us_moneylog':{ $sqlCol = 'name'; break; } // Колонка никнейма
    case 'us_userlog':{ $sqlCol = 'user'; break; }
}
if($numnames > 0){ // Проверка на изменение ника для вывода логов
    $sh_login_table = '';
    $sqlWhere = "`".$sqlCol."` LIKE '%".$nsplayer."%'";
    while($sqlRow = mysqli_fetch_array($sh_login)) {
        // Таблица изменения ников
        $sh_login_table = $sh_login_table.'
        <tr><td>'.$sqlRow['PlayerName'].'</td>
        <td>'.$sqlRow['OldName'].'</td>
        <td>'.$sqlRow['Data'].'</td></tr>';
        // Формирование запроса
        $sqlWhere = $sqlWhere." OR `".$sqlCol."` LIKE '%".$sqlRow["PlayerName"]."%' OR `".$sqlCol."` LIKE '%".$sqlRow["OldName"]."%'";
    }
} else $sqlWhere = "`".$sqlCol."` LIKE '%".$nsplayer."%'";
?>