<?php
$type = $_GET['type_pay'];
$account = $_GET["account"];
$email = $_GET["customerEmail"];
$sum = $_GET["sum"];
header("Location: https://honest-rp.su/uindex?account=".$account."&customerEmail=".$email."&sum=".$sum);
