const ARTICLE_ASSIGN_SECTION_ID = '#article-assign-list';
const ARTICLE_APPROVE_SECTION_ID = '#article-approve-list';
const API_ARTICLE_URL = '/public/api/api_articles.php';



function loadArticles() {
      var reviewers = fetchReviewers();
      var articles = fetchArticles();

      var forAssign = articles.filter(article => article.state == 1);
      var forApproval = articles.filter(article => article.state == 3);

      loadArticlesForAssigning(reviewers, forAssign)
}

function loadArticlesForAssigning(reviewers, articles) {
      var $section = jQuery(ARTICLE_ASSIGN_SECTION_ID);

      $section.empty();

      if (reviewers == null || articles == null) {
            return;
      }

      var reviewerOptionsHtml = '<option value="">-- Select Reviewer --</option>';
      reviewers.forEach(reviewer => {
            reviewerOptionsHtml += `<option value="${reviewer.id}">${reviewer.username}</option>`;
      });

      var $table = $('<table class="table table-hover table-striped table-dark table-responsive"></table>');
      var $thead = $('<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Reviewer</th><th></th></tr></thead>');
      var $tbody = $('<tbody></tbody>');

      articles.forEach(article => {
            var $row = $('<tr></tr>');

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
                  assignReviewer(article.id, reviewerID);
            })

            var $tdAssign = $('<td></td>').append($button);
            $row.append($tdAssign);

            // Append row to body
            $tbody.append($row);
      });

      // 4. Assemble the table
      $table.append($thead);
      $table.append($tbody);
      $section.append($table);
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