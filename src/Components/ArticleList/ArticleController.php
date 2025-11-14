<?php
require_once __DIR__ . '/../../Core/BaseController.php';
require_once __DIR__ . '/ArticleModel.php';

class ArticleController extends BaseController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new ArticleModel($this->db);
    }

    public function fetchAllArticles() {
        $loadedArticles = $this->model->getAllArticles();

        if ($loadedArticles === false) {
            return ['success' => false, 'message' => 'Error fetching articles.'];
        }

        return ['success' => true, 'articles' => $loadedArticles];
    }

    public function fetchUserArticles($user_id) {
        if ($user_id === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        $loadedArticles = $this->model->getArticlesByUserId($user_id);
        if ($loadedArticles === false) {
            return ['success' => false, 'message' => 'Error fetching articles.'];
        }

        return ['success' => true, 'articles' => $loadedArticles];
    }

    public function showArticlePage() {
        $this->render('ArticleList', 'article_list');
    }

    public function createArticle($user_id, $title, $description, $file) {
        if ($user_id === null || empty($title) || $file === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        if ($file['type'] !== 'application/pdf') {
            return ['success' => false, 'message' => 'Only PDF files are allowed.'];
        }

        if (!$this->model->checkForAvaiableName($title)) {
            return ['success' => false, 'message' => 'An article with this title already exists. Please choose a different title.'];
        }

        $filename = $this->model->savePDFFile($file);

        if ($filename !== false) {
            // Save article to database
            $articleId = $this->model->insertArticle($user_id, $title, $description, $filename);
            if ($articleId !== false) {
                return ['success' => true, 'message' => 'Article created successfully.', 'article_id' => $articleId];
            } else {
                return ['success' => false, 'message' => 'Failed to save article to database.'];
            }
        } else {
            return ['success' => false, 'message' => 'File upload failed.'];
        }
    }

    public function editArticle($article_id, $title, $description, $file = null) {
        if ($article_id === false || empty($title)) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        if (!$this->model->checkForAvaiableName($title, $article_id)) {
            return ['success' => false, 'message' => 'An article with this title already exists. Please choose a different title.'];
        }


        $filename = null;
        if ($file !== null) {
            if ($file['type'] !== 'application/pdf') {
                return ['success' => false, 'message' => 'Only PDF files are allowed.'];
            }
            $this->model->deleteOldFile($article_id);
            $filename = $this->model->savePDFFile($file);
            if ($filename === false) {
                return ['success' => false, 'message' => 'File upload failed.'];
            }
        }

        $updateSuccess = $this->model->updateArticle($article_id, $title, $description, $filename);
        if ($updateSuccess) {
            return ['success' => true, 'message' => 'Article updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update article.'];
        }
    }

    public function deleteArticle($article_id) {
        if ($article_id === false) {
            return ['success' => false, 'message' => 'Missing article ID.'];
        }

        $this->model->deleteOldFile($article_id);

        $deleteSuccess = $this->model->deleteArticle($article_id);
        if ($deleteSuccess) {
            return ['success' => true, 'message' => 'Article deleted successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete article.'];
        }
    }
}