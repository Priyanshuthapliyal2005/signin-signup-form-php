<nav class="navbar navbar-expand-lg bg-body-tertiary pt-3">
  <div class="container-fluid">

    <h1><a class="navbar-brand" href="index.php">NAME</a></h1>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
        </li>
    </ul>

    <form class="d-flex">
        <a class="btn btn-outline-success mx-2" type="submit" href="signup.php">Signup</a>
        <a class="btn btn-outline-primary mx-2" type="submit" href="login.php">Login</a>

        <?php
        // Check if the user is logged in
        // You may need to adjust this condition based on your authentication logic
        $loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

        if ($loggedIn) {
            echo '<a class="btn btn-outline-danger mx-2" type="submit" href="logout.php">Logout</a>';
        }
        ?>
    </form>

  </div>
</nav>
