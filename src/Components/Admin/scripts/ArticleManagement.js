const ARTICLE_ASSIGN_SECTION_ID = '#article-assign-list';
const ARTICLE_APPROVE_SECTION_ID = '#article-approve-list';
const API_ARTICLE_URL = '/public/api/api_articles.php';



function loadArticles() {
      var reviewers = fetchReviewers();
      var articles = fetchArticles();

      var forAssign = articles.filter(article => article.state == 1);
      var forApproval = articles.filter(article => article.state == 3);

      loadArticlesForAssigning(reviewers, forAssign);
      loadArticlesForApproving(reviewers, forApproval);
}

function loadArticlesForAssigning(reviewers, articles) {
      var $section = jQuery(ARTICLE_ASSIGN_SECTION_ID);

      $section.empty();

      if (reviewers == null || articles == null || articles.length == 0) {
            return;
      }

      var reviewerOptionsHtml = '<option value="0">-- Select Reviewer --</option>';
      reviewers.forEach(reviewer => {
            reviewerOptionsHtml += `<option value="${reviewer.id}">${reviewer.username}</option>`;
      });

      var $wrapper = $('<div class="table-responsive"></div>');
      var $table = $('<table class="table table-hover table-striped table-dark table-responsive"></table>');
      var $thead = $('<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Reviewer</th><th></th></tr></thead>');
      var $tbody = $('<tbody></tbody>');

      articles.forEach(article => {
            var $row = $(`<tr id="assign-row-${article.id}"></tr>`);

            $row.append(`<td>${article.id}</td>`);
            $row.append(`<td>${article.title}</td>`);         
            $row.append(`<td>${article.description}</td>`);  

            // 3. Create the Select for THIS specific row
            var $select = $(`<select class="form-control assign-reviewer-select" data-article-id="${article.id}">
                                ${reviewerOptionsHtml}
                             </select>`);

            if (article.reviewer_id) {
                $select.val(article.reviewer_id);
            }

            var $tdAction = $('<td></td>').append($select);
            $row.append($tdAction);

            var $button = $('<button type="submit" class="btn btn-primary">Assign</button>')
            $button.off('click').on('click', function () {
                  var reviewerID = $select.val();

                  if(reviewerID == 0) {
                        alert('Please, select valid reviewer!')
                        return;
                  }
                  assignReviewer(article.id, reviewerID);
            })

            var $tdAssign = $('<td></td>').append($button);
            $row.append($tdAssign);

            // Append row to body
            $tbody.append($row);
      });

      $table.append($thead);
      $table.append($tbody);
      $wrapper.append($table);
      $section.append($wrapper);
}

function loadArticlesForApproving(reviewers, articles) {
      var $section = jQuery(ARTICLE_APPROVE_SECTION_ID);

      $section.empty();

      if (reviewers == null || articles == null || articles.length == 0) {
            return;
      }

      var $wrapper = $('<div class="table-responsive"></div>');
      var $table = $('<table class="table table-hover table-striped table-dark table-responsive"></table>');
      var $thead = $('<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Reviewer</th><th></th></tr></thead>');
      var $tbody = $('<tbody></tbody>');

      articles.forEach(article => {
            var $row = $(`<tr id="approve-row-${article.id}"></tr>`);

            $row.append(`<td>${article.id}</td>`);
            $row.append(`<td>${article.title}</td>`);         
            $row.append(`<td>${article.description}</td>`);  

            let reviewOfArticle = reviewers.find(reviewer => reviewer.id == article.reviewer_id);

            $row.append(`<td>${reviewOfArticle.username}</td>`)

            var $button = $('<button type="submit" class="btn btn-primary">Show review</button>')
            $button.off('click').on('click', function () {
                  showApproveModal(article.id, article.title, article.review);
            })

            var $tdAssign = $('<td></td>').append($button);
            $row.append($tdAssign);
            $tbody.append($row);
      });

      $table.append($thead);
      $table.append($tbody);
      $wrapper.append($table);
      $section.append($wrapper);
}

function showApproveModal(articleID, articleTitle, articleReview) {
      $('#approve-article-id').val(articleID);
      $('#approve-article-title').html(articleTitle);
      $('#approve-review-text').html(articleReview);

      const approve = new bootstrap.Modal($('#approve-modal')[0]);
      approve.show();
}

function fetchReviewers() {
      var loadedArticles = [];
      // Simulated article data
      $.ajax({
            url: ADMIN_API_URL,
            type: 'GET',
            dataType: 'json',
            data: {
                  action: 'fetchReviewers'
            },
            async: false,
            success: function(response) {
                  if (response.success) {
                  loadedArticles = response.data;
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

function fetchArticles() {
      var loadedArticles = [];
      // Simulated article data
      $.ajax({
            url: API_ARTICLE_URL,
            type: 'GET',
            dataType: 'json',
            data: {
                  action: 'fetchArticles'
            },
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


function assignReviewer(articleID, reviewerID) {
    $.ajax({
        url: ADMIN_API_URL,
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'assignReviewer',
            article_id: articleID,
            reviewer_id: reviewerID
        },
        success: function(response) {
            if (response.success) {
                  alert(response.message);
                  $(`#assign-row-${articleID}`).fadeOut(300, function() { 
                        $(this).remove(); 
                  });

            } else {
                console.error('Error assigning reviewer:', response.message);
                alert('Failed: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX network error:', error);
            alert('A network error occurred.');
        }
    });
}

function setState(event, newState) {
      event.preventDefault();
      var articleID = $('#approve-article-id').val();

      $.ajax({
            url: ADMIN_API_URL,
            type: 'POST',
            dataType: 'json',
            data: {
                  action: 'newState',
                  state: newState,
                  article_id: articleID,
            },
            success: function(response) {
                  if (response.success) {
                        alert(response.message);
                        const myModalEl = document.getElementById('approve-modal');
                        const approve = bootstrap.Modal.getInstance(myModalEl);
                        if (approve) {
                            approve.hide();
                        }

                        $('#approve-row-' + articleID).fadeOut(300, function() { 
                              $(this).remove(); 
                        });     
                  } 
                  else {
                        console.error('Error assigning reviewer:', response.message);
                        alert('Failed: ' + response.message);
                  }
            },
            error: function(xhr, status, error) {
                  console.error('AJAX network error:', error);
                  alert('A network error occurred.');
            }
      });
}