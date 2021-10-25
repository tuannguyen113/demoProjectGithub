<?php
    session_start();
    $_SESSION=array();
    session_destroy();//huy toanf bo phien cua session
    header("location: login.php");

