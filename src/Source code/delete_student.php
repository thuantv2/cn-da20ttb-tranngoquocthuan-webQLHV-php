<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xoá Sinh viên</title>
</head>
<body>
<style>
    form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

p {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
h2 {
    text-align: center;
}
</style>
   

    <?php
    $id = $_GET['id'];

    $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM SINHVIEN WHERE MASV = '$id'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
       
        <form action="" method="post">
             <h2>Xoá Sinh viên</h2>
             <p>Bạn có chắc chắn muốn xoá sinh viên <?php echo $row['TENSV']; ?>?</p>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="delete_student" value="Xoá">
            <a href="index.php">Quay lại</a>
        </form>

    <?php
    } else {
        echo "<p>Không tìm thấy sinh viên có mã $id.</p>";
    }

    $conn->close();
    ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_student"])) {
    $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $id = $_POST["id"];

    $sql = "DELETE FROM SINHVIEN WHERE MASV = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Xoá sinh viên thành công.</p>";

        // Chuyển hướng về trang index sau khi xoá thành công
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>



</body>
</html>
