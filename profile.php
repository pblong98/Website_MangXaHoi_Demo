<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/profilePage.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
    <script type="text/javascript" src="./javascript/profilePage.js"></script>
    
    <?php
        include_once('functions.php');
        if(KiemTraIdTrangCaNhan($_REQUEST['ID']) == 0)
            header('location: 404.php');
        if(!isset($_SESSION['USER']))
            header('location: index.php');
        echo '<title>'.$_REQUEST['ID'].'</title>';
    ?>
</head>
<body >
    <?php include('header.php')?>
    <div id= "FriendListSideBar">
        <ul style="color: white; text-align: center; margin-top: 5px;">
            Bạn bè của <?php echo $_REQUEST['ID'];?>
        </ul>
        <ul style="list-style-type: none">
            <?php LoadDanhSachBanBe($_REQUEST['ID'])?>
        </ul>
    </div>

    <div id = "ProfileArea">
        <?php echo LoadProfileInformation($_REQUEST['ID']);?>    
        <p style="text-align:center; margin-top: 10px; font-weight: bolder; color: rgb(255, 255, 255); background-color: rgb(36, 36, 36); padding: 5px;">BÀI VIẾT</p>   
        <?php echo LoadDanhSachBaiVietCaNhan($_REQUEST['ID']);?>
    </div>
    <?php echo TaoFormUpdate($_SESSION['USER'])?>
</body>
</html>
<?php include('footer.php')?>