<?PHP
$Row = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `fID` FROM `s_fraction` WHERE `fLeader` = '$_SESSION[USER_LOGIN]'"));
if(!($Row[0] >= 1)) header("Location: ?page=0");
?>
<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
				<?PHP
					$fRow = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `s_fraction` WHERE `fLeader` = '$_SESSION[USER_LOGIN]'"));
					if($fRow['fAssistant'] == 'None') $fRow['fAssistant'] = 'Отсутствует';
					if($fRow['fFreeze']) $fRow['fFreeze'] = 'Заморожена'; else $fRow['fFreeze'] = 'Функционирует';
					if($fRow['fAntiTK']) $fRow['fAntiTK'] = 'Включено'; else $fRow['fAntiTK'] = 'Отключено';
					if($fRow['fMessage'] == 'None') $fRow['fMessage'] = 'Не указано';
					$FRACZP = explode(",", $fRow['fSalary']);
					//
					switch($fRow['fID']) {
						case 1: $MAXRANG = 13; break;
						case 2: $MAXRANG = 9; break;
						case 3: $MAXRANG = 14; break;
						case 4: $MAXRANG = 9; break;
						case 5: $MAXRANG = 9; break;
						case 6: $MAXRANG = 9; break;
						case 7: $MAXRANG = 5; break;
						case 8: $MAXRANG = 0; break;
						case 9: $MAXRANG = 8; break;
						case 10: $MAXRANG = 13; break;
						case 11: $MAXRANG = 9; break;
						case 12: $MAXRANG = 9; break;
						case 13: $MAXRANG = 9; break;
						case 14: $MAXRANG = 9; break;
						case 15: $MAXRANG = 9; break;
						case 16: $MAXRANG = 8; break;
						case 17: $MAXRANG = 9; break;
						case 18: $MAXRANG = 9; break;
						case 19: $MAXRANG = 14; break;
						case 20: $MAXRANG = 8; break;
						case 21: $MAXRANG = 13; break;
						case 22: $MAXRANG = 9; break;
						case 23: $MAXRANG = 9; break;
						case 24: $MAXRANG = 8; break;
						case 25: $MAXRANG = 8; break;
						case 26: $MAXRANG = 8; break;
					}
					//
                    $rgrang = $_POST['rgrang']; $rgname = $_POST['rgname'];
					$FRINTXT1 = '<center><h4 style="color: #ff0000;">Указанный игрок не состоит в вашей организации!</h4></center>';
					$FRINTXT2 = '<center><h4 style="color: #ff0000;">Вы не можете назначить человека на указанный ранг!</h4></center>';
					$FRINTXT3 = '<center><h4 style="color: #628e38;">Вы успешно уволили '.$rgname.'!</h4></center>';
					$FRINTXT4 = '<center><h4 style="color: #628e38;">Вы успешно назначили '.$rgname.' на '.$rgrang.' ранг!</h4></center>';
                    if (isset($_POST['rgbtn']) && isset($_POST['rgrang']) && isset($_POST['rgname'])){
						$CHPLINFRAC = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `s_users` WHERE `Name`='$rgname'"));
						if($CHPLINFRAC['pMember'] != $fRow['fID']) echo ''.$FRINTXT1.'';
						else if($rgrang >= $MAXRANG) echo ''.$FRINTXT2.'';
						else {
							$SQL = mysqli_query($CONNECT, "UPDATE `s_users` SET `pRank`='$rgrang' WHERE `Name`='$rgname'");
							if($rgrang == 0) echo ''.$FRINTXT3.''; else echo ''.$FRINTXT4.'';
						}
                    }
					echo '<br><table style="text-align: left; width: 100%; height: auto;" border="0">
					<tbody>
                        <tr>
                            <td width="80%">
                                <div class="ageninf">
                                <div>
                                    <p><strong>Управление организацией</strong></p>
                                    <p class="inf">
										Название организации: <b>'.$fRow['fName'].'</b><br>
										Первый заместитель: <b>'.$fRow['fAssistant'].'</b><br><br>
									</p>
									<p class="inf" style="font-size:14px;">
										Состояние фракции: <b>'.$fRow['fFreeze'].'</b><br>
										Анти-ТК: <b>'.$fRow['fAntiTK'].'</b><br>
										Сообщение при входе: <b>'.$fRow['fMessage'].'</b><br>
									</p>
									<img src="../resource/img/fraction.png" style="width:112px;">
                                </div>
								</div>
                            </td>';
                            UCP_MENU();
                            echo '</tr>
					  </tbody>
					</table>';
					//
					echo '<br><div class="asetbltwo">
                        <div style="padding:22px 0 0;background-image:url(../resource/img/career.png?v=3);background-repeat:no-repeat;background-position:center;">
							<p><strong>Повысить/Понизить сотрудника</strong></p>
							<center>Укажите значение «0» чтобы уволить.</center><br>
                            <p class="inf">
								<center>
                                <form method="POST" class="ui-form">
                                    <div class="form-row">
										<input type="text" name="rgname" required="" autocomplete="off" maxlength="24" pattern="[A-Za-z]{2,24}_[A-Za-z]{2,24}" title="Введите никнейм по формату Имя_Фамилия." required><label for="asname">Никнейм</label><br>
										<input type="text" name="rgrang" required="" autocomplete="off" maxlength="2" pattern="[0-9]{1,2}" required><label for="asname">Ранг</label>
                                    </div>
                                    <p><input name="rgbtn" type="submit" value="Назначить"></p>
                                </form>
                                </center>
                            </p>
                        </div>
                        <div style="padding:22px 0 0;">
							<p><strong>Ранги и зарплаты</strong></p>
                            <p class="inf">
								<center>
									<table class="table table-bordered" width="100%" id="dataTableS" cellspacing="0" style="width:90%;font-size:12px;">
										<tbody>';
											$COUNT = 0;
											while($COUNT <= $MAXRANG) {
												echo '
												<tr><td>'.$fRow['rank_'.$COUNT.''].'</td>
												<td>'.$FRACZP[$COUNT].'</td></tr>';
												$COUNT++;
											}
										echo '</tbody>
									</table>
                                </center>
                            </p>
						</div>
					</div>';
					echo '<br><div class="asetbl">
						<div>
							<p><strong>Список сотрудников</strong></p>
                            <p class="inf">
								<center>
								<div id="load_page"><center><h4>Загрузка таблицы...</h4></center></div>
                            	<div id="content_log" style="display:none;width:95%;">
									<table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
										<thead>
											<tr>
												<th>Никнейм</th>
												<th>Уровень</th>
												<th>Ранг</th>
												<th>Последний вход</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Никнейм</th>
												<th>Уровень</th>
												<th>Ранг</th>
												<th>Последний вход</th>
											</tr>
										</tfoot>
										<tbody>';
											$SQL = mysqli_query($CONNECT, "SELECT * FROM `s_users` WHERE `pMember`='$fRow[fID]'");
											if(mysqli_num_rows($SQL) > 0) {
												while($RFrac = mysqli_fetch_array($SQL)) {
													echo '
													<tr><td>'.$RFrac['Name'].'</td>
													<td>'.$RFrac['pLevel'].'</td>
													<td>'.$RFrac['pRank'].'</td>
													<td>'.$RFrac['pGetonDate'].'</td></tr>';
												}
											}
										echo '</tbody>
									</table>
								</div>
                                </center>
                            </p>
						</div>
					</div>';
				?>
			<br>
			<br>
		</div>
	</div>
<script>
$(document).ready(function() {
	$('#dataTable').DataTable();
	$('#load_page').hide();
	$('#content_log').show();
});
</script>