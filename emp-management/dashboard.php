<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !==true){
    header(("location:login.php"));
    exit;
}
?>
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
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="text-center">Employees Details</h2>
                </div>
                <div class="mt-5 mb-3 clearfix form-inline justify-content-around">
                    <form class="form-inline" method="GET">
                        <input class="form-control mr-sm-2" name="key" type="search" placeholder="Search"
                               value="<?php if(isset($_GET["key"])) {echo $_GET["key"];} ?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <a href="dashboard.php" class="btn btn-success">ALL</a>
                    <a href="create.php" class="btn btn-success "><i class="fa fa-plus"></i>Add New Employee</a>
                </div>
                <?php
                require_once "config.php";
                if (isset($_GET["key"]) && !empty($_GET["key"])){
                    $keyword=trim($_GET["key"]);
                    $sql="SELECT * FROM employees WHERE name LIKE '%$keyword%' OR address LIKE '%$keyword%' OR salary LIKE '%$keyword%' ";
                }else{
                    $sql="SELECT * FROM employees";
                }
                
                //include config file
//                require_once "config.php";

                //attempt select query execution
//                $sql="select * from employees";
                if ($result=$mysqli->query($sql)){
                    if ($result->num_rows>0){
                        echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Name</th>";
                                    echo "<th>Address</th>";
                                    echo "<th>Salary</th>";
                                    echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row=$result->fetch_array()){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['address'] . "</td>";
                                    echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td>";
                                        echo '<a href="read.php?id='.$row['id'].'" class="mr-3"
                                                    title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                        echo '<a href="update.php?id='.$row['id'].'" class="mr-3"
                                                    title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                        echo '<a href="delete.php?id='.$row['id'].'" class="mr-3"
                                                    title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</td>";
                                echo "</tr>";


                            }
                            echo "</tbody>";
                            echo "</table>";
                            //free result set
                            $result->free();
                        }else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    }else{
                        echo "Oops! Something went wrong.Please try again later.";
                    }
                    //close connection
                    $mysqli->close();
                ?>
            </div>
        </div>
    </div>
    <p><a href="logout.php" class="btn btn-danger ml-3">Sign Put of Your Account</a></p>
</div>
</body>
</html>
