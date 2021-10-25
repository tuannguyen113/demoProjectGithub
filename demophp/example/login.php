<?php
    session_start();//bat buoc khi moi goi cac bien session
    $_SESSION["username"] = "admin";
    $_SESSION["email"]="admin@yourcompany.com";//khoi tao gan gtri cho session "key"->"value"
    echo 'welcom '. $_SESSION["username"];//truy xuat

    //huy toan vo session (toan bo cac bien session dc kich hoat)
    if(isset($_SESSION["username"])){
        unset($_SESSION["username"]);
    }

    //////
    if(isset($_SESSION["loggedin"])||$_SESSION["loggedin"] ===true){
        header("location:create.php");
        exit();
    }