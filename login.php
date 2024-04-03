<?php
session_start(); // always start the session

// Check if the user is logged in, if yes destroy it
if (isset($_SESSION['u'])) {
    // Destroy the session para totally forgot na ng website yung session/cookies
    session_destroy();
}
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/login.css" />
    <title>Sign in & Sign up Form</title>
    <style>
      .forgot-password {
          text-align: right;
          margin-top: 10px;
          width: 100%;
      }
      .forgot-password a {
          color: #333;
          text-decoration: none;
          font-size: 14px;
      }
      .contains {
          position: relative;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <!-- form for sign in -->
          <form class="sign-in-form" id="loginForm" method="post">
            <h2 class="title">Sign in</h2>
            <div class="contains"> <!-- Updated class name to "contains" -->
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Username" name="username" required/>
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="password" required/>
              </div>
              <div class="forgot-password">
                <a href="forgot.php">Forgot Password?</a>
              </div>
            </div>
            <button type='submit' name='login_btn' id="loginBtn" class='btn'>LOGIN</button>
          </form>
          <!-- form for sign up  -->
          <form action="verify.php" method="post" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username"  name="username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" required/>
            </div>
            <button type='submit' name='register_btn' class='btn'>SIGN UP</button>
          </form>
        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
                Ready to ship with ease? Sign up now and experience seamless freight management!
            </p>
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
                Welcome aboard the kargada freight services! Join us and experience seamless shipping like never before.
            </p>
            <button class="btn transparent" id="sign-in-btn">Sign in</button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
      document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Disable the login button to prevent multiple submissions
        document.getElementById('loginBtn').disabled = true;

        var formData = new FormData(this);

        // Send AJAX request to auth.php
        fetch('auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.status
            });
            document.getElementById('loginBtn').disabled = false;
            setTimeout(() => {
              location.reload();
          }, 20000);
          } else if (data.redirect) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Successful!'
            }).then(() => {
                // Redirect the user after showing the success message
                window.location.href = data.redirect;
            });
          } else {
            // If no status or redirect URL is provided
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Login failed. Please try again later.'
            });
            document.getElementById('loginBtn').disabled = false;
          }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred. Please try again later.'
            });
            // Re-enable the login button in case of error
            document.getElementById('loginBtn').disabled = false;
        });
      });
    </script>
    <!-- javascript for login -->
    <script src="./assets/js/login.js"></script>
  </body>
  </html>
