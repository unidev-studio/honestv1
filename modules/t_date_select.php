<?PHP
	$CurrentDay = date("j");
	$CurrentMon = date("n");
	$CurrentYear = date("Y");
	$i = 0;
	while($i <= 31) {
		$Day[$i] = $CurrentDay - $i;
		$Year[$i] = $CurrentYear;
		if($Day[$i] <= 0) {
			$Mon[$i] = $CurrentMon - 1;
			if($Mon[$i] <= 0) {
				$Mon[$i] = 12;
				$Year[$i] -= 1;
				$Day[$i] = date("t", strtotime($Year[$i].'-'.$Mon[$i])) + $Day[$i];
			} else {
				$Year[$i] = $CurrentYear;
				$Day[$i] = date("t", strtotime($Year[$i].'-'.$Mon[$i])) + $Day[$i];
			}
		}
		else $Mon[$i] = $CurrentMon; $i++;
	}
	$i = 30;
	while($i >= 0) {
		if($DATE == date("Y-m-d", strtotime($Year[$i].'-'.$Mon[$i].'-'.$Day[$i]))) {
			if($i != 0) echo '<a class="sd_active" href="adminpanel?page='.$PAGE.'&date='.$Year[$i].'-'.$Mon[$i].'-'.$Day[$i].'">'.rus_date("D", strtotime($Year[$i].'-'.$Mon[$i].'-'.$Day[$i])).' '.$Day[$i].'.'.date("m", strtotime($Year[$i].'-'.$Mon[$i])).'</a>';
			else echo '<a class="sd_active" href="adminpanel?page='.$PAGE.'&date='.$Year[$i].'-'.$Mon[$i].'-'.$Day[$i].'">'.rus_date("D", strtotime($Year[$i].'-'.$Mon[$i].'-'.$Day[$i])).' '.$Day[$i].'.'.date("m", strtotime($Year[$i].'-'.$Mon[$i])).' (Сегодня)</a>';
		} else {
			if($i != 0) echo '<a href="adminpanel?page='.$PAGE.'&date='.$Year[$i].'-'.$Mon[$i].'-'.$Day[$i].'">'.rus_date("D", strtotime($Year[$i].'-'.$Mon[$i].'-'.$Day[$i])).' '.$Day[$i].'.'.date("m", strtotime($Year[$i].'-'.$Mon[$i])).'</a>';
			else echo '<a href="adminpanel?page='.$PAGE.'&date='.$Year[$i].'-'.$Mon[$i].'-'.$Day[$i].'">'.rus_date("D", strtotime($Year[$i].'-'.$Mon[$i].'-'.$Day[$i])).' '.$Day[$i].'.'.date("m", strtotime($Year[$i].'-'.$Mon[$i])).' (Сегодня)</a>';
		} $i--;
	}
?>