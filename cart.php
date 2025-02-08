<?php
session_start();
if (isset($_SESSION["u"])) {
    $user = $_SESSION["u"];
?>
    
    <html>
    <head>
              <link rel="stylesheet" href="style.css">
        <link rel="icon" href="resources/icon.png">
        <title>Electronic Shop</title>
    </head>

    <body>
        <div class="cartBody">
            <?php include "header.php";
            include "connection.php";
            ?>
            <div class="cartBody1">
                <div class="cartSubBody1">
                    <div class="addProTitle" style="margin-bottom: 30px; margin-top: 30px;">Cart</div>

                    <?php
                    $product_rs = Database::search("SELECT cart.qty AS cart_qty, product.qty AS product_qty, product.id AS product_id, cart.id AS cart_id, cart.*, product.* FROM cart INNER JOIN product ON product.id = cart.product_id WHERE cart.user_email = '" . $user["email"] . "'
");
                    $product_num = $product_rs->num_rows;

                    for ($p = 1; $p < $product_num + 1; $p++) {
                        $product_data = $product_rs->fetch_assoc();
                        if ($p % 4 == 1) {
                    ?>
                            <div class="productPanel">
                            <?php
                        }
                            ?>
                            <div class="productDiv">
                                <div class="productImgDiv">
                                    <img src="<?php echo ($product_data["image_path"]); ?>" onclick="view(<?php echo ($product_data['id']); ?>);" class="productImgH" />
                                </div>
                                <div class="productdescript">
                                    <p><?php echo ($product_data["product_code"]); ?></p>
                                    <div class="productName"><?php echo ($product_data["product_name"]); ?></div>
                                    <p>Rs.<?php echo ($product_data["price"]); ?>.00</p>
                                    <p class="availableQty"><b style="color: red;"><?php echo ($product_data["product_qty"]); ?></b> Items available</p>
                                    <input type="number" id="qty<?php echo ($product_data['id']); ?>" min="0" class="qtyInput" placeholder="Qty" value="<?php echo ($product_data["cart_qty"]); ?>" onchange="changeQty(<?php echo ($product_data['product_id']); ?>);" />
                                    <button class="addCartBtn" onclick="RemoveCart(<?php echo ($product_data['product_id']); ?>);">Remove from Cart</button>
                                </div>

                            </div>
                            <?php

                            if ($p % 4 == 0 || $p == $product_num) {
                            ?>
                            </div>
                    <?php
                            }
                        }

                    ?>

                </div>
                <div class="cartSubBody2" id="sumBody">
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
                </div>
            </div>
            <div class="alertDiv" id="alertDiv"></div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}

?>