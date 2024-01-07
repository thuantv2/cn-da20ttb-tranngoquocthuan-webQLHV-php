<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_student"])) {
    $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $id = $_POST["id"];
    $tensv = $_POST["tensv"];
    $lopsv = $_POST["lopsv"];
    $email = $_POST["email"];

    $sql = "UPDATE SINHVIEN SET TENSV = '$tensv', LOPSV = '$lopsv', EMAIL = '$email' WHERE MASV = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Sửa sinh viên thành công.</p>";

        // Chuyển hướng về trang QLSV.php sau khi lưu thành công
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Nếu không phải là phương thức POST hoặc không có tham số 'edit_student', thì chuyển hướng hoặc xử lý khác
    header("Location: QLSV.php"); // Chuyển hướng về trang danh sách sinh viên
    exit();
}
?>
