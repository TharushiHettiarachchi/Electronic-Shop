
<html >

<head>
  <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resources/icon.png">
    <title>Electronic Shop</title>
</head>

<body>
    <div class="addProductDiv">
        <?php include "header.php"; ?>

        <div class="addProductBackground">

            <div class="addProform">
                <h2 class="addProTitle">Add Products</h2>
                <p id="errorMsg" style="color: red;"></p>
                <div class="inputDiv1">
                    <label class="inputLabel1">Product Number</label>
                    <input class="inputField1" id="pno" type="text" />
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Product Name</label>
                    <input class="inputField1" id="pname" type="text" />
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Product Category</label>
                    <select class="inputField1" id="pcategory">
                        <option value="0">Select</option>
                        <?php
                        include "connection.php";
                        $category_rs = Database::search("SELECT * FROM `product_category` ORDER BY `name` ASC");
                        $category_num = $category_rs->num_rows;
                        for ($i = 0; $i < $category_num; $i++) {
                            $categgory_data = $category_rs->fetch_assoc();
                        ?>
                            <option value="<?php echo ($categgory_data["id"]); ?>"><?php echo ($categgory_data["name"]); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Price</label>
                    <input class="inputField1" id="pprice" type="text" />
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Quantity</label>
                    <input class="inputField1" id="pqty" type="number" />
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Description</label>
                    <textarea class="inputField2" id="pdescription" rows="10" cols="10"></textarea>
                </div>
                <div class="inputDiv1">
                    <label class="inputLabel1">Product Image</label>
                    <input class="inputField1" style="display: none;" id="proImg" type="file" onclick="addProductImg();" />
                    <div class="proImgDiv">
                        <label for="proImg" id="proImg2" class="addImgTxt"> Click to Add Image</label>
                        <img for="proImg" class="proDivImg" id="proDivImg" src=""/>
                    </div>
                </div>
                <div class="inputDiv1">
                    <button class="button" style="margin-top: 20px;" onclick="addProduct();">Add</button>
                </div>
            </div>
        </div>
        <div class="alertDiv" id="alertDiv"></div>
    </div> 
    <script src="script.js"></script>
</body>

</html>