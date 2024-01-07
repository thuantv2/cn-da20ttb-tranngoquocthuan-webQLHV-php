<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm danh môn học</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        div.tk{
            background: white;
            color: black;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            line-height: 2;  
        }

        h2 {
            text-align: center;
            background-color: #B0C4DE;
            color: white;
            padding: 10px;
        }

        .gv {
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: black;
        }

        input[type="text"] {
            padding: 8px;
            width: 250px;
            font-size: 15px;
        }

        input[type="submit"] {
            padding: 8px 12px;
            color: #fff;
            background-color: #4452b1;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #172baf;
        }

        h3 {
            color: #007180;
            font-size: 20px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007180;
            color: #fff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
       
        /* Your existing styles remain unchanged */

        .ndd {
            display: none; /* Initially hide the attendance form container */
            margin-top: 20px;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
        }

        .ndd h4 {
            color: #007180;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .ndd form {
            margin-top: 10px;
        }

        .ndd label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .ndd select,
        .ndd input[type="date"],
        .ndd input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .ndd select {
            width: 100%;
        }

        .ndd input[type="submit"] {
            color: #fff;
            background-color: #007180;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ndd input[type="submit"]:hover {
            background-color: #004e52;
        }
    </style>
</head>

<body>
    <h2>ĐIỂM DANH MÔN HỌC</h2>
    <div class="gv">
        <!-- Phần tìm kiếm giáo viên -->
        <form action="" method="post">
            <label for="magv_search">Nhập mã giáo viên:</label>
            <input type="text" name="magv_search" required>
            <input type="submit" name="search_teacher" value="Tìm kiếm">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_teacher"])) {
            $magv_search = $_POST["magv_search"];

            $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Lấy thông tin giáo viên
            $result_teacher = $conn->query("SELECT * FROM GIAOVIEN WHERE MAGV = '$magv_search'");

            if ($result_teacher) {
                $teacher_row = $result_teacher->fetch_assoc();
                echo "<div class='tk'>";
                if ($teacher_row) {
                    echo "<h3>Thông Tin Giáo Viên</h3>";
                    echo "<strong>Tên Giáo Viên:</strong> {$teacher_row['TENGV']}<br>";
                    echo "<strong>Mã Giáo Viên:</strong> {$teacher_row['MAGV']}<br>";

                    // Lấy thông tin môn học giáo viên dạy
                    $result_subjects = $conn->query("SELECT DISTINCT MONHOC.MAMH, TENMH, SOTIET
                    FROM CHUYENCAN
                    JOIN MONHOC ON CHUYENCAN.MAMH = MONHOC.MAMH
                    WHERE CHUYENCAN.MAGV = '$magv_search'");

                    if ($result_subjects !== false && $result_subjects->num_rows > 0) {
                        echo "<h4>Danh Sách Môn Học</h4>";

                        while ($subject_row = $result_subjects->fetch_assoc()) {
                            echo "<p>";
                            // Hiển thị thông tin môn học
                            echo "<strong>Mã môn học:</strong> {$subject_row['MAMH']}<br>";
                            echo "<strong>Tên môn học:</strong> {$subject_row['TENMH']}<br>";
                            echo "<strong>Tổng số tiết:</strong> {$subject_row['SOTIET']}<br>";

                            // Thêm combo box chọn mã lớp và hidden input để lưu mã môn học
                            echo "<form action='' method='post'>";
                            echo "<label for='malop'>Chọn Mã Lớp:</label>";
                            echo "<select name='malop'>";
                            // Truy vấn CSDL để lấy danh sách các lớp
                            $result_classes = $conn->query("SELECT DISTINCT LOPSV FROM SINHVIEN");
                            while ($class_row = $result_classes->fetch_assoc()) {
                                echo "<option value='{$class_row['LOPSV']}'>{$class_row['LOPSV']}</option>";
                            }
                            echo "</select>";

                            // Hidden input để lưu mã môn học
                            echo "<input type='hidden' name='mamh' value='{$subject_row['MAMH']}'>";

                            echo " | <input type='submit' name='submit_class_selection' value='Điểm danh'>";
                            echo "</form>";

                            // Thêm nút điểm danh với mã môn học

                            // Hiển thị form điểm danh
                            echo "<div class='ndd' id='attendanceFormContainer_{$subject_row['MAMH']}' style='display: none;'>";
                            echo "<h4>CHI TIẾT ĐIỂM DANH - {$subject_row['TENMH']}</h4>";
                            echo "<form action='' method='post'>";
                            echo "<label for='ngay_diem_danh'>Ngày điểm danh:</label>";
                            echo "<input type='date' name='ngay_diem_danh' required>";
                            echo "&ensp;&ensp;<label for='student'>Chọn sinh viên:</label>";
                            echo "<select name='masv' id='student'>";
                            // Populate the student options based on the selected class...
                            echo "</select>";
                            echo "&ensp;&ensp;<label for='so_tiet_vang'>Số tiết vắng:</label>";
                            echo "<select name='so_tiet_vang' id='so_tiet_vang'>";
                            for ($i = 1; $i <= 4; $i++) {
                                $percentage = $i / 60 * 100; // Calculate the percentage
                                echo "<option value='{$i}' title='{$percentage}%' >{$i}</option>";
                            }
                            echo "</select>";
                            echo "<input type='hidden' name='mamh' value='{$subject_row['MAMH']}'>"; // Hidden input để lưu mã môn học
                            echo "&ensp;&ensp;<input type='submit' name='submit_attendance' value='Lưu điểm danh'>";
                            echo "</form>";
                            echo "</div>";

                            echo "</p>";
                        }
                    } else {
                        echo "<p>Giáo viên này không dạy môn học nào.</p>";
                    }
                }
                echo "</div>";
            }
        }

        // Xử lý khi người dùng chọn lớp và gửi điểm danh
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_class_selection"])) {
            $selected_class = $_POST["malop"];
            $selected_subject = $_POST["mamh"];

          // Lấy danh sách sinh viên theo lớp đã chọn
          $result_students = $conn->query("SELECT MASV, TENSV FROM SINHVIEN WHERE LOPSV = '$selected_class'");

          if ($result_students->num_rows > 0) {
              echo "<div class='ndd' id='attendanceFormContainer' style='display: block;'>";
              echo "<h4>CHI TIẾT ĐIỂM DANH - {$selected_subject}</h4>";
              echo "<form action='' method='post'>";
              echo "<label for='ngay_diem_danh'>Ngày điểm danh:</label>";
              echo "<input type='date' name='ngay_diem_danh' required>";
              echo "&ensp;&ensp;<label for='student'>Chọn sinh viên:</label>";
              echo "<select name='masv' id='student'>";
              while ($student_row = $result_students->fetch_assoc()) {
                  echo "<option value='{$student_row['MASV']}'>{$student_row['TENSV']}</option>";
              }
              echo "</select>";
              echo "&ensp;&ensp;<label for='so_tiet_vang'>Số tiết vắng:</label>";
              echo "<select name='so_tiet_vang' id='so_tiet_vang'>";
              for ($i = 1; $i <= 4; $i++) {
                  $percentage = $i / 60 * 100; // Calculate the percentage
                  echo "<option value='{$i}' title='{$percentage}%' >{$i}</option>";
              }
              echo "</select>";
              echo "<input type='hidden' name='mamh' value='{$selected_subject}'>"; // Hidden input để lưu mã môn học
              echo "&ensp;&ensp;<input type='submit' name='submit_attendance' value='Lưu điểm danh'>";
              echo "</form>";
              echo "</div>";
          } else {
              echo "<p>Không có sinh viên nào được tìm thấy trong lớp {$selected_class}.</p>";
          }

      } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_attendance"])) {
          // Xử lý khi người dùng gửi thông tin điểm danh
          $ngay_diem_danh = $_POST["ngay_diem_danh"];
          $masv = $_POST["masv"];
          $so_tiet_vang = $_POST["so_tiet_vang"];
          $mamh = $_POST["mamh"];

          // Lưu thông tin điểm danh vào CSDL
          $sql = "INSERT INTO CHITIETDIEMDANH (NGAYcc, MASV, MAMH, SOTIETVANG) VALUES ('$ngay_diem_danh', '$masv', '$mamh', '$so_tiet_vang')";

          if ($conn->query($sql) === TRUE) {
              echo "Điểm danh thành công!";
              // Không cần chuyển hướng về trang khác
          } else {
              echo "Lỗi: " . $sql . "<br>" . $conn->error;
          }
      }
      ?>
  </div>

  <script>
      function showAttendanceForm(mamh, tenmh) {
          var formContainer = document.getElementById('attendanceFormContainer_' + mamh);
          formContainer.style.display = 'block';
      }
  </script>
</body>
</html>