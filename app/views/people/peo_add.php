<?php require_once 'app/views/shares/header.php'; ?>

<link rel="stylesheet" href="/GiuaKy/public/css/form.css">

<div class="form-container">
    <h2>Thêm nhân viên</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?controller=people&action=add">
        <div class="form-group">
            <label for="ma_nv">Mã nhân viên</label>
            <input type="text" name="ma_nv" id="ma_nv" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ten_nv">Tên nhân viên</label>
            <input type="text" name="ten_nv" id="ten_nv" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phai">Giới tính</label>
            <select name="phai" id="phai" class="form-control" required>
                <option value="Nam">Nam</option>
                <option value="Nu">Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="noi_sinh">Nơi sinh</label>
            <input type="text" name="noi_sinh" id="noi_sinh" class="form-control">
        </div>
        <div class="form-group">
            <label for="ma_phong">Mã phòng</label>
            <select name="ma_phong" id="ma_phong" class="form-control" required>
                <?php foreach ($phongban as $pb): ?>
                    <option value="<?= $pb['Ma_Phong'] ?>"><?= $pb['Ten_Phong'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="luong">Lương</label>
            <input type="number" name="luong" id="luong" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>