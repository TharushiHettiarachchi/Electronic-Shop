<?php
include "connection.php";
session_start();
$user = $_SESSION["u"];
$pid = $_POST["pid"];

Database::iud("DELETE FROM `cart` WHERE `user_email` = '".$user["email"]."' AND `product_id` = '".$pid."'");
echo("Sucessfully Deleted");


?>