<?php
session_start();
//echo "hello mvc";

//lấy ra các tham số tương ứng với controller và action
//mà mình đã tự quy định từ trước
//trong khóa học, thì tham số truyền url sẽ có dạng sau
//http://localhost?controller=book&action=index
//lấy ra controller
$controller = isset($_GET['controller'])
    ? $_GET['controller'] : 'book';
//lấy ra action
$action = isset($_GET['action']) ? $_GET['action'] :
    'index';
print_r($controller);
print_r($action);

//sau khi lấy đc 2 tham số controller và action,
//việc tiếp theo là chuyển đổi controller thành chính tên
//class mà bạn đã tạo ra
//book -> mục tiêu là tạo ra
// đươc 1 chuỗi tên là BookController.php
//chuyển k
$controller = ucfirst($controller);
//Book
//nối chuỗi Controller.php để thành tên 1 file
$fileController = $controller . "Controller.php";
print_r($fileController);

//nhúng file vừa chuyển đổi ở trên vào để có thể sử dụng
//class của file đó
//khai báo đường dẫn tới file controller ở trên
//để chuẩn bị nhúng vào hệ thống
$pathController = "controllers/$fileController";
print_r($pathController);

//nhúng file controller vào để chuẩn bị khởi tạo đối tượng
//và gọi action tương ứng
//trước khi nhúng cần kiểm tra xem file đã tồn tại hay chưa,
//tương đương với trang Not found
if (!file_exists($pathController)) {
    die("Trang bạn tìm không tồn tại");
}
require_once "$pathController";
//sau khi nhúng file thành công,
// nghĩa là có thể sử dụng
//code bên trong file đó
//bắt đầu khởi tạo đối tượng từ file trên
//BookController
$classController = $controller."Controller";
$object = new $classController();
//gọi phương thức mà user truyền lên thông qua tham
//số action trên url
//nếu action ko tồn tại thì báo lỗi
if (!method_exists($object, $action)) {
    die("Phương thức $action
     không tồn tại trong class $classController");
}
$object->$action();
?>