<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
                <?PHP
                    include 'modules/us_sql.php';
                    include 'modules/main_search.php';
                    if(($CHKC == 1) && ($chnsadm != 1)){
                        echo '<br><div class="asetbl">
                            <div><p><strong>История варнов</strong></p>
                            <p class="inf">
                                <center>
                                <div id="load_page"><center><h5>Загрузка таблицы...</h5></center></div>
                                <div id="content_log" style="display:none;width:95%;">
                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Администратор</th>
                                                <th>Причина</th>
                                                <th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Администратор</th>
                                                <th>Причина</th>
                                                <th>Дата</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                            if($numwarns > 0) {
                                                while($RWarn = mysqli_fetch_array($sh_warn)) {
                                                    echo '
                                                    <tr><td>'.$RWarn['NameAdmin'].'</td>
                                                    <td>'.$RWarn['Text'].'</td>
                                                    <td>'.$RWarn['Date'].'</td></tr>';
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