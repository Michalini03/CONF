<?php
/*if (!isset($_SESSION['user_id'])) {
    $_SESSION['access_rights'] = 0;
    exit;
}*/

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