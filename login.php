<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

$login = false;
include('connection.php');

if (isset($_POST['submit'])) {
    $username = SQLite3::escapeString($_POST['user']);
    $password = $_POST['pass'];

    $query = $conn->query("SELECT * FROM signup WHERE username = '$username' OR email = '$username'");
    $row = $query->fetchArray(SQLITE3_ASSOC);

    if ($row) {
        if (password_verify($password, $row["password"])) {
            $login = true;
            session_start();

            $query_username = $conn->query("SELECT username FROM signup WHERE username = '$username' OR email = '$username'");
            $result_username = $query_username->fetchArray(SQLITE3_ASSOC);

            $_SESSION['username'] = $result_username['username'];
            $_SESSION['loggedin'] = true;
            header("Location: welcome.php");
            exit();
        }
    } else {
        echo '<script>
                alert("Login failed. Invalid username or password!!");
                window.location.href = "login.php";
            </script>';
        exit();
    }
}
?>

<?php 
include("connection.php");
include("navbar.php");
?>

<html lang="en">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br><br>
    <div id="form">
        <h1 id="heading">Login Form</h1>
        <form name="form" action="login.php" method="POST" onsubmit="return isValid()">
            <label>Enter Username/Email: </label>
            <input type="text" id="user" name="user" required><br><br>
            <label>Password: </label>
            <input type="password" id="pass" name="pass" required><br><br>
            <input type="submit" id="btn" value="Login" name="submit">
        </form>
    </div>
    <script>
        function isValid() {
            var user = document.form.user.value;
            if (user.length == 0) {
                alert("Enter username or email id!");
                return false;
            }
        }
    </script>
</body>
</html>
