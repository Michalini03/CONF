const API_ARTICLE_URL = '/public/api/api_articles.php';
const ARTICLE_SRC_PATH = 'public/uploads/';


function getUserArticles(userId) {
    var loadedArticles = [];
    // Simulated article data
    $.ajax({
        url: API_ARTICLE_URL,
        type: 'GET',
        dataType: 'json',
        data: {
            action: 'fetchArticleById',
            user_id: userId
        },
        async: false,
        success: function(response) {
            if (response.success) {
                loadedArticles = response.articles;
            } else {
                console.error('Error fetching user articles:', response.message);
            }   
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
    return loadedArticles;
}

function clearArticleList() {
      $('#article-list').empty();
}

function renderArticleList(userId) {
    clearArticleList();
    var articles = [];
    articles = getUserArticles(userId);

    if(!articles || articles.length == 0) {
        $('#article-list').append('You did not create any article, yet!');
    }

    articles.forEach(function(article) {
        var $articleRow = $(`<div id="article-${article.id}" class="article-row mb-3 p-3"></div>`);
        $articleRow.append('<h5>' + article.title + '</h5>');
        $articleRow.append('<p class="article-row-desc">' + (article.description || 'No description available.') + '</p>');
        $articleRow.append('<p>State: ' + getStateString(article.state) + '</p>');
        $articleRow.append('<p>Last Edited: ' + article.last_edited + '</p>');
        $articleRow.append('<a href="' + ARTICLE_SRC_PATH + article.file_name + '" target="_blank" class="btn btn-secondary btn-sm me-2">View PDF</a>');

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

function getStateString(stateIndex) {
    stateIndex = Number(stateIndex);

    var dict = {
        1: "Waiting for assignment",
        2: "Waiting for review",
        3: "Waiting for approval",
        4: "Approved",
        5: "Declined"
    };

    return dict[stateIndex];
}