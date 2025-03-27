<?php
require_once 'app/controllers/PeopleController.php';

// Lấy URL từ query string
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

// Gọi phương thức với tham số (nếu có)
if ($param) {
    if (method_exists($controller, $method)) {
        $controller->$method($param);
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
?>