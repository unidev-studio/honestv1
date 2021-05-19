<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    if(isset($_POST['nsuser']) && isset($_POST['nsenter'])){
                        $nsplayer = $_POST['nsuser'];
                        CreateLog($_SESSION['USER_LOGIN'], 'Произвел поиск '.$nsplayer.'');
                        //
                        $CHKC = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `pID` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$nsplayer'"));
                        $NWYALVL = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `level` FROM `s_admin` WHERE `Name` = '$_SESSION[USER_LOGIN]'"));
                        $NSUALVL = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `level` FROM `s_admin` WHERE `Name` = '$nsplayer'"));
                        if($NSUALVL[0] > $NWYALVL[0]){ $chnsadm = 1; } else{ $chnsadm = 0; }
                        if($CHKC != 1){ echo '<center><h4 style="color: #ff0000;">Указанный игрок не найден!</h4></center>'; $nsplayer = 'Не указан'; }
                        else if($chnsadm == 1){ echo '<center><h4 style="color: #ff0000;">У Вас недостаточно прав что-бы использовать поиск на этого игрока!</h4></center>'; $nsplayer = 'Не указан'; }
                        else {
                            $chsupp = mysqli_num_rows(mysqli_query($CONNECT, "SELECT `sID` FROM `s_supports` WHERE `sName` = '$nsplayer'"));
                            $Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$nsplayer'"));
                            $DoAcc = mysqli_query($CONNECT, "SELECT `pID`,`Name`,`pLevel` FROM `s_users` WHERE `pIpReg` LIKE '%$Row[pIpReg]%' OR `pIpReg` LIKE '%$Row[pIp]%' OR `pIp` LIKE '%$Row[pIp]%' OR `pIp` LIKE '%$Row[pIpReg]%' ORDER BY `pLevel` DESC");
                            $hPromo = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `code` FROM `s_promocode_used` WHERE `idacca` = '$Row[pID]'"));
                            $Q_CHBIZZ = mysqli_query($CONNECT, "SELECT * FROM `businesses` WHERE `bOwner` = '$nsplayer' LIMIT 3");
                            $Q_CHFARM = mysqli_query($CONNECT, "SELECT * FROM `farms` WHERE `owner` = '$nsplayer' LIMIT 1");
                            $CHHOUSE = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `house` WHERE `hOwner` = '$nsplayer' LIMIT 1"));
                            $NEXT_LEVEL = ($Row['pLevel'] + 1) * 4;
                            $SKIN = explode(",", $Row['pChars']);
                            $LICENSES = explode(",", $Row['licenses']);
                            $LICTIME = explode("|", $Row['licensesTime']);
                            $GUNSKILL = explode(",", $Row['pGunSkills']);
                            //
                            $CHSRVX = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `s_boost_server`"));
                            if($CHSRVX['boost_time'] >= 1) $DonateInAcc = $Row['u_donate'] + ($Row['u_nodonate'] * $CHSRVX['donate']);
                            else $DonateInAcc = $Row['u_donate'] + $Row['u_nodonate'];
                            //
                            if ($AccFamily['fName'] == '') $AccFamily['fName'] = 'Нет';
                            if ($Row['pDrug'] == '-') $Row['pDrug'] = 'Отсутствует';
                            if ($Row['pMarriedTo'] == '-') $Row['pMarriedTo'] = 'Отсутствует';
                            if ($Row['pWarns'] == '0') $Row['pWarns'] = 'Отсутствуют';
                            switch($Row['pJob']) {
                                case 0: $pJob = 'Безработный'; break;
                                case 1: $pJob = 'Водитель автобуса'; break;
                                case 2: $pJob = 'Таксист'; break;
                                case 3: $pJob = 'Продавец хотдогов'; break;
                                case 4: $pJob = 'Развозчик продуктов'; break;
                                case 5: $pJob = 'Механик'; break;
                                case 6: $pJob = 'Инкассатор'; break;
                                case 7: $pJob = 'Прораб'; break;
                                case 8: $pJob = 'Тренер'; break;
                                case 9: $pJob = 'Дальнобойщик'; break;
                            }
                            if ($LICENSES[0] == '0') $LICENSES[0] = 'Отсутствует'; else $LICENSES[0] = 'Есть';
                            if ($LICENSES[1] == '0') $LICENSES[1] = 'Отсутствует'; else $LICENSES[1] = 'Есть';
                            if ($LICENSES[2] == '0') $LICENSES[2] = 'Отсутствует'; else $LICENSES[2] = 'Есть';
                            if ($LICENSES[3] == '0') $LICENSES[3] = 'Отсутствует'; else $LICENSES[3] = 'Есть';
                            if ($LICENSES[4] == '0') $LICENSES[4] = 'Отсутствует'; else $LICENSES[4] = 'Есть';
                            switch($Row['vip_rank']) {
                                case 0: $Row['vip_rank'] = 'Отсутствует'; $Row['vip_time'] = ''; break;
                                case 1: $Row['vip_rank'] = 'Bronze Vip'; $Row['vip_time'] = '(до '.date('d-m-Y', $Row['vip_time']).')'; break;
                                case 2: $Row['vip_rank'] = 'Silver Vip'; $Row['vip_time'] = '(до '.date('d-m-Y', $Row['vip_time']).')'; break;
                                case 3: $Row['vip_rank'] = 'Gold Vip'; $Row['vip_time'] = '(до '.date('d-m-Y', $Row['vip_time']).')'; break;
                                case 4: $Row['vip_rank'] = 'Platinum Vip'; $Row['vip_time'] = '(до '.date('d-m-Y', $Row['vip_time']).')'; break;
                                case 5: $Row['vip_rank'] = 'Diamond Vip'; $Row['vip_time'] = '(до '.date('d-m-Y', $Row['vip_time']).')'; break;
                            }
                            switch($Row['boost_rank']) {
                                case 0: $Row['boost_rank'] = 'Отсутствует'; $Row['boost_time'] = ''; break;
                                case 1: $Row['boost_rank'] = 'Стартовый'; $Row['boost_time'] = '(до '.date('d-m-Y', $Row['boost_time']).')'; break;
                                case 2: $Row['boost_rank'] = 'Профессиональный'; $Row['boost_time'] = '(до '.date('d-m-Y', $Row['boost_time']).')'; break;
                                case 3: $Row['boost_rank'] = 'Авторитет'; $Row['boost_time'] = '(до '.date('d-m-Y', $Row['boost_time']).')'; break;
                                case 4: $Row['boost_rank'] = 'Босс'; $Row['boost_time'] = '(до '.date('d-m-Y', $Row['boost_time']).')'; break;
                            }
                            switch($Row['pMember']) {
                                case 0: $Row['pMember'] = 'Гражданский'; break;
                                case 1: $Row['pMember'] = 'LSPD'; break;
                                case 2: $Row['pMember'] = 'ФБР'; break;
                                case 3: $Row['pMember'] = 'Армия СФ'; break;
                                case 4: $Row['pMember'] = 'Медики СФ'; break;
                                case 5: $Row['pMember'] = 'La Cosa Nostra'; break;
                                case 6: $Row['pMember'] = 'Yakuza'; break;
                                case 7: $Row['pMember'] = 'Мэрия'; break;
                                case 8: $Row['pMember'] = 'Casino'; break;
                                case 9: $Row['pMember'] = 'SF News'; break;
                                case 10: $Row['pMember'] = 'SFPD'; break;
                                case 11: $Row['pMember'] = 'Автошкола'; break;
                                case 12: $Row['pMember'] = 'Ballas Gang'; break;
                                case 13: $Row['pMember'] = 'Vagos Gang'; break;
                                case 14: $Row['pMember'] = 'Русская Мафия'; break;
                                case 15: $Row['pMember'] = 'Grove Street'; break;
                                case 16: $Row['pMember'] = 'LS News'; break;
                                case 17: $Row['pMember'] = 'Aztecas Gang'; break;
                                case 18: $Row['pMember'] = 'Rifa Gang'; break;
                                case 19: $Row['pMember'] = 'Армия ЛВ'; break;
                                case 20: $Row['pMember'] = 'LV News'; break;
                                case 21: $Row['pMember'] = 'LVPD'; break;
                                case 22: $Row['pMember'] = 'Медики ЛС'; break;
                                case 23: $Row['pMember'] = 'Медики ЛВ'; break;
                                case 24: $Row['pMember'] = "Hell's Angels MC"; break;
                                case 25: $Row['pMember'] = 'Warlocks MC'; break;
                                case 26: $Row['pMember'] = 'Pagans MC'; break;
                                default: $Row['pMember'] = 'Неизвестно'; break;
                            }
                            switch($CHHOUSE['hKlass']) {
                                case 0: $hKlass = 'N'; break;
                                case 1: $hKlass = 'D'; break;
                                case 2: $hKlass = 'C'; break;
                                case 3: $hKlass = 'B'; break;
                                case 4: $hKlass = 'A'; break;
                                case 5: $hKlass = 'S'; break;
                                default: $hKlass = 'Неизвестно'; break;
                            }
                            if ($Row['activate_mail'] == '0') $Row['activate_mail'] = 'Не подтвержден'; else $Row['activate_mail'] = 'Подтвержден';
                            if ($Row['Google'] == '0') $Row['Google'] = 'Не подтвержден'; else $Row['Google'] = 'Подтвержден';
                            if ($Row['CheckIP'] == '0') $Row['CheckIP'] = 'Не подтвержден'; else $Row['CheckIP'] = 'Подтвержден';
                        }
                    }
                    else{ $nsplayer = 'Не указан'; }
                    
					include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        // Информация об аккаунте <bags-grid>
                        echo '<br><div class="ucrinf">
                            <div>
                                <p><strong>Дополнительная информация</strong></p>
                                <p class="inf">
                                    Реферальный аккаунт: <b>'.$Row['pDrug'].'</b><br>
                                    Состоит в семье: <b>'.$AccFamily['fName'].'</b><br>
                                    Организация (Ранг): <b>'.$Row['pMember'].' ('.$Row['pRank'].')</b><br>
                                    Подработка: <b>'.$pJob.'</b><br>
                                    Уровень розыска: <b>'.$Row['pWantedLevel'].' звезд</b><br>
                                    Муж/Жена: <b>'.$Row['pMarriedTo'].'</b><br>
                                    Варны: <b>'.$Row['pWarns'].'</b><br>
                                    Материалов: <b>'.$Row['pMats'].' шт.</b><br>
                                    Наркотиков: <b>'.$Row['pDrugs'].' грамм</b><br>
                                </p>
                                <img src="../resource/img/ucrof1.png">
                            </div>
                            <div>
                                <p><strong>Прочее</strong></p>
                                <p class="inf">
                                    <span><b>Улучшения</b></span><br>
                                    Баланс аккаунта: <b>'.$DonateInAcc.'руб.</b><br>
                                    VIP-Статус: <b>'.$Row['vip_rank'].'</b> '.$Row['vip_time'].'<br>
                                    Стартовый пакет: <b>'.$Row['boost_rank'].'</b> '.$Row['boost_time'].'<br><br>
                                    <!--Анти-голод: <b>'.$Row['pID'].'</b><br>-->
                                    <span><b>Защита аккаунта</b></span><br>
                                    E-mail: <b>'.$Row['activate_mail'].'</b><br>
                                    Google-Auth: <b>'.$Row['Google'].'</b><br>
                                    Проверка по IP: <b>'.$Row['CheckIP'].'</b><br>
                                </p>
                                <img src="../resource/img/ucrof2.png">
                            </div>
                            <div>
                                <p><strong>Лицензии</strong></p>
                                <p class="inf">
                                    Водительские права: <b>'.$LICENSES[0].'</b> (до '.date('d-m-Y', $LICTIME[0]).')<br>
                                    Лицензия пилота: <b>'.$LICENSES[1].'</b> (до '.date('d-m-Y', $LICTIME[1]).')<br>
                                    Лицензия на катера: <b>'.$LICENSES[2].'</b> (до '.date('d-m-Y', $LICTIME[2]).')<br>
                                    Лицензия рыболова: <b>'.$LICENSES[3].'</b> (до '.date('d-m-Y', $LICTIME[3]).')<br>
                                    Лицензия на оружие: <b>'.$LICENSES[4].'</b> (до '.date('d-m-Y', $LICTIME[4]).')<br>
                                </p>
                                <img src="../resource/img/ucrof3.png">
                            </div>
                            <div>
                                <p><strong>Навыки персонажа</strong></p>
                                <p class="inf">
                                    Владение SDPistol: <b>'.$GUNSKILL[0].'/100%</b><br>
                                    Владение Deagle: <b>'.$GUNSKILL[1].'/100%</b><br>
                                    Владение ShotGun: <b>'.$GUNSKILL[2].'/100%</b><br>
                                    Владение MP5: <b>'.$GUNSKILL[3].'/100%</b><br>
                                    Владение AK47: <b>'.$GUNSKILL[4].'/100%</b><br>
                                    Владение M4A1: <b>'.$GUNSKILL[5].'/100%</b><br>
                                </p>
                                <img src="../resource/img/ucrof4.png">
                            </div>
                            <div>
                                <p><strong>Имущество</strong></p>
                                <p class="inf">';
                                    if ($CHHOUSE >= 1) {
                                        if($CHHOUSE['hLock'] == 0) $HLOCK = "Закрыт"; else $HLOCK = "Открыт";
                                        if($CHHOUSE['hGarageID'] == -1) $HGARAGE = "Отсутствует"; else $HGARAGE = "Имеется";
                                        echo 'Дом №: <b>'.$CHHOUSE['hID'].'</b><br>
                                        Гос. стоимость: <b>$'.$CHHOUSE['hValue'].'</b><br>
                                        Состояние: <b>'.$HLOCK.'</b><br>
                                        Класс дома: <b>'.$hKlass.'</b><br>
                                        Гараж: <b>'.$HGARAGE.'</b><br>
                                        Аптечек: <b>'.$CHHOUSE['hHel'].'</b><br>';
                                    }
                                    else echo '<b>У игрока отсутствует дом!</b>';
                                echo '</p>
                                <img style="width:96px;" src="../resource/img/ucrof5.png">
                            </div>
                        </div>';

                        $NUM_BIZZ = mysqli_num_rows($Q_CHBIZZ);
                        $CHFARM = mysqli_fetch_array($Q_CHFARM); $NUM_FARM = mysqli_num_rows($Q_CHFARM);
                        if($NUM_BIZZ > 0 || $NUM_FARM > 0) echo'<br><div style="text-align:left;width:100%;padding:1em;height:auto;background:#fff;border-radius:18px;box-shadow: 0px 0px 30px 0px rgba(232,0,0,0.15), inset 0px 0px 6px 0px rgba(232,0,0,0.13);" border="0" class="ucprofile">
                        <center><h3><strong>Бизнесы</strong></h3></center></div> <br><div class="ucrinf">';
                        else echo'<br><div style="text-align:left;width:100%;padding:1em;height:auto;background:#fff;border-radius:18px;box-shadow: 0px 0px 30px 0px rgba(232,0,0,0.15), inset 0px 0px 6px 0px rgba(232,0,0,0.13);" border="0" class="ucprofile">
                        <center><h3><strong>У игрока отсутствуют бизнесы!</strong></h3></center></div> <br><div class="ucrinf">';
                            if($NUM_FARM > 0){
                                $CHFARM['id'] = $CHFARM['id'] - 1;
                                echo '<div><p><strong>Ферма №: '.$CHFARM['id'].'</strong></p>
                                <p class="inf">
                                    Продуктов: <b>'.$CHFARM['prods'].'</b><br>
                                    На банковском счету: <b>$'.$CHFARM['bank'].'</b><br>
                                    На счету электроэнергии: <b>$'.$CHFARM['landtax'].'</b><br>
                                    Зарплата сотрудникам: <b>$'.$CHFARM['zp'].'</b><br>
                                    Стоимость закупа зерна: <b>$'.$CHFARM['grain_price'].'</b><br>
                                    Зерна на складе: <b>'.$CHFARM['grain'].'</b><br>
                                    Зерна засеяно: <b>'.$CHFARM['grain_sown'].'</b><br>
                                </p><img style="width:88px;" src="../resource/img/ucrof6.png"></div>';
                            }
                            if($NUM_BIZZ > 0){
                                while($BizRow = mysqli_fetch_array($Q_CHBIZZ)) {
                                    if($BizRow['bLocked'] == 1) $BSTATUS = "Закрыто"; else $BSTATUS = "Открыто";
                                    if($BizRow['bMafia'] == 5) $BMAFIA = "La Cosa Nostra";
                                    else if($BizRow['bMafia'] == 6) $BMAFIA = "Yakuza";
                                    else if($BizRow['bMafia'] == 14) $BMAFIA = "Russian Mafia";
                                    else $BMAFIA = "-";
                                    echo '<div><p><strong>Бизнес №: '.$BizRow['id'].'</strong></p>
                                    <p class="inf">
                                        Название: <b>'.$BizRow['bName'].'</b><br>
                                        Гос. стоимость: <b>$'.$BizRow['bBuyPrice'].'</b><br>
                                        Продуктов: <b>'.$BizRow['bProducts'].'</b><br>
                                        На банковском счету: <b>$'.$BizRow['bBank'].'</b><br>
                                        На счету электроэнергии: <b>$'.$BizRow['bLandTax'].'</b><br>
                                        Состояние: <b>'.$BSTATUS.'</b><br>
                                        Под контролем: <b>'.$BMAFIA.'</b><br>
                                        Сообщение при входе: <b>'.$BizRow['bMessage'].'</b><br>
                                    </p><img style="width:88px;" src="../resource/img/ucrof6.png"></div>';
                                }
                            }
                        echo '</div>';
                        
                        // Транспорт игрока
                        $uCar = mysqli_query($CONNECT, "SELECT `vModel`,`vFine` FROM `s_vehicle_player` WHERE `vOwner` = '$Row[pID]' LIMIT 3");
                        if(mysqli_num_rows($uCar) >= 1) {
                            echo '<table style="text-align:left;width:100%;height:auto;background:#fff;border-radius:18px;box-shadow: 0px 0px 30px 0px rgba(232,0,0,0.15), inset 0px 0px 6px 0px rgba(232,0,0,0.13);" border="0" class="ucprofile">
                                <tbody><tr><td style="padding:0 0 22px;"><center><h3><strong>Личный транспорт</strong></h3>';
                                    while ($rowc = mysqli_fetch_array($uCar)) {
                                        echo '<img src="../resource/img/vehicles/Vehicle_'.$rowc['vModel'].'.jpg" />';
                                        if($rowc['vFine'] >= 1) {
                                            echo '<img src="../resource/img/vfinestatus.jpg" style="height:22px;margin-left:-110px;margin-top:-115px;border-bottom:none;" />';
                                        }
                                    }
                                echo '</center></td></tr></tbody></table>';
                            }
                        else echo '<div style="text-align:left;width:100%;padding:1em;height:auto;background:#fff;border-radius:18px;box-shadow: 0px 0px 30px 0px rgba(232,0,0,0.15), inset 0px 0px 6px 0px rgba(232,0,0,0.13);" border="0" class="ucprofile">
                        <center><h3><strong>У игрока отсутствует личный транспорт!</strong></h3></center></div>';
                    }
				?>
			<br>
			<br>
		</div>
    </div>
<script>
$(document).ready(function() {
	$('#dataTable').DataTable();
	$('#load_page').hide();
	$('#content_log').show();
});
</script>