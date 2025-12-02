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
    <title>Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Hero Section (Welcome) */
        .dashboard-hero {
            background: linear-gradient(135deg, #1e1e1e 0%, #2c2c2c 100%);
            border-bottom: 3px solid #198754;
            padding: 3rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        /* Search Bar Styling */
        .search-container {
            max-width: 600px;
            margin: 0 auto 2rem auto;
        }
        .form-control-dark {
            background-color: #2c2c2c;
            border: 1px solid #444;
            color: #fff;
            padding: 0.75rem 1.25rem;
        }
        .form-control-dark:focus {
            background-color: #2c2c2c;
            border-color: #198754;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
        .form-control-dark::placeholder {
            color: #adb5bd;
        }

        /* Card Styling (For items injected by JS) */
        /* Note: Your DashboardHandler.js should use these classes */
        .dashboard-card {
            background-color: #2c2c2c;
            border: 1px solid #333;
            transition: transform 0.2s;
            border-radius: 8px;
            overflow: hidden;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            border-color: #198754;
        }

        /* Pagination Styling */
        .pagination-container {
            background-color: #1e1e1e;
            padding: 1rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            border: 1px solid #333;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .paging-btn {
            color: #198754;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
        }
        .paging-btn:hover {
            color: #fff;
            transform: scale(1.2);
        }
    </style>

    <script src="/src/Components/Dashboard/scripts/DashboardHandler.js"></script>
</head>

<body>
    
    <div class="dashboard-hero text-center">
        <div class="container">
            <?php if (isset($_SESSION['user_id'])): ?>
                <h1 class="display-5 fw-bold text-white">
                    Welcome, <span class="text-success"><?= htmlspecialchars($_SESSION['username']) ?></span>!
                </h1>
                <p class="lead  mb-0">Explore the latest articles and updates. 🚀</p>
            <?php else: ?>
                <h1 class="display-5 fw-bold text-white">Welcome to the Dashboard!</h1>
                <p class="lead ">Join our community to access full features.</p>
                <div class="mt-3">
                    <a href="/login" class="btn btn-success px-4">Log In</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mb-5">
        
        <div class="search-container">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control form-control-dark" placeholder="Search articles..." aria-label="Search" aria-describedby="search-addon">
                <button class="btn btn-success" type="button" id="search-addon">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div id="dashboard-list" class="row g-4">
             <div class="col-12 text-center  py-5">
                 <div class="spinner-border text-success" role="status"></div>
                 <p class="mt-2">Loading content...</p>
             </div>
        </div>

        <div id="number-pages" class="container mt-5 text-center">
            <div class="pagination-container gap-4">
                
                <i id="left-paging" class="bi bi-arrow-left-circle-fill fs-3 paging-btn"></i>

                <div class="d-flex flex-column justify-content-center">
                    <div>
                        <span id="current-view-num" class="fw-bold text-white fs-5">0 – 0</span>
                        <span class=" mx-1">of</span>
                        <span id="complete-view-num" class="fw-bold text-success fs-5">0</span>
                    </div>
                </div>

                <i id="right-paging" class="bi bi-arrow-right-circle-fill fs-3 paging-btn"></i>
                
            </div>
        </div>

    </div>

</body>
</html>

<script>
    // Load articles when the page is ready
    document.addEventListener('DOMContentLoaded', function() {
        const isUserLogged = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;
        
        if(typeof drawArticles === 'function') {
            drawArticles(isUserLogged);
        }
    });
</script>