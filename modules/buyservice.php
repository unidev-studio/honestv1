<?PHP
if(isset($_GET['service'])) $SERVICE = $_GET['service'];
if(isset($_GET['nickname'])) $NICKNAME = $_GET['nickname'];
$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `u_donate` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
$BALANCE = $Row['u_donate'];
switch($SERVICE)
{
	case 0:
	{
		if($BALANCE < 50) echo json_encode(array('status' => 0, 'text' => 'У Вас недостаточно средств!'));
		else
		{
			if(preg_match('/[A-Z]{1}[a-z]{2,9}[_][A-Z]{1}[a-z]{2,9}+/', $NICKNAME) == false) echo json_encode(array('status' => 0, 'text' => 'Неверный Nick Name!<br>Пример: Carl_Johnson'));
			else
			{
				if(GetUserOnlineStatus()) echo json_encode(array('status' => 0, 'text' => 'Сначала выйдите с сервера!'));
				else
				{
					$BALANCE -= 50;
					mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '$BALANCE', `pChangeName` = '$NICKNAME' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
					echo json_encode(array('status' => 1, 'text' => 'Вы успешно купили смену Nick Name на '.$NICKNAME.'!<br>Зайдите на сервер и введите команду "/setchangename" чтобы сменить Nick Name'));
				}
			}
		}
		break;
	}
	case 1:
	{
		if($BALANCE < 200) echo json_encode(array('status' => 0, 'text' => 'У Вас недостаточно средств!'));
		else
		{
			if(GetUserOnlineStatus()) echo json_encode(array('status' => 0, 'text' => 'Сначала выйдите с сервера!'));
			else
			{
				$BALANCE -= 200;
				mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '$BALANCE', `pWarns` = '0' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
				echo json_encode(array('status' => 1, 'text' => 'Вы успешно сняли Warn!'));
			}
		}
		break;
	}
}
?>