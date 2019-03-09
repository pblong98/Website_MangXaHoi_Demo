<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
    <script type="text/javascript" src="./javascript/wall.js"></script>
    <title>Khôi phục mật khẩu</title>
    
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    require_once 'functions.php';
    $page='fogot-password';
     if(isset($_POST['email']))
     {
         $email=$_POST['email'];     
         $user=findUserByEmail($email);
         echo $user['ID'];
         if($user)
         {
             $secret=createResetPassword($user['ID']);
             sendEmail($user['email'],$user['NAME'],'Yêu cầu đổi mật khẩu',
             'Click <a href="http:///localhost:8080/ltw1_18_11/reset-password.php?secret='.$secret.'"> vào đây </a>');
         }
     }
    ?>
<h1> Khôi phục mật khẩu</h1>
<?php if (!isset($_POST['email'])) :?>
<form action="fogot-password.php" method="post">
  <div class="form-group">
    <label for="email">Địa chỉ Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn">  
  </div>
  <button type="submit" class="btn btn-primary">Khôi phục</button>
</form>
    <?php else:?>
   
<p class="text-success"><h3>Đã gửi thông tin khôi phục mật khẩu!!!</h3></p>
</br>
<p><a href="./index.php" class="text-primary">Trang Chủ</a></p>
<?php endif;?>
    </div>
</body>
</html>

   
   