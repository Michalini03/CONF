<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/CONF/public/css/bootstrap.min.css">
    <script src="/CONF/src/Components/Login/scripts/LoginUser.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
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
      <button type="submit" class="btn btn-primary" onclick="submitLogin()">Submit</button>
    </form>
</body>
</html>
