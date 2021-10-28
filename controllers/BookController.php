<?php
require_once 'models/Book.php';
class BookController {
    /**
     * Liệt kê các sách đang có trên hệ thống
     */
    public function index() {
        echo "<h1>Trang liệt kê sách</h1>";
        //gọi view để hiển thị dữ liệu
        //gọi view thực chất là nhúng file view vào
        //gọi file luôn phải nhớ là đứng tại
//        vị trí file index gốc của ứng dụng
        $book = new Book();
        $books = $book->index();
//        print_r($books);
        require_once 'views/books/index.php';
    }

    public function add() {
        $error = '';
        //xử lý submit form
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            //xử lý validate, nếu mà để trống tên sách
//            thì báo lỗi và không cho submit form
            if (empty($name)) {
                $error = "Name không được để trống";
            }
            else {
                //gọi model để insert dữ liệu vào database
                $book = new Book();
                //gọi phương thức để insert dữ liệu
                //nên tạo 1 mảng tạm để lưu thông tin của
//                đối tượng dựa theo cấu trúc bảng
                $bookArr = [
                    'name' => $name
                ];
                $isInsert = $book->insert($bookArr);
                if ($isInsert) {
                    $_SESSION['success'] = "Thêm mới thành công";
                }
                else {
                    $_SESSION['error'] = "Thêm mới thất bại";
                }
                header("Location: index.php?controller=book&action=index");
                exit();
            }
        }
        //gọi view
        require_once 'views/books/add.php';
    }

    public function edit() {
        //lấy ra thông tin sách dựa theo id đã gắn trên url
        //xử lý validate cho trường hợp id truyền lên không hợp lệ
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Tham số không hợp lệ";
            header("Location: index.php?controller=book&action=index");
            return;
        }
        if (!is_numeric($_GET['id'])) {
            $_SESSION['error'] = "Id phải là số";
            header("Location: index.php?controller=book&action=index");
            return;
        }
        $id = $_GET['id'];
        //gọi model để lấy ra đối tượng sách theo id
        $bookModel = new Book();
        $book = $bookModel->getBookById($id);

        //xử lý submit form, lặp lại thao tác khi submit lúc thêm mới
        $error = '';
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            //check validate dữ liệu
            if (empty($name)) {
                $error = "Name không được để trống";
            }
            else {
                //xử lý update dữ liệu vào hệ thống
                $bookModel = new Book();
                $bookArr = [
                    'id' => $id,
                    'name' => $name
                ];
                $isUpdate = $bookModel->update($bookArr);
                if ($isUpdate) {
                    $_SESSION['success'] = "Update bản ghi #$id thành công";
                }
                else {
                    $_SESSION['error'] = "Update bản ghi #$id thất bại";
                }
                header("Location: index.php?controller=book&action=index");
                exit();
            }
        }
        //truyền ra view
        require_once 'views/books/edit.php';
    }

    public function delete() {
        //url trên trình dueyjet sẽ có dạng
//        ?controller=book&action=delete&id=1
        //bắt id từ trình duyêtj
        $id = $_GET['id'];
        if (!is_numeric($id)) {
            header("Location: index.php?controller=book&action=index");
            exit();
        }

        $book = new Book();
        $isDelete = $book->delete($id);

        if ($isDelete) {
            //chuyển hướng về trang liệt kê danh sách
            //tạo session thông báo mesage
            $_SESSION['success'] = "Xóa bản ghi #$id thành công";
        }
        else {
            //báo lỗi
            $_SESSION['error'] = "Xóa bản ghi #$id thất bại";
        }


        exit();


    }
}