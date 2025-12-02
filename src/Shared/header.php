<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferention App</title>

    <!-- Bootstrap CSS (local) -->
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/global.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/public/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="public/images/logo.png" alt="Logo" width="40" height="40" class="me-1">
      Conferention
    </a>

    
    <!-- Toggle button for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Right-aligned links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php  if(isset($_SESSION['user_id'])): ?>
          <?php  if($_SESSION['access_rights'] >= 1): ?>
            <li class="nav-item">
              <a class="nav-link" href="/myarticles">My Articles</a>
            </li>
          <?php  endif; ?>
          <?php  if($_SESSION['access_rights'] >= 2): ?>
            <li class="nav-item">
              <a class="nav-link" href="/myreviews">My Reviews</a>
            </li>
          <?php  endif; ?>
          <?php  if($_SESSION['access_rights'] >= 3): ?>
            <li class="nav-item">
              <a class="nav-link" href="/admin">Admin Panel</a>
            </li>
          <?php  endif; ?>
          <li class="nav-item">
            <form action="/public/api/api_login.php?action=logout" method="POST" style="display:inline;">
              <button type="submit" class="nav-link btn btn-link" style="text-decoration:none;">Logout</button>
            </form>
          </li>
        <?php  else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
        <?php  endif; ?>
      </ul>
    </div>
  </div>
</nav>


<!-- Content starts here -->
<div class="container mt-4">
