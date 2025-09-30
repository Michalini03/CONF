<?php
if (!isset($_SESSION['user'])) {
    header("Location: /myapp/public/login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/myapp/public/css/style.css">
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
    <p>You are logged in 🎉</p>
    <a href="/CONF/logout">Logout</a>
</body>
</html>
