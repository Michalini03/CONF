function showEditModal(id, title, description) {
    $('#edit-article-id').val(id);
    $('#edit-article-title').val(title);
    $('#edit-article-desc').val(description);

    const editModal = new bootstrap.Modal($('#edit-modal')[0]);
    editModal.show();
}

function hideEditModal() {
    $('#edit-modal').hide();
}

function clearEditModal() {
    $('#edit-article-id').val('');
    $('#edit-article-title').val('');
    $('#edit-article-desc').val('');
}

function validateEditForm(title, description) {
    const errors = [];
      if (!title || title.trim() === '') {
            errors.push("Title is required.");
      }

      return errors;
}

function submitArticleEdit(event) {
      event.preventDefault();
      const articleId = $('#edit-article-id').val();
      const title = $('#edit-article-title').val();
      const description = $('#edit-article-desc').val();
      const file = $('#edit-article-file')[0]?.files[0] ?? null;

      var formData = new FormData();
      formData.append('title', title);
      formData.append('description', description);
      formData.append('file', file);
      formData.append('article_id', articleId);
      formData.append('action', 'editArticle');

      console.log("Submitting edit for article ID:", formData);

      $.ajax({
            url: API_ARTICLE_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                  if (response.success) {
                        alert('Article updated successfully!');
                        hideEditModal();
                        clearEditModal();
                        location.reload();
                  }             
                  else {  
                  }
            },
            error: function(xhr, status, error) {
                  console.error('AJAX error:', error);
                  hideEditModal();
                  clearEditModal();
            }
      });
}