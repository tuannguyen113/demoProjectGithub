<?php
//tạo kết nối
//    require_once "connection.php";
//huong thu tuc
    $servername="localhost";
    $username = "root";
    $password="01679207479";
    $conn = new mysqli($servername,$username,$password);
    //kiem tra ket noi
    if($conn->connect_error){
        die("Connection fixed".$conn->connect_error);
    }echo "ket noi thanh cong";
    //query string create table
//    $sql="create table Employee(
//             id int primary key auto_increment,
//             firstname varchar(25) not null,
//             lastname varchar(25) not null,)";
//
//    if($conn->query($sql)===true){
//        echo "tao bang thanh cong";
//    }else{
//        echo "Error!! ".$conn->error;
//    }
//    echo "ket noi thanh cong";
//    $conn->close();
