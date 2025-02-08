<?php
session_start();
$product = $_GET["id"];
$_SESSION["p"] = $product;


?>