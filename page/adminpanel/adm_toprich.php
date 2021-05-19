<style>.col-md-7{width:100%;}rect{fill:none;}</style>
<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
			<center>
				<h3>Топ Богачей</h3>
				<div id="graph" style="min-width:400px;height:400px;margin:0 auto;max-width:900px;max-height:300px;"></div>
				<p><?php echo '
					Всего вирт на сервере: <a style="color:green;text-decoration:none;">$'.$SITE['s_allcash'].'</a>. Из которых <a style="color:red;text-decoration:none;">$'.$SITE['s_adban'].'</a> заблокированные<br>
					<a style="color:#BD0B4C;text-decoration:none;">
						В багажниках: $'.$SITE['s_acarcash'].' / Бизнесах: $'.$SITE['s_abizcash'].' / Фермах: $'.$SITE['s_afarmcash'].'
					</a><br>
					<a style="color:#D05481;text-decoration:none;">
						Материалов: '.$SITE['s_amats'].' / Наркотиков: '.$SITE['s_adrugs'].'
					</a>
				'; ?></p>
			</center>
					<table style="text-align: left; width: 100%; height: auto;" border="0">
						<tbody>
							<tr>
								<td width="80%">
									<div class="table-responsive">
										<table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
											<thead>
												<tr>
													<th>№</th>
													<th>Ник</th>
													<th>Уровень</th>
													<th>Наличные</th>
													<th>Банк</th>
													<th>Депозит</th>
													<th>Итого</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>№</th>
													<th>Ник</th>
													<th>Уровень</th>
													<th>Наличные</th>
													<th>Банк</th>
													<th>Депозит</th>
													<th>Итого</th>
												</tr>
											</tfoot>
											<tbody>
												<?PHP echo $SITE['s_adm_toprich_list']; ?>
											</tbody>
										</table>
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
<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'graph', type: 'spline',
                    marginRight: 130, marginBottom: 25
                },
                title: { text: 'График наличия виртуальной валюты', x: -20 },
                xAxis: { type: 'datetime', dateTimeLabelFormats: { day: '%e %b' } },
                yAxis: { title: { text: 'Деньги' }, min: 0 },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10, y: 100,
                    borderWidth: 0
				},
                series: [{ name: 'Всего', data: [<?php series($SITE['s_tr_all']);?>] },
				{ name: 'В транспорте', data: [<?php series($SITE['s_tr_vechiles']);?>] },
				{ name: 'В бизнесах', data: [<?php series($SITE['s_tr_businesses']);?>] },
				{ name: 'На фермах', data: [<?php series($SITE['s_tr_farms']);?>] },
                { name: 'Заблокировано', data: [<?php series($SITE['s_tr_banned']);?>] },
				{ name: 'Материалы', data: [<?php series($SITE['s_tr_mats']);?>] },
				{ name: 'Наркотики', data: [<?php series($SITE['s_tr_drugs']);?>] }]
            });
        });
    });
</script>
<?php function series($cache){ echo str_replace('[[', '[', str_replace(']]', ']', str_replace('"', '', $cache)));}?>