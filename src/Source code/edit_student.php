<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh viên</title>
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

label {
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
        <form action="process_edit_student.php" method="post">
            <h2>Sửa Sinh viên</h2>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <label for="tensv">Tên Sinh viên:</label>
            <input type="text" name="tensv" value="<?php echo $row['TENSV']; ?>" required><br>

            <label for="lopsv">Lớp:</label>
            <input type="text" name="lopsv" value="<?php echo $row['LOPSV']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['EMAIL']; ?>" required><br>

            <input type="submit" name="edit_student" value="Lưu">
            <a href="index.php">Quay lại</a>
        </form>

    <?php
    } else {
        echo "<p>Không tìm thấy sinh viên có mã $id.</p>";
    }

    $conn->close();

    ?>

    
</body>
</html>
