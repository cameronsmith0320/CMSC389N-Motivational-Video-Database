/* This js file attempts to improve consistency of our pages by replacing certain elements with consistent content
 * To use, include
 *      <script src="style.js"></script>
 *  near the end of the page, and use <span id="__ID__"></span> tags where you want the content to be
 */

'use strict'

main();

function main(){
    let footer = "&copy;2017 Database of Motivation Videos",
        username = "logged in as: " + "TEST_USER";

    document.getElementById("footer").innerHTML = footer;
    document.getElementById("username").innerHTML = username;
}