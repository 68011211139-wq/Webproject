<?php
require_once "config/database.php";
require_once "includes/auth.php";

$page_title = "PetFood Shop";
$sql = "SELECT p.*, u.full_name AS owner_name
        FROM products p
        JOIN users u ON p.owner_id = u.id
        ORDER BY p.id DESC";
$result = $conn->query($sql);
include "includes/header.php";
?>
<div class="hero p-4 p-md-5 mb-4">
  <h1 class="display-6 fw-bold">อาหารสัตว์เลี้ยงคุณภาพดี 🐶🐱</h1>
  <p class="lead mb-0">รวมอาหารสุนัข อาหารแมว ขนม และสินค้าเพื่อสัตว์เลี้ยง</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4">สินค้าทั้งหมด</h2>
  <?php if (isset($_SESSION["user_id"])): ?>
    <a class="btn btn-success" href="create.php">+ เพิ่มสินค้า</a>
  <?php endif; ?>
</div>

<div class="row g-4">
<?php while ($row = $result->fetch_assoc()): ?>
  <div class="col-md-6 col-lg-4">
    <div class="card product-card h-100 border-0 shadow-sm">
      <?php if (!empty($row["image"]) && file_exists("uploads/".$row["image"])): ?>
        <img src="uploads/<?= htmlspecialchars($row["image"]) ?>" class="card-img-top product-img" alt="สินค้า">
      <?php else: ?>
        <div class="product-img d-flex align-items-center justify-content-center fs-1">🐾</div>
      <?php endif; ?>
      <div class="card-body">
        <h3 class="h5"><?= htmlspecialchars($row["name"]) ?></h3>
        <p class="text-muted"><?= nl2br(htmlspecialchars($row["description"])) ?></p>
        <div class="price">฿<?= number_format((float)$row["price"], 2) ?></div>
        <small class="text-muted">ผู้ขาย: <?= htmlspecialchars($row["owner_name"]) ?></small>
      </div>
      <?php if (isset($_SESSION["user_id"]) && ((int)$row["owner_id"] === current_user_id() || current_role() === "admin")): ?>
      <div class="card-footer bg-white border-0 pb-3">
        <a href="edit.php?id=<?= (int)$row["id"] ?>" class="btn btn-outline-primary btn-sm">แก้ไข</a>
        <a href="delete.php?id=<?= (int)$row["id"] ?>" class="btn btn-outline-danger btn-sm"
           onclick="return confirm('ยืนยันการลบสินค้านี้?')">ลบ</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
<?php endwhile; ?>
</div>
<?php include "includes/footer.php"; ?>
