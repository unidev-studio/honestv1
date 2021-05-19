<?PHP 
	include('modules/head.php');
	include('modules/header.php');
?>
	<div class="container">
		<div class="col-md-12 post">
			<h1>Новости</h1>
			<?PHP
			$wall_id = "-158042965";
			$group_id = preg_replace("/-/i", "", $wall_id);
			$count = 100;
			$token = "bbb0df65bbb0df65bbb0df6555bbef859abbbb0bbb0df65e1b0639dfd3087ba0fa408e9";
			$api = file_get_contents("https://api.vk.com/api.php?oauth=1&method=wall.get&owner_id={$wall_id}&count={$count}&v=5.58&access_token={$token}");
			$wall = json_decode($api);
			$wall = $wall->response->items;
			for ($i = 0; $i < count($wall); $i++) {
				if(!$wall[$i]->text) continue;
				$new_text = preg_replace("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", '<a href="$1://$2">$1://$2</a>$3', $wall[$i]->text);
				echo '<div class="news_post"><div class="news_head"><span class="news_name">Honest Role Play | Играй в GTA SA c нами</span><div class="news_date">'.date("d.m.Y в H:i", $wall[$i]->date).'</div></div><div class="news_body">'.$new_text.'</div></div>';
			}
			?>
			<br>
			<br>
		</div>	
	</div>
<?PHP include('modules/footer.php'); ?>