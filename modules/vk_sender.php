<?php
if(isset($_GET['m']) && isset($_GET['t'])){ $vk_return = 1; $message = $_GET['m']; $user_id = $_GET['t']; }
else if(isset($_POST['m']) && isset($_POST['t'])){ $vk_return = 1; $message = $_POST['m']; $user_id = $_POST['t']; }
else{ $vk_return = 0; }
if($vk_return == 1){
    echo 1;
} else include('page/404.php');