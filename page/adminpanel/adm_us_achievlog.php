<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
                    include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>История достижений</strong></p>
                            <p class="inf">
                                <center>
                                <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                                <div id="content_log" style="display:none;width:95%;">
                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>№</th>
												<th>Игрок</th>
												<th>Достижение</th>
												<th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>№</th>
												<th>Игрок</th>
												<th>Достижение</th>
												<th>Дата</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                            $AL_COUNT = 0;
											$AL_SQL = mysqli_query($CONNECT, "SELECT * FROM `s_achiev` WHERE `pID`='$Row[pID]' OR `Name`='$Row[Name]' ORDER BY `Date` DESC");
											if(mysqli_num_rows($AL_SQL) > 0) {
												while($alRow = mysqli_fetch_array($AL_SQL)) {
													$AL_COUNT++;
													echo '
													<tr><td>'.$AL_COUNT.'</td>
													<td>'.$alRow['Name'].'</td>
													<td>'.$alRow['Info'].'</td>
													<td>'.$alRow['Date'].'</td></tr>';
												}
											}
											mysqli_free_result($AL_SQL);
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