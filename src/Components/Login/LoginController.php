<?php
require_once __DIR__ . '/LoginModel.php';
require_once __DIR__ . '/../../Core/BaseController.php';

class LoginController extends BaseController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new LoginModel($this->db);
    }

    public function checkUserInfoInDB($username, $password) {
        $id = $this->model->getUserId($username);
        if ($id === -1) {
            return ['success' => false, 'message' => 'User not found'];
        }

        $isCorrect = $this->model->validateUser($id, $password);
        if ($isCorrect) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            return ['success' => true, 'message' => 'Login successful'];
        } else {
            return ['success' => false, 'message' => 'Invalid password'];
        }
    }
}
