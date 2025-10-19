function showCreateModal() {
      clearCreateModal();

      const createModal = new bootstrap.Modal($('#create-modal')[0]);
      createModal.show();
}

function clearCreateModal() {
      $('#create-article-title').val('');
      $('#create-article-desc').val('');
      $('#create-article-file').val('');
}

function createNewArticle(event) {
    event.preventDefault();

    const title = $('#create-article-title').val().trim();
    const description = $('#create-article-desc').val().trim();
    const fileInput = $('#create-article-file')[0];
    const file = fileInput.files[0];

    if (!title || !description || !file) {
        alert('Please fill in all fields and select a file.');
        return;
    }

    var formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('file', file);

    $.ajax({
        url: '/CONF/public/api/articles/create.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Article created successfully!');
                location.reload();
            } else {
                alert('Error creating article: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error creating article: ' + xhr.responseText);
        }
    });
}
