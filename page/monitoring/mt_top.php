<div class="container">
		<div class="col-md-12 post">
			<div class="mn-nav">
				<p>Мониторинг</p>
				<div>
				<a href="/monitoring"><label>Все игроки</label></a>
				<a href="?page=fraction"><label>Организации</label></a>
				<a href="?page=job"><label>Работы</label></a>
				<a href="?page=top"><label class="active">ТОП</label></a>
				</div>
			</div><br>
				<center>
					<?PHP
					if(isset($_POST['ften'])) $topName = $_POST['ften'];
					else $topName = 'Самые старые';
					switch($topName){
						case 'Самые старые': $th = '<th>№</th><th>Игрок</th><th>Уровень</th><th>Статус</th>'; break;
						case 'Самые богатые': $th = '<th>№</th><th>Игрок</th><th>Статус</th>'; break;
						case 'ТОП пожертвований': $th = '<th>№</th><th>Игрок</th><th>Статус</th>'; break;
						case 'ТОП промокодов': $th = '<th>№</th><th>Промокод</th><th>Владелец</th><th>Кол-во использований</th>'; break;
					}
					//
					echo '<br><div class="asetbl">
						<div>
							<center><div style="display:flex;flex-wrap:wrap;justify-content:center;padding:0 2% 0 2%;">
							'.$SITE['s_mt_top_list'].'
							</div></center>
						</div>
						<div><p><strong>'.$topName.'</strong></p><br>
						<p style="font-size:10px;color:darkgrey;margin:-3em 0 1.5em 0;">Последнее обновление: '.date('H:i:s', $MONITORING_Time).'</p>
						<p class="inf">
							<center>
							<div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
							<div id="content_log" style="display:none;width:95%;">
								<table class="table table-bordered" width="100%" id="dataTableS" cellspacing="0">
									<thead><tr>'.$th.'</tr></thead>
									<tfoot><tr>'.$th.'</tr></tfoot>
									<tbody>';
										echo file_get_contents('scripts/cache/mt_top_'.$topName.'.cache.php');
									echo '</tbody>
								</table>
							</div>
							</center>
						</p></div>
					</div>';
					?>
				</center>
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