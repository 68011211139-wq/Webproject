<?php
require_once "config/database.php";
require_once "includes/auth.php";
require_login();

$id = (int)($_GET["id"] ?? 0);

$stmt = $conn->prepare("SELECT owner_id, image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) exit("ไม่พบสินค้าที่ต้องการลบ");
if ((int)$product["owner_id"] !== current_user_id() && current_role() !== "admin") {
    http_response_code(403);
    exit("คุณไม่มีสิทธิ์ลบสินค้านี้");
}

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if (!empty($product["image"]) && file_exists("uploads/".$product["image"])) {
    @unlink("uploads/".$product["image"]);
}

header("Location: index.php");
exit;
