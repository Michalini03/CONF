<?php
if (!isset($_SESSION)) {
    session_start();
}
require __DIR__ . '/../../Shared/header.php';
require __DIR__ . '/view/articleList.php';
?>