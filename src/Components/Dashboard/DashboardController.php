<?php
if (!isset($_SESSION['user'])) {
    header("Location: /myapp/public/login");
    exit;
}

require __DIR__ . '/../../Shared/header.php';
?>

<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
    <p>You are logged in 🎉</p>
</body>
</html>
