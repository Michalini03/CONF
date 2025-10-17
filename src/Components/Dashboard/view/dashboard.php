<?php
/*if (!isset($_SESSION['user_id'])) {
    header("Location: /CONF/login");
    exit;
}*/

require __DIR__ . '/../../../Shared/header.php';
?>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p>You are logged in 🎉</p>
    <?php else: ?>
        <p>Please <a href="/CONF/login">log in</a> to access the dashboard.</p>
    <?php endif; ?>
</body>
</html>