<?php
require_once "config/database.php";
require_once "includes/auth.php";
require_login();

$id = (int)($_GET["id"] ?? $_POST["id"] ?? 0);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) exit("ไม่พบข้อมูลสินค้าที่ต้องการแก้ไข");
if ((int)$product["owner_id"] !== current_user_id() && current_role() !== "admin") exit("คุณไม่มีสิทธิ์แก้ไขสินค้านี้");

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = (float)($_POST["price"] ?? 0);
    $imageName = $product["image"];

    if ($name === "") {
        $error = "กรุณากรอกชื่อสินค้า";
    } elseif ($price < 0) {
        $error = "ราคาต้องไม่ติดลบ";
    } elseif (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            $error = "อัปโหลดรูปไม่สำเร็จ";
        } else {
            $allowed = ["jpg","jpeg","png","webp"];
            $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) {
                $error = "รองรับเฉพาะ JPG, JPEG, PNG, WEBP";
            } elseif ($_FILES["image"]["size"] > 3 * 1024 * 1024) {
                $error = "รูปต้องมีขนาดไม่เกิน 3MB";
            } else {
                if (!is_dir("uploads")) mkdir("uploads", 0755, true);
                $imageName = bin2hex(random_bytes(12)) . "." . $ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName);
                if (!empty($product["image"]) && file_exists("uploads/".$product["image"])) {
                    @unlink("uploads/".$product["image"]);
                }
            }
        }
    }

    if ($error === "") {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $imageName, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
$page_title = "แก้ไขสินค้า";
include "includes/header.php";
?>
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<h1 class="h3 mb-4">แก้ไขสินค้า</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $id ?>">
<div class="mb-3"><label class="form-label">ชื่อสินค้า</label><input class="form-control" name="name" value="<?= htmlspecialchars($product["name"]) ?>" required></div>
<div class="mb-3"><label class="form-label">รายละเอียด</label><textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($product["description"]) ?></textarea></div>
<div class="mb-3"><label class="form-label">ราคา (บาท)</label><input class="form-control" type="number" name="price" min="0" step="0.01" value="<?= htmlspecialchars($product["price"]) ?>" required></div>
<div class="mb-3"><label class="form-label">เปลี่ยนรูป</label><input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp"></div>
<button class="btn btn-primary">บันทึกการแก้ไข</button>
<a href="index.php" class="btn btn-secondary">ยกเลิก</a>
</form>
</div></div></div></div>
<?php include "includes/footer.php"; ?>
