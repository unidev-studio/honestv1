<?PHP
if(isset($_GET['page'])) $PAGE = $_GET['page'];
else $PAGE = '0';
?>
<?PHP
	include('modules/head.php');
	include('modules/header.php');
	$lock = 1;
	if($lock != 1) include('page/ucp_login.php');
	else if($PAGE) {
		switch($PAGE) {
			case '0': { include('page/monitoring/mt_all.php'); break; }
			case 'fraction': { include('page/monitoring/mt_fraction.php'); break; }
			case 'job': { include('page/monitoring/mt_job.php'); break; }
			case 'top': { include('page/monitoring/mt_top.php'); break; }
			default: { include('page/monitoring/mt_all.php'); break; }
		}
	}
	else if(!$PAGE) include('page/monitoring/mt_all.php');
	include('modules/footer.php');
?>