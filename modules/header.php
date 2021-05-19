	<div class="container head">
		<div class="col-md-4 wow fadeInLeft" data-wow-delay="1s">
			<h3>Личный кабинет</h3><br>
			<a class="hlink hl-left" href="ucp">Перейти к UCP</a>
		</div>
		<div class="col-md-4 wow fadeInDown"><img src="../resource/img/logo.png?v=<?php echo $ci; ?>"></div>
		<div class="col-md-4 wow fadeInRight" data-wow-delay="1s">
			<h3>Играть на сервере</h3><br>
			<a class="hlink hl-right" href="samp://s1.honest-rp.su:7777">Подключиться к серверу</a><br><br><br>
		</div>
	</div>

	<div class="container nav wow fadeInDown" data-wow-delay="1s">
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 1) echo '_active'; ?>" href="/">Главная</a>
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 2) echo '_active'; ?>" href="news">Новости</a>
		<a class="page" href="https://forum.honest-rp.su/">Форум</a>
		<a class="page" href="https://media.honest-rp.su/">Сотрудничество</a>
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 3) echo '_active'; ?>" href="donate">Донат</a>
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 4) echo '_active'; ?>" href="monitoring">Мониторинг</a>
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 15) echo '_active'; ?>" href="statemap">Карта</a>
		<a class="page<?PHP if ($_SESSION['CURRENT_PAGE'] == 5) echo '_active'; ?>" href="ucp">Личный кабинет</a>
	</div>