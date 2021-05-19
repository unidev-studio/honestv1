<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
                    include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>История входов</strong></p>
                            <p class="inf">
                                <center>
                                <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                                <div id="content_log" style="display:none;width:95%;">
                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Никнейм</th>
                                                <th>IP-Адрес</th>
                                                <th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Никнейм</th>
                                                <th>IP-Адрес</th>
                                                <th>Дата</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                            $SQL = mysqli_query($CONNECT, "SELECT * FROM `sh_connect` WHERE `pID`='$Row[pID]'");
                                            if(mysqli_num_rows($SQL) > 0) {
                                                while($RConnect = mysqli_fetch_array($SQL)) {
                                                    echo '
                                                    <tr><td>'.$RConnect['PlayerName'].'</td>
                                                    <td>'.$RConnect['PlayerIP'].'</td>
                                                    <td>'.$RConnect['Data'].'</td></tr>';
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