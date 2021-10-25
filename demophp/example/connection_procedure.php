<?php
    $servername="localhost";
    $username="root";
    $password="";

    //tao ket noi
$conn = new mysql_connect($servername,$username,$password);
if(!$conn){
    die("Connection filed");
}
echo "ket noi thanh cong";