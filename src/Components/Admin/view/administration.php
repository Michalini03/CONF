<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}

if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 3) {
    header('Location: /');
    exit;
}
?>

<?php include_once __DIR__ . '/../../../Shared/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Panel</title>
    <script src="/src/Components/Admin/scripts/UserManagement.js"></script>
    <script src="/src/Components/Admin/scripts/ArticleManagement.js"></script>
</head>
<body>
    <header>
        <h1>Administration Panel</h1>
    </header>
    <main>
        <div id="user-management" class="container">
            <?php if($_SESSION['access_rights'] == 4): ?>
            <h2>Admin Management</h2>
            <div id="admin-list" class="container">
                <!-- Admin list will be dynamically loaded here -->

            </div>
            <?php endif; ?>
            <h2>User Management</h2>
            <div id="user-list" class="container">
                <!-- User list will be dynamically loaded here -->
            </div>
            <h2>Assign reviewer to article</h2>
            <div id="article-assign-list" class="container">
                <!-- User list will be dynamically loaded here -->
            </div>
            <h2>Approve article</h2>
            <div id="article-assign-list" class="container">
                <!-- User list will be dynamically loaded here -->
            </div>
        </div>
    </main>

    <div id="approve-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted mb-2">Review Content:</p>
                    <div id="review-text" class="p-3 bg-light border rounded">
                        <span class="text-secondary font-italic">Loading review text...</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btn-decline">Decline</button>
                    <button type="button" class="btn btn-success" id="btn-approve">Approve</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

    


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var access_rights = <?php echo json_encode($_SESSION['access_rights']); ?>;
        setupRightsMap(access_rights);
        loadUsers();
        <?php if($_SESSION['access_rights'] == 4): ?>
        loadAdmins();
        <?php endif; ?>
        loadArticles();
    });
</script>