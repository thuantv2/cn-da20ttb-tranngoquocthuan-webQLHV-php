<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Điểm Danh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h2 {
            text-align: center;
            background-color: #B0C4DE;
            color: white;
            padding: 10px;
        }

        .thongke-form {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        .canh-bao-button {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }

        /* Hiệu ứng hover khi di chuột vào nút cảnh báo */
        .canh-bao-button:hover {
            background-color: darkred;
        }
        .lop{
            background-color: white;
            color: black;
            font-size: larger;
        }

    </style>
</head>

<body>
    <h2>THỐNG KÊ ĐIỂM DANH</h2>
    <div class="thongke-form">
        <?php
        // Kết nối CSDL
        $conn = new mysqli("127.0.0.1", "root", "", "qlthuan1");

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Truy vấn thống kê số tiết vắng của sinh viên và áp dụng các quy tắc
        $result_thongke = $conn->query("SELECT chitietdiemdanh.MASV, sinhvien.TENSV, sinhvien.LOPSV, sinhvien.EMAIL, monhoc.MAMH, monhoc.TENMH, SUM(chitietdiemdanh.SOTIETVANG) AS TONGTIETVANG
        FROM chitietdiemdanh
        INNER JOIN sinhvien ON chitietdiemdanh.MASV = sinhvien.MASV
        INNER JOIN monhoc ON chitietdiemdanh.MAMH = monhoc.MAMH
        GROUP BY chitietdiemdanh.MASV, sinhvien.LOPSV, sinhvien.EMAIL, monhoc.MAMH, monhoc.TENMH
        ORDER BY sinhvien.LOPSV, TONGTIETVANG DESC");

        if ($result_thongke->num_rows > 0) {
            echo "<h3>Bảng theo dõi các sinh viên nghĩ học</h3>";

            $currentClass = ""; // Lớp hiện tại đang xử lý
            echo "<table>";
            echo "<tr>
                <th>Mã Sinh Viên</th>
                <th>Tên Sinh Viên</th>
                <th>Lớp</th>
                <th>Mã Môn Học</th>
                <th>Tên Môn Học</th>
                <th>Tổng Tiết Vắng</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>";

            while ($thongke_row = $result_thongke->fetch_assoc()) {
                $masv = $thongke_row['MASV'];
                $tong_tiet_vang = $thongke_row['TONGTIETVANG'];

                // Xử lý quy tắc và gán trạng thái
                $trang_thai = "";
                if ($tong_tiet_vang >= 16) {
                    $trang_thai = "Cấm thi";
                } elseif ($tong_tiet_vang >= 12) {
                    $trang_thai = "Cảnh cáo học vụ";
                } elseif ($tong_tiet_vang >= 10) {
                    $trang_thai = "Nhắc nhở";
                }

                // Tính phần trăm và thêm vào cột "Tổng Tiết Vắng"
                $ti_le_phan_tram = round(($tong_tiet_vang / 60) * 100, 2); // 60 là số tiết điểm danh tối đa (điều chỉnh nếu cần)

                // Kiểm tra xem lớp hiện tại có thay đổi không, nếu có thì tạo thêm dòng header cho lớp mới
                if ($currentClass != $thongke_row['LOPSV']) {
                    echo "<tr>
                        <th class ='lop' colspan='8'>Lớp {$thongke_row['LOPSV']}</th>
                    </tr>";

                    $currentClass = $thongke_row['LOPSV'];
                }

                echo "<tr>
                    <td>{$masv}</td>
                    <td>{$thongke_row['TENSV']}</td>
                    <td>{$thongke_row['LOPSV']}</td>
                    <td>{$thongke_row['MAMH']}</td>
                    <td>{$thongke_row['TENMH']}</td>
                    <td>{$tong_tiet_vang} ({$ti_le_phan_tram}%)</td>
                    <td>{$trang_thai}</td>
                    <td>";

                // Hiển thị nút cảnh báo màu đỏ nếu số tiết vắng vượt quá 12
                if ($tong_tiet_vang >= 12) {
                    echo "<button class='canh-bao-button' onclick=\"canhBao('{$thongke_row['EMAIL']}')\">Cảnh Báo</button>";
                } elseif ($tong_tiet_vang >= 10 && $tong_tiet_vang < 12) {
                    echo "<button onclick=\"guiNhacNho('{$thongke_row['EMAIL']}')\">Gửi Nhắc Nhở</button>";
                }

                echo "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Không có sinh viên nào.</p>";
        }
        ?>
        <script>
            function guiNhacNho(email) {
                // Thực hiện các thao tác gửi email nhắc nhở ở phía client
                alert("Gửi nhắc nhở đến " + email);
            }

            function canhBao(email) {
                // Thực hiện các thao tác cảnh báo ở phía client
                alert("Cảnh báo đến " + email);
            }
        </script>
    </div>
</body>

</html>
