<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh viên</title>
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
   

    <form action="process_add_student.php" method="post">
         <h2>Thêm Sinh viên</h2>
        <label for="masv">Mã Sinh viên:</label>
        <input type="text" name="masv" required><br>

        <label for="tensv">Tên Sinh viên:</label>
        <input type="text" name="tensv" required><br>

        <label for="lopsv">Lớp:</label>
        <input type="text" name="lopsv" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" name="add_student" value="Thêm">

       <a href="index.php">Quay lại</a> 
    </form>

    

   

</body>
</html>
