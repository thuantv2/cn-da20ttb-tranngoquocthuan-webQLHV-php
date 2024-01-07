<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Môn Học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .sua {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        form {
            margin-top: 20px;
        }

        strong {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 20px;
            text-align: center;
        }
    </style>

</head>

<body>
<div class="sua">
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
                echo "<h2>Sửa Môn Học</h2>";
                echo "<strong><form action='edit_subject.php' method='post'>";
                echo "<strong><input type='hidden' name='mamh' value='{$mamh}'>";
                echo "<strong>Tên Môn Học: <input type='text' name='tenmh' value='{$subject_row['TENMH']}' required><br>";
                echo "<strong>Số Tiết: <input type='number' name='sotiet' value='{$subject_row['SOTIET']}' required><br>";
                echo "<input type='submit' name='submit_edit_subject' value='Lưu'>";
                echo "</form>";

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_edit_subject"])) {
                    $tenmh = $_POST["tenmh"];
                    $sotiet = $_POST["sotiet"];

                    $conn->query("UPDATE MONHOC 
                                  SET TENMH = '$tenmh', SOTIET = '$sotiet'
                                  WHERE MAMH = '$mamh'");

                    echo "<p>Sửa thông tin môn học thành công.</p>";
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
</body>
</html>
