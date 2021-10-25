<?php
//include config file
require_once "../connect/config.php";
//define variables and initialize with empty values
$macn=$tencn="";
$macn_err=$tencn_err="";

//processing form data when form is submitted
if(isset($_POST["macn"]) && !empty($_POST["macn"])){
    $macn = $_POST["macn"];
    //validate macn
    $input_macn=trim($_POST["macn"]);
    if (empty($input_macn)){
        $macn_err=="Vui lòng nhập mã chuyên ngành";
    }elseif (strlen($input_macn)!==5){
        $macn_err="Vui lòng nhâp trường này 5 kí tự.";
    }else{
        $macn=$input_macn;
    }
    //validate tencn
    $input_tencn=trim($_POST["tencn"]);
    if (empty($input_tencn)){
        $tencn_err="Vui lòng nhập tên chuyên ngành.";
    }else{
        $tencn=$input_tencn;
    }

    //check input errors before inserting in database
    if (empty($macn_err)&& empty($tencn_err)){
        $sql ="update chuyennganh set macn=?, tencn=?";
        if ($stmt = $mysqli->prepare($sql)){
            //bind variabalees to the prepaered statement parameter
            $stmt->bind_param("ss",$param_macn,$param_tencn);
            //set parameter
            $param_macn=$macn;
            $param_tencn=$tencn;

            //attempt to execute the prepared statement
            if ($stmt->execute()){
                //record updated successfully.Redirect to landing page
                header("location: dashboard.php");
                exit();
            }else{
                echo "Rất tiếc.Vui lòng thử lại sau.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();

}else{
    //check existence of id parameter before processing further
    if (isset($_GET["macn"]) && !empty(trim($_GET["macn"]))){
        //get url parameter
        $macn=trim($_GET["macn"]);

        //prepare a select statement
        $sql="select * from chuyennganh where macn=?";
        if ($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s",$param_macn);
            //set parameters
            $param_macn=$macn;
            //attempt to execute the prepared statement
            if ($stmt->execute()){
                $result=$stmt->get_result();
                if ($result->num_rows == 1){
                    $row =$result->fetch_array(MYSQLI_ASSOC);
                    //retrieve individual field value
                    $macn = $row["macn"];
                    $tencn=$row["tencn"];
                }else{
                    //url doesn't contain valid id redirect to error page
                    header("location:error.php");
                    exit();
                }
            }else{
                echo "Rất tiếc!Vui lòng thử lại sau.";
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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật bản ghi</title>
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
                <h2 class="mt-5">Cập nhật bản ghi</h2>
                <p>Vui lòng điền giá trị vào biểu mẫu và gửi để cập nhật bản ghi</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI']))?>" method="post">
                    <div class="form-group">
                        <label for="">Mã chuyên ngành</label>
                        <input type="text" name="macn" class="form-control
                               <?php echo (!empty($macn_err))? 'is-invalid' : '' ;?>" value="<?php echo $macn;?>">
                        <span class="invalid-feedback"><?php echo $macn_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Tên chuyên ngành</label>
                        <input type="text" name="tencn" class="form-control
                               <?php echo (!empty($tencn_err))? 'is-invalid' : '' ;?>" value="<?php echo $tencn;?>">
                        <span class="invalid-feedback"><?php echo $tencn_err;?></span>
                    </div>
                    <input type="hidden" name="macn" value="<?php echo $macn; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
