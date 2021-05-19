<?PHP 
	if(isset($_GET['date'])) $DATE = date("Y-m-d", strtotime($_GET['date']));
	else $DATE = date("Y-m-d");
?>
<style>.col-md-7{width:100%;}</style>
<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
			<center><h3>Фракционный лог</h3></center>
				<table style="text-align: left; width: 100%; height: auto;" border="0">
					<tbody>
						<tr>
							<td width="80%">
							<div id="load_page"><center><h4>Загрузка лога...</h4></center></div>
							<div id="content_log" style="display:none;">
								<div class="select_date"><?PHP include_once 'modules/t_date_select.php';?></div>
								<div class="table-responsive">
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
										<tbody>
										<?PHP
											$COUNT = 0;
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `s_logs_f_money` WHERE `date` LIKE '$DATE %:%:%' ORDER BY `Date` DESC");
											if(mysqli_num_rows($SQL) > 0){
												while($Row = mysqli_fetch_array($SQL)){
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
											mysqli_free_result($SQL);
										?>
										</tbody>
									</table>
								</div>
							</div>
							</td>
							<?PHP echo APANEL_MENU(); ?>
						</tr>
					  </tbody>
				</table>
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