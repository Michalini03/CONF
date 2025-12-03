const API_REVIEW_URL = '/public/api/api_review.php';
const ARTICLE_SRC_PATH = 'public/uploads/';
const LIST_ID = '#review-list';

function renderReviewList(userID) {
      $.ajax({
            url: API_REVIEW_URL,
            type: 'GET',
            dataType: 'json',
            data: {
                  action: 'fetchReviewList',
                  user_id: userID
            },
            async: false,
            success: function(response) {
                  if (response.success) {
                        loadedArticles = response.data;
                        displayArticles(loadedArticles);
                  } 
                  else {
                        console.error('Error fetching articles:', response.message);
                  }
            },
            error: function(xhr, status, error) {
                  console.error('AJAX error:', error);
            }
      });
}

function displayArticles(articles) {
      var $section = $(LIST_ID);
      $section.empty();

      if(!articles || articles.length == 0) {
            $section.html("No articles for reviewing were found!");
            return;
      }

      articles.forEach(function(article) {
            var $articleRow = $(`<div id="review-card-${article.id}" class="article-row mb-3 p-3"></div>`);
            $articleRow.append('<h5>' + article.title + '</h5>');
            $articleRow.append('<p class="article-row-desc">' + (article.description || 'No description available.') + '</p>');
            $articleRow.append('<p>Last Edited: ' + article.last_edited + '</p>');
            $articleRow.append('<a href="' + ARTICLE_SRC_PATH + article.file_name + '" target="_blank" class="btn btn-secondary btn-sm me-2">View PDF</a>');

            var $editButton = $('<button class="btn btn-primary btn-sm me-2 edit-article-btn" data-article-id="' + article.id + '">Edit</button>');
            $editButton.off('click').on('click', function() {
                  showReviewModal(article.id, article.title);
            });
            $articleRow.append($editButton);

            $section.append($articleRow);
      });
}

function showReviewModal(articleID, articleTitle) {
    $('#review-article-id').val(articleID);
    $('#review-article-title').html(articleTitle);

    // Use getOrCreateInstance. If it exists, get it. If not, create it.
    const myModalEl = document.getElementById('review-modal');
    const reviewModal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    
    reviewModal.show();
}

function addReview(event) {
      event.preventDefault();

      var reviewText = $("#review-article-text").val();
      var articleID = $('#review-article-id').val();

      if(reviewText == '') {
            alert("Please, dont leave review empty!");
            return;
      }

      $.ajax({
            url: API_REVIEW_URL,
            type: 'POST',
            dataType: 'json',
            data: {
                  action: 'addReview',
                  article_id: articleID,
                  text: reviewText
            },
            success: function(response) {
                  if (response.success) {
                        alert(response.message);
                        
                        const myModalEl = document.getElementById('review-modal');
                        const reviewModal = bootstrap.Modal.getInstance(myModalEl);
                        if (reviewModal) {
                            reviewModal.hide();
                        }
                        
                        $("#review-article-text").val(''); 
                        $('#review-card-' + articleID).fadeOut(300, function() { 
                              $(this).remove(); 
                        });                    
                  } 
                  else {
                        console.error('Error:', response.message);
                  }
            },
            error: function(xhr, status, error) {
                  console.error('AJAX error:', error);
            }
      });
}