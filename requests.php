<?php  
    include_once('functions.php');

    //Yêu cầu đăng nhập
    if(isset($_REQUEST["name"]) && isset($_REQUEST["pass"]))
    {
        echo DangNhap($_REQUEST["name"], $_REQUEST["pass"]);
        exit;
    }
    //Yêu cầu đăng ký
    if(isset($_REQUEST["name"]) && isset($_REQUEST["pass1"]) && isset($_REQUEST["pass2"]))
    {
        echo DangKy($_REQUEST["name"], $_REQUEST["pass1"], $_REQUEST["pass2"]);
        exit;
    }
    //Yêu cầu hủy kêt bạn
    if(isset($_REQUEST["relationship"]))
    {
        if($_REQUEST["relationship"] == 1)
            return HuyKB($_REQUEST['YOU'], $_REQUEST['THATPERSION']);
        if($_REQUEST["relationship"] == 2)
            return HuyLoiMoiKB($_REQUEST['YOU'], $_REQUEST['THATPERSION']);
        if($_REQUEST["relationship"] == 3)
            return KB($_REQUEST['YOU'], $_REQUEST['THATPERSION']);
        if($_REQUEST["relationship"] == 4)
            return ChapNhanKB($_REQUEST['YOU'], $_REQUEST['THATPERSION']);
    }
    if(isset($_REQUEST["updateUser"]))
    {
        CapNhatThongTinTaiKhoan($_REQUEST["updateUser"], $_REQUEST["name"], $_REQUEST["add"], $_REQUEST["email"], $_REQUEST["hobby"]);
        echo 'Cập nhật đã được ghi nhận !';
        exit;
    }

    if(isset($_REQUEST["updatePass"]))
    {
        $mess = DoiMatKhau($_REQUEST["oldPass"], $_REQUEST["newPass1"], $_REQUEST["newPass2"]);
        echo $mess;
        exit;
    }

    if(isset($_REQUEST["addcomment"]))
    {
        $mess = GuiBinhLuan($_REQUEST["postID"],$_REQUEST["comment"]);
        echo $mess;
        exit;
    }

    if(isset($_REQUEST["likePost"]))
    {
        $mess = Like($_REQUEST["likePost"]);
        echo $mess;
        exit;
    }
?>