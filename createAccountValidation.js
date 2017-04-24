"use strict";

var requestObj = new XMLHttpRequest();

function validate() {
    var scriptURL = "createAccountValidationSupport.php";
    
    var username = document.getElementById("username").value;
    scriptURL += "?username=" + username;
    var password = document.getElementById("password").value;
    scriptURL += "&password=" + password;
    var verifyPassword = document.getElementById("verifyPassword").value;
    scriptURL += "&verifyPassword=" + verifyPassword;
    var email = document.getElementById("email").value;
    scriptURL += "&email=" + email;
    var randomValue = (new Date()).getTime();
    scriptURL += "&randomValue=" + randomValue;
    
    var asynch = true;
    requestObj.open("GET", scriptURL, asynch);
    requestObj.onreadystatechange = processRequest;
    requestObj.send(null);
}

function processRequest() {
    if (requestObj.readyState === 4) {
        if (requestObj.status === 200) {
            var results = requestObj.responseText;
            var resultsArr = results.split("|");
            document.getElementById("usernameErrors").innerHTML = resultsArr[0];
            document.getElementById("passwordErrors").innerHTML = resultsArr[1];
            document.getElementById("emailErrors").innerHTML = resultsArr[2];
        }
    }
}