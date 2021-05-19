<?php
  /*if(($_SESSION[USER_LOGIN] != "Maximiliano_Mersetti") &&
    ($_SESSION[USER_LOGIN] != "Mickey_Waerd") &&
    ($_SESSION[USER_LOGIN] != "Don_Claus")){
    header("Location: https://honest-rp.su/ucp?page=profile");
  }*/
?>
<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
				<br>
				<?PHP
					$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
					if($Row['activate_mail'] == 1){ $pMailText = '<span style="color:green;font-weight:bold;">Y |</span> У вас подтвержден E-Mail.'; $pMail = 33; }
					else{ $pMailText = '<span style="color:#dd3333;font-weight:bold;">X |</span> У вас <b>НЕ</b> подтвержден E-Mail!'; $pMail = 0; }
					if($Row['Google'] == 1){ $pGoogleText = '<span style="color:green;font-weight:bold;">Y |</span> У вас подтвержден Google.Auth.'; $pGoogle = 33; }
					else{ $pGoogleText = '<span style="color:#dd3333;font-weight:bold;">X |</span> У вас <b>НЕ</b> подтвержден Google.Auth!'; $pGoogle = 0; }
					if($Row['CheckIP'] == 1){ $pIpText = '<span style="color:green;font-weight:bold;">Y |</span> У вас подтверждена привязка по IP.'; $pIp = 33; }
					else{ $pIpText = '<span style="color:#dd3333;font-weight:bold;">X |</span> У вас <b>НЕ</b> подтверждена привязка по IP!'; $pIp = 0; }
					$pBar = 0; $pBar = $pBar + $pMail + $pGoogle + $pIp;
					// all = 180 percent
					if($pBar == 33){ $pBar = 30; $pbInf = 60; }
					else if($pBar == 66){ $pBar = 65; $pbInf = 120; }
					else if($pBar >= 99){ $pBar = 100; $pbInf = 180; }
				?>
				<table style="text-align: left; width: 100%; height: auto;" border="0">
					<tbody>
						<tr>
							<td width="80%">
								<center>
									<div class="ageninf">
									<div>
										<p><strong>Защита аккаунта</strong></p>
										<p class="prinf"><br>
											<?PHP echo ''.$pMailText.'<br>'.$pGoogleText.'<br>'.$pIpText.''; ?>
										</p>
										<div class="prinfr">
											<b>Аккаунт защищен на <?php echo ''.$pBar.''; ?>%</b><br>
											<div class="circle-out"><div class="progress"></div>
											<div class="circle-in" onmouseover="increaseProgress()" style="background-image:url(../resource/img/protection.png?v=2);background-repeat:no-repeat;background-size:cover;">
											</div></div>
										</div>
									</div>
									</div>
								</center>
							</td>
							<?PHP UCP_MENU();?>
						</tr>
					</tbody>
				</table>
				<?PHP
				// Регулирование защиты аккаунта
					if($_SESSION['ACTION_MESSAGE']){
						echo '<center><h4>'.$_SESSION['ACTION_MESSAGE'].'</h4></center>';
						$_SESSION['ACTION_MESSAGE'] = 0;
					}
					echo '<br><div class="ucrinf">
						<div style="background-image:url(../resource/img/email.png?v=6);background-repeat:no-repeat;background-position:center;">
							<p><strong>Смена E-Mail</strong></p>
							<p class="inf"><center>';
								$EMAIL = $Row['pEmail']; $ACTIVE = $Row['activate_mail'];
								if($ACTIVE) echo '<span style="color:green;"><b>Активирован</b></span>';
								else echo '<form method="POST" action="/ucp?action=return_send" class="gprotect">
								<input name="return_send" value="Повторно выслать письмо подтверждения" type="submit"></form>';
								echo '<div class="changepass_box">
									<form method="POST" action="/ucp">
										<input type="email" name="email" placeholder="Новый E-Mail" value="'.$EMAIL.'" required>
										<input name="changemail" value="Изменить" type="submit">
									</form>
								</div>
							</center></p>
						</div>
						<div style="background-image:url(../resource/img/password.png?v=1);background-repeat:no-repeat;background-position:center;">
							<p><strong>Смена пароля</strong></p>
							<p class="inf"><center>
								<div class="changepass_box">
									<form method="POST" action="/ucp">
										<input name="old_password" placeholder="Текущий пароль" type="password" maxlength="24"  pattern="[A-Za-z-0-9]{5,24}" title="Не менее 5 и неболее 24 латынских символов или цифр." required>
										<input name="new_password" placeholder="Новый пароль" type="password" maxlength="24"  pattern="[A-Za-z-0-9]{5,24}" title="Не менее 5 и неболее 24 латынских символов или цифр." required>
										<input name="repeat_password" placeholder="Повторить пароль" type="password" maxlength="24"  pattern="[A-Za-z-0-9]{5,24}" title="Не менее 5 и неболее 24 латынских символов или цифр." required>
										<input name="changepass" value="Сменить" type="submit">
									</form>
								</div>
							</center></p>
						</div>
						<div style="background-image:url(../resource/img/gauth.png?v=1);background-repeat:no-repeat;background-position:center;">
							<p><strong>Настройки Google.Auth</strong></p>
							<div class="gainf"><center>
								<b>Нажмите "Генерировать" чтобы сгенерировать секретный код</b><br>
								<form method="POST" action="/ucp" class="gprotect">
									<input type="text" style="text-align:center;" value="'.$Row['GooglePassword'].'" disabled></input>
									<input name="generate_google" type="submit" value="Генерировать"></input>
								</form><br>';
								if(!$Row['Google'] && $Row['GooglePassword'] != 'None') echo '
								<br><b>Введите полученный код из приложения, чтобы активировать защиту</b><br>
								<form method="POST" action="/ucp" class="gprotect">
									<input name="code_google" type="text"></input>
									<input name="active_google" type="submit" value="Активировать"></input>
								</form>';
								else if($Row['Google'] && $Row['GooglePassword'] != 'None') echo '
								<br><b>Защита по Google Аутентификатору <span style="color:green">включена</span>!</b><br>
								<b>Нажмите <a href="?page=offgoogle">здесь</a> чтобы отключить</b>';
							echo '</center></div>
							<div class="gainfr"><center>';
								if($Row['GooglePassword'] != 'None'){
									$url =  sprintf("otpauth://totp/%s@honest-rp.su?secret=%s", $_SESSION['USER_LOGIN'], $Row['GooglePassword']);
									$encoder = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=';
									$QR_IMG = sprintf( "%s%s",$encoder, urlencode($url));
									echo '<img src="'.$QR_IMG.'">';
								}
							echo '</center></div>
						</div>
						<div style="background-image:url(../resource/img/ip.png?v=1);background-repeat:no-repeat;background-position:center;">
							<p><strong>Привязка по IP</strong></p>
							<p class="inf"><center>
								<b>Только через игру!</b>
							</center></p>
						</div>
					</div>';
				?>
			<br>
			<br>
		</div>
	</div>
<script>
var progress = <?php echo''.$pbInf.'';?>;
var progressEl = document.querySelector('.progress');
var increaseProgress = function() {
progress = progress; // + 10
progressEl.style.transform = 'rotate('+progress+'deg)';
}
</script>