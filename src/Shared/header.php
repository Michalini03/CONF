<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferention App</title>

    <!-- Bootstrap CSS (local) -->
    <link rel="stylesheet" href="/CONF/public/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/CONF">Conferention</a>
    
    <!-- Toggle button for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Right-aligned links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php  if($_SESSION['user_id'] > 2): ?>
          <li class="nav-item">
            <a class="nav-link" href="/CONF/admin">Admin Panel</a>
          </li>
        <?php  endif; ?>
        <?php  if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="/CONF/public/logout.php">Logout</a>
          </li>
        <?php  else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/CONF/login">Login</a>
          </li>
        <?php  endif; ?>
      </ul>
    </div>
  </div>
</nav>


<!-- Content starts here -->
<div class="container mt-4">
