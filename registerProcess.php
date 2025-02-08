<?php
include "connection.php";
include "SMTP.php";
include "PHPMailer.php";
include "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];

if (empty($fname)) {
    echo ("Please enter your First Name");
} else if (empty($lname)) {
    echo ("Please enter your Last Name");
} else if (empty($email)) {
    echo ("Please enter your Email");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address.");
} else if (empty($password)) {
    echo ("Plaese enter your Password!");
} else if (strlen($password) < 5 || strlen($password) > 10) {
    echo ("Password must have 5 to 10  characters!");
} else {
    $user_rs =  Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
    $user_num = $user_rs->num_rows;
    if ($user_num > 0) {
        echo ("Email already exists.");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
        Database::iud("INSERT INTO `user`(  `fname`, `lname`, `email`, `password`, `registered_date`) VALUES('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','" . $date . "')");


        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'electronishoppvt@gmail.com';
        $mail->Password = 'twud xajg bdfp xwsm';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('electronishoppvt@gmail.com', 'Welcome to Electronic Shop');
        $mail->addReplyTo('electronishoppvt@gmail.com', 'Contact Us');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Electronic Shop';
        $bodyContent = '<h1 style="color:orange;">Welcome to Electronic Shop</h1><br><p>Dear ' . $fname . ' ' . $lname . ',</p><br><p>Thank you for registering with ElecShop! We are thrilled to have you on board. Explore a wide range of electronic components, tools, and accessories tailored to meet all your project needs. Enjoy a seamless shopping experience, exclusive discounts, and fast delivery right to your doorstep.

If you have any questions or need assistance, feel free to reach out to our support team at electronishoppvt@gmail.com. <br>

Happy shopping!<br>
The ElecShop Team<p>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            // echo 'Verification code sending failed.';
        } else {
            // echo 'Success';
            echo ("Registration Successful");
        }
       
    }
}
