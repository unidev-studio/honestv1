<?php
/*function Graph($table, $title, $subtitle, $yAxis_Title, $columns) {
	$table = 'w_cash_log'; # Название таблицы в бд
	$title = 'Макет графика'; # Заголовок таблицы
    $subtitle = '<a href="https://vk.com/mersetti">by Mersetti</a>'; # Подзаголовок таблицы
	$yAxis_Title = 'Игроки'; # Текст по вертикали
	$columns = 'c_all,vechiles,businesses,farms,banned';
	
	//$columns = explode(",", $columns);
	//echo $columns[0]; # c_all
	//echo count($columns); # Выводит 5

	global $CONNECT;
	$SQL = mysqli_query($CONNECT, "SELECT * FROM `$table`");
	
    $data = array();
	$data2 = array();
    while($Row = mysqli_fetch_array($SQL)) {
		$data[] = '[Date.UTC('.date('Y, n, j', strtotime($Row['datetime'])).'), '.$Row['field1'].']';
		$data2[] = '[Date.UTC('.date('Y, n, j', strtotime($Row['datetime'])).'), '.$Row['field2'].']';
	}
	
	$series = [
		[
			'name' => 'Подключения',
			'data' => join($data, ',')
		],
		[
			'name' => 'Онлайн',
			'data' => join($data2, ',')
		]
	];
	$series = str_replace('"', '', json_encode($series, JSON_UNESCAPED_UNICODE)).''; # Извращение 1
	$series = str_replace('name:', 'name:"', $series).''; # Извращение 2
	$series = 'series: '.str_replace(',data', '",data', $series).''; # Извращение 3
	
	require_once('graph_model.php');
}*/