function showDeleteModal(articleId) {
    // Open Bootstrap modal
    const deleteModal = new bootstrap.Modal($('#delete-modal')[0]);
    deleteModal.show();

    var $deleteModalConfirm =  $(`#confirm-delete-article`);
    $deleteModalConfirm.off('click').on('click', function() {
        deleteArticle(articleId);
    });
}

function hideDeleteModal() {
    var deleteModal = bootstrap.Modal.getInstance($('#delete-modal')[0]);
    deleteModal.hide();
}

function deleteArticle(articleId) {
      $.ajax({
            url: API_ARTICLE_URL,
            type: 'POST',
            data: { 
                  article_id: articleId,
                  action: 'deleteArticle'
            },
            dataType: 'json',
            success: function(response) {
                  if (response.success) {
                        alert('Article deleted successfully!');
                        $('#article-' + articleId).remove();
                  }
                  else {
                        alert('Error deleting article: ' + response.message);
                  }
                  hideDeleteModal();
            },
            error: function(xhr, status, error) {
                  console.error('AJAX error:', error);
                  hideDeleteModal();
            }
      });
}