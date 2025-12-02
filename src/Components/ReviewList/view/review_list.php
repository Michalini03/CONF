<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}

if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
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
    <title>Review List</title>
</head>
      <body>
      <header>
            <h1>My Reviews</h1>
            
      </header>
      <main>
            <div id="review-list" class="container">
                  <!-- Articles will be dynamically loaded here -->
            </div>
      </main>

      <div id="review-modal" class="modal" style="display: none;">
            <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title">Review an article</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                              <form id="review-form">
                                    <div class="mb-3">
                                          <label for="create-article-content" class="form-label">Review:</label>
                                          <textarea class="form-control" id="create-article-desc" rows="5" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" onclick="addReview(event)">Review Article</button>
                              </form>
                        </div>
                  </div>
            </div>
      </div>

      </body>
</html>

<script>
      // Load Reviews when the page is ready
      
</script>