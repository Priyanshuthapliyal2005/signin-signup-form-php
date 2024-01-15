<?php
// Include the SQLite connection script
include "connection.php";

// Check if the user is authenticated
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Assuming you have a "signup" table with columns "id", "username", and "email"
$query = "SELECT id, username, email FROM signup";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="overflow:hidden;">

    <?php 
        include "navbar.php";
    ?>

    <div class="container mt-4">
        <h1>Signup Table</h1>

        <?php
        // Check if there are rows in the result set
        if ($result) {
            echo '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Fetch each row from the result set
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                echo '<tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['username'] . '</td>
                        <td>' . $row['email'] . '</td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No signups found</p>';
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
