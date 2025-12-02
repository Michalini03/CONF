<?php
require_once __DIR__ . '/AdminModel.php';
require_once __DIR__ . '/../../Core/BaseController.php';


class AdminController extends BaseController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new AdminModel($this->db);
    }

    public function showAdminPage() {
        $this->render('Admin', 'administration');
    }

    public function fetchAllUsers() {
        $data = $this->model->getAllUsers();
        if ($data === null) {
            return ['success' => false, 'message' => 'No users found.'];
        }
        return ['success' => true, 'data' => $data];
    }

    public function fetchAllReviewers() {
        $data = $this->model->getAllReviewers();
        if ($data === null) {
            return ['success' => false, 'message' => 'No reviewers found.'];
        }
        return ['success' => true, 'data' => $data];
    }

    public function fetchAllAdmins() {
        $data = $this->model->getAllAdmins();
        if ($data === null) {
            return ['success' => false, 'message' => 'No admins found.'];
        }
        return ['success' => true, 'data' => $data];
    }

    public function updateUserAccess($user_id, $new_access_rights) {
        if ($user_id === null || $new_access_rights === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }    
        if($this->model->updateUserAccess($user_id, $new_access_rights)) {
            return ['success' => true, 'message' => 'User access rights updated successfully.'];
        } 
        else {
            return ['success' => false, 'message' => 'Failed to update user access rights.'];
        }
    }

    public function deleteUser($user_id, $new_author_id) {
        if ($user_id === null || $new_author_id === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        if($this->model->deleteUser($user_id)) {
            $this->model->reassignUserArticles($user_id, $new_author_id);
            return ['success' => true, 'message' => 'User deleted successfully.'];
        } 
        else {
            return ['success' => false, 'message' => 'Failed to delete user.'];
        }
    }

    public function addReviewer($reviewer_id, $article_id) {
        if ($reviewer_id === null || $article_id === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        if ($this->model->addReviewer($reviewer_id, $article_id)) {
            return ['success' => true, 'message' => 'Reviewer added successfully.'];
        } 
        else {
            return ['success' => false, 'message' => 'Failed to add reviewer.'];
        }
    }

    public function changeState($article_id, $new_state) {
        if ($new_state === null || $article_id === null) {
            return ['success' => false, 'message' => 'Missing required fields.'];
        }

        if ($this->model->changeState($article_id, $new_state)) {
            return ['success'=> true, 'message'=> 'State changed successfully'];
        }
        else {
            return ['success'=> false, 'message'=> 'Failed to change state'];
        }
    }
}