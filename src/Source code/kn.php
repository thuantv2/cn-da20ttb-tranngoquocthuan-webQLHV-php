<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "qlthuan1";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
