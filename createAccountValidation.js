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
            var usernameErrors = document.getElementById("usernameErrors");
            var passwordErrors = document.getElementById("passwordErrors");
            var emailErrors = document.getElementById("emailErrors");
            if (resultsArr[0] === "") {
                usernameErrors.className = "";
                usernameErrors.innerHTML = resultsArr[0];
            }
            else {
                usernameErrors.className = "alert alert-danger";
                usernameErrors.innerHTML = resultsArr[0];
            }
            if (resultsArr[1] === "") {
                passwordErrors.className = "";
                passwordErrors.innerHTML = resultsArr[1];
            }
            else {
                passwordErrors.className = "alert alert-danger";
                passwordErrors.innerHTML = resultsArr[1];
            }
            if (resultsArr[2] === "") {
                emailErrors.className = "";
                emailErrors.innerHTML = resultsArr[2];
            }
            else {
                emailErrors.className = "alert alert-danger";
                emailErrors.innerHTML = resultsArr[2];
            }
        }
    }
}
