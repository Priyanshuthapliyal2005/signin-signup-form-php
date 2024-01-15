<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

include("connection.php");

if (isset($_POST['submit'])) {
    $username = SQLite3::escapeString($_POST['user']);
    $email = SQLite3::escapeString($_POST['email']);
    $password = SQLite3::escapeString($_POST['pass']);
    $cpassword = SQLite3::escapeString($_POST['cpass']);

    // Check if username already exists
    $result = $conn->query("SELECT COUNT(*) as count FROM signup WHERE username='$username'");
    $count_user = $result->fetchArray(SQLITE3_ASSOC)['count'];

    // Check if email already exists
    $result = $conn->query("SELECT COUNT(*) as count FROM signup WHERE email='$email'");
    $count_email = $result->fetchArray(SQLITE3_ASSOC)['count'];

    if ($count_user == 0 && $count_email == 0) {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO signup(username, email, password) VALUES('$username', '$email', '$hash')";
            $result = $conn->exec($sql);

            if ($result) {
                header("Location: login.php");
                exit();
            }
        } else {
            echo '<script>
                alert("Passwords do not match");
                window.location.href = "signup.php";
            </script>';
            exit();
        }
    } else {
        if ($count_user > 0) {
            echo '<script>
                window.location.href="index.php";
                alert("Username already exists!!");
            </script>';
            exit();
        }
        if ($count_email > 0) {
            echo '<script>
                window.location.href="index.php";
                alert("Email already exists!!");
            </script>';
            exit();
        }
    }
}

include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="form">
        <h1 id="heading">SignUp Form</h1><br>
        <form name="form" action="signup.php" method="POST">
            <label>Enter Username: </label>
            <input type="text" id="user" name="user" required><br><br>
            <label>Enter Email: </label>
            <input type="email" id="email" name="email" required><br><br>
            <label>Create Password: </label>
            <input type="password" id="pass" name="pass" required><br><br>
            <label>Retype Password: </label>
            <input type="password" id="cpass" name="cpass" required><br><br>
            <input type="submit" id="btn" value="SignUp" name="submit"/>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
