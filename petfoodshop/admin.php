<?php
require_once "config/database.php";
require_once "includes/auth.php";
require_admin();

$userCount = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()["c"];
$productCount = $conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()["c"];
$users = $conn->query("SELECT id, full_name, username, role FROM users ORDER BY id DESC");

$page_title = "Admin Dashboard";
include "includes/header.php";
?>
<h1 class="h3 mb-4">Admin Dashboard</h1>
<div class="row g-3 mb-4">
  <div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">สมาชิกทั้งหมด</div><div class="display-6 fw-bold"><?= $userCount ?></div></div></div></div>
  <div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">สินค้าทั้งหมด</div><div class="display-6 fw-bold"><?= $productCount ?></div></div></div></div>
</div>
<div class="card border-0 shadow-sm">
<div class="card-body">
<h2 class="h5">รายชื่อผู้ใช้</h2>
<div class="table-responsive">
<table class="table align-middle">
<thead><tr><th>ID</th><th>ชื่อ</th><th>Username</th><th>Role</th></tr></thead>
<tbody>
<?php while ($u = $users->fetch_assoc()): ?>
<tr>
<td><?= (int)$u["id"] ?></td>
<td><?= htmlspecialchars($u["full_name"]) ?></td>
<td><?= htmlspecialchars($u["username"]) ?></td>
<td><span class="badge <?= $u["role"] === "admin" ? "text-bg-danger" : "text-bg-secondary" ?>"><?= htmlspecialchars($u["role"]) ?></span></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div></div>
<?php include "includes/footer.php"; ?>
