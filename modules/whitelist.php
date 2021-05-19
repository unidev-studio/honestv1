<?php
if ($_SESSION['USER_LOGIN'] != 'Nick_Name' &&
    $_SESSION['USER_LOGIN'] != 'Nick_Name' &&
    $_SESSION['USER_IP'] != '127.0.0.1') include('page/closed.php');
else include('modules/page_module.php');