<?php
require_once __DIR__ . '/../../Core/BaseController.php';
require_once __DIR__ . '/DashboardModel.php';

class DashboardController extends BaseController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new DashboardModel($this->db);
    }

    public function showDashboard() {
        $this->render('Dashboard', 'dashboard');
    }

    public function fetchDashboardData($index, $filter = null) {
        if ($index == null) {
            return ['success' => false, 'message' => 'Invalid values'];
        }

        if($filter) {
            $count = $this->model->getArticleCountFiltered($filter);
            $data = $this->model->fetchDashboardDataFiltered($index, $filter);
        }
        else {
            $count = $this->model->getArticleCount();
            $data = $this->model->fetchDashboardData($index);
        }

        if (isset($data)) {
            return ['success'=> true,'data'=> $data, 'count'=> $count];
        } else {
            return ['success'=> false,'message'=> 'Error fetching data'];
        }
    }
}
