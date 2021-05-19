<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
					include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>Логи действий</strong></p>
                            <p class="inf">
                                <center>
                                <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                                <div id="content_log" style="display:none;width:95%;">
                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>№</th>
												<th>IP</th>
												<th>Игрок</th>
												<th>Локация</th>
                                                <th>Действие</th>
                                                <th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>№</th>
												<th>IP</th>
												<th>Игрок</th>
												<th>Локация</th>
                                                <th>Действие</th>
                                                <th>Дата</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                            $COUNT = 0;
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `sl_users` WHERE $sqlWhere");
											if(mysqli_num_rows($SQL) > 0) {
												while($Row = mysqli_fetch_array($SQL)) {
													$COUNT++;
													echo '
													<tr><td>'.$COUNT.'</td>
													<td>'.$Row['playerIP'].'</td>
													<td>'.$Row['user'].'</td>
													<td>'.$Row['location'].'</td>
													<td>'.$Row['action'].'</td>
													<td>'.$Row['date'].'</td></tr>';
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