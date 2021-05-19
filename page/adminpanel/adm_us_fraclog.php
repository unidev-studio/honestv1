<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
                    include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>Фракционные логи</strong></p>
                            <p class="inf">
                                <center>
                                <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                                <div id="content_log" style="display:none;width:95%;">
                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>№</th>
												<th>Дата</th>
												<th>Никнейм</th>
												<th>Действие</th>
												<th>Значение</th>
                                                <th>Фракция</th>
                                                <th>Ранг</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>№</th>
												<th>Дата</th>
												<th>Никнейм</th>
												<th>Действие</th>
												<th>Значение</th>
                                                <th>Фракция</th>
                                                <th>Ранг</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                            $COUNT = 0;
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `s_logs_f_money` WHERE `pID` LIKE '$Row[pID]'");
											if(mysqli_num_rows($SQL) > 0) {
												while($Row = mysqli_fetch_array($SQL)) {
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
													$COUNT++;
													echo '
													<tr><td>'.$COUNT.'</td>
                                                    <td>'.$Row['date'].'</td>
                                                    <td>'.$Row['pName'].'</td>
													<td>'.$Row['Reason'].'</td>
                                                    <td>'.$Row['Money'].'</td>
                                                    <td>'.$Row['pMember'].'</td>
                                                    <td>'.$Row['pRank'].'</td></tr>';
												}
                                            }
                                        echo '</tbody>
                                    </table>
                                </div>
                                </center>
                            </p></div>
                        </div>';
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