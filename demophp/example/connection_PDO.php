<?php
    //procedure
    $servername="localhost";
    $username="root";
    $password="01679207479";
    $db="demophp";

try {
    $conn=new PDO("mysql:host=$servername;$db",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //create table
    $sql="Create table employee(
        id int primarykey auto_increment,
        firstname varchar(25) not null,
        lastname varchar (25) not null
        )";
    $conn->exec($sql);
    echo "Create table successfully";


}catch (PDOException $e){
    echo "Connection failed". $e->getMessage();
}
$conn=null;
?>