<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !==true){
    header("location:login.php");
    exit;
}
?>
<?php
//include config file
require_once "config.php";
//define variables and initialize with empty values
$name=$address=$salary="";
$name_err=$address_err=$salary_err="";

//processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    //validate name
    $input_name=trim($_POST["name"]);
    if (empty($input_name)){
        $name_err=="Please enter a name.";
    }elseif (!filter_var($input_name,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err="Please enter a valid name.";
    }else{
        $name=$input_name;
    }
    //validate address
    $input_address=trim($_POST["address"]);
    if (empty($input_address)){
        $address_err="Please enter and address.";
    }else{
        $address=$input_address;
    }
    //validate salary
    $input_salary=trim($_POST["salary"]);
    if (empty($input_salary)){
        $salary_err="please enter the salary amount.";
    }elseif (!ctype_digit($input_salary)){
        $salary_err="Please enter a positive integer value.";
    }else{
        $salary=$input_salary;
    }
    //check input errors before inserting in database
    if (empty($name_err)&& empty($address_err)&& empty($salary_err)){
        $sql ="update employees set name=?, address=?, salary=? where id=?";
        if ($stmt = $mysqli->prepare($sql)){
            //bind variabalees to the prepaered statement parameter
            $stmt->bind_param("sssi",$param_name,$param_address,$param_salary,$param_id);
            //set parameter
            $param_name=$name;
            $param_address=$address;
            $param_salary=$salary;
            $param_id=$id;
            //attempt to execute the prepared statement
            if ($stmt->execute()){
                //record updated successfully.Redirect to landing page
                header("location: dashboard.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();

}else{
    //check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        //get url parameter
        $id=trim($_GET["id"]);

        //prepare a select statement
        $sql="select * from employees where id=?";
        if ($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i",$param_id);
            //set parameters
            $param_id=$id;
            //attempt to execute the prepared statement
            if ($stmt->execute()){
                $result=$stmt->get_result();
                if ($result->num_rows == 1){
                    $row =$result->fetch_array(MYSQLI_ASSOC);
                    //retrieve individual field value
                    $name = $row["name"];
                    $address=$row["address"];
                    $salary=$row["salary"];
                }else{
                    //url doesn't contain valid id redirect to error page
                    header("location:error.php");
                    exit();
                }
            }else{
                echo "Oops! Something went wrong .Please try again later.";
            }
        }
        $stmt->close();
        $mysqli->close();
    }else{
        //url dosen't contain id parameter Redirect to error page
        header("location:error.php");
        exit();
    }
}
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the employee record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                   
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control
                            <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $name;?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address" class="form-control
                            <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"<?php echo $address; ?>"></textarea>
                        <span class="invalid-feedback"><?php echo $address_err;?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Salary</label>
                        <input type="text" name="salary" class="form-control
                            <?php echo (!empty($salary_err)) ? 'is-invalid' : '';?>"value="<?php echo $salary;?>">
                        <span class="invalid-feedback"><?php echo $salary_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
