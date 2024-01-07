<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Css/student.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
    <div class="bang">

        <form method="post">
            <label for="class">Chọn lớp:</label>
            <select name="class" id="class">
                <option value="DA20TTA">DA20TTA</option>
                <option value="DA20TTB">DA20TTB</option>
                <!-- Thêm các lớp khác nếu cần -->
            </select>
            <input type="submit" value="Xem danh sách">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedClass = $_POST["class"];

            // Kết nối CSDL và truy vấn sinh viên của lớp đã chọn
            $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            $query = "SELECT * FROM SINHVIEN WHERE LOPSV = '$selectedClass'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<h3>Danh sách Sinh viên</h3>";
                echo "<table>
                        <tr>
                            <th>Mã Sinh viên</th>
                            <th>Tên Sinh viên</th>
                            <th>Lớp</th>
                            <th>Email</th>
                            <th>Thao tác</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['MASV']}</td>
                            <td>{$row['TENSV']}</td>
                            <td>{$row['LOPSV']}</td>
                            <td>{$row['EMAIL']}</td>
                            <td>
                                <a href='add_student.php?id={$row['MASV']}'>Thêm sinh viên</a>
                                <a href='edit_student.php?id={$row['MASV']}'>Sửa</a>
                                <a href='delete_student.php?id={$row['MASV']}'>Xoá</a>
                            </td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Không có sinh viên nào.</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>

</html>
