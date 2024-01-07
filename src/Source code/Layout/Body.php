<div id="wrapper_body" class="clr">
    <div class="main-wrapper_body">
        <?php
        if (isset($_REQUEST['frame'])){
            switch ($_REQUEST['frame']){
                case "QLSV": 
                    include 'QLSV.php';
                    break;
                case "MH":
                    include 'MH.php';
                    break;
                case "THONGKE": 
                    include 'THONGKE.php';
                    break;
                default: 
                    include 'QLSV.php';
                    break;
            }
        }
        else {
            include 'MH.php';
        }
        ?>
    </div>
</div>
