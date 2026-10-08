<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION["user_id"]);
}

function current_user_id(): ?int {
    return isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : null;
}

function current_role(): ?string {
    return $_SESSION["role"] ?? null;
}

function require_login(): void {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function require_admin(): void {
    require_login();
    if (current_role() !== "admin") {
        http_response_code(403);
        exit("คุณไม่มีสิทธิ์เข้าหน้านี้");
    }
}
