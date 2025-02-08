<?php
session_start();
if (isset($_SESSION["p"])) {
    $product_id = $_SESSION["p"];
    include "connection.php";
    $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_category` ON `product`.`product_category_id` = `product_category`.`id` WHERE `product`.`id` = '" . $product_id . "'");
    $product_data = $product_rs->fetch_assoc();
?>
       <html>
    <head>

        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="resources/icon.png">
        <title>Electronic Shop</title>
    </head>
    <body>
        <div class="productViewBody">
            <?php include "header.php"; ?>
            <div class="productViewBody2">
                <div class="productViewDiv1">
                    <img src="<?php echo ($product_data["image_path"]); ?>" class="productViewImg" />
                </div>
                <div class="productViewDiv2">
                    <h2 class="productViewTitle"><?php echo ($product_data["product_code"] . ' ' . $product_data["product_name"]); ?></h2>
                    <p><b style="color: red; font-size:18px;"><?php echo ($product_data["qty"]); ?></b> Items Available</p>
                    <p class="productViewPrice">Rs. <?php echo number_format($product_data["price"], 2, '.', ''); ?></p>
                    <div class="categoryTag"><?php echo ($product_data["name"]); ?></div>
                    <div class="descriptionBox">
                        <p class="descriptionTitle">Description</p>
                        <p class="descriptionDetails"><?php echo ($product_data["description"]); ?></p>
                    </div>
                    <input type="number" placeholder="Quantity" class="productViewQty" id="qty<?php echo ($product_id); ?>" />
                    <?php
                    if (isset($_SESSION["u"])) {

                        $user = $_SESSION["u"];
                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $product_id . "' AND `user_email` = '" . $user["email"] . "'");
                        $cart_num = $cart_rs->num_rows;
                        if ($cart_num == 1) {
                          
                    ?>
                            <button class="addCartBtn2"  disabled>Added to Cart</button>
                        <?php
                        } else {
                        ?>
                             <button class="addCartBtn2" id="cartBtn<?php echo ($product_id); ?>" onclick="addToCart(<?php echo ($product_id); ?>);">Add to Cart</button>
                        <?php
                        }
                    } else {

                        ?>
                       
                    <?php
                    }

                    ?>
                   
                </div>
            </div>

            <div class="alertDiv" id="alertDiv"></div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>
<?php


} else {
    echo ("something went wrong");
}
?>