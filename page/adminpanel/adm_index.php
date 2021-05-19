<div class="container">
		<div class="col-md-12 post">
			<h1>Администраторский раздел</h1>
				<?PHP 
                    $Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
					$aInf = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `s_admin` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
					$sdInf = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `sl_apanel` WHERE `sName` = '$_SESSION[USER_LOGIN]'"));
                    $aITime = intval($aInf['s_OTime'] / 60);
                    switch($aInf['level']) {
                        case 0.1: $aILvl = 'Модератор'; break;
                        case 2.5: $aILvl = 'Администратор'; break;
                        case 6: $aILvl = 'Главный Администратор'; break;
                        case 7.9: $aILvl = 'Спец. Администратор'; break;
                        case 10: $aILvl = 'Основатель'; break;
					}
                    $SKIN = explode(",", $Row['pChars']);
					echo '<br><table style="text-align: left; width: 100%; height: auto;" border="0">
					<tbody>
                        <tr>
                            <td width="80%">
                                <div class="ageninf">
                                <div>
                                    <p><strong>'.$_SESSION['USER_LOGIN'].'</strong></p>
                                    <p class="inf">
										Уровень модератора: <b>'.$aInf['level'].' ('.$aILvl.')</b><br><br>
                                        <b>Статистика за всё время</b><br>
                                        Ответов в репорт: <b>'.$aInf['s_Reports'].'</b><br>
                                        Блокировок: <b>'.$aInf['s_Bans'].'</b><br>
                                        Варнов: <b>'.$aInf['s_Warns'].'</b><br>
                                        Отыграно под админкой (за неделю): <b>'.$aITime.' минут(ы)</b><br>
                                    </p>
                                    <img src="../resource/img/skins/'.$SKIN[0].'.png" />
                                </div>
                                </div>
                            </td>';
                            APANEL_MENU();
                            echo '</tr>
					  </tbody>
					</table>';
					//
					if(($sdInf['sdlSearch'] == 1) || ($sdInf['sdPromo'] == 1) || ($sdInf['sdCfoll'] == 1)
					|| ($sdInf['sdAdmins'] == 1) || ($sdInf['sdRoot'] == 1)){
					echo '<br><div class="ucrinf">';
						if($sdInf['sdlSearch'] == 1){
							echo '<div>
								<p><strong>Поиск пользователя</strong></p>
								<p class="inf"></p><br>
								<a href="?page=usersearch">Перейти</a>
							</div>';
						}
						if($sdInf['sdAdmins'] == 1){
							echo '<div>
								<p><strong>Управление администраторами/саппортами</strong></p>
								<p class="inf"></p><br>
								<a href="?page=asetting">Перейти</a>
							</div>';
						}
						if($sdInf['sdCfoll'] == 1){
							echo '<div>
								<p><strong>Управление лидерами</strong></p>
								<p class="inf"></p><br>
								<a href="?page=cfoll">Перейти</a>
							</div>';
						}
						if($sdInf['sdPromo'] == 1){
							echo '<div>
								<p><strong>Управление промокодами</strong></p>
								<p class="inf"></p><br>
								<a href="https://media.honest-rp.su/mngpanel?page=promopanel">Перейти</a>
							</div>';
						}
						if($sdInf['sdRoot'] == 1){
							echo '<div>
								<p><strong>Управление сервером</strong></p>
								<p class="inf"></p><br>
								<a href="?page=editserver">Перейти</a>
							</div>';
						}
						echo '
					</div>';
					}
				?>
			<br>
			<br>
		</div>
	</div>