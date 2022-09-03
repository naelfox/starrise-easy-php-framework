<?php
$protocol = "";

function url(){
    
if ($_SERVER['HTTPS'] == 'on') {
    $protocol = "https";
} else {
    $protocol = "http";
}
   return "$protocol://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'] . '?');
}





