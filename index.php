<?php
header('Content-Type: text/html; charset=utf-8');
require('router/main.php');

$start = new routing();
$start->router();
?>