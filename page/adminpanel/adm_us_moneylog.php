<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
                    include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>Денежные логи</strong></p>
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
                                        <tbody>';
                                            $COUNT = 0;
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `s_logs_money` WHERE $sqlWhere");
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