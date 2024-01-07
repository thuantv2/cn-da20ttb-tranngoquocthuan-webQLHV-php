<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm Danh Sinh Viên</title>
    <style>
body {
    font-family: Arial, sans-serif;
    color: #333;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007bff;
}

.diemdanh-form {
    margin: 20px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: auto;
}

label {
    margin-top: 10px;
    font-weight: bold;
}

input[type="date"],
select {
    padding: 8px;
    margin-top: 5px;
}

input[type="submit"] {
    padding: 10px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

p {
    text-align: center;
    font-size: 18px;
    color: #555;
}

/* Style tooltip */
#so_tiet_vang[title] {
    position: relative;
}

#so_tiet_vang[title]:hover:after {
    content: attr(title);
    padding: 5px;
    background-color: #333;
    color: #fff;
    border-radius: 4px;
    position: absolute;
    z-index: 1;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
}
    </style>

</head>

<body>
    <h2>Điểm Danh Sinh Viên</h2>
    <div class="diemdanh-form">
        <form action="" method="post">
            <label for="ngay_diem_danh">Ngày điểm danh:</label>
            <input type="date" name="ngay_diem_danh" required>

            <label for="masv">Chọn Sinh Viên:</label>
            <select name="masv" id="masv">

                <?php
                // Connect to the database
                $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

                // Check connection
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Get the class from the URL parameter
                $selectedClass = $_GET['class'];

                // Query to get the list of students in the selected class
                $result_students = $conn->query("SELECT MASV, TENSV FROM SINHVIEN WHERE LOPSV = '$selectedClass'");

                // Check if there are students
                if ($result_students->num_rows > 0) {
                    while ($student_row = $result_students->fetch_assoc()) {
                        echo "<option value='{$student_row['MASV']}'>{$student_row['TENSV']}</option>";
                    }
                } else {
                    echo "<option value='' disabled>No students found</option>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </select>l

            <label for="mamh">Chọn Mã Môn Học:</label>
            <select name="mamh" id="mamh">
                <!-- Option tags for subjects go here -->
                <?php
                // Connect to the database
                $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

                // Check connection
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Query to get the list of subjects
                $result_subjects = $conn->query("SELECT MAMH, TENMH FROM MONHOC");

                // Check if there are subjects
                if ($result_subjects->num_rows > 0) {
                    while ($subject_row = $result_subjects->fetch_assoc()) {
                        echo "<option value='{$subject_row['MAMH']}'>{$subject_row['TENMH']}</option>";
                    }
                } else {
                    echo "<option value='' disabled>No subjects found</option>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </select>

            <label for="so_tiet_vang">Số Tiết Vắng:</label>
            <select name="so_tiet_vang" id="so_tiet_vang">
                <option value="1" title="1,67%">1</option>
                <option value="2" title="3,33%">2</option>
                <option value="3" title="5%">3</option>
                <option value="4" title="6,67%">4</option>
            </select>
            <input type="submit" name="submit_attendance" value="Lưu điểm danh">
        </form>
        <script>
    // Script để hiển thị tỷ lệ phần trăm khi di chuột vào số tiết vắng
    var selectElement = document.getElementById("so_tiet_vang");

    var timeoutId;

    selectElement.addEventListener("mouseenter", function () {
        var selectedOption = this.options[this.selectedIndex];
        if (selectedOption) {
            var percentage = selectedOption.getAttribute("title");
            this.title = "Tỷ lệ: " + percentage;

            // Đặt độ trễ 500ms (có thể điều chỉnh theo ý muốn)
            timeoutId = setTimeout(function () {
                selectElement.title = "";
            }, 10);
        }
    });

    selectElement.addEventListener("mouseleave", function () {
        clearTimeout(timeoutId);
        this.title = "";
    });
</script>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_attendance"])) {

    // Get the form data
    $ngay_diem_danh = $_POST["ngay_diem_danh"];
    $masv = $_POST["masv"];
    $mamh = $_POST["mamh"];
    $so_tiet_vang = $_POST["so_tiet_vang"];

    // Connect to the database
    $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

    // Check connection
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Check if the subject exists in the monhoc table
    $result_subject = $conn->query("SELECT * FROM monhoc WHERE MAMH = '$mamh'");

    if ($result_subject->num_rows == 0) {
        // The subject does not exist, you may want to handle this situation accordingly
        echo "<p>Mã môn học không tồn tại.</p>";
    } else {
        // Insert the attendance record into the database
        $result_insert = $conn->query("INSERT INTO chitietdiemdanh (MASV, MAMH, NGAYCC, SOTIETVANG) VALUES ('$masv', '$mamh', '$ngay_diem_danh', $so_tiet_vang)");

        // Check if the insertion was successful
        if ($result_insert) {
            echo "<p>Điểm danh thành công.</p>";

            // Thực hiện các cập nhật khác nếu cần
            // Ví dụ: Cập nhật tổng số tiết vắng của sinh viên
            $conn->query("UPDATE sinhvien SET TONGTIETVANG = TONGTIETVANG + $so_tiet_vang WHERE MASV = '$masv'");
        } else {
            echo "<p>Điểm danh thất bại. Lỗi: " . $conn->error . "</p>";
        }
    }

    // Close the database connection
    $conn->close();
}
?>
<p style="text-align: center; margin-top: 20px;"><a href="index.php">Quay về Trang Chủ</a></p>
    </div>

</body>

</html>
