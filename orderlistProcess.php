<?php
include "connection.php";
session_start();
$user = $_SESSION["u"];

$order_id = substr(uniqid(), -6);
$date = date("Y-m-d H:i:s");
Database::iud("INSERT INTO `orders`(`order_id`,`date_time`,`status`,`user_email`,`amount`) VALUES('" . $order_id . "','" . $date . "','1','" . $user["email"] . "','0')");

$order_rs = Database::search("SELECT * FROM `orders` WHERE `order_id` = '" . $order_id . "'");
$order_data = $order_rs->fetch_assoc();

$cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $user["email"] . "'");
$cart_num = $cart_rs->num_rows;
$amount = 0;
for ($i = 0; $i < $cart_num; $i++) {
    $cart_data = $cart_rs->fetch_assoc();

    Database::iud("INSERT INTO `order_items` (`orders_id`,`product_id`,`qty`) VALUES('" . $order_data["id"] . "','" . $cart_data["product_id"] . "','" . $cart_data["qty"] . "')");

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
    $product_data = $product_rs->fetch_assoc();
$new_qty = $product_data["qty"] - $cart_data["qty"];
    $product_price = round(floatval($product_data["price"]), 2);
    $amount1 = intval($cart_data["qty"]) * $product_price;
    $amount2 = round($amount1, 2);
    $amount = $amount + $amount2;

    Database::iud("UPDATE `product` SET `qty` = '".$new_qty."' WHERE `id` = '".$product_data["id"]."'");
    

    
}

Database::iud("UPDATE `orders` SET `amount` = '".$amount."' WHERE `id` = '".$order_data["id"]."'");

echo("Order Successfully Placed");

Database::iud("DELETE FROM `cart` WHERE `user_email` = '".$user["email"]."'");
?>
