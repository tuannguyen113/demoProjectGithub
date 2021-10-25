<?php
require_once "../connect/config.php";
if (isset($_POST["id"]) && !empty($_POST["id"])){
    require_once "../connect/config.php";
    $sql="delete from sach where id=?";
    if ($stmt=$mysqli->prepare($sql)){
        $stmt->bind_param("i",$param_id);
        $param_id=trim($_POST["id"]);
        if ($stmt->execute()){
            header("location:dashboard.php");
            exit();
        }else{
            echo "Rất tiếc!Đã xảy ra lỗi.Vui lòng thử lại sau";
        }
    }$stmt->close();
    $mysqli->close();
}else{
    if (empty(trim($_GET["id"]))){
        header("location:error.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xóa bản ghi</title>
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
                <div class="h2 mt-5 mb-3">Xóa bản ghi</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="alert alert-danger">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]);?>"/>
                        <p>Bạn có thật sự muốn xóa bản ghi này không?</p>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="dashboard.php" class="btn btn-secondary ml-2">No</a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>