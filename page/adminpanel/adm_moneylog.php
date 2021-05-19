<?PHP 
	if(isset($_GET['date'])) $DATE = date("Y-m-d", strtotime($_GET['date']));
	else $DATE = date("Y-m-d");
?>
<style>.col-md-7{width:100%;}</style>
<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
			<center><h3>Денежный лог</h3></center>
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
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>№</th>
												<th>Дата</th>
												<th>Никнейм</th>
												<th>Действие</th>
												<th>Значение</th>
											</tr>
										</tfoot>
										<tbody>
										<?PHP
											$COUNT = 0;
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `s_logs_money` WHERE `date` LIKE '$DATE %:%:%' ORDER BY `Date` DESC");
											if(mysqli_num_rows($SQL) > 0) {
												while($Row = mysqli_fetch_array($SQL)) {
													$COUNT++;
													$r_translate = $Row['reason'];
													include 'modules/logs_translate.php';
													echo '
													<tr><td>'.$COUNT.'</td>
													<td>'.$Row['date'].'</td>
													<td id="from_'.$Row['id'].'">'.$Row['name'].'</td>
													<script>MarcTooltips.add("#from_'.$Row['id'].'", "Наличные: $'.$Row['pCash'].'<br>Банк: $'.$Row['pBank'].'");</script>
													<td>'.$r_translate.'</td>
													<td>'.$Row['amount'].'</td></tr>';
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