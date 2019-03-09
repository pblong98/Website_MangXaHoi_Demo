<?php 
session_start();
session_destroy();
?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/loginPage.css" />
    <script type="text/javascript" src="./javascript/loginPage.js"></script>
</head>
<body onload="DangNhapMode(); Notification('show')">

    <div id="notificationBox">Chào mừng đến với mạng xã hội, xin mời đăng nhập hoặc đăng ký.</div>
    </div>
    <div id = "FormDangNhap">
        </br>
        <b>Đăng nhập</b>
        <div id ="ButtonGroup">              
            <span id="KNbtn" onclick="DangNhapMode()">Đăng nhập</span>
            <span id="KDbtn" onclick="DangKyMode()">Đăng ký</span> 
        </div> 
        <form>           
            <p>Tên đăng nhập:</p><input id = "TenDN" type="text" placeholder="Tên đăng nhập..." value=""/></br>
            <p>Mật khẩu:</p><input id = "MatKhau1" type="password" placeholder="Mật khẩu..." value=""/></br>
            <p class="DangKyItem">Nhập lại mật khẩu:</p><input type="password" id = "MatKhau2" class="DangKyItem" placeholder='Nhập lại mật khẩu...' value=""/>
            <input class="DangNhapItem" type="checkbox" name="remember"/><i class="DangNhapItem">Nhớ mật khẩu</i></br>      
            <div id ="button" onclick="Xacnhan()">Xác nhận</div>
            </br>
            Quên Mật Khẩu<a href="./fogot-password.php">Click vào đây</a>
        </form>
    </div>
</body>
</html>