<?php
require_once 'app/controllers/PeopleController.php';

// Lấy URL từ query string (cho GET requests)
$url = $_GET['url'] ?? 'People';
$urlParts = explode('/', $url);

// Xác định controller và phương thức
$controllerName = $urlParts[0] . 'Controller';
$method = $urlParts[1] ?? 'index';
$param = $urlParts[2] ?? null;

// Kiểm tra controller tồn tại
if (!class_exists($controllerName)) {
    echo "Controller không tồn tại.";
    exit();
}

$controller = new $controllerName();

// Xử lý request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý POST request (thêm, sửa)
    if (method_exists($controller, $method)) {
        $controller->$method($param); // Gọi phương thức với tham số (nếu có)
    } else {
        echo "Phương thức không tồn tại.";
    }
} else {
    // Xử lý GET request (hiển thị trang)
    if ($param) {
        if (method_exists($controller, $method)) {
            $controller->$method($param); // Gọi phương thức với tham số (nếu có)
        } else {
            echo "Phương thức không tồn tại.";
        }
    } else {
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            echo "Phương thức không tồn tại.";
        }
    }
}
?>