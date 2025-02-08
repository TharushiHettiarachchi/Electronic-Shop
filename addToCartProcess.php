<?php
session_start();
if (isset($_SESSION["u"])) {
    $user = $_SESSION["u"];
    $qty = $_POST["qty"];
    $pid = $_POST["pid"];

    include "connection.php";

    if(empty($qty)){
        echo("Please add a Qunatity");
        
    }else{
        $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $pid . "'");

        $product_num = $product_rs->num_rows;
      
        if ($product_num == 1) {
    
            $product_data = $product_rs->fetch_assoc();
            if ($product_data["qty"] >= $qty) {
                Database::iud("INSERT INTO `cart` (`product_id`,`user_email`,`qty`) VALUES('".$pid."','".$user["email"]."','".$qty."')");
                echo("Successfully added to cart");
            } else {
                echo ("Maximum stock is " . $product_data["qty"] . " Items");
            }
        } else {
            echo ("Something went wrong");
        }
    }

  
} else {
    echo ("Please Login First!");
}
