<?php
require_once "../connect/config.php";
$masach=$tensach=$tacgia=$namxb=$trangthai=$macn="";
$masach_err=$tensach_err=$tacgia_err=$namxb_err=$trangthai_err=$macn_err="";
if ($_SERVER["REQUEST_METHOD"]=="POST"){
//    validate masach
    $input_masach=trim($_POST["masach"]);
    if (empty($input_masach)){
        $masach_err="Vui long nhap ma sach";

    }elseif(strlen($input_masach)!==5){
        $masach_err="Nhap qua gioi han";
   }else{
        $masach=$input_masach;

    }
    //validate tensach
    $input_tensach=trim($_POST["tensach"]);
    if (empty($input_tensach)){
        $tensach_err="Vui long nhap ten sach";
    }else{
        $tensach=$input_tensach;
    }
    //validate tacgia
    $input_tacgia=trim($_POST["tacgia"]);
    if (empty($input_tacgia)){
        $tacgia_err="Vui long nhap ten tac gia";
    }else{
        $tacgia=$input_tacgia;
    }

    //validate nam xuat ban
    $input_namxb=trim($_POST["namxb"]);
    if (empty($input_namxb)){
        $namxb_err="Vui long nhap nam xuat ban";
    }
    elseif (strlen($input_namxb)!==4){
        $namxb_err="Gia tri chua dung dinh dang";
    }else{
        $namxb=$input_namxb;
    }
    //validate trang thai
    $input_trangthai=trim($_POST["trangthai"]);
    if (empty($input_trangthai)){
        $trangthai_err="Vui long nhap trang thai";

    }elseif ($input_trangthai==="chưa xuất bản"){
        $trangthai=$input_trangthai;
    }elseif ($input_trangthai==="xuất bản"){
        $trangthai=$input_trangthai;
    }else{
        $trangthai_err="Trang thai phai la 'chưa xuất bản' hoặc ''xuất bản'. ";
    }
   //validate macn
    $input_macn=trim($_POST["macn"]);
    if (empty($input_macn)){
        $macn_err="Vui long nhap ma chuyen nganh";
    }
    elseif (strlen($input_macn)!==5){
        $macn_err="Ki tu nhap vao chua dung dinh dang";
    }else{
        $macn=$input_macn;
    }

    if (empty($masach_err) && empty($tensach_err) && empty($tacgia_err) && empty($namxb_err) && empty($trangthai_err) && empty($macn_err) ){
        $sql="insert into sach (masach,tensach,tacgia,namxb,trangthai,macn) values (?,?,?,?,?,?)";
        if ($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("sssiss",$param_masach,$param_tensach,$param_tacgia,$param_namxb,$param_trangthai,$param_macn);
            $param_masach=$masach;
            $param_tensach=$tensach;
            $param_tacgia=$tacgia;
            $param_trangthai=$trangthai;
            $param_namxb=$namxb;
            $param_macn=$macn;
            if ($stmt->execute()){
                header("location:dashboard.php");
                exit();
            }else{
                echo "Rất tiếc!Đã xảy ra lỗi.Vui lòng thử lại";
                echo $stmt->error;
            }
        }$stmt->close();
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
                    <h2 class="text-center">Tạo bản ghi</h2>
                    <p>Vui lòng nhập đầy đủ thông tin vào biểu mẫu </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="">Mã sách</label>
                            <input type="text" name="masach" class="form-control
                                <?php echo (!empty($masach_err))? 'is-invalid' : '';?>" value="<?php echo $masach;?>">
                            <span class="invalid-feedback"><?php echo $masach_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Tên sach</label>
                            <input type="text" name="tensach" class="form-control
                                <?php echo (!empty($tensach_err))? 'is-invalid' : '';?>" value="<?php echo $tensach;?>">
                            <span class="invalid-feedback"><?php echo $tensach_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Tác giả</label>
                            <input type="text" name="tacgia" class="form-control
                                <?php echo (!empty($tacgia_err))? 'is-invalid' : '';?>" value="<?php echo $tacgia;?>">
                            <span class="invalid-feedback"><?php echo $tacgia_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Năm xuất bản</label>
                            <input type="text" name="namxb" class="form-control
                                <?php echo (!empty($namxb_err))? 'is-invalid' : '';?>" value="<?php echo $namxb;?>">
                            <span class="invalid-feedback"><?php echo $namxb_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <input type="text" name="trangthai" class="form-control
                                <?php echo (!empty($trangthai_err))? 'is-invalid' : '';?>" value="<?php echo $trangthai;?>">
                            <span class="invalid-feedback"><?php echo $trangthai_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Mã chuyên ngành</label>
                            <input type="text" name="macn" class="form-control
                                <?php echo (!empty($macn_err))? 'is-invalid' : '';?>" value="<?php echo $macn;?>">
                            <span class="invalid-feedback"><?php echo $macn_err;?></span>
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
