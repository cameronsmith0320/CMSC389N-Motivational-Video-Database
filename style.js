/* This js file attempts to improve consistency of our pages by replacing certain elements with consistent content
 * To use, include
 *      <script src="style.js"></script>
 *  near the end of the page, and use <span id="__ID__"></span> tags where you want the content to be
 */

'use strict'

main();

function main(){
    let footer = "&copy;2017 Database of Motivation Videos",
        php_user = document.getElementById("phpjs-username").textContent,
        loginbtn = document.getElementById("loginbtn"),
        username;


    if(php_user){
        username = "logged in as: " + php_user;
        loginbtn.innerHTML = '<a href="logout.php" class="btn btn-default btn-sm"> logout </a>';
    }else{
        username = "Not logged in. ";
        loginbtn.innerHTML = '<a href="createAccount.php" class="btn btn-primary btn-sm"> new account </a>' +
            '<a href="login.php" class="btn btn-default btn-sm"> login </a>';
    }

    if(document.getElementById("footer"))
        document.getElementById("footer").innerHTML = footer;
    if(document.getElementById("username"))
        document.getElementById("username").innerHTML = username;

}
