<?PHP 
	include('modules/head.php');
    include('modules/header.php');
?>
	<div class="container pkto">
		<div class="col-md-12 post">
			<div class="wow fadeInDown" data-wow-offset="100">
                <h1>Карта штата</h1>
                    <!--
                    <button onclick="myFunction()">Click</button>
                    <div id="myDIV">TEST TEX
                    </div>
                    -->
                    <script src="https://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU" type="text/javascript"></script>
                    <script>
                    var houseList = new Array();
                    <?PHP echo $SITE['s_statemap_cache']; ?>
                    </script>
                    <div id="map" class="map_wr" style="margin-top:30px; width:100%; height:768px"></div>
                <br><br>
			</div>
		</div>
	</div>
<script language="javascript" src="../resource/js/map.js?v=<?php echo $ci;?>"></script> 
<?PHP include('modules/footer.php'); ?>
<script>
function myFunction() {
var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>