<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cập nhật hình đại diện</title>
    <?php
        include_once('functions.php');
    ?>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
        }
        h3{
            text-align: center;
            margin-bottom: 20px;
            color: rgb(0, 78, 97);
        }
    </style>
</head>
<body >
    <h3>Cập nhật ảnh đại diên</h3>
    <div class="container">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="avatar"/>
            <input type="submit" name="uploadclick" value="Upload"/>
        </form>
	</div>
    
    <?php // Xử Lý Upload
    
    // Nếu người dùng click Upload
    if (isset($_POST['uploadclick']))
    {
        // Nếu người dùng có chọn file để upload
        if (isset($_FILES['avatar']))
        {
            // Nếu file upload không bị lỗi,
            // Tức là thuộc tính error > 0
            if ($_FILES['avatar']['error'] > 0)
            {
                echo 'File Upload Bị Lỗi';
            }
            else{               
                // Upload file
                move_uploaded_file($_FILES['avatar']['tmp_name'], './img/avatar/'.$_FILES['avatar']['name']);
                uploadAvartar($_SESSION['USER'],'./img/avatar/'.$_FILES['avatar']['name']);
                echo 'Cập nhật hình đại diện thành công !';
            }
        }
        else{
            echo 'Bạn chưa chọn file upload';
        }
    }
?>

</body>

</html>