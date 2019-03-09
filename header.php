<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
    <script type="text/javascript" src="./javascript/profilePage.js"></script>
    <script type="text/javascript" src="./javascript/header.js"></script> 
    <?php
        include_once('functions.php');
        function loadAnhDD()
        {
            global $conn;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conn->prepare("select * from account where ID = :ID limit 1");
            $result->execute(array('ID' => $_SESSION['USER']));
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return '"background-image: url('.$row['AVATAR_LINK'].');"';
        }
    ?>
</head>
<body >
    <div id = "MenuBar">
        <img src="./img/Logo.png"/>
        <input type="text" placeholder="Tìm kiếm..." id="searchBox"/>
        <button id="searchBTN" onclick="search();" ></button>
        <button id="notifiBox">Thông báo</button>
        <a href="wall.php"><button id="HomeBTN">Trang chủ</button></a>
        <a href=<?php echo 'profile.php?ID='.$_SESSION['USER']?>><button id="ProfileBTN" style=<?php echo loadAnhDD();?>><?php echo $_SESSION['USER']?></button></a>
        <a href="index.php"><button id="LogoutBTN">Đăng xuất</button></a>
    </div>
</body>
</html>