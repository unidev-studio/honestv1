	<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
			<center>
				<h3>Пожалуйста авторизуйтесь</h3>
				<div class="login_box">
					<form method="POST" action="/ucp">
						<input name="login" placeholder="Логин" type="text" maxlength="32" title="Не менее 3 и неболее 32 латынских символов или цифр." required>
						<input name="password" placeholder="Пароль" type="password" maxlength="48" title="Не менее 5 и неболее 48 латынских символов или цифр." required>
						<div style="transform:scale(0.825);transform-origin:0 0;margin-left:5px;" class="g-recaptcha" data-sitekey="6LfQKs4ZAAAAAKc2gfV1y-4g18dEHQrTk-iHQHTf"></div>
						<input name="enter" value="Войти" type="submit">
					</form>
				</div>
				<p>Забыли пароль? <a href="/ucp?action=recovery">Восстановить доступ</a></p>
				<?PHP if($Message && !$SUCCES_ENTER) echo '<p style="color: #ff0000;">'.$Message.'</p>'; ?>
			</center>
			<br>
			<br>
		</div>
	</div>