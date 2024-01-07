<title>Xóa Môn Học</title>
<style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .xoa {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            background-color: #dc3545;
            color: #ffffff;
            padding: 20px;
            margin: 0;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        p {
            margin-top: 20px;
            color: #495057;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #bd2130;
        }

        p.success {
            color: #28a745;
            font-weight: bold;
        }
    </style>
    <div class="xoa">
<?php
$conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["mamh"])) {
    $mamh = $_GET["mamh"];
    $result_subject = $conn->query("SELECT * FROM MONHOC WHERE MAMH = '$mamh'");

    if ($result_subject) {
        $subject_row = $result_subject->fetch_assoc();

        if ($subject_row) {
            echo "<h2>Xóa Môn Học</h2>";
            echo "<p>Bạn có chắc chắn muốn xóa môn học '{$subject_row['TENMH']}' (Mã Môn Học: {$mamh}) không?</p>";
            echo "<form action='delete_subject.php' method='post'>";
            echo "<input type='hidden' name='mamh' value='{$mamh}'>";
            echo "<input type='submit' name='submit_delete_subject' value='Xác Nhận'>";
            echo "</form>";

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_delete_subject"])) {
                $conn->query("DELETE FROM MONHOC WHERE MAMH = '$mamh'");
                echo "<p>Xóa môn học thành công.</p>";
            }
        } else {
            echo "<p>Không tìm thấy môn học có mã {$mamh}.</p>";
        }
    } else {
        echo "Query error: " . $conn->error;
    }
} else {
    echo "<p>Thiếu thông tin mã môn học.</p>";
}

$conn->close();
?>
</div>