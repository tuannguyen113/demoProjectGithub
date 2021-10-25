<?php
//include config file
require_once "../connect/config.php";
//define variables and initialize with empty values
$mabd=$tenbd=$diachi=$email=$sdt="";
$mabd_err=$tenbd_err=$diachi_err=$email_err=$sdt_err="";


//processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    //validate mabd
    $input_mabd=trim($_POST["mabd"]);
    if (empty($input_mabd)){
        $mabd_err=="Vui lòng nhập mã bạn đọc";
    }elseif (strlen($input_mabd)!==5){
        $mabd_err="Vui lòng nhâp trường này 5 kí tự.";
    }else{
        $mabd=$input_mabd;
    }
    //validate tenbd
    $input_tenbd=trim($_POST["tenbd"]);
    if (empty($input_tenbd)){
        $tenbd_err="Vui lòng nhập tên bạn đọc.";
    }else{
        $tenbd=$input_tenbd;
    }
    //validate diachi
    $input_diachi=trim($_POST["diachi"]);
    if (empty($input_diachi)){
        $diachi_err="Vui lòng nhập địa chỉ";
    }else{
        $diachi=$input_diachi;
    }
    //validate email
    $input_email=trim($_POST["email"]);
    if (empty($input_email)){
        $email_err="Vui lòng nhập email";
    }elseif(!filter_var($input_email,FILTER_VALIDATE_EMAIL)){
        $email_err="Email không đúng định dạng";
    }else{
        $email=$input_email;
    }
    //validate sdt
    $input_sdt=trim($_POST["sdt"]);
    if (empty($input_sdt)){
        $sdt_err="Vui lòng nhập số điện thoại";
    }elseif(strlen($input_sdt)!==10 && !is_numeric($input_sdt)){
        $sdt_err="Vượt quá giới hạn hoặc không đúng định dạng";
    }else{
        $sdt=$input_sdt;
    }


    //check input errors before inserting in database
    if (empty($mabd_err)&& empty($tenbd_err)){
        $sql ="update bandoc set mabd=?, tenbd=?,diachi=?,email=?,sdt=?";
        if ($stmt = $mysqli->prepare($sql)){
            //bind variabalees to the prepaered statement parameter
            $stmt->bind_param("sssss",$param_mabd,$param_tenbd,$param_diachi,$param_email,$param_sdt);
            //set parameter
            $param_mabd=$mabd;
            $param_tenbd=$tenbd;
            $param_diachi=$diachi;
            $param_email=$email;
            $param_sdt=$sdt;

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
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        //get url parameter
        $id=trim($_GET["id"]);

        //prepare a select statement
        $sql="select * from bandoc where id=?";
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
                    $id=$row["id"];
                    $mabd = $row["mabd"];
                    $tenbd=$row["tenbd"];
                    $diachi=$row["diachi"];
                    $email=$row["email"];
                    $sdt=$row["sdt"];
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
                        <label for="">Mã bạn đọc</label>
                        <input type="text" name="mabd" class="form-control
                               <?php echo (!empty($mabd_err))? 'is-invalid' : '' ;?>" value="<?php echo $mabd;?>">
                        <span class="invalid-feedback"><?php echo $mabd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Tên bạn đọc</label>
                        <input type="text" name="tenbd" class="form-control
                               <?php echo (!empty($tenbd_err))? 'is-invalid' : '' ;?>" value="<?php echo $tenbd;?>">
                        <span class="invalid-feedback"><?php echo $tenbd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control
                               <?php echo (!empty($diachi_err))? 'is-invalid' : '' ;?>" value="<?php echo $diachi;?>">
                        <span class="invalid-feedback"><?php echo $diachi_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control
                               <?php echo (!empty($email_err))? 'is-invalid' : '' ;?>" value="<?php echo $email;?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </div>
                     <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control
                               <?php echo (!empty($sdt_err))? 'is-invalid' : '' ;?>" value="<?php echo $sdt;?>">
                        <span class="invalid-feedback"><?php echo $sdt_err;?></span>
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
