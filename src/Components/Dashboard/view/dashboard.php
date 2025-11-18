<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}   
?>

<?php include_once __DIR__ . '/../../../Shared/header.php'; ?>

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

            <div id="dashboard-list" class="container">
                <!-- Search results will be dynamically loaded here -->
                
            </div>

            <div id="number-pages" class="container">
                <p class="d-flex align-items-center gap-3 my-2">

                    <!-- Left button -->
                    <svg id="left-paging" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" style="cursor: pointer;" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>

                    <!-- Current page range -->
                    <span id="current-view-num" class="fw-semibold">1 – 10</span>
                    of
                    <!-- Total count -->
                    <span id="complete-view-num" class="fw-semibold">100</span>

                    <!-- Right button -->
                    <svg id="right-paging" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" style="cursor: pointer;" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                    </svg>

                </p>
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