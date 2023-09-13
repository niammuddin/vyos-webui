<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /index.php");
    exit;
}

// Define username and password
$admin_username = "admin";
$admin_password = "admin";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["username"] == $admin_username && $_POST["password"] == $admin_password){
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $admin_username;
        header("location: /index.php");
    } else{
        $login_err = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>    
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" type="image/x-icon" href="./assets/images/icon/vyos-icon.png">

<!-- Theme CSS -->
<link rel="stylesheet" type="text/css" href="./assets/css/theme.min.css">

<!-- sweetalert2 -->
<script src="./assets/js/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/sweetalert2.min.css">

<style>
    .swal2-popup {font-size: small !important;}
</style>

</head>

<body>
 <main class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
      <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <a href="#" class="form-check form-switch theme-switch btn btn-light btn-icon rounded-circle d-none ">
          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
  
           </a>
        <!-- Card -->
        <div class="card smooth-shadow-md">
          <!-- Card body -->
          <div class="card-body p-6">
            <div class="mb-4">
              <a href="#"><img src="./assets/images/svg/vyos.svg" class="mb-2 text-inverse" alt="Image" width="50px"></a>
              <p class="mb-6">Please enter your user information.</p>
            </div>
            <!-- Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <!-- Username -->
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" name="username" placeholder="Username address here" required="">
              </div>
              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="**************" required="">
              </div>
              <!-- Checkbox -->
              <div class="d-lg-flex justify-content-between align-items-center
                  mb-4">
                <div class="form-check custom-checkbox">
                  <input type="checkbox" class="form-check-input" id="rememberme">
                  <label class="form-check-label" for="rememberme">Remember
                      me</label>
                </div>

              </div>
              <div>
                <!-- Button -->
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Sign
                    in</button>
                </div>


              </div>

              <?php
    if(isset($login_err)){
        echo '<script>';
        echo 'Swal.fire("Error", "Invalid username or password.", "error");';
        echo '</script>';
    }
?>

            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
