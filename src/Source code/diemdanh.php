<!-- Trang điểm danh -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm Danh</title>
    <!-- Thêm các thư viện cần thiết -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-right: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    // Kiểm tra xem có tham số `session` được truyền không
    if (isset($_GET['session'])) {
        // Lấy giá trị của tham số `session`
        $session = $_GET['session'];

        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy danh sách sinh viên cho buổi học cụ thể
        $result_students = $conn->query("SELECT SINHVIEN.MASV, TENSV
                                        FROM CHUYENCAN
                                        JOIN SINHVIEN ON CHUYENCAN.MASV = SINHVIEN.MASV
                                        WHERE NGAYCC = '$session'");

        if ($result_students->num_rows > 0) {
            echo "<h2>Điểm danh - Buổi $session</h2>";
            echo "<ul>";

            while ($student_row = $result_students->fetch_assoc()) {
                echo "<li>";
                echo "<label for='attendance_" . $student_row['MASV'] . "'>" . $student_row['TENSV'] . "</label>";
                echo "<input type='radio' id='attendance_" . $student_row['MASV'] . "' name='attendance[" . $student_row['MASV'] . "]' value='1'> Đi học";
                echo "<input type='radio' name='attendance[" . $student_row['MASV'] . "]' value='0'> Vắng học";
                echo "</li>";
            }

            echo "</ul>";
            echo "<button onclick='submitAttendance()'>Lưu điểm danh</button>";
        } else {
            echo "<p>Không có sinh viên nào cho buổi học này.</p>";
        }

        // Đóng kết nối
        $conn->close();
    } else {
        // Nếu không có tham số `session`, thông báo lỗi
        echo "<p>Không có thông tin buổi học được cung cấp.</p>";
    }
    ?>

    <script>
        function submitAttendance() {
            // TODO: Gửi dữ liệu điểm danh lên server và xử lý
            alert("Dữ liệu điểm danh đã được gửi lên server.");
        }
    </script>
</body>
</html>
