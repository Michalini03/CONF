<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Conferention</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/login.page.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        
    </style>

    <script src="/src/Components/Login/scripts/LoginUser.js"></script>
    <script src="/src/Components/Login/scripts/RegisterUser.js"></script>
</head>
<body>

    <div class="container d-flex justify-content-center">
        
        <div class="auth-card">
            <h1 class="brand-title">Conferention</h1>
            
            <div id="message" class="mb-3"></div>

            <div id="login-form" class="form-content">
                <h2 class="form-title"><i class="bi bi-box-arrow-in-right"></i> Login</h2>
                <form onsubmit="event.preventDefault();">
                    
                    <div class="mb-3">
                        <label for="login-username" class="form-label  small">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" id="login-username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="login-password" class="form-label  small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="login-password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100" onclick="submitLogin(event)">Log In</button>
                </form>

                <div id="register-redirect" class="text-center mt-3 small ">
                    <p>Don't have an account? <a href="#" onclick="changeToRegister()">Register here</a></p>
                </div>
            </div>

            <div id="register-form" class="form-content" style="display:none;">
                <h2 class="form-title"><i class="bi bi-person-plus-fill"></i> Register</h2>
                <form onsubmit="event.preventDefault();">
                    
                    <div class="mb-3">
                        <label for="register-username" class="form-label  small">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="register-username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="register-password" class="form-label small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="register-password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="register-confirm-password" class="form-label small">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-check-lg"></i></span>
                            <input type="password" class="form-control" id="register-confirm-password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100" onclick="submitRegistration(event)">Create Account</button>
                </form>

                <div id="login-redirect" class="text-center mt-3 small">
                    <p>Already have an account? <a href="#" onclick="changeToLogin()">Login here</a></p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>