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
    <title>Article List</title>
     <script src="/src/Components/ArticleList/scripts/ListLoader.js"></script>
      <script src="/src/Components/ArticleList/scripts/EditArticle.js"></script>
      <script src="/src/Components/ArticleList/scripts/CreateArticle.js"></script>
      <script src="/src/Components/ArticleList/scripts/DeleteArticle.js"></script>
</head>
      <body>
      <header>
            <h1>My Articles</h1>
            
      </header>
      <main>
            <div id="article-list" class="container">
                  <!-- Articles will be dynamically loaded here -->
            </div>
            <button id="create-article-button" class="btn btn-primary" onclick="showCreateModal()">Create New Article</button>
      </main>

      <div id="edit-modal" class="modal" style="display: none;">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Edit Article</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                        <form id="edit-article-form">
                              <div class="mb-3">
                                    <label for="edit-article-title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="edit-article-title" required>
                              </div>
                              <div class="mb-3">
                                    <label for="edit-article-content" class="form-label">Description</label>
                                    <textarea class="form-control" id="edit-article-desc" rows="5"></textarea>
                              </div>
                              <div class="mb-3">
                                    <label for="edit-article-upload" class="form-label">PDF File</label>
                                    <input type="file" class="form-control" id="edit-article-file" rows="1" accept="application/pdf"></input>
                              </div>
                              <input type="hidden" id="edit-article-id">
                              <button type="submit" class="btn btn-primary" onclick="submitArticleEdit(event)">Save changes</button>
                        </form>
                  </div>
                  </div>
              </div>
      </div>

      <div id="delete-modal" class="modal" style="display: none;">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Delete Article</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <p>Are you sure you want to delete this article?</p>
                      <input type="hidden" id="delete-article-id">
                          <button type="button" class="btn btn-danger" id="confirm-delete-article">Delete</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  </div>
            </div>
      </div>
      </div>

      <div id="create-modal" class="modal" style="display: none;">
            <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title">Create New Article</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                              <form id="create-article-form">
                                    <div class="mb-3">
                                          <label for="create-article-title" class="form-label">Title</label>
                                          <input type="text" class="form-control" id="create-article-title" required>
                                    </div>
                                    <div class="mb-3">
                                          <label for="create-article-content" class="form-label">Description</label>
                                          <textarea class="form-control" id="create-article-desc" rows="5" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                          <label for="create-article-upload" class="form-label">PDF File</label>
                                          <input type="file" class="form-control" id="create-article-file" accept="application/pdf" rows="1" required></input>
                                    </div>
                                    <button type="submit" class="btn btn-primary" onclick="createNewArticle(event)">Create Article</button>
                              </form>
                        </div>
                  </div>
            </div>
      </div>

      </body>
</html>

<script>
      // Load articles when the page is ready
      document.addEventListener('DOMContentLoaded', function() {
            const userAccessRights = <?php echo json_encode($_SESSION['access_rights']); ?>;
            const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
            renderArticleList(userAccessRights, userId);
      });
</script>