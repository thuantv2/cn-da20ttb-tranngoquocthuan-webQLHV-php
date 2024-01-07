<?php
    if (isset($_REQUEST['frame'])){?>
        <li id="noselect"><a href="https://www.tvu.edu.vn/"><span>Trang chủ TVU</span></a></li>
        <li <?php if($_REQUEST['frame'] == 'MH') echo 'id="noselect"'; else echo 'id="noselect"' ?>><a href="./?frame=MH"><span>Điểm danh môn học</span></a></li>
        <li <?php if($_REQUEST['frame'] == 'QLSV') echo 'id="select"'; else echo 'id="noselect"' ?>><a href="./?frame=QLSV"><span>Quản lý thông tin sinh viên</span></a></li>      
        <li <?php if($_REQUEST['frame'] == 'THONGKE') echo 'id="noselect"'; else echo 'id="noselect"' ?>><a href="./?frame=THONGKE"><span>Thống kê</span></a></li>
    <?php }else { ?>
        <li id="noselect"><a href="https://www.tvu.edu.vn/"><span>Trang chủ TVU</span></a></li>
        <li id="noselect"><a href="./?frame=MH"><span>Điểm danh môn học</span></a></li>
        <li id="select"><a href="./?frame=QLSV"><span>Quản lý thông tin sinh viên</span></a></li>     
        <li id="noselect"><a href="./?frame=THONGKE"><span>Thống kê</span></a></li>
    <?php }
?>
