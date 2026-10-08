<?php
require_once "config/database.php";
require_once "includes/auth.php";

if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($full_name === "" || $username === "" || $password === "") {
        $error = "กรุณากรอกข้อมูลให้ครบ";
    } elseif (strlen($password) < 6) {
        $error = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = "ชื่อผู้ใช้นี้มีอยู่แล้ว";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "user";
            $stmt = $conn->prepare("INSERT INTO users (full_name, username, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $username, $hash, $role);
            $stmt->execute();
            header("Location: login.php?registered=1");
            exit;
        }
    }
}
$page_title = "สมัครสมาชิก";
include "includes/header.php";
?>
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm">
<div class="card-body p-4">
<h1 class="h3 mb-4">สมัครสมาชิก</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label class="form-label">ชื่อ-นามสกุล</label><input class="form-control" name="full_name" required></div>
  <div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" minlength="6" required></div>
  <button class="btn btn-success w-100">สมัครสมาชิก</button>
</form>
</div></div></div></div>
<?php include "includes/footer.php"; ?>
