<?php
$searchTxt = $_POST["searchTxt"];
include "connection.php";

if(empty($searchTxt)){

}else{
?>

<div class="categoryDiv">
    <h2 class="categoryTitle">Searched Items</h2>
    <hr>
    <?php
    $product_rs = Database::search("SELECT * FROM `product` WHERE `product_name` LIKE '%".$searchTxt."%'");
    $product_num = $product_rs->num_rows;
    ?>
<h3><?php echo($product_num); ?> Items Found</h3>
<?php
    for ($p = 1; $p < $product_num + 1; $p++) {
        $product_data = $product_rs->fetch_assoc();
        if ($p % 5 == 1) {
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
                    <p>Rs. <?php echo number_format($product_data["price"], 2, '.', ''); ?></p>
                    <p class="availableQty"><b style="color: red;"><?php echo ($product_data["qty"]); ?></b> Items available</p>
                    <input type="number" id="qty<?php echo ($product_data['id']); ?>" min="0" class="qtyInput" placeholder="Qty" />
                    <?php

                    if (isset($_SESSION["u"])) {

                        $user = $_SESSION["u"];
                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $product_data["id"] . "' AND `user_email` = '" . $user["email"] . "'");
                        $cart_num = $cart_rs->num_rows;
                        if ($cart_num == 1) {
                    ?>
                            <button class="addedCartBtn" disabled>Added to Cart</button>
                        <?php
                        } else {
                        ?>
                            <button class="addCartBtn" id="cartBtn<?php echo ($product_data['id']); ?>" onclick="addToCart(<?php echo ($product_data['id']); ?>);">Add to Cart</button>
                        <?php
                        }
                    } else {

                        ?>
                        <button class="addCartBtn" onclick="addToCart(<?php echo ($product_data['id']); ?>);">Add to Cart</button>
                    <?php
                    }

                    ?>

                </div>

            </div>
            <?php

            if ($p % 5 == 0 || $p == $product_num) {
            ?>
            </div>
    <?php
            }
        }

    ?>





</div>

<?php
}
?>
















