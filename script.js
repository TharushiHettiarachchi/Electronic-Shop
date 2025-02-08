function switchToLogin() {

    var registerDiv = document.getElementById("registerDiv");
    var loginDiv = document.getElementById("loginDiv");

    loginDiv.style.display = "flex";
    registerDiv.style.display = "none";


}

function switchToRegister() {

    var registerDiv = document.getElementById("registerDiv");
    var loginDiv = document.getElementById("loginDiv");

    registerDiv.style.display = "flex";
    loginDiv.style.display = "none";


}

function register() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var alertDiv = document.getElementById("alertDiv");

    var form = new FormData();
    form.append("fname", fname);
    form.append("lname", lname);
    form.append("password", password);
    form.append("email", email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
        





            if (response == "Registration Successful") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";
               
                setTimeout(() => {
                    alertDiv.style.display = "none";
                    switchToLogin();
                }, 3000);
              
            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }


        }

    }

    request.open("POST", "registerProcess.php", true);
    request.send(form);

}

function login() {
    var emailL = document.getElementById("emailL").value;
    var passwordL = document.getElementById("passwordL").value;
    var alertDiv = document.getElementById("alertDiv");

    var form = new FormData();
    form.append("emailL", emailL);
    form.append("passwordL", passwordL);


    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;

            if (response == "Login Successful") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";

                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location = "index.php";
                }, 3000);

            }else if (response == "Admin") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";

                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location = 'addProduct.php';
                }, 3000);
               
            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }

        

        }

    }

    request.open("POST", "loginProcess.php", true);
    request.send(form);




}



function addProduct() {
    var pno = document.getElementById("pno");
    var pname = document.getElementById("pname");
    var pcategory = document.getElementById("pcategory");
    var pprice = document.getElementById("pprice");
    var pqty = document.getElementById("pqty");
    var pdescription = document.getElementById("pdescription");
    var proImg = document.getElementById("proImg");
    var alertDiv = document.getElementById("alertDiv");

    var form = new FormData();
    form.append("pno", pno.value);
    form.append("pname", pname.value);
    form.append("pcategory", pcategory.value);
    form.append("pprice", pprice.value);
    form.append("pqty", pqty.value);
    form.append("pdescription", pdescription.innerHTML);
    form.append("proImg", proImg.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
           
            if (response == "Successful") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";
               
                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location.reload();

                }, 3000);
              
            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }

        }

    }

    request.open("POST", "addProductProcess.php", true);
    request.send(form);



}

function addProductImg() {

    var proDivImg = document.getElementById("proDivImg");
    var proImg2 = document.getElementById("proImg2");
    var proImg = document.getElementById("proImg");
   

    proImg.onchange = function () {
        var file1 = this.files[0];
        var url = window.URL.createObjectURL(file1);

       
        proDivImg.style.display = "block";
        proDivImg.src = url;
    }
}



function view(id) {
    var product = id;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            window.location = "singleProduct.php";
        }
    }
    r.open("GET", "viewProcess.php?id=" + product, true);
    r.send();
}

function addToCart(id) {
    var qty = document.getElementById("qty" + id);
    var cartBtn = document.getElementById("cartBtn" + id);
    var alertDiv = document.getElementById("alertDiv");

    var form = new FormData();
    form.append("qty", qty.value);
    form.append("pid", id);


    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
            if (response == "Successfully added to cart") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";
                qty.value = 0;
                setTimeout(() => {
                    alertDiv.style.display = "none";

                }, 3000);
                cartBtn.className = "addedCartBtn";
                cartBtn.innerHTML = "Added to Cart"
            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }

        }

    }

    request.open("POST", "addToCartProcess.php", true);
    request.send(form);


}


function RemoveCart(id) {

   
    var alertDiv = document.getElementById("alertDiv");

    var form = new FormData();
  
    form.append("pid", id);


    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
            if (response == "Sucessfully Deleted") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";

                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location.reload();
                }, 3000);

            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }

        }

    }

    request.open("POST", "removeCartProcess.php", true);
    request.send(form);


}

function placeOrder() {

    var alertDiv = document.getElementById("alertDiv");



    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
            if (response == "Order Successfully Placed") {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "green";

                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location.reload();
                }, 3000);

            } else {
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                }, 3000);
            }

        }

    }

    request.open("GET", "orderlistProcess.php", true);
    request.send();


}

function openSummary(id) {
  

    var summary = document.getElementById("orderSum" + id);

    if (summary.style.display == "block") {
        summary.style.display = "none"
    } else {
        summary.style.display = "block"
    }

}


function changeQty(id){
    var qty = document.getElementById("qty" + id);
    var sumBody = document.getElementById("sumBody");
  

    var form = new FormData();
    form.append("qty", qty.value);
    form.append("pid", id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;

            if(response.startsWith("Maximum")){
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location.reload();
                }, 3000);
            }else if(response == "Something went wrong"){
                alertDiv.innerHTML = response;
                alertDiv.style.display = "flex";
                alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.709)";
                setTimeout(() => {
                    alertDiv.style.display = "none";
                    window.location.reload();
                }, 3000);
            }else{
                sumBody.innerHTML = response;
            }
         
        }

    }

    request.open("POST", "changeQtyProcess.php", true);
    request.send(form);
    
}



function searchProducts(){
    
    var searchProducts = document.getElementById("searchProducts");
    var searchTxt = document.getElementById("searchTxt");


     var form = new FormData();
    form.append("searchTxt",searchTxt.value);
   

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
            searchProducts.innerHTML = response;
         
       }

    }

    request.open("POST", "searchProcess.php", true);
    request.send(form);

}