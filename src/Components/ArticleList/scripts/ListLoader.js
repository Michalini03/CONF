function getArticles() {
    var loadedArticles = [];
    // Simulated article data
    $.ajax({
        url: '/CONF/public/api/articles/render_my.php',
        type: 'GET',
            dataType: 'json',
            async: false,
            success: function(response) {
                if (response.success) {
                    loadedArticles = response.articles;
                } else {
                    console.error('Error fetching articles:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
    });

    return loadedArticles;
}

function renderArticleList() {
      var articles = getArticles();
      articles.forEach(function(article) {
            var $articleRow = $(`<div id="article-${article.id}" class="article-row mb-3 p-3"></div>`);
            $articleRow.append('<h5>' + article.title + '</h5>');
            $articleRow.append('<p>' + (article.description || 'No description available.') + '</p>');
            $articleRow.append('<p>Last Edited: ' + article.last_edited + '</p>');
            $articleRow.append('<a href="' + article.file_name + '" target="_blank" class="btn btn-secondary btn-sm me-2">View PDF</a>');

            var $editButton = $('<button class="btn btn-primary btn-sm me-2 edit-article-btn" data-article-id="' + article.id + '">Edit</button>');
            $editButton.off('click').on('click', function() {
                  showEditModal(article.id, article.title, article.description || '');
            });
            $articleRow.append($editButton);

            var $deleteButton = $('<button class="btn btn-danger btn-sm delete-article-btn" id="delete-article-' + article.id + '">Delete</button>');
            $deleteButton.off('click').on('click', function() {
                  showDeleteModal(article.id);
            });
            $articleRow.append($deleteButton);
            $('#article-list').append($articleRow);
      });
}