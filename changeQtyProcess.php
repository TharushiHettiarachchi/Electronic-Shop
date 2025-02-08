<?php
session_start();
include "connection.php";
if (isset($_SESSION["u"])) {
    $pid = $_POST["pid"];
    $qty = $_POST["qty"];
    $user = $_SESSION["u"];



    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $pid . "'");

    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {

        $product_data = $product_rs->fetch_assoc();
        if ($product_data["qty"] >= $qty) {
            Database::iud("UPDATE `cart` SET `qty` = '" . $qty . "' WHERE `user_email` = '" . $user["email"] . "' AND `product_id` = '" . $pid . "'");
?>

            <div class="sumTitle" style="margin-bottom: 30px; margin-top: 30px;">Order List</div>
            <div class="orderTableDiv">
                <table class="orderTable">
                    <thead class="tableHead">
                        <td>#</td>
                        <td>Product</td>
                        <td>Qty</td>
                        <td>Amount</td>
                    </thead>
                    <tbody>
                        <?php
                        $cart_rs = Database::search("SELECT  cart.qty AS cart_qty, product.qty AS product_qty,  product.price AS product_price ,  product.product_name AS product_name FROM cart  INNER JOIN  product  ON    product.id = cart.product_id   WHERE  cart.user_email = '" . $user["email"] . "' ");
                        $cart_num = $cart_rs->num_rows;
                        $subTotal = 0;
                        for ($i = 0; $i < $cart_num; $i++) {
                            $cart_data = $cart_rs->fetch_assoc();
                        ?>
                            <tr>
                                <td style="text-align: center; padding-left: 10px; padding-right: 10px;"><?php echo ($i + 1); ?></td>
                                <td><?php echo htmlspecialchars($cart_data["product_name"]); ?></td>
                                <td style="text-align: center; padding-left: 10px; padding-right: 10px;"><?php echo intval($cart_data["cart_qty"]); ?></td>
                                <?php
                                $product_price = round(floatval($cart_data["product_price"]), 2);
                                $amount1 = intval($cart_data["cart_qty"]) * $product_price;
                                $amount = round($amount1, 2);
                                $subTotal = $subTotal + $amount;
                                ?>
                                <td style="text-align: end; padding-left: 10px; padding-right: 10px;">
                                    <?php echo number_format($amount, 2, '.', ''); ?>
                                </td>
                            </tr>

                        <?php
                        }

                        ?>
                    </tbody>
                </table>


            </div>

            <div class="totalPanel">
                <div class="totalDesc subTotal">Sub Total</div>
                <div class="totalAmount subTotal"><?php echo number_format($subTotal, 2, '.', ''); ?></div>
            </div>
            <button class="button2" onclick="placeOrder();">Place Order</button>












<?php


        } else {
            echo ("Maximum stock is " . $product_data["qty"] . " Items");
        }
    } else {
        echo ("Something went wrong");
    }
}








?>