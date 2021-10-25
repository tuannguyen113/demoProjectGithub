<?php
//cookies laf 1 file vatli
setcookie("username","admin",time()+15*24*60*60);
echo $_COOKIE["username"];
if (isset($_COOKIE["username"])){
    echo "welcom, ". $_COOKIE["username"];
}else{
    echo "welcom guest";
}