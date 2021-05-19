<?php
if($lsRow['fLeader'] != 'None'){
    $c_leaders++;
    switch($lsRow['fName']) {
        case 'LSPD': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'ФБР': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Армия СФ': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Медики СФ': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Мэрия': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'SF News': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'SFPD': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Автошкола': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'LS News': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Армия ЛВ': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'LV News': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'LVPD': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Медики ЛС': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Медики ЛВ': $t_gos = $t_gos + ($dtUsr[0] - $dtUsr[1]); break;

        case 'Ballas Gang': $t_gang = $t_gang + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Vagos Gang': $t_gang = $t_gang + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Grove Street': $t_gang = $t_gang + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Aztecas Gang': $t_gang = $t_gang + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Rifa Gang': $t_gang = $t_gang + ($dtUsr[0] - $dtUsr[1]); break;

        case 'La Cosa Nostra': $t_maf = $t_maf + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Yakuza': $t_maf = $t_maf + ($dtUsr[0] - $dtUsr[1]); break;
        case 'Русская Мафия': $t_maf = $t_maf + ($dtUsr[0] - $dtUsr[1]); break;
    }
}