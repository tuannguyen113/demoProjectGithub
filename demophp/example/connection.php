<?php
    define('DB_SEVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','01679207479');
    define('DB_NAME','demophp');

    $mysqli = new mysqli(DB_SEVER,DB_USERNAME,DB_PASSWORD);
//    if($mysqli==true){
//        echo "connect success";
//    }
    if($mysqli===false){
        die("Error!! ".$mysqli->connect_error);
    }
    /*
     * $servername="localhost";
     * $username="root";
     * $password=""
     * tao ket noi
     * $conn=new mysqli($servername,$username,$password)
     * if($conn->connect_error){
     * die("Connect filed". $conn->connect_error);}
     * echo "ket noi thanh cong";
     *
     *
     *
     * */
