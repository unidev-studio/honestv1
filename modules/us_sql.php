<?php
if(isset($_POST['nsuser']) && isset($_POST['nsenter'])){
    $nsplayer = $_POST['nsuser'];
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
        $NEXT_LEVEL = ( ($Row['pLevel'] + 1) * 4) - 1;
        $SKIN = explode(",", $Row['pChars']);
    }
}
else { $nsplayer = 'Не указан'; }
?>