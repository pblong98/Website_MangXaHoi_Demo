<html lang="en">
<head>
    
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/wall.css" />
    <script type="text/javascript" src="./javascript/wall.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Khôi phục mật khẩu</title>
</head>
<body>
    <div class="container">

<?php
require_once 'functions.php';
$page='forgot-password';
$success=false;
if(isset($_POST['secret'])&& isset($_POST['password']))
{
    $password=$_POST['password'];
    $secret=$_POST['secret'];
    $passwordHash=password_hash($password,PASSWORD_BCRYPT);
    $reset=findResetPassword($secret);
    if($reset &&!$reset['used'])
    {
        $userId=$reset['userId'];
        markResetPassword($secret);
        updatePassword($userId,$passwordHash);
        header('Location: index.php');
        $success=true;
    }
}
?>
<h1>Khôi phục mật khẩu</h1>
<?php if(!$success):?>
<form action="reset-password.php" method="POST">
<input type="hidden" name="secret" value="<?php echo $_GET['secret'];?>">
<div class="form-group">
<label for="password"> Mật khẩu</label>
<input type="password" class="form-control" id="password"name="password">
</div>
<button type="submit" class="btn btn-primary" name ="submit">Khôi phục</button>
</form>
<?php endif;?>
</div>
</body>
</html>