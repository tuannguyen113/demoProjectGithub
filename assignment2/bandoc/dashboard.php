<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/jquery-3.5.1.min.js">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 form-inline justify-content-between">
                    <h2>Bảng hiển thị</h2>
                    <a href="create.php" class="btn btn-success "><i class="fa fa-plus"></i>Add New Employee</a>
                </div>
                <?php
                require_once "../connect/config.php";
                $sql="select * from bandoc";
                if ($result=$mysqli->query($sql)) {
                    if ($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Mã bạn đọc</th>";
                        echo "<th>Tên bạn đọc</th>";
                        echo "<th>Địa chỉ</th>";
                        echo "<th>Email</th>";
                        echo "<th>Số điện thoại</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row['mabd'] . "</td>";
                            echo "<td>" . $row['tenbd'] . "</td>";
                            echo "<td>" . $row['diachi'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['sdt'] . "</td>";
                            echo "<td class='form-inline justify-content-center'>";
                            echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3"
                                                    title="update record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?id=' . $row['id'] . '" class="mr-3"
                                                    title="update record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo '</<table>';
                        $result->free();
                    } else {
                        echo '<div class="alert alert-danger"><em>Không tìm thấy bản ghi nào</em></div>';
                    }
                }else{
                    echo "Rất tiếc!Đã xảy ra lỗi.Vui lòng thử lại sau.";
                }
                $mysqli->close();
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>