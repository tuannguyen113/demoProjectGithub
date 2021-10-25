<?php
//Initialize the session
session_start();

//check if the user is already logged im. if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}

//Include config file
require_once "config.php";

//define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    }else{
        $username = trim($_POST["username"]);
    }

//check if password is empty
if(empty(trim($_POST["password"]))){
    $password_err = "Please enter your password.";
} else{
    $password = trim($_POST["password"]);
}

//validate credentials
if(empty($username_err) && empty($password_err)){
    //prepare a select statement
    $sql = "SELECT id, username, password FROM user1 WHERE username = ?";

    if($stmt = $mysqli->prepare($sql)){
        //bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_username);

        //set parameters
        $param_username = $username;

        //attempt to execute the prepared statement
        if($stmt->execute()){
            //store result
            $stmt->store_result();

            //check if username exists, if yes then verify password
            if($stmt->num_rows == 1){
                //bind result variables
                $stmt->bind_result($id, $username, $hashed_password);
                if($stmt->fetch()){
                    if(password_verify($password, $hashed_password)){
                        //password is correct, so start a new session
                        session_start();

                        //store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        //redirect user to welcome page
                        header("location: dashboard.php");
                    } else{
                        //password is not valid, display a generic error message
                        $login_err = "Invalid username of password.";
                    }
                }
            }else{
                //username doesn't exist, display a generic error message
                $login_err = "Invalid username or password.";
            }
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        //Close statement
        $stmt->close();
    }
}

//close connectionn
$mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper
        {   width:600px ;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>