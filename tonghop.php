<?php
const DB_HOST = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'dhtl_danba';

class Book
{
    public $id;
    public $name;

    public function insert($param = [])
    {
        $connection = $this->connectDb();
        //tạo và thực thi truy vấn
        $queryInsert = "INSERT INTO books(`name`) 
        VALUES ('{$param['name']}')";
        $isInsert = mysqli_query($connection, $queryInsert);
        $this->closeDb($connection);

        return $isInsert;
    }

    public function getBookById($id = null)
    {
        $connection = $this->connectDb();
        $querySelect = "SELECT * FROM books WHERE id=$id";
        $results = mysqli_query($connection, $querySelect);
        $book = [];
        if (mysqli_num_rows($results) > 0) {
            $books = mysqli_fetch_all($results, MYSQLI_ASSOC);
            $book = $books[0];
        }
        $this->closeDb($connection);

        return $book;
    }

    /**
     * Truy vấn lấy ra tất cả sách trong CSDL
     */
    public function index()
    {
        $connection = $this->connectDb();
        //truy vấn
        $querySelect = "SELECT * FROM books";
        $results = mysqli_query($connection, $querySelect);
        $books = [];
        if (mysqli_num_rows($results) > 0) {
            $books = mysqli_fetch_all($results, MYSQLI_ASSOC);
        }
        $this->closeDb($connection);

        return $books;
    }

    public function update($book = [])
    {
        $connection = $this->connectDb();
        $queryUpdate = "UPDATE books 
    SET `name` = '{$book['name']}' WHERE `id` = {$book['id']}";
        $isUpdate = mysqli_query($connection, $queryUpdate);
        $this->closeDb($connection);

        return $isUpdate;
    }

    public function delete($id = null)
    {
        $connection = $this->connectDb();

        $queryDelete = "DELETE FROM books WHERE id = $id";
        $isDelete = mysqli_query($connection, $queryDelete);

        $this->closeDb($connection);

        return $isDelete;
    }

    public function connectDb()
    {
        $connection = mysqli_connect(
            DB_HOST,
            DB_USERNAME,
            DB_PASSWORD,
            DB_NAME
        );
        if (!$connection) {
            die("Không thể kết nối. Lỗi: " . mysqli_connect_error());
        }

        return $connection;
    }

    public function closeDb($connection = null)
    {
        mysqli_close($connection);
    }
}
echo "<h1>Trang liệt kê sách</h1>";
//gọi view để hiển thị dữ liệu
//gọi view thực chất là nhúng file view vào
//gọi file luôn phải nhớ là đứng tại
//        vị trí file index gốc của ứng dụng
$book = new Book();
$books = $book->index();


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
    <?php if (!empty($books)) : ?>
        <?php foreach ($books as $book) : ?>
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
                    <a href="<?php echo $urlDetail ?>">Chi tiết</a> &nbsp;
                    <a href="<?php echo $urlEdit ?>">Edit</a> &nbsp;
                    <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="<?php echo $urlDelete ?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="2">KHông có dữ liệu</td>
        </tr>
    <?php endif; ?>
</table>