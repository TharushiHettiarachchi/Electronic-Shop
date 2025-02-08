<?php
session_start();
if (isset($_SESSION["u"])) {
    include "connection.php";
    $user = $_SESSION["u"];
?>
       <html >
    <head>
              <link rel="icon" href="resources/icon.png">
        <link rel="stylesheet" href="style.css">
        <title>Electronic Shop</title>
    </head>

    <body>
        <div class="profileBg">
            <?php include "header.php"; ?>

            <div class="profileFormBg">
                <div class="profileImgDiv">
                    <img src="resources/account.png" class="profilePgImg" />
                </div>
                <div class="profileFormDiv">
                    <div class="addProTitle" style="margin-bottom: 30px; margin-top: 30px;">Profile</div>
                    <div class="profilePanel">
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">First Name</label>
                            <input class="profileInput" type="text" value="<?php echo ($user["fname"]); ?>" />
                        </div>
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">Last Name</label>
                            <input class="profileInput" type="text" value="<?php echo ($user["lname"]); ?>" />
                        </div>
                    </div>
                    <div class="profilePanel">
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">Mobile Number</label>
                            <input class="profileInput" type="text" value="" />
                        </div>
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">Email</label>
                            <input class="profileInput" type="text" value="<?php echo ($user["email"]); ?>" />
                        </div>
                    </div>
                    <div class="profilePanel">
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">Password</label>
                            <input class="profileInput" type="text" value="<?php echo ($user["password"]); ?>" />
                        </div>
                        <div class="profilePanelDiv1">
                            <label class="profileLabel">Registered Date</label>
                            <input class="profileInput" type="text" value="<?php echo ($user["registered_date"]); ?>" />
                        </div>
                    </div>
                    <?php
                    $orderlist_rs = Database::search("SELECT * FROM `orders` WHERE `user_email` = '" . $user["email"] . "'");
                    $orderlist_num = $orderlist_rs->num_rows;
                    if ($orderlist_num == 0) {
                    ?>
                        <div class="orderdPDiv">You have not ordered anything yet.</div>
                        <?php
                    } else {
                        for ($o = 0; $o < $orderlist_num; $o++) {
                            $orderlist_data = $orderlist_rs->fetch_assoc();
                        ?>
                            <div class="orderdPDiv1">
                                <div class="orderTopPanel">
                                    <div class="orderdescDiv">

                                        <div class="orderIdDiv" onclick="openSummary('<?php echo ($orderlist_data['order_id']); ?>');">Order Id : <?php echo ($orderlist_data["order_id"]); ?></div>
                                        <div class="orderTimeDiv"><?php echo ($orderlist_data["date_time"]); ?></div>
                                    </div>
                                    <div class="orderAmountDiv">Rs. <?php echo ($orderlist_data["amount"]); ?>.00</div>
                                </div>
                                <div class="oderDivTable" id="orderSum<?php echo ($orderlist_data["order_id"]); ?>">
                                    <table class="ordersumTable">
                                        <thead class="ordersumTable">
                                            <td style="text-align: start;">Product</td>
                                            <td>Unit Price</td>
                                            <td>Qty</td>
                                            <td style="text-align: right;"> Amount</td>
                                        </thead>
                                        <tbody class="tableBody">
                                            <?php
                                            $order_rs = Database::search("SELECT  * FROM `orders` INNER JOIN `order_items` ON `orders`.`id` = `order_items`.`orders_id` WHERE `orders`.`order_id` = '".$orderlist_data["order_id"]."'");
                                            $order_num = $order_rs->num_rows;
                                            $subTotal = 0;
                                            for ($i = 0; $i < $order_num; $i++) {
                                                $order_data = $order_rs->fetch_assoc();
                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $order_data["product_id"] . "' ");
                                                $product_data = $product_rs->fetch_assoc();
                                            ?>
                                                <tr>

                                                    <td style="text-align: left;"><?php echo ($product_data["product_code"] . "  " . $product_data["product_name"]); ?></td>
                                                    <td style="text-align: center; padding-left: 10px; padding-right: 10px;"><?php echo intval($product_data["price"]); ?></td>
                                                    <td><?php echo ($order_data["qty"]); ?></td>
                                                    <?php
                                                    $product_price = round(floatval($product_data["price"]), 2);
                                                    $amount1 = intval($order_data["qty"]) * $product_price;
                                                    $amount = round($amount1, 2);

                                                    ?>
                                                    <td style="text-align: end; padding-left: 10px;">
                                                        <?php echo number_format($amount, 2, '.', ''); ?>
                                                    </td>
                                                </tr>

                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <?php
                        }
                        ?>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="script.js"></script>

    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}

?>