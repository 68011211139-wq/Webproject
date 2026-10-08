<?php
require_once "config/database.php";
require_once "includes/auth.php";

if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, full_name, username, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = (int)$user["id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit;
    }
    $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
}
$page_title = "เข้าสู่ระบบ";
include "includes/header.php";
?>
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm">
<div class="card-body p-4">
<h1 class="h3 mb-4">เข้าสู่ระบบ</h1>
<?php if (isset($_GET["registered"])): ?><div class="alert alert-success">สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ</div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-dark w-100">เข้าสู่ระบบ</button>
</form>
</div></div></div></div>
<?php include "includes/footer.php"; ?>
