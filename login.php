<!DOCTYPE html>
<html >

<head>
   
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resources/icon.png">
    <title>Electronic Shop</title>
</head>

<body>

    <div class="backgroundDiv">
        <?php include "header.php";
        session_start();
        ?>
        <div class="backgroundDiv2">
            <div class="loginDiv" id="registerDiv">
                <img class="iconImg" src="resources/icon.png" />
                <h1 class="title">Register</h1>
                <p id="errorMsg" style="color: red;"></p>
                <div class="inputDiv">
                    <label class="inputLabel">First Name</label>
                    <input class="inputField" id="fname" type="text" />
                </div>
                <div class="inputDiv">
                    <label class="inputLabel">Last Name</label>
                    <input class="inputField" id="lname" type="text" />
                </div>
                <div class="inputDiv">
                    <label class="inputLabel">Email</label>
                    <input class="inputField" id="email" type="email" />
                </div>
                <div class="inputDiv">
                    <label class="inputLabel">Password</label>
                    <input class="inputField" id="password" type="password" />
                </div>
                <div class="inputDiv">
                    <button class="button" onclick="register();">Register</button>
                    <a class="loginLink" onclick="switchToLogin();">Already have an account? Login</a>
                </div>
            </div>
            <div class="loginDiv1" id="loginDiv">
                <img class="iconImg" src="resources/icon.png" />
                <h1 class="title">SignIn</h1>
                <p id="errorMsg1" style="color: red;"></p>
                <div class="inputDiv">
                    <label class="inputLabel">Email</label>
                    <input class="inputField" id="emailL"  type="email" />
                </div>
                <div class="inputDiv">
                    <label class="inputLabel">Password</label>
                    <input class="inputField" id="passwordL" type="password" />
                </div>
                <div class="inputDiv">
                    <button class="button" onclick="login();">Login</button>
                    <a class="loginLink" onclick="switchToRegister();">Don't have an account? Register</a>
                </div>
            </div>
        </div>
        <div class="alertDiv" id="alertDiv"></div>
    </div>
    <script src="script.js"></script>
</body>

</html>