<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/login.page.css">
        <!-- Custom JS for login and registration -->
    <script src="/src/Components/Login/scripts/LoginUser.js"></script>
    <script src="/src/Components/Login/scripts/RegisterUser.js"></script>
        <!-- jQuery (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    
    <div class="container mt-4">
    <h1 class="text-center heading">Welcome to Conferention</h1>
    <div id="login-form" class="form">
        <h2>Login</h2>
        <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="input" class="form-control" id="login-username" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="login-password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary" onclick="submitLogin(event)">Submit</button>
        </form>

        <div id="register-redirect">
                <p>Don't have an account? <a href="#" onclick="changeToRegister()">Register here</a></p>
        </div>
    </div>

    <div id="register-form" style="display:none;" class="form">
        <h2>Register</h2>
        <form>
                <div class="mb-3">
                    <label for="register-username" class="form-label">Username</label>
                    <input type="input" class="form-control" id="register-username" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="register-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="register-password">
                </div>
                <div class="mb-3">
                    <label for="register-confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password">
                </div>
                <button type="submit" class="btn btn-primary" onclick="submitRegistration(event)">Submit</button>
        </form>
        <div id="login-redirect">
                <p>Already have an account? <a href="#" onclick="changeToLogin()">Login here</a></p>
        </div>

    </div>

    <div id="message"></div>
    </div>

</body>
</html>
