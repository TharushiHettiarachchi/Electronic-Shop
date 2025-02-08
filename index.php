<html>

<head>

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resources/icon.png">
    <title>Electronic Shop</title>
</head>

<body>

    <div class="indexBody">
        <?php include "header.php";
        include "connection.php";
        session_start();
        ?>
        <div class="landingSlide">
            <h1 class="landingTitle">Power Up Your Projects with <br>Quality Electronic Components</h1>
            <p class="landingP">Find the best selection of resistors, capacitors, microcontrollers, and more to bring your ideas to life.<br>
                <a href="#scrollMe"><button class="shopBtn">Shop Now</button></a>
            </p>

        </div>
        <div class="searchView">
            <h2 class="searchTitle">Search your Desires</h2>
            <input type="text" class="searchBar" onkeyup="searchProducts();" id="searchTxt" />
        </div>
        <div id="searchProducts" id="searchProducts">
        </div>
        <div id="scrollMe"></div>
        <?php
        $category_rs = Database::search("SELECT * FROM `product_category` ORDER BY 'name' ASC");
        $category_num = $category_rs->num_rows;
        for ($i = 0; $i < $category_num; $i++) {
            $category_data = $category_rs->fetch_assoc();
        ?>
            <div class="categoryDiv">
                <h2 class="categoryTitle"><?php echo ($category_data["name"]); ?></h2>
                <hr>
                <?php
                $product_rs = Database::search("SELECT * FROM `product` WHERE `product_category_id` = '" . $category_data['id'] . "'");
                $product_num = $product_rs->num_rows;

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

        <div class="alertDiv" id="alertDiv"></div>

    </div>
    <script src="script.js"></script>
</body>

</html>