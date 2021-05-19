<style>.col-md-7{width:100%;}</style>
<div class="container">
	<div class="col-md-12 post">
		<h1>Администраторский раздел</h1
			<?PHP
				echo '<br><table style="text-align: left; width: 100%; height: auto;" border="0">
				<tbody>
                    <tr>
                        <td width="80%">
                            <div class="ageninf">
                            <div>
                                <p><strong>Управление лидерами организаций</strong></p>
                                <p class="tinf">
                                    Количество лидеров: <b>'.$SITE['s_adm_cfoll_leaders'].'</b><br><br>
                                    [Ф] Активность гос. орг.: <b>'.$SITE['s_adm_cfoll_gos'].' час(ов)</b><br>
                                    [Ф] Активность банд: <b>'.$SITE['s_adm_cfoll_gang'].' час(ов)</b><br>
                                    [Ф] Активность мафий: <b>'.$SITE['s_adm_cfoll_maf'].' час(ов)</b><br>
                                </p>
                                <p class="tinfr">
                                    Информация об активности от:<br>
									<b>'.date_format(date_modify(date_create(), '-1 week'), 'Y-m-d').'</b><br>
									<br>Обчислить общее время проведенное на сервере:<br>
									<b>Онлайн + AFK<b><br>
                                </p>
                            </div>
                            </div>
                        </td>';
                        APANEL_MENU();
                        echo '</tr>
				  </tbody>
                </table>';
                //
                echo '<br><div class="asetbl">
					<div>
						<p><strong>Список лидеров</strong></p>
                        <p class="inf">
                            <center>
							<table class="table table-bordered" width="100%" id="dataTable" cellspacing="0" style="width:95%;">
								<thead>
									<tr>
										<th>№</th>
										<th>Организация</th>
										<th>Лидер</th>
										<th>Онлайн</th>
										<th>AFK</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>№</th>
										<th>Организация</th>
										<th>Лидер</th>
										<th>Онлайн</th>
										<th>AFK</th>
									</tr>
								</tfoot>
								<tbody>';
                                    echo $SITE['s_adm_cfoll_list'];
								echo '</tbody>
                            </table>
                            </center>
                        </p>
                    </div>
                </div>';
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