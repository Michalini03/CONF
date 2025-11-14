const API_ARTICLE_URL = '/public/api/api_articles.php';

async function drawArticles(isLogged) {
      var articles = await fetchAllArticles();
      console.log(articles);
}

function fetchAllArticles() {
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
