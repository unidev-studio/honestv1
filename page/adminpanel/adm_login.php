	<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
			<center>
				<h3>Пожалуйста авторизуйтесь</h3>
				<div class="login_box">
					<form method="POST" action="/adminpanel">
						<input name="password" placeholder="Пароль" type="password" maxlength="24" title="Не менее 3 и неболее 24 латынских символов или цифр." required>
						<input name="enter" value="Войти" type="submit">
					</form>
				</div>
				<?PHP if($Message && !$SUCCES_ENTER) echo '<p style="color: #ff0000;">'.$Message.'</p>'; ?>
			</center>
			<br>
			<br>
		</div>
	</div>