<!-- app/views/people/peo_add.php -->
<h1>THÊM NHÂN VIÊN</h1>
<form method="POST" action="index.php?action=add">
    <label for="ma_nv">Mã Nhân Viên:</label>
    <input type="text" id="ma_nv" name="ma_nv" required>

    <label for="ten_nv">Tên Nhân Viên:</label>
    <input type="text" id="ten_nv" name="ten_nv" required>

    <label for="phai">Giới Tính:</label>
    <select id="phai" name="phai" required>
        <option value="Nam">Nam</option>
        <option value="Nu">Nữ</option>
    </select>

    <label for="noi_sinh">Nơi Sinh:</label>
    <input type="text" id="noi_sinh" name="noi_sinh">

    <label for="ma_phong">Phòng Ban:</label>
    <select id="ma_phong" name="ma_phong" required>
        <?php foreach ($departments as $dept): ?>
            <option value="<?php echo $dept['Ma_Phong']; ?>"><?php echo $dept['Ten_Phong']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="luong">Lương:</label>
    <input type="number" id="luong" name="luong">

    <button type="submit">Thêm</button>
</form>
<a href="index.php?action=index" class="back">Quay lại</a>

<?php if (isset($error)): ?>
    <p style="color: red; text-align: center;"><?php echo $error; ?></p>
<?php endif; ?>