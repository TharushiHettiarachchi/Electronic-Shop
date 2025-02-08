<?php
session_start();
require "connection.php";

$passwordL = $_POST["passwordL"];
$emailL = $_POST["emailL"];


if(empty($emailL)){
    echo("Please enter your Email!!!");
}else if(strlen($emailL)>= 100){
    echo("Email must have less than 100 characters");
} else if(!filter_var($emailL,FILTER_VALIDATE_EMAIL)){
echo("Invalid Email !!");
} else if(empty($passwordL)){
    echo("Please enter your Password!!!");
} else if(strlen($passwordL)<5 || strlen($passwordL)>20){
    echo("Password must have between 5 to 20 Characters");
} else{

$rs = Database::search("SELECT * FROM `user` WHERE `email`='".$emailL."' AND `password`='".$passwordL."' ");
$n = $rs->num_rows;
if($n==1){
    
 $d = $rs->fetch_assoc();
 $_SESSION["u"]=$d;

if($d["fname"] == 'admin' && $d["password"] = 'admin1234'){
    echo("Admin");
}else{
    echo("Login Successful");
}


} else{
    echo("Invalid Username or Password");
}

}
?>