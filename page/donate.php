<?PHP
	include('modules/head.php'); 
	include('modules/header.php');
?>
	<div class="container">
		<div class="col-md-12 post">
			<h1>Донат</h1>
			<center>
				<h3><b>ПОПОЛНЕНИЕ ИГРОВОГО СЧЁТА</b></h3>
				<div class="doninf">
					<div>
						<div class="ndbox">
							<center>
							<form action="/don" method="GET">
                                <select name="type_pay">
                                    <option value="1">QIWI</option>
                                    <option value="2">Другое</option>
                                </select>
								<input type="name" name="account" placeholder="Напишите Ваш игровой никнейм" autocomplete="off" required>
								<input type="email" name="customerEmail" placeholder="Напишите Ваш E-Mail" autocomplete="off" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
								<input type="sum" name="sum" placeholder="Введите сумму пополнения" autocomplete="off" required>
								<input value="Оплатить" type="submit">
							</form>
							<?php if($_SESSION['USER_PROMOCODE'])
								echo'<span>Вы используете промокод: <b style="color:green;">'.$_SESSION['USER_PROMOCODE'].'</b></span>';?>
							</center>
						</div>
						<div class="infr">
							<center>
							<a href="#startpack" class="button button-green">Начальные паки</a>
							<a href="#vipstatus" class="button button-green">Vip-привелегии</a>
							</center>
						</div>
					</div>
				</div>
				<!-- Start Modal -->
				<a href="#x" class="overlay" id="startpack"></a>
				<div class="popup">
					<h3>НАЧАЛЬНЫЕ ПАКИ</h3><br>
					<table class="dontable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th></th>
								<th>Стартовый</th>
								<th>Профессиональный</th>
								<th>Гетто тащер</th>
								<th>Авторитет</th>
								<th>Босс</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Стоимость на 14 дней</b></td>
								<td style="color:green;">150 рублей</td>
								<td style="color:green;">299 рублей</td>
								<td style="color:green;">399 рублей</td>
								<td style="color:green;">499 рублей</td>
								<td style="color:green;">799 рублей</td>
							</tr>
							<tr>
								<td style="color:#d72566;"><b>Кэшбек от стоимости</b></td>
								<td style="color:#d72566;">5%</td>
								<td style="color:#d72566;">10%</td>
								<td style="color:#d72566;">5%</td>
								<td style="color:#d72566;">10%</td>
								<td style="color:#d72566;">15%</td>
							</tr>
							<tr>
								<td><b>Вирты при покупке</b></td>
								<td>$50 000</td><td>$100 000</td><td>$250 000</td><td>$300 000</td><td>$1 000 000</td>
							</tr>
							<tr>
								<td><b>Опыт в час</b></td>
								<td>x2</td><td>x2</td><td>x4</td><td>x3</td><td>x4</td>
							</tr>
							<tr>
								<td><b>Процент к зарплате на работе</b></td>
								<td>+5%</td><td>+10%</td><td>+10%</td><td>+15%</td><td>+20%</td>
							</tr>
							<tr>
								<td><b>Процент к зарплате в организации</b></td>
								<td>-</td><td>+10%</td><td>+10%</td><td>+15%</td><td>+20%</td>
							</tr>
							<tr>
								<td><b>Скидка в автосалоне</b></td>
								<td>5%</td><td>10%</td><td>10%</td><td>15%</td><td>20%</td>
							</tr>
							<tr>
								<td><b>Скидка в магазине одежды</b></td>
								<td>5%</td><td>10%</td><td>10%</td><td>15%</td><td>20%</td>
							</tr>
							<tr>
								<td><b>Скидка на покупку дома</b></td>
								<td>5%</td><td>10%</td><td>-</td><td>15%</td><td>20%</td>
							</tr>
							<tr>
								<td><b>Опыт на навыки оружия</b></td>
								<td>-</td><td>x2</td><td>x4</td><td>x3</td><td>x4</td>
							</tr>
							<tr>
								<td><b>Опыт на работе таксистов</b></td>
								<td>-</td><td>x2</td><td>-</td><td>x3</td><td>x3</td>
							</tr>
							<tr>
								<td><b>Опыт на работе дальнобойщиков</b></td>
								<td>-</td><td>x2</td><td>-</td><td>x2</td><td>x3</td>
							</tr>
							<tr>
								<td><b>Опыт на работе продуктовозов</b></td>
								<td>-</td><td>x2</td><td>-</td><td>x2</td><td>x3</td>
							</tr>
							<tr>
								<td><b>Опыт на работе автоугонщиков</b></td>
								<td>-</td><td>x2</td><td>x3</td><td>x2</td><td>x3</td>
							</tr>
							<tr>
								<td><b>Уникальное предложение</b></td>
								<td>-</td><td>-</td><td>50 тыс. нарко и матов</td><td>-</td><td>-</td>
							</tr>
						</tbody>
					</table>
				</div>
				<a href="#x" class="overlay" id="vipstatus"></a>
				<div class="popup">
					<h3>VIP-ПРИВЕЛЕГИИ</h3><br>
					<table class="dontable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th></th>
								<th>BRONZE VIP</th>
								<th>SILVER VIP</th>
								<th>GOLD VIP</th>
								<th>PLATINUM VIP</th>
								<th>DIAMOND VIP</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Стоимость (Дни)</b></td>
								<td style="color:green;">499 рублей (30)</td>
								<td style="color:green;">799 рублей (60)</td>
								<td style="color:green;">999 рублей (90)</td>
								<td style="color:green;">1499 рублей (120)</td>
								<td style="color:green;">2199 рублей (365)</td>
							</tr>
							<tr>
								<td style="color:#d72566;"><b>Кэшбек от стоимости</b></td>
								<td style="color:#d72566;">5%</td>
								<td style="color:#d72566;">10%</td>
								<td style="color:#d72566;">10%</td>
								<td style="color:#d72566;">15%</td>
								<td style="color:#d72566;">20%</td>
							</tr>
							<tr>
								<td><b>Ежечастная доп. зарплата</b></td>
								<td>$5 000</td><td>$7 500</td><td>$8 500</td><td>$9 500</td><td>$10 000</td>
							</tr>
							<tr>
								<td><b>Опыт в час</b></td>
								<td>x1</td><td>x2</td><td>x2</td><td>x3</td><td>x3</td>
							</tr>
							<tr>
								<td><b>Процент к зарплате на работе</b></td>
								<td>+5%</td><td>+10%</td><td>+15%</td><td>+20%</td><td>+25%</td>
							</tr>
							<tr>
								<td><b>Процент к зарплате в организации</b></td>
								<td>+5%</td><td>+10%</td><td>+15%</td><td>+20%</td><td>+25%</td>
							</tr>
							<tr>
								<td><b>Максимальное кол-во машин</b></td>
								<td>1</td><td>2</td><td>2</td><td>3</td><td>3</td>
							</tr>
							<tr>
								<td><b>Максимальное кол-во бизнесов</b></td>
								<td>1</td><td>2</td><td>2</td><td>3</td><td>3</td>
							</tr>
							<tr>
								<td><b>Скидка в автосалоне</b></td>
								<td>5%</td><td>10%</td><td>15%</td><td>20%</td><td>25%</td>
							</tr>
							<tr>
								<td><b>Скидка в магазине одежды</b></td>
								<td>5%</td><td>10%</td><td>15%</td><td>20%</td><td>25%</td>
							</tr>
							<tr>
								<td><b>Скидка на покупку дома</b></td>
								<td>5%</td><td>10%</td><td>15%</td><td>20%</td><td>25%</td>
							</tr>
							<tr>
								<td><b>Скидка на покупку бизнеса</b></td>
								<td>5%</td><td>10%</td><td>15%</td><td>20%</td><td>25%</td>
							</tr>
							<tr>
								<td><b>Опыт на навыки оружия</b></td>
								<td>x2</td><td>x3</td><td>x3</td><td>x3</td><td>x6</td>
							</tr>
							<tr>
								<td><b>Опыт на работе таксистов</b></td>
								<td>x3</td><td>x3</td><td>x3</td><td>x3</td><td>x6</td>
							</tr>
							<tr>
								<td><b>Опыт на работе дальнобойщиков</b></td>
								<td>x3</td><td>x3</td><td>x3</td><td>x3</td><td>x6</td>
							</tr>
							<tr>
								<td><b>Опыт на работе продуктовозов</b></td>
								<td>x3</td><td>x3</td><td>x3</td><td>x3</td><td>x6</td>
							</tr>
							<tr>
								<td><b>Опыт на работе автоугонщиков</b></td>
								<td>x3</td><td>x3</td><td>x3</td><td>x3</td><td>x6</td>
							</tr>
							<tr>
						</tbody>
					</table>
				</div>
				<!-- End Modal -->
            <br><h1>Полезная информация</h1>
            <div class="ucrinf">
				<div>
					<p><strong>Что можно купить</strong></p>
					<p class="inf">
						Игровая валюта: <b>1 H-Point = 2560 вирт</b> (При X1)<br>
						Смена ника: <b>50 H-Point</b><br>
						Снятие варна: <b>100 H-Point</b><br>
                        Законопослушность (+10): <b>15 H-Point</b><br>
                        Очистить все черные списки: <b>150 H-Point</b><br>
						Анти-голод: <b>150 H-Point</b><br>
						Навыки владения оружием: <b>1 H-Point = 2%</b><br>
						Создание семьи: <b>300 H-Point</b><br>
						Уникальные аксессуары: <b>от 50 H-Point</b><br>
						SIM-карты формата 44444 и т.п.: <b>от 350 H-Point</b><br>
					</p>
					<img src="../resource/img/dinf1.png" style="margin:auto;">
				</div>
				<div>
					<p><strong>Акции</strong></p>
					<p class="inf">
						<span><b>При пополнении счета на сумму, вы получаете дополнительный % от суммы пополнения</b></span><br><br>
						- <b>5%</b> при пополнении от <b>500</b>руб.<br>
						- <b>15%</b> при пополнении от <b>1 500</b>руб.<br>
						- <b>25%</b> при пополнении от <b>2 500</b>руб.<br>
						- <b>50%</b> при пополнении от <b>15 000</b>руб.<br>
						<?php
							if($SITE['s_boost_time'] >= date('d-m-Y')){
								echo '<br><span><b>Сейчас действует игровая акция:</b></span>
								<b style="font-size:10px;vertical-align:top;">До '.$SITE['s_boost_time'].'</b>';
								if($SITE['s_boost_donate'] > 1) echo '<br><b>* X'.$SITE['s_boost_donate'].'</b> донат';
								if($SITE['s_boost_cash'] > 1) echo '<br><b>* X'.$SITE['s_boost_cash'].'</b> конвертация валюты';
							}
						?>
						<br><br><b>Курс валюты:</b> 1 H-Point - 1 рубль.
					</p>
					<img src="../resource/img/dinf2.png" style="margin:auto;">
				</div>
			</div>
			</center>
			<br>
			<br>
		</div>
	</div>
<?PHP include('modules/footer.php'); ?>
