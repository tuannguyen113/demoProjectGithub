<?php
require_once "../connect/config.php";
$mabd=$tenbd=$diachi=$email=$sdt="";
$mabd_err=$tenbd_err=$diachi_err=$email_err=$sdt_err="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //validate mabd
    $input_mabd=trim($_POST["mabd"]);
    if (empty($input_mabd)){
        $mabd_err="Vui lòng nhập mã bạn đọc";
    }elseif(strlen($input_mabd)>5){
        $mabd_err="Nhập tối đa 5 kí tự";
    }else{
        $mabd=$input_mabd;
    }

    //validate tenbd
    $input_tenbd=trim($_POST["tenbd"]);
    if (empty($input_tenbd)){
        $tenbd_err="Vui lòng nhập tên bạn đọc";
    }else {
        $tenbd = $input_tenbd;
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

    if (empty($mabd_err) && empty($tenbd_err) && empty($diachi_err) &&empty($email_err) && empty($sdt_err)){
        $sql="Insert into bandoc (mabd,tenbd,diachi,email,sdt) values (?,?,?,?,?)";
        if ($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("ssssi",$param_mabd,$param_tenbd,$param_diachi,$param_email,$param_sdt);

            $param_mabd=$mabd;
            $param_tenbd=$tenbd;
            $param_diachi=$diachi;
            $param_email=$email;
            $param_sdt=$sdt;
            if ($stmt->execute()){
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
                <h2 class="mt-5">Tạo bản ghi</h2>
                <p>Vui lòng nhập đầy đủ thông tin vào biểu mẫu </p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="">Mã bạn đọc</label>
                        <input type="text" name="mabd" class="form-control
                                <?php echo (!empty($mabd_err))? 'is-invalid' : '';?>" value="<?php echo $mabd;?>">
                        <span class="invalid-feedback"><?php echo $mabd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Tên bạn đọc</label>
                        <input type="text" name="tenbd" class="form-control
                                <?php echo (!empty($tenbd_err))? 'is-invalid' : '';?>" value="<?php echo $tenbd;?>">
                        <span class="invalid-feedback"><?php echo $tenbd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control
                                <?php echo (!empty($diachi_err))? 'is-invalid' : '';?>" value="<?php echo $diachi;?>">
                        <span class="invalid-feedback"><?php echo $diachi_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control
                                <?php echo (!empty($email_err))? 'is-invalid' : '';?>" value="<?php echo $email;?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control
                                <?php echo (!empty($sdt_err))? 'is-invalid' : '';?>" value="<?php echo $sdt;?>">
                        <span class="invalid-feedback"><?php echo $sdt_err;?></span>
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
