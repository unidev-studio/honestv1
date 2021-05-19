<?php
if(isset($_GET['m']) && isset($_GET['t'])){ $tg_return = 1; $message = $_GET['m']; $user_id = $_GET['t']; }
else if(isset($_POST['m']) && isset($_POST['t'])){ $tg_return = 1; $message = $_POST['m']; $user_id = $_POST['t']; }
else{ $tg_return = 0; }
if($tg_return == 1){
    echo json_encode('Error', JSON_UNESCAPED_UNICODE);
} else include('page/404.php');