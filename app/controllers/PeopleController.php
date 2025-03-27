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

    public function add() {
        $error = null; // Khởi tạo biến $error ở đây

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // LẤY VÀ KIỂM TRA DỮ LIỆU - RẤT QUAN TRỌNG
            $ma_nv = mysqli_real_escape_string($this->conn, $_POST['ma_nv']);
            $ten_nv = mysqli_real_escape_string($this->conn, $_POST['ten_nv']);
            $phai = mysqli_real_escape_string($this->conn, $_POST['phai']);
            $noi_sinh = mysqli_real_escape_string($this->conn, $_POST['noi_sinh']);
            $ma_phong = mysqli_real_escape_string($this->conn, $_POST['ma_phong']);

            // Ép kiểu và kiểm tra lương
            $luong = isset($_POST['luong']) ? (float)$_POST['luong'] : 0; // Đảm bảo lương luôn là số
            if ($luong < 0) {
                $error = "Lỗi: Lương phải là một số dương.";
            }

            // Nếu không có lỗi, thực hiện thêm vào database
            if (!$error) {
                // Thêm nhân viên vào cơ sở dữ liệu
                $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
                        VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', $luong)";

                if ($this->conn->query($sql) === TRUE) {
                    // Chuyển hướng về trang danh sách nhân viên sau khi thêm thành công
                    header("Location: index.php?controller=people&action=index");
                    exit();
                } else {
                    $error = "Lỗi: " . $this->conn->error;
                }
            }
        }

        // Lấy danh sách phòng ban để hiển thị trong form
        $sql_phongban = "SELECT Ma_Phong, Ten_Phong FROM phongban";
        $result_phongban = $this->conn->query($sql_phongban);
        $phongban = [];
        if ($result_phongban->num_rows > 0) {
            while ($row = $result_phongban->fetch_assoc()) {
                $phongban[] = $row;
            }
        }

        // Load view peo_add.php để hiển thị form thêm nhân viên
        $this->loadView('people/peo_add', ['phongban' => $phongban, 'error' => $error]); // Pass $error (even if it's null)
    }

    public function edit($id) {
        $error = null;
        $ma_nv = $id;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // LẤY VÀ KIỂM TRA DỮ LIỆU - RẤT QUAN TRỌNG
            $ten_nv = mysqli_real_escape_string($this->conn, $_POST['ten_nv']);
            $phai = mysqli_real_escape_string($this->conn, $_POST['phai']);
            $noi_sinh = mysqli_real_escape_string($this->conn, $_POST['noi_sinh']);
            $ma_phong = mysqli_real_escape_string($this->conn, $_POST['ma_phong']);

            // Ép kiểu và kiểm tra lương
            $luong = isset($_POST['luong']) ? (float)$_POST['luong'] : 0; // Đảm bảo lương luôn là số
             if ($luong < 0) {
                $error = "Lỗi: Lương phải là một số dương.";
            }
            // Nếu không có lỗi, thực hiện cập nhật database
            if (!$error) {
                // Cập nhật thông tin nhân viên trong cơ sở dữ liệu
                $sql = "UPDATE nhanvien
                        SET Ten_NV = '$ten_nv', Phai = '$phai', Noi_Sinh = '$noi_sinh', Ma_Phong = '$ma_phong', Luong = $luong
                        WHERE Ma_NV = '$ma_nv'";

                if ($this->conn->query($sql) === TRUE) {
                    // Chuyển hướng về trang danh sách nhân viên sau khi sửa thành công
                    header("Location: index.php?controller=people&action=index");
                    exit();
                } else {
                    $error = "Lỗi: " . $this->conn->error;
                }
            }
        }

        // Lấy thông tin nhân viên để hiển thị trong form sửa
        $sql_nhanvien = "SELECT * FROM nhanvien WHERE Ma_NV = '$ma_nv'";
        $result_nhanvien = $this->conn->query($sql_nhanvien);
        $nhanvien = $result_nhanvien->fetch_assoc();

        // Lấy danh sách phòng ban để hiển thị trong form sửa
        $sql_phongban = "SELECT Ma_Phong, Ten_Phong FROM phongban";
        $result_phongban = $this->conn->query($sql_phongban);
        $phongban = [];
        if ($result_phongban->num_rows > 0) {
            while ($row = $result_phongban->fetch_assoc()) {
                $phongban[] = $row;
            }
        }

        // Load view peo_edit.php để hiển thị form sửa nhân viên
        $this->loadView('people/peo_edit', ['nhanvien' => $nhanvien, 'phongban' => $phongban, 'error' => $error]);
    }

    public function delete($id) {
        $ma_nv = $id;

        // Xóa nhân viên khỏi cơ sở dữ liệu
        $sql = "DELETE FROM nhanvien WHERE Ma_NV = '$ma_nv'";
        if ($this->conn->query($sql) === TRUE) {
            // Chuyển hướng về trang danh sách nhân viên sau khi xóa thành công
            header("Location: index.php?controller=people&action=index");
            exit();
        } else {
            echo "Lỗi: " . $this->conn->error;
        }
    }

    private function loadView($view, $data = []) {
        extract($data);
        require_once "app/views/shares/header.php";
        require_once "app/views/$view.php";
        require_once "app/views/shares/footer.php";
    }
}
?>