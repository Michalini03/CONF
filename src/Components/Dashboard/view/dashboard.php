<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/dashboard.page.css">
    <script src="/src/Components/Dashboard/scripts/DashboardHandler.js"></script>
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p>See what's new! 🚀</p>
    <?php else: ?>
        <h1>Welcome to the Dashboard!</h1>
        <p>Please <a href="/login">log in</a> to access your dashboard features.</p>
    <?php endif; ?>

    <div class="dashboard-widgets container">
        <!-- Dashboard widgets will be dynamically loaded here -->
        <div class="search-bar">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
                <button class="btn btn-secondary" type="button" id="search-addon">
                        <i class="fas fa-search"></i>
                    </button>
            </div>

            <div id="search-results" class="container">
                <!-- Search results will be dynamically loaded here -->
                
            </div>

            <div id="number-pages" class="container">
                <p><span id="current-view-num">1 - 10</span> of <span id="complete-view-num">100</span></p>
            </div>
    </div>
</body>
</html>

<script>
    // Load articles when the page is ready
    document.addEventListener('DOMContentLoaded', function() {
        const isUserLogged = <?php
            if (isset($_SESSION['user_id'])) {
                echo 'true';
            } else {
                echo 'false';
            }
        ?>;
        drawArticles(isUserLogged);
    });
</script>