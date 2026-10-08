<?php
$host = "localhost";
$dbname = "petfood_shop";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
