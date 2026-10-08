<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title ?? "PetFood Shop") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f7f8fa; }
        .navbar-brand { font-weight:700; }
        .hero { background:linear-gradient(135deg,#fff3cd,#e8f5e9); border-radius:24px; }
        .product-card { transition:.2s; }
        .product-card:hover { transform:translateY(-4px); box-shadow:0 10px 25px rgba(0,0,0,.08); }
        .product-img { height:220px; object-fit:cover; background:#eee; }
        .price { color:#198754; font-size:1.25rem; font-weight:700; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">🐾 PetFood Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.php">สินค้า</a></li>
        <?php if (isset($_SESSION["user_id"])): ?>
          <li class="nav-item"><a class="nav-link" href="create.php">เพิ่มสินค้า</a></li>
          <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
            <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><span class="nav-link">👤 <?= htmlspecialchars($_SESSION["full_name"] ?? "") ?></span></li>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm ms-lg-2" href="logout.php">ออกจากระบบ</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
          <li class="nav-item"><a class="btn btn-warning btn-sm ms-lg-2" href="register.php">สมัครสมาชิก</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container pb-5">
