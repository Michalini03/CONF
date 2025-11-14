<?php
require_once __DIR__ . '/../../Core/BaseController.php';

class DashboardController extends BaseController {
    private $model;

    public function __construct() {
        parent::__construct();
    }

    public function showDashboard() {
        $this->render('Dashboard', 'dashboard');
    }
}
