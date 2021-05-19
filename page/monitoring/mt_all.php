	<div class="container">
		<div class="col-md-12 post">
			<div class="mn-nav">
				<p>Мониторинг</p>
				<div>
				<a href="/monitoring"><label class="active">Все игроки</label></a>
				<a href="?page=fraction"><label>Организации</label></a>
				<a href="?page=job"><label>Работы</label></a>
				<a href="?page=top"><label>ТОП</label></a>
				</div>
			</div><br>
				<center>
					<?PHP
					//
					echo '<br><div class="asetbl">
						<div><p><strong>ТЕКУЩИЙ ОНЛАЙН</strong></p>
						<p style="font-size:10px;color:darkgrey;margin:-1.5em 0 5px 0;">Последнее обновление: '.date('H:i:s', $MONITORING_Time).'</p>
						<p><b>'.$SITE['s_mt_all_num'].'/1000</b></p>
						<p style="font-size:10px;color:#BD0B4C;margin:-1em 0 5px 0;">Пик за сегодня: '.$SITE['s_mt_peak_now'].' ('.$SITE['s_mt_peak_percent'].'%)</p>
                        <p class="inf">
                            <center>
                            <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                            <div id="content_log" style="display:none;width:95%;">
                                <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>№</th>
											<th>Игрок</th>
											<th>Уровень</th>
											<th>Фракция</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>№</th>
											<th>Игрок</th>
											<th>Уровень</th>
											<th>Фракция</th>
                                        </tr>
                                    </tfoot>
									<tbody>';
										echo $SITE['s_mt_all'];
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