<?php
require_once 'app/config/database.php';

class PeopleController {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function index() {
        // Số nhân viên trên mỗi trang
        $so_nhan_vien_tren_trang = 5;
        $trang_hien_tai = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
        $vi_tri_bat_dau = ($trang_hien_tai - 1) * $so_nhan_vien_tren_trang;

        // Đếm tổng số nhân viên
        $sql_count = "SELECT COUNT(*) AS total FROM nhanvien";
        $result_count = $this->conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $tong_so_nhan_vien = $row_count['total'];
        $tong_so_trang = ceil($tong_so_nhan_vien / $so_nhan_vien_tren_trang);

        // Lấy dữ liệu cho trang hiện tại
        $sql = "SELECT * FROM nhanvien LIMIT $vi_tri_bat_dau, $so_nhan_vien_tren_trang";
        $result = $this->conn->query($sql);

        $nhanvien = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nhanvien[] = $row;
            }
        }

        // Truyền dữ liệu sang view
        $data = [
            'nhanvien' => $nhanvien,
            'trang_hien_tai' => $trang_hien_tai,
            'tong_so_trang' => $tong_so_trang,
            'vi_tri_bat_dau' => $vi_tri_bat_dau
        ];

        // Load view
        $this->loadView('people/peo_list', $data);
    }

    private function loadView($view, $data = []) {
        extract($data);
        require_once "app/views/shares/header.php";
        require_once "app/views/$view.php";
        require_once "app/views/shares/footer.php";
    }
}
?>