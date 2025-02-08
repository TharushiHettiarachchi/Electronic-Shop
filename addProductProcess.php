<?php
include "connection.php";
$pno = $_POST["pno"];
$pname = $_POST["pname"];
$pcategory = $_POST["pcategory"];
$pprice = $_POST["pprice"];
$pqty = $_POST["pqty"];
$pdescription = $_POST["pdescription"];

if(empty($pname)){
    echo("Please enter the Product Name");
}else if($pcategory == 0){
    echo("Please select Product Category");
}else if(empty($pprice)){
    echo("Please enter the Product Price");
}else if(empty($pqty)){
    echo("Please enter the Product Quantity");
}
// -
else{

    $allowed_image_extensions = array("image/jpeg","image/png","image/svg+xml");

    if(isset($_FILES["proImg"])){
    
        $image_file = $_FILES["proImg"];
        $file_extension = $image_file["type"];
    
        if(in_array($file_extension,$allowed_image_extensions)){
    
            $new_img_extension;
    
        if($file_extension == "image/jpeg"){
            $new_img_extension = ".jpeg";
        }else if($file_extension == "image/png"){
            $new_img_extension = ".png";
        }else if($file_extension == "image/svg+xml"){
            $new_img_extension = ".svg";
        }
    
        $file_name = "products//".$pno."_".uniqid().$new_img_extension;
        move_uploaded_file($image_file["tmp_name"],$file_name);
    
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
    
        Database::iud("INSERT INTO `product`(`product_code`,`product_name`,`product_category_id`,`qty`,`image_path`,`price`,`date_added`) VALUES 
        ('".$pno."','".$pname."','".$pcategory."','".$pqty."','".$file_name."','".$pprice."','".$date."')");
    
      echo ("Successful");
        }else{
            echo ("Inavid image type.");
        }
    
    }else{
        echo("Upload an Image");
    }
    
}

?>