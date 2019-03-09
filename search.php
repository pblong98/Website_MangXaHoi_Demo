<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="./css/search.css" />
    <script type="text/javascript" src="./javascript/wall.js"></script>
    <?php
        include_once('functions.php');
        if(!isset($_SESSION['USER']))
        {
            if(isset($_REQUEST['ID']) && isset($_REQUEST['PASS']))
            {
                if(DangNhap($_REQUEST['ID'], $_REQUEST['PASS']) == "Đăng nhập thành công")
                {
                    $_SESSION['USER'] = $_REQUEST['ID'];
                    header('Location:./wall.php');
                }
                else
                {
                    echo "Có điều gì đó vô cùng sai đã sảy ra !";
                }
            }
            else
            {
                header('Location:./index.php');
            }
        }
        else
        {
            echo '<title>'.$_SESSION['USER'].'</title>';
        }
        if(!isset($_REQUEST['keyword']))
        {
            header('Location:./wall.php');
        }
    ?>
</head>
<body >
    <?php include('header.php'); ?>

    <div id = "ResultContainer">
        <div id = "TieuDe_dsbaiviet">Người dùng phù hợp với kết quả</div>
        
        <div id= "profileSearchResult">
            <ul style="list-style-type: none">
                <?php LoadDanhSachNguoiDungTheoTuKhoa($_REQUEST['keyword']) ?>
            </ul>
        </div>
        
        <div id = "TieuDe_dsbaiviet">Bài viết phù hợp với kết quả</div>
        <?php LoadDanhSachBaiVietTheoTuKhoa($_REQUEST['keyword'])?>
    </div>
    
</body>
</html>