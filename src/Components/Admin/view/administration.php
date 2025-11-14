<?php
if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Panel</title>
    <script src="/src/Components/Admin/scripts/UserManagement.js"></script>
</head>
<body>
    <header>
        <h1>Administration Panel</h1>
    </header>
    <main>
        <div id="user-management" class="container">
            <?php if($_SESSION['access_rights'] == 3): ?>
            <h2>Admin Management</h2>
            <div id="admin-list" class="container">
                <!-- Admin list will be dynamically loaded here -->

            </div>
            <?php endif; ?>
            <h2>User Management</h2>
            <div id="user-list" class="container">
                <!-- User list will be dynamically loaded here -->
            </div>
        </div>
    </main>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var access_rights = <?php echo json_encode($_SESSION['access_rights']); ?>;
        setupRightsMap(access_rights);
        loadUsers();
        <?php if($_SESSION['access_rights'] == 3): ?>
        loadAdmins();
        <?php endif; ?>
    });
</script>