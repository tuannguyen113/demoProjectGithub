<?php

    require_once "connection.php";
    //kiem tra ketnoi
    if($mysqli->connect_error){
        die("Conection filed".$mysqli->connect_error);
        $sql="select id,firstname,lastname from employee";
        $result= $mysqli->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                echo "id: ".row["id"]."-name: ".row["$firstname"]
            }
        }
    }
