<?php
  /*if(($_SESSION['USER_LOGIN'] != 'Maximiliano_Mersetti') &&
    ($_SESSION['USER_LOGIN'] != 'Mickey_Waerd') &&
    ($_SESSION['USER_LOGIN'] != 'Stephen_Nill')){
    header("Location: https://honest-rp.su/ucp?page=profile");
  }*/
  if(!$_SESSION['USER_LOGIN']){ header("Location: https://honest-rp.su/ucp?page=profile"); }
  $_SESSION['ROULETTE_HASH'] = md5(''.base64_encode($_SESSION['USER_LOGIN']).base64_encode(date('dmYhi')).''); //Хеширование
?>
<link href="../resource/css/roulette.css?v=<?php echo $ci;?>" rel="stylesheet"> <!-- [!] -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="container">
	<div class="col-md-12 post">
    <div style="display:flow-root;">
    <h1 style="float:left;">Личный кабинет</h1>
    <p style="float:right;margin-top:0.8em;">*Пометка: При обновлении страницы выпавший предмет генерируется по новой.</p>
    </div><br>
    <div style="display:none;"><span id="checklogin"></span><span id="boostspin"></span></div>
    <h4 style="margin:-1.4em 0 0.7em 0;text-align:center;">LIVE-ПРОКРУТЫ</h4>
    <div id="live_item_box"></div>
    <table width="100%" style="text-align: left; height: auto;" border="0">
			<tbody>
				<tr>
					<td width="80%">
							<div class="roulette_box">
                <div id="main">
                <div id="win"></div>
                <div id="freespin">Кол-во бесплатных прокрутов: <span id="freespins"></span></div>
								<ul id="boxes">
                  <?PHP
                    $i = 0;
                    while($i < 9){
                      $rtems = array("exp", "money", "licenses", "licenses", "skills", "skills", "freespin", "cashback", // Список предметов
                      "exp", "landstalker", "dune", "stretch", "romero", "washington", "hotknife", "euros", "slamvan", "camper", "fcr900", "quad", "journey", //
                      "exp", "sk46", "sk49", "sk292", "sk293", "sk297", //
                      "exp", "bat", "boombox", "cue", //
                      "exp", "vip", "boost"); //
                      $ritem = array_rand($rtems, 1);
                      switch($rtems[$ritem]){
                        case "exp":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 40){ $ritem = 'exp'; $imgs = '1'; } // 40%
                          else $imgs = 0; break;
                        case "money":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 20){ $ritem = 'money'; $imgs = '2'; } // 20%
                          else $imgs = 0; break;
                        case "licenses":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 35){ $ritem = 'licenses'; $imgs = '3'; } // 35%
                          else $imgs = 0; break;
                        case "skills":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 35){ $ritem = 'skills'; $imgs = '4'; } // 35%
                          else $imgs = 0; break;
                        case "freespin":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'freespin'; $imgs = '5'; } // 10%
                          else $imgs = 0; break;
                        case "cashback":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'cashback'; $imgs = '6'; } // 10%
                          else $imgs = 0; break;
                        // ТРАНСПОРТ //
                        case "landstalker":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'landstalker'; $imgs = '7'; } // 5%
                          else $imgs = 0; break;
                        case "dune":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'dune'; $imgs = '8'; } // 5%
                          else $imgs = 0; break;
                        case "stretch":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'stretch'; $imgs = '9'; } // 5%
                          else $imgs = 0; break;
                        case "romero":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'romero'; $imgs = '10'; } // 5%
                          else $imgs = 0; break;
                        case "washington":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'washington'; $imgs = '11'; } // 5%
                          else $imgs = 0; break;
                        case "hotknife":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'hotknife'; $imgs = '12'; } // 5%
                          else $imgs = 0; break;
                        case "euros":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'euros'; $imgs = '13'; } // 5%
                          else $imgs = 0; break;
                        case "slamvan":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'slamvan'; $imgs = '14'; } // 5%
                          else $imgs = 0; break;
                        case "camper":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'camper'; $imgs = '15'; } // 5%
                          else $imgs = 0; break;
                        case "fcr900":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'fcr900'; $imgs = '16'; } // 5%
                          else $imgs = 0; break;
                        case "quad":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'quad'; $imgs = '17'; } // 5%
                          else $imgs = 0; break;
                        case "journey":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'journey'; $imgs = '18'; } // 5%
                          else $imgs = 0; break;
                        // СКИНЫ //
                        case "sk46":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'sk46'; $imgs = '19'; } // 10%
                          else $imgs = 0; break;
                        case "sk49":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'sk49'; $imgs = '20'; } // 10%
                          else $imgs = 0; break;
                        case "sk292":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'sk292'; $imgs = '21'; } // 10%
                          else $imgs = 0; break;
                        case "sk293":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'sk293'; $imgs = '22'; } // 10%
                          else $imgs = 0; break;
                        case "sk297":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 10){ $ritem = 'sk297'; $imgs = '23'; } // 10%
                          else $imgs = 0; break;
                        // АКСЕССУАРЫ //
                        case "bat":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'bat'; $imgs = '24'; } // 5%
                          else $imgs = 0; break;
                        case "boombox":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'boombox'; $imgs = '25'; } // 5%
                          else $imgs = 0; break;
                        case "cue":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'cue'; $imgs = '26'; } // 5%
                          else $imgs = 0; break;
                        // ОСТАЛЬНОЕ //
                        case "vip":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'vip'; $imgs = '27'; } // 5%
                          else $imgs = 0; break;
                        case "boost":
                          $percent = 0 + mt_rand() / mt_getrandmax() * (100 - 0);
                          if($percent < 5){ $ritem = 'boost'; $imgs = '28'; } // 5%
                          else $imgs = 0; break;
                      }
                      if($imgs == 0) continue;
                      else {
                        echo '<li class="tape"><img src="../resource/img/roulette_item/'.$ritem.'.png?v='.$ci.'" name="'.$ritem.'" alt="'.$imgs.'" class="tape-img"></li>';
                        $i++;
                      }
                    }
                  ?>
                </ul>
                </div>
                <center>
                <button onclick="start()" class="mainbutt">Крутить <span id="textsp"></span></button><br>
                <a href="/ucp?page=balance"><label>Баланс <span id="balance"></span> Р</label></a>
                </center>
							</div>
					</td>
				  <?PHP UCP_MENU();?>
				</tr>
			</tbody>
		</table>
    <center>
    <div><br>
			<h1>Возможные призы</h1>
			<div class="rwin-item">
				<div class="rwin-d"><img src="../resource/img/roulette_item/exp.png?v=<?php echo $ci;?>" /><div class="rwin-text">EXP</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/money.png?v=<?php echo $ci;?>" /><div class="rwin-text">Вирты</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/licenses.png?v=<?php echo $ci;?>" /><div class="rwin-text">Лицензии</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/skills.png?v=<?php echo $ci;?>" /><div class="rwin-text">Скиллы</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/freespin.png?v=<?php echo $ci;?>" /><div class="rwin-text">Фриспин</div></div>
        <div class="rwin-d"><img src="../resource/img/roulette_item/cashback.png?v=<?php echo $ci;?>" /><div class="rwin-text">Кэшбек</div></div>
      </div>
      <div class="rwin-item">
				<div class="rwin-d"><img src="../resource/img/roulette_item/car.png?v=<?php echo $ci;?>" /><div class="rwin-text">Транспорт</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/sk49.png?v=<?php echo $ci;?>" /><div class="rwin-text">Скины</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/boombox.png?v=<?php echo $ci;?>" /><div class="rwin-text">Аксессуары</div></div>
        <div class="rwin-d"><img src="../resource/img/roulette_item/vip.png?v=<?php echo $ci;?>" /><div class="rwin-text">VIP</div></div>
				<div class="rwin-d"><img src="../resource/img/roulette_item/boost.png?v=<?php echo $ci;?>" /><div class="rwin-text">Boost-Pack</div></div>
			</div>
		</div><br>
    </center>
		<div id="item_box"></div>
		<br><br>
  </div>
