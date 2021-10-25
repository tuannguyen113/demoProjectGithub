<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!==true){
    header("location: login.php");
    exit;
}
?>
<?php
//process delete operation after confirmation
if (isset($_POST["id"]) && !empty($_POST["id"])){
    //include config file
    require_once "config.php";
    //prepare a delete statement
    $sql="delete from employees where id=?";
    if ($stmt=$mysqli->prepare($sql)){
        $stmt->bind_param("i",$param_id);
        //set parameters
        $param_id=trim($_POST["id"]);
        //attempt to execute the prepared statement
        if ($stmt->execute()){
            header("location: dashboard.php");
            exit();
        }else{
            echo "Oops! Something went wrong.please try again later";
        }
    }
    //close statement
    $stmt->close();
    //close connection
    $mysqli->close();
}else{
    //check existence of id parameter
    if (empty(trim($_GET["id"]))){
        header("location:error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]);?>"/>
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="dashboard.php" class="btn btn-secondary ml-2">NO</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>