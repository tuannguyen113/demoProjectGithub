<?php
    session_start();//bat buoc khi moi goi cac bien session
    if(!isset($_SESSION["logggedin"])||$_SESSION["loggedin"] !==true){
        header("location:login.php");
    }
    //create employee
