	<div class="container">
		<div class="col-md-12 post">
			<center><h1>
			<?PHP 
				if($_SESSION['ACTION_MESSAGE']) 
				{
					echo $_SESSION['ACTION_MESSAGE'];
					$_SESSION['ACTION_MESSAGE'] = 0;
				}
			?>
			</h1> <a href="/ucp">Вернуться в UCP</a></center>
		</div>
	</div>