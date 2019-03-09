<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
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
    ?>
</head>
<body >
    <?php include('header.php')?>
    <div id= "FriendListSideBar">
        <ul style="list-style-type: none">
            <?php LoadDanhSachBanBe($_SESSION['USER'])?>
        </ul>
    </div>
    <div id = "PostArea">
        <div id ="NewPost">
            <div id="UpLoadPostOption">
                <form method="post" action="wall.php" enctype="multipart/form-data">  
                    <textarea id="newpostInput" placeholder="Đăng bài viết" name="content"></textarea>                
                    <input type="file" name="image"/>
                    <i style="font-size: 14px;">Chế độ công khai: </i>
                    <select name = "publicity">
                        <option value="public">Mọi người</option>
                        <option value="friend">Bạn bè</option>
                        <option value="private">Cá nhân</option>
                    </select>
                    <input type="submit" name="uploadclick" id="NewPostBTN" value="Đăng"/>
                </form>
                <?php // Xử Lý Upload  
                // Nếu người dùng click Upload
                if (isset($_POST['uploadclick']))
                {
                    $imageLink = 'no';
                    // Nếu người dùng có chọn file để upload
                    if (isset($_FILES['image']))
                    {
                        // Nếu file upload không bị lỗi,
                        // Tức là thuộc tính error > 0
                        if ($_FILES['image']['error'] > 0)
                        {
 
                        }
                        else{               
                            // Upload file
                            move_uploaded_file($_FILES['image']['tmp_name'], './img/postImg/'.$_FILES['image']['name']);
                            $imageLink = './img/postImg/'.$_FILES['image']['name'];
                        }                       
                    }                   
                    dangBaiViet($_POST['content'], $_POST['publicity'], $imageLink);
                    echo '<script> alert("Đăng bài viết thành công!");</script>';
                    header('Refresh: 0.5, URL= wall.php');
                }
                ?>
            </div>
        </div>
       
        <?php
            echo LoadDanhSachBaiViet();
        ?>
    </div>
    <?php include('footer.php')?>
</body>
</html>