	<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
			<center>
				<h4>У данного аккаунта стоит защита по Google Аутентификатору</h4>
				<h4>Для продолжения введите 6-ти значный код</h4>
				<div class="login_box">
					<form method="POST" action="/ucp">
						<input name="code" placeholder="6-ти значный код" type="password" maxlength="6"  pattern="[0-9]{1,6}" title="Не более 6 цифр." required>
						<a href="?page=logout"><label style="float:left;width:32%;margin:5px 0 0 6px;">Выйти</label></a>
						<input name="enter_code" value="Войти" type="submit" style="float:right;margin-right:-4px;width:65%;">
					</form>
				</div>
				<?PHP if($Message && !$SUCCES_ENTER) echo '<p style="color: #ff0000;">'.$Message.'</p>'; ?>
			</center>
			<br>
			<br>
		</div>
	</div>