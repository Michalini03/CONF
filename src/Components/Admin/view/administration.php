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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/admin.page.css">
    

    <script src="/src/Components/Admin/scripts/UserManagement.js"></script>
    <script src="/src/Components/Admin/scripts/ArticleManagement.js"></script>
</head>
<body>

    <header class="admin-header">
        <div class="container">
            <h1 class="display-6">
                <i class="bi bi-shield-lock-fill text-highlight"></i> 
                Administration
            </h1>
            <p class="lead mb-0" style="color: #adb5bd;">Control panel for <span class="text-highlight">users & content</span>.</p>
        </div>
    </header>

    <main>
        <div class="container mb-5">
            
            <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#tab-users" type="button" role="tab">
                        <i class="bi bi-people"></i> Users
                    </button>
                </li>

                <?php if($_SESSION['access_rights'] == 4): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="admins-tab" data-bs-toggle="tab" data-bs-target="#tab-admins" type="button" role="tab">
                        <i class="bi bi-person-badge"></i> Admins
                    </button>
                </li>
                <?php endif; ?>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="assign-tab" data-bs-toggle="tab" data-bs-target="#tab-assign" type="button" role="tab">
                        <i class="bi bi-pen"></i> Assign Reviewers
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approve-tab" data-bs-toggle="tab" data-bs-target="#tab-approve" type="button" role="tab">
                        <i class="bi bi-check2-circle"></i> Approve Articles
                    </button>
                </li>
            </ul>

            <div class="tab-content section-card" id="adminTabsContent">
                
                <div class="tab-pane fade show active" id="tab-users" role="tabpanel">
                    <h4 class="mb-4 text-highlight">User Management</h4>
                    <div id="user-list">
                        <div class="text-center py-4 text-muted">Loading users...</div>
                    </div>
                </div>

                <?php if($_SESSION['access_rights'] == 4): ?>
                <div class="tab-pane fade" id="tab-admins" role="tabpanel">
                    <h4 class="mb-4 text-highlight">Admin Management</h4>
                    <div id="admin-list">
                        <div class="text-center py-4 text-muted">Loading admins...</div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="tab-pane fade" id="tab-assign" role="tabpanel">
                    <h4 class="mb-4 text-highlight">Assign Reviewers</h4>
                    <div id="article-assign-list">
                        <div class="text-center py-4 text-muted">Loading articles...</div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-approve" role="tabpanel">
                    <h4 class="mb-4 text-highlight">Pending Approvals</h4>
                    <div id="article-approve-list">
                        <div class="text-center py-4 text-muted">Loading pending approvals...</div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div id="approve-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Approval: <span id="approve-article-title" class="text-highlight"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">Review Content:</p>
                    <div class="p-3 rounded review-box-dark">
                        <span id="approve-review-text" class="fst-italic">Loading review text...</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <input id="approve-article-id" type="hidden"></input>
                    <button type="button" class="btn btn-outline-danger" id="btn-decline" onclick="setState(event, 5)">Decline</button>
                    <button type="button" class="btn btn-success" id="btn-approve" onclick="setState(event, 4)">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var access_rights = <?php echo json_encode($_SESSION['access_rights']); ?>;
            
            if(typeof setupRightsMap === "function") setupRightsMap(access_rights);
            
            if(typeof loadUsers === "function") loadUsers();
            
            <?php if($_SESSION['access_rights'] == 4): ?>
                if(typeof loadAdmins === "function") loadAdmins();
            <?php endif; ?>
            
            if(typeof loadArticles === "function") loadArticles();
        });
    </script>
</body>
</html>