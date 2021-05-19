<div class="container">
		<div class="col-md-12 post">
			<div class="mn-nav">
				<p>Мониторинг</p>
				<div>
				<a href="/monitoring"><label>Все игроки</label></a>
				<a href="?page=fraction"><label class="active">Организации</label></a>
				<a href="?page=job"><label>Работы</label></a>
				<a href="?page=top"><label>ТОП</label></a>
				</div>
			</div><br>
				<center>
					<?PHP
					if(isset($_POST['ften'])) $ftName = $_POST['ften'];
					else $ftName = 'LSPD';
					//
					echo '<br><div class="asetbl">
						<div>
							<center><div style="display:inline-flex;flex-wrap:wrap;justify-content:center;padding:0 2% 0 2%;">';
								echo $SITE['s_mt_fraction_list'];
							echo '</div></center>
						</div>
						<div><p><strong>'.$ftName.'</strong></p>
						<p style="font-size:10px;color:darkgrey;margin:-1.5em 0 5px 0;">Последнее обновление: '.date('H:i:s', $MONITORING_Time).'</p>
						<p><b>Всего: '.number_format(file_get_contents('scripts/cache/mt_fraction_'.$ftName.'_num.cache.php'), 0, '', ',').' человек(а).</b></p>
                        <p class="inf">
                            <center>
                            <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                            <div id="content_log" style="display:none;width:95%;">
                                <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Игрок</th>
											<th>Ранг</th>
											<th>Статус</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>№</th>
                                            <th>Игрок</th>
											<th>Ранг</th>
											<th>Статус</th>
                                        </tr>
                                    </tfoot>
									<tbody>';
										echo file_get_contents('scripts/cache/mt_fraction_'.$ftName.'.cache.php');
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