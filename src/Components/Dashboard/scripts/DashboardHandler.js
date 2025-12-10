const API_DASHBOARD_URL = '/public/api/api_dashboard.php';
const ARTICLE_SRC_PATH = 'public/uploads/';

var IS_LOGGED = false
var PAGING = 1
var FILTER = null


async function drawArticles(isLogged = null) {
      var articles = await fetchDashboardArticles();

      if(isLogged == true) IS_LOGGED = true;

      var $dashboardList = $('#dashboard-list');
      $dashboardList.empty();


      articles.forEach(function(article) {
            var $articleRow = $(`<div id="article-${article.id}" class="article-row mb-3 p-3"></div>`);
            let authorBackup = article.author ?? 'ARCHIVE';
            
            $articleRow.append('<h5>' + article.title + '</h5>');
            $articleRow.append('<p class="article-row-desc">' + (article.description || 'No description available.') + '</p>');
            $articleRow.append('<p>Author: ' + authorBackup + '</p>')
            $articleRow.append('<p>Last Edited: ' + article.last_edited + '</p>');
            if (IS_LOGGED) $articleRow.append('<a href="' + ARTICLE_SRC_PATH + article.file_name + '" target="_blank" class="btn btn-secondary btn-sm me-2">View PDF</a>');

            $('#dashboard-list').append($articleRow);
      });
}

function handlePaging(articleCount) {
      var maxPageCount = Math.min(articleCount, PAGING + 4);

      $('#current-view-num').text(`${PAGING} - ${maxPageCount}`);
      $('#complete-view-num').text(articleCount);

      if(PAGING == 1) {
            $('#left-paging').hide();
            if(articleCount <= PAGING + 4) {
                  $('#right-paging').hide();
            }
            else {
                  $('#right-paging').show();
            }
      }
      else if (maxPageCount = articleCount) {
            $('#left-paging').show();
            $('#right-paging').hide();
      }
      else {
            $('#right-paging').show();
            $('#left-paging').show()
      }

      $('#left-paging').off('click').on('click', function () {
            PAGING -= 5;
            drawArticles();
      });

      $('#right-paging').off('click').on('click', function () {
            PAGING += 5;
            drawArticles();
      });
}


function fetchDashboardArticles() {
      var loadedArticles = [];
      // Simulated article data
      $.ajax({
            url: API_DASHBOARD_URL,
            type: 'GET',
            dataType: 'json',
            data: {
                  action: 'fetchDashboardData',
                  index: PAGING - 1,
                  filter: FILTER
            },
            async: false,
            success: function(response) {
                  if (response.success) {
                  loadedArticles = response.data;
                  handlePaging(response.count)
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


function submitSearch() {
      var inputText = $('#search-text').val();
      PAGING = 1
      if(!inputText || inputText == "") {
            FILTER = null;
      }
      else {
            FILTER = inputText;
      }

      drawArticles()
}

