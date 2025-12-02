<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}

if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 1) {
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
    <title>My Articles</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/article_list.page.css">

    <script src="/src/Components/ArticleList/scripts/ListLoader.js"></script>
    <script src="/src/Components/ArticleList/scripts/EditArticle.js"></script>
    <script src="/src/Components/ArticleList/scripts/CreateArticle.js"></script>
    <script src="/src/Components/ArticleList/scripts/DeleteArticle.js"></script>
</head>
<body>

    <header class="page-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 m-0"><i class="bi bi-journal-text text-success"></i> My Articles</h1>
                <p class="lead mb-0" style="color: #adb5bd;">Manage your submissions and publications</p>
            </div>
            <button class="btn btn-success btn-lg" onclick="showCreateModal()">
                <i class="bi bi-plus-lg"></i> New Article
            </button>
        </div>
    </header>

    <main>
        <div class="container">
            <div id="article-list" class="row g-4">
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2">Loading your articles...</p>
                </div>
            </div>
        </div>
    </main>

    <div id="edit-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-article-form">
                        <div class="mb-3">
                            <label for="edit-article-title" class="form-label text-success">Title</label>
                            <input type="text" class="form-control" id="edit-article-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-article-desc" class="form-label text-success">Description</label>
                            <textarea class="form-control" id="edit-article-desc" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-article-file" class="form-label text-success">Update PDF (Optional)</label>
                            <input type="file" class="form-control" id="edit-article-file" accept="application/pdf">
                            <div class="form-text" style="color: whitesmoke">Leave empty to keep the current file.</div>
                        </div>
                        <input type="hidden" id="edit-article-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitArticleEdit(event)">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Delete Article</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="fs-5">Are you sure you want to delete this article?</p>
                    <p class="small">This action cannot be undone.</p>
                    <input type="hidden" id="delete-article-id">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-article">Yes, Delete It</button>
                </div>
            </div>
        </div>
    </div>

    <div id="create-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success"><i class="bi bi-plus-circle-fill"></i> Create New Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="create-article-form">
                        <div class="mb-3">
                            <label for="create-article-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="create-article-title" placeholder="Enter article title..." required>
                        </div>
                        <div class="mb-3">
                            <label for="create-article-desc" class="form-label">Description</label>
                            <textarea class="form-control" id="create-article-desc" rows="5" placeholder="Enter a brief abstract..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create-article-file" class="form-label">PDF File</label>
                            <input type="file" class="form-control" id="create-article-file" accept="application/pdf" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="createNewArticle(event)">Create Article</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
                const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
                
                // Clear the loading spinner before rendering if your render function doesn't clear the container
                // document.getElementById('article-list').innerHTML = ''; 
                
                if (typeof renderArticleList === 'function') {
                    renderArticleList(userId);
                }
          });

          // Helper function to open modal (if your external scripts don't handle Bootstrap 5)
          function showCreateModal() {
              var myModal = new bootstrap.Modal(document.getElementById('create-modal'));
              myModal.show();
          }
    </script>
</body>
</html>