</div>
<!--<div class="state"></div>-->
<?php
function start(){
  global $CONNECT;
  $_SESSION['ROULETTE_HASH'] = md5(''.base64_encode($_SESSION['USER_LOGIN']).base64_encode(date('dmYh')).'');
  $SQL = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `u_donate` FROM `".MYSQL_TABLE_USERS."` WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'"));
  $DONATE = $SQL['u_donate'];
  $DONATE -= 49;
  mysqli_query($CONNECT, "UPDATE `".MYSQL_TABLE_USERS."` SET `u_donate` = '$DONATE' WHERE `".MYSQL_FIELD_LOGIN."` = '$_SESSION[USER_LOGIN]'");
}
?>
<script language="javascript" src="../resource/js/roulette.js?v=<?php echo $ci;?>"></script>
<!-- Honest Preloader -->
<style type="text/css">
</style>
<div id="hpreloader"><div class="hpreload">Загрузка страницы..</div></div>
<script type="text/javascript">
var hpreloader = document.getElementById("hpreloader");
function fadeOutnojquery(el){
    el.style.opacity = 1;
    var interhpreloader = setInterval(function(){
        el.style.opacity = el.style.opacity - 0.05;
        if(el.style.opacity <= 0.05){
            clearInterval(interhpreloader);
            hpreloader.style.display = "none";
        }
    }, 16);
}
window.onload = function(){
    setTimeout(function(){
        fadeOutnojquery(hpreloader);
    }, 4567);
};
</script>
<!-- End Honest Preloader -->