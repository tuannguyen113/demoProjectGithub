<?php
require_once "../connect/config.php";
$macn=$tencn="";
$macn_err=$tencn_err="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //validate macn
    $input_macn=trim($_POST["macn"]);
    if (empty($input_macn)){
        $macn_err="Vui lòng nhập mã chuyên ngành.";
    }elseif (strlen($input_macn)!==5){
        $macn_err="Mã chuyên ngành chứa 5 kí tự";
    }else{
        $macn=$input_macn;
    }
    //validate tencn
    $input_tencn=trim($_POST["tencn"]);
    if (empty($input_tencn)){
        $address_err="Vui lòng nhập tên chuyên ngành.";
    }else{
        $tencn=$input_tencn;
    }

    //check input errors before inserting in database
    if (empty($macn_err) && empty($tencn_err)){
        //prepare an insert satement
        $sql="Insert into chuyennganh (macn,tencn) values (?,?)";
        if($stmt=$mysqli->prepare($sql)){
            //bind variables to the prepared statement as parameters
            $stmt->bind_param("ss",$param_macn,$param_tencn);

            //set parameters
            $param_macn=$macn;
            $param_tencn=$tencn;

            //attempt to execute the prepared statement
            if($stmt->execute()){
                header("location:dashboard.php");
                exit();
            }else{
                echo "Rất tiếc!Đã xảy ra lỗi.Vui lòng thử lại";
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tạo bản ghi</title>
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
                <h2 class="mt-5">Tạo mới</h2>
                <p>Vui lòng điền đầy đủ thông tin vào biểu mẫu</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="form-group">
                        <label for="">Mã chuyên ngành</label>
                        <input type="text" name="macn" class="form-control
                        <?php echo (!empty($macn_err))? 'is-invalid' : '';?>" value="<?php echo $macn;?>">
                        <span class="invalid-feedback"><?php echo $macn_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Tên chuyên ngành</label>
                        <input type="text" name="tencn" class="form-control
                        <?php echo (!empty($tencn_err))? 'is-invalid' : '';?>" value="<?php echo $tencn;?>">
                        <span class="invalid-feedback"><?php echo $tencn_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>
