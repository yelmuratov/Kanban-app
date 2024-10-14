<?php
  use App\Helper\Helper;
  Helper::checkGuest(); // Ensure that only guests can access the registration page
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="/"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <!-- Action set to /register_user, method POST -->
      <form action="/register" method="POST" id="registerForm" onsubmit="return validatePasswords()">
        <!-- Full Name -->
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- Email -->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- Error Message for Password Mismatch -->
        <div class="input-group mb-3" id="password-error" style="display: none;">
          <div class="alert alert-danger w-100">
            <strong>Error!</strong> Passwords do not match.
          </div>
        </div>

        <!-- Register Button -->
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <!-- Already have an account -->
      <a href="/login" class="text-center">I already have a membership</a>
    </div>
    <!-- /.register-card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<!-- JavaScript for password confirmation -->
<script>
  function validatePasswords() {
    var password = document.getElementById('password').value;
    var passwordConfirmation = document.getElementById('password_confirmation').value;

    if (password !== passwordConfirmation) {
      document.getElementById('password-error').style.display = 'block';
      return false; // Prevent form submission
    }

    document.getElementById('password-error').style.display = 'none';
    return true; // Allow form submission
  }
</script>

</body>
</html>
