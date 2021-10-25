<?php
    if($_SERVER["REST_METHOD"]=="POST"){
        echo $_POST["name"];
        echo $_POST["email"];
    }
    if($_SERVER["REST_METHOD"]=="GET"){
        echo $_GET["tel"];
        echo $_GET["address"];
    }

