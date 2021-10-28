<?php
//file hiển thị thông báo lỗi
require_once 'views/commons/message.php';
?>

<a href="index.php?controller=book&action=add">
    Thêm mới sách
</a>
<table border="1" cellspacing="0" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th></th>
    </tr>
    <?php if (!empty($books)): ?>
        <?php foreach ($books AS $book) : ?>
            <tr>
                <td><?php echo $book['id'] ?></td>
                <td><?php echo $book['name'] ?></td>
                <td>
                    <?php
                    //khai báo 3 url xem, sửa, xóa
                    $urlDetail =
                        "index.php?controller=book&action=detail&id=" . $book['id'];
                    $urlEdit =
                        "index.php?controller=book&action=edit&id=" . $book['id'];
                    $urlDelete =
                        "index.php?controller=book&action=delete&id=" . $book['id'];
                    ?>
                    <a href="<?php echo $urlDetail?>">Chi tiết</a> &nbsp;
                    <a href="<?php echo $urlEdit?>">Edit</a> &nbsp;
                    <a onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                       href="<?php echo $urlDelete?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="2">KHông có dữ liệu</td>
        </tr>
    <?php endif; ?>
</table>