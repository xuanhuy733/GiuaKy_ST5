<?php require_once 'app/views/shares/header.php'; ?>

<h2>Danh sách nhân viên</h2>
<a href="index.php?url=People/add" class="btn btn-success mb-3">Thêm nhân viên</a>
<table class="table table-bordered table-striped">
    <thead class="thead-light">
        <tr>
            <th>STT</th>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Giới tính</th>
            <th>Nơi sinh</th>
            <th>Mã phòng</th>
            <th>Lương</th>
            <th>Action</th> </tr>
    </thead>
    <tbody>
        <?php if (!empty($nhanvien)): ?>
            <?php $stt = $vi_tri_bat_dau + 1; ?>
            <?php foreach ($nhanvien as $nv): ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td><?= $nv['Ma_NV'] ?></td>
                    <td><?= $nv['Ten_NV'] ?></td>
                    <td>
                        <?php if ($nv['Phai'] == 'Nu'): ?>
                            <img src="/GiuaKy/public/images/woman.png" alt="Nữ" class="gender-icon">
                        <?php else: ?>
                            <img src="/GiuaKy/public/images/man.png" alt="Nam" class="gender-icon">
                        <?php endif; ?>
                    </td>
                    <td><?= $nv['Noi_Sinh'] ?></td>
                    <td><?= $nv['Ma_Phong'] ?></td>
                    <td><?= number_format($nv['Luong']) ?> VND</td>
                    <td> <a href="index.php?controller=people&action=edit&id=<?= $nv['Ma_NV'] ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="index.php?url=People/edit/<?= $nv['Ma_NV'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Không có dữ liệu</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $tong_so_trang; $i++): ?>
            <li class="page-item <?= ($i == $trang_hien_tai) ? 'active' : '' ?>">
                <a class="page-link" href="?controller=people&action=index&trang=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php require_once 'app/views/shares/footer.php'; ?>