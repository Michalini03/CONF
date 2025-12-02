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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/review.page.css">
    <script src="/src/Components/ReviewList/scripts/reviewHandler.js"></script>
</head>
<body>

    <header class="page-header">
        <div class="container">
            <h1 class="display-6 m-0">
                <i class="bi bi-chat-right-text-fill text-success"></i> My Reviews
            </h1>
            <p class="lead mb-0" style="color: #adb5bd;">Evaluate assigned articles and provide feedback.</p>
        </div>
    </header>

    <main>
        <div class="container">
            <div id="review-list" class="row g-4">
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2 text-muted">Loading assigned reviews...</p>
                </div>
            </div>
        </div>
    </main>

    <div id="review-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-fill text-success"></i> Review Article: 
                        <span id="review-article-title" class="text-white fw-bold"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="review-form">
                        <div class="mb-3">
                            <label for="review-article-text" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="review-article-text" rows="8" placeholder="Write your review here..." required></textarea>
                        </div>
                        <input type="hidden" id="review-article-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="addReview(event)">
                        <i class="bi bi-check-circle"></i> Submit Review
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
                const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
                
                if(typeof renderReviewList === 'function'){
                    renderReviewList(userId);
                }
          });
    </script>
</body>
</html>