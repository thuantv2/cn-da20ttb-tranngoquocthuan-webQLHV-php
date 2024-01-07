<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_student"])) {
    $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $masv = $_POST["masv"];
    $tensv = $_POST["tensv"];
    $lopsv = $_POST["lopsv"];
    $email = $_POST["email"];

    $sql = "INSERT INTO SINHVIEN (MASV, TENSV, LOPSV, EMAIL) VALUES ('$masv', '$tensv', '$lopsv', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Thêm sinh viên thành công.</p>";

        // Chuyển hướng về trang QLSV.php sau khi thêm thành công
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
