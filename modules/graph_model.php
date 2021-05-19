<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<script src="../js/graph/highcharts.js?v=<?php echo $ci;?>"></script>
<script src="../js/graph/exporting.js?v=<?php echo $ci;?>"></script>
<script type="text/javascript" src="../js/graph/jquery-3.5.1.min.js?v=<?php echo $ci;?>"></script>
<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'spline',
                    marginRight: 130,
                    marginBottom: 25
                },
                title: {
                    text: '<?php echo $title?>',
                    x: -20 // Центр
                },
                subtitle: {
                    text: '<?php echo $subtitle?>',
                    x: -20
                },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: { 
                        day: '%e %b'    
                    }
                },
                yAxis: {
                    title: {
                        text: '<?php echo $yAxis_Title?>'
                    },
                    min: 0
                },
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
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: [{
                    name: 'Подключения',
                    data: [<?php echo join($data, ',') ?>]
                    /*[
                        [Date.UTC(2012,  01, 10), 1  ],
                        [Date.UTC(2012,  01, 11), 2  ],
                        [Date.UTC(2012,  01, 12), 3  ],
                        [Date.UTC(2012,  01, 13), 7  ]
                    ]*/
                },
                {
                    name: 'Онлайн',
                    data: [<?php echo join($data2, ',') ?>]                            
                }]
            });
        });
    });
</script>