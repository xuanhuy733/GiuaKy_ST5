<?php
// create_admin.php
require_once 'app/config/database.php'; // Đảm bảo file này chứa class Database

$database = new Database();
$conn = $database->getConnection();

$username = 'admin';
$password = password_hash('password', PASSWORD_DEFAULT); // Mã hóa mật khẩu
$fullname = 'Admin User';
$email = 'admin@example.com';
$role = 'Admin';

$sql = "INSERT INTO users (username, password, fullname, email, role) 
            VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $username, $password, $fullname, $email, $role);

if ($stmt->execute()) {
    echo "Tài khoản admin đã được tạo thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn = null; // Đóng kết nối PDO
?>