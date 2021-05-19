	<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
				<br>
				<table style="text-align: left; width: 100%; height: auto;" border="0">
					<tbody>
						<tr>
							<td width="100%">
								<center>
									<div class="changepass_box">
										<form method="POST" action="/ucp">
											<input name="login" type="text" placeholder="Ник/Email" maxlength="64" pattern="[A-Za-z-0-9]{6}{3,64}" title="Не менее 3 и неболее 64 латынских символов или цифр." required>
											<input name="recovery" value="Восстановить" type="submit">
										</form>
									</div>
									<?php if($_SESSION['ACTION_MESSAGE']){ echo $_SESSION['ACTION_MESSAGE']; $_SESSION['ACTION_MESSAGE'] = 0; } ?>
								</center>
							</td>
						</tr>
					</tbody>
				</table>
			<br>
			<br>
		</div>
	</div>