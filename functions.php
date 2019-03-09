<?php session_start();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

    //initialize (init.php)
    $conn = new PDO("mysql:host=localhost;dbname=social;charset=utf8", 'root', '');
    function findUserBytentk($tentk){
        global $conn;
        $stmt = $conn->prepare("SELECT*FROM account WHERE ID=? LIMIT 1");
        $stmt -> execute(array($tentk));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
        }
    function DangNhap($tentk, $matkhau)
    {
        $user=findUserBytentk($tentk);

    try {
       // global $conn;
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // $result = $conn->prepare("select * from account where ID = :ID and PASSWORD = :PASS limit 1");
       // $result->execute(array('ID'=>$tentk, 'PASS'=>$matkhau));
       // $rows = $result->fetchAll(PDO::FETCH_ASSOC);
       $rows=password_verify($matkhau,$user['PASSWORD']);
        if($rows)
        {
            $_SESSION['user'] = $tentk;
            return "Đăng nhập thành công";
        }
        else
            return "Lỗi: Sai mật khẩu hoặc tên tài khoản";
        }
    catch(PDOException $e)
        {
            return 'Lỗi: Không thể kết nối tới cơ sở dữ liệu !';
        }
    }

    function DangKy($ID,$pass1, $pass2)
    {
        if($pass1 == null || $pass2==null || $ID==null)        
            return 'Lỗi: Bạn nhập thiết dữ liệu !';
        
        if($pass1 != $pass2)
            {return 'Lỗi: Bạn nhập thiết dữ liệu !';}               
        else
        {
            $passhash=password_hash($pass1,PASSWORD_DEFAULT);
            //HASH pass word
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = :ID limit 1");
        $result->execute(array('ID'=>$ID));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) >= 1)
            return 'Lỗi: Tài khoản đã có người đăng ký !';

        $stmt = $conn->prepare("INSERT INTO account (ID,PASSWORD,NAME,AVATAR_LINK) VALUES( :ID,:PASSWORD,:NAME,'./img/avatar/default-avatar.jpg')");
        $stmt -> execute(array('ID'=>$ID,'PASSWORD'=>$passhash,'NAME'=>$ID));
        return 'Đăng ký thành công, xin mời đăng nhập !';
        }
    }

    function LoadProfileInformation($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = '".$ID."' limit 1");
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        //Nút cập nhật thông tin cá nhân
        $htnm_BTN_Edit_Profile = '<button id="UpdateProfile_btn" onclick="HienThiFormCapNhatThongTinCaNhan();">Cập nhật</button>';
        //Nút kết bạn
        $htnm_BTN_Relationship = TaoNutQuanHeBanBe($ID);

        if($_SESSION['USER'] != $_REQUEST['ID'])
        {
            $htnm_BTN_Edit_Profile = '';
        }
        else
        {
            $htnm_BTN_Relationship = "";
        }
        //'.$htnm_BTN_Relationship.'
        return 
        '<div id="Avatar_And_Cover_Img">
            <div id="Profile_avatar" style="background-image: url(\''.$row['AVATAR_LINK'].'\');"></div>
            <h3 id="ProfileName">'.$row['NAME'].'</h3>
            '.$htnm_BTN_Relationship.'
        </div>
        <div id="ProfilesInfor">
            <h3>Giới thiệu</h3>
            <table>
                <tr>
                    <th>Họ tên: </th>
                    <td id="name">'.$row['NAME'].'</td>
                </tr>
                <tr>
                    <th>Địa chỉ: </th> 
                    <td id="addr">'.$row['address'].'</td>
                </tr>
                <tr>
                    <th>Email: </th>
                    <td id="Email">'.$row['email'].'</td>
                </tr>
                <tr>
                    <th>Sở thích: </th>
                    <td id="Hobby">'.$row['hobby'].'</td> 
                </tr>
            </table>
            '.$htnm_BTN_Edit_Profile.'
        </div>';       
    }

    function KiemTraIdTrangCaNhan($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = :ID");
        $result->execute(array('ID' => $ID));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return count($rows);
    }

    function TaoNutQuanHeBanBe($ID)
    {
        if(XemQuanHeBanBe($ID) == 'bạn bè')
            return '<button id="Relationship_btn" onclick="HuyKetBanBTN(\'' .$_SESSION['USER'] .'\',\''.$ID.'\');" style="Background: red;">Hủy kết bạn</button>';
        if(XemQuanHeBanBe($ID) == 'theo dõi')
            return '<button id="Relationship_btn" onclick="HuyLoiMoiKetBanBTN(\'' .$_SESSION['USER'] .'\',\''.$ID.'\');" style="Background: orange; width: 200px; left: 500px;">Hủy lời mời kết bạn</button>';
        if(XemQuanHeBanBe($ID) == 'người lạ')
            return '<button id="Relationship_btn" onclick="KetBanBTN(\'' .$_SESSION['USER'] .'\',\''.$ID.'\');">Kết bạn</button>';
        if(XemQuanHeBanBe($ID) == 'được theo dõi')
            return '<button id="Relationship_btn" onclick="ChapNhanKetBanBTN(\'' .$_SESSION['USER'] .'\',\''.$ID.'\');" style="Background: green; width: 200px; left: 500px;">Chấp nhận lời mời kết bạn</button>';
            
    }
    
    function XemQuanHeBanBe($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from relationship where ID1 = :ID1 and ID2 = :ID2 limit 1");
        $result->execute(array('ID1' => $_SESSION['USER'],'ID2' => $ID));
        $rows = $result->fetch(PDO::FETCH_ASSOC);

        $condition1 = 0;
        $condition2 = 0;

        if($rows['ID1'] != null)
            $condition1 = 1;
        
        $result = $conn->prepare("select * from relationship where ID1 = :ID1 and ID2 = :ID2 limit 1");
        $result->execute(array('ID1' => $ID,'ID2' => $_SESSION['USER']));
        $rows = $result->fetch(PDO::FETCH_ASSOC);
        
        if($rows['ID1'] != null)
            $condition2 = 1;

        if($condition1 && $condition2)
            return 'bạn bè';
        if($condition1 && !$condition2)
            return 'theo dõi';
        if(!$condition1 && !$condition2)
            return 'người lạ';
        if(!$condition1 && $condition2)
            return 'được theo dõi';
            
    }

    function HuyKB($YOU, $THATPERSION)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM relationship where ID1 = :YOU AND ID2 = :THATPERSION");
        $stmt -> execute(array('YOU'=>$YOU, 'THATPERSION'=>$THATPERSION));
    }

    function HuyLoiMoiKB($YOU, $THATPERSION)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM relationship where ID1 = :YOU AND ID2 = :THATPERSION");
        $stmt -> execute(array('YOU'=>$YOU, 'THATPERSION'=>$THATPERSION));
    }

    function KB($YOU, $THATPERSION)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO relationship VALUES(:YOU,:THATPERSION)");
        $stmt -> execute(array('YOU'=>$YOU, 'THATPERSION'=>$THATPERSION));
    }

    function ChapNhanKB($YOU, $THATPERSION)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO relationship VALUES(:YOU,:THATPERSION)");
        $stmt -> execute(array('YOU'=>$YOU, 'THATPERSION'=>$THATPERSION));
    }

    function CapNhatThongTinTaiKhoan($ID, $NAME, $ADD, $EMAIL, $HOBBY)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = :ID limit 1");
        $result->execute(array('ID' => $ID));
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if($row['NAME'] != $NAME)
        {
            $stmt = $conn->prepare("UPDATE account SET NAME = :NAME WHERE ID = :ID");   
            $stmt -> execute(array('NAME'=>$NAME, 'ID'=>$ID));
        }

        if($row['email'] != $EMAIL)
        {
            $stmt = $conn->prepare("UPDATE account SET email = :email WHERE ID = :ID");   
            $stmt -> execute(array('email'=>$EMAIL, 'ID'=>$ID));
        }

        if($row['address'] != $ADD)
        {
            $stmt = $conn->prepare("UPDATE account SET address = :address WHERE ID = :ID");   
            $stmt -> execute(array('address'=>$ADD, 'ID'=>$ID));
        }

        if($row['hobby'] != $HOBBY)
        {
            $stmt = $conn->prepare("UPDATE account SET hobby = :hobby WHERE ID = :ID");   
            $stmt -> execute(array('hobby'=>$HOBBY, 'ID'=>$ID));
        }
    }

    function TaoFormUpdate($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = :ID limit 1");
        $result->execute(array('ID' => $ID));
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $htmlcode = 
        '<div id="UpdateProfileScreen">
            <div id="UpdateProfile">
                <h3>Cập nhật thông tin cá nhân!</h3>
                <p>Họ và tên: </p>
                <input type="text" id="updateNameInput" value="'.$row['NAME'].'"/>
                <p>Địa chỉ: </p>
                <input type="text" id="updateAddrsInput" value="'.$row['address'].'"/>
                <p>Email: </p>
                <input type="text" id="updateEmailInput" value="'.$row['email'].'"/>
                <p>Sở thích: </p>
                <input type="text" id="updateHobbyInput" value="'.$row['hobby'].'"/></br></br></br>  
                <button id="commitBTN" onclick="GuiThongTinCapNhat(\''.$_SESSION['USER'].'\');">Xác nhận</button>
                <button id="CancelBTN" onclick="TatHienThiFormCapNhatThongTinCaNhan(\''.$_SESSION['USER'].'\');">Hủy</button>
            </div>
            <div>
                <iframe src="ChangeAvatar.php" id="UpdateAvatar"></iframe>
            </div>
            <div id="UpdatePassword">
                <h3>Đổi mật khẩu</h3>
                <p>Mật khẩu cũ </p>
                <input type="password" name="oldPass" id="oldPass"/>
                <p>Mật khẩu mới: </p>
                <input type="password" name="newPass1" id="newPass1"/>
                <p>Nhập lại mật khẩu mới: </p>
                <input type="password" name="newPass2" id="newPass2"/>
                <button id="ChangePassBTN" onclick="DoiMatKhau(\''.$_SESSION['USER'].'\');">Xác nhận</button>
            </div>
        </div>';
        return $htmlcode;
    }

    function uploadAvartar($id, $link)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("update account set AVATAR_LINK = :link where ID = :id");
        $stmt->execute(array('link'=>$link ,'id' => $id));
    }

    function DoiMatKhau($oldPass, $newPass1, $newPass2)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID = :id");
        $result->execute(array('id'=>$_SESSION['USER']));
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if($row == null)
            return "Có lỗi đã xảy ra ! M đang cố hack web t đấy à ?????";
        if($row['PASSWORD'] == $oldPass)
        {
            if($newPass1 != $newPass2)
                return "Mật khẩu mới bạn nhập không khớp với nhau !";
            else
            {
                $stmt = $conn->prepare("update account set PASSWORD = :pass where ID = :id");
                $stmt->execute(array('pass'=>$newPass1 ,'id' => $_SESSION['USER']));
                return "Cập nhật mật khẩu thành công !";
            }
        }
        else
            return "Mật khẩu cũ bạn nhập không chính xác !";
    }

    function LoadDanhSachBanBe($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select con1.ID2
                                        from (select * from relationship bb where bb.ID1 = :id) con1 INNER JOIN
                                            (select * from relationship bb where bb.ID2 = :id) con2 on con1.ID2 = con2.ID1");
        $result->execute(array('id'=>$ID));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        $friendList_htmlcode = array();
        $friend_htmlcode = '';

        foreach($rows as $row)
        {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conn->prepare("select * from account where ID=:id");
            $result->execute(array('id'=>$row['ID2']));
            $r = $result->fetch(PDO::FETCH_ASSOC);
            $friend_htmlcode = '<li>
                                    <a href="profile.php?ID='.$r['ID'].'">
                                        <span class="friendAvatar" style="background-image: url(\''.$r['AVATAR_LINK'].'\');"></span>
                                        <span class="friendName">'.$r['NAME'].'</span>
                                    </a>
                                </li>';
            echo $friend_htmlcode;
        }
    }

    function layAvatar($id)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID=:id");
        $result->execute(array('id'=>$id));
        $r = $result->fetch(PDO::FETCH_ASSOC);
        return $r['AVATAR_LINK'];
    }

    function layTen($id)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account where ID=:id");
        $result->execute(array('id'=>$id));
        $r = $result->fetch(PDO::FETCH_ASSOC);
        return $r['NAME'];
    }

    function dangBaiViet($content, $mode, $image)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("insert into post values (:id,:content,:mode,now(),:owner,:image)");
        $postID=createPostID($_SESSION['USER']);
        $stmt->execute(array('id'=>$postID ,'content' => $content, 'mode' => $mode, 'owner' => $_SESSION['USER'], 'image' => $image));
    }

    function createPostID($string)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = DateTime::createFromFormat('U.u', microtime(true));
        $now->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
        return hash('md5', $string.$now->format("m-d-Y H:i:s.u"));
    }

    function LocBaiViet($baiviet)
    {
        //public thì được xem => ok
        if($baiviet['MODE'] == 'public')
            return 'ok';
        //Bài viết ở chế độ bạn bè và người xem cũng là bạn bè của chủ bài viết => ok
        if(XemQuanHeBanBe($baiviet['ID_OWNER']) == 'bạn bè' && $baiviet['MODE'] == 'friend')
            return 'ok';
        //Bài viết ở chế độ bạn bè và người xem cũng là chủ bài viết => ok
        if(XemQuanHeBanBe($baiviet['ID_OWNER']) && $baiviet['ID_OWNER'] == $_SESSION['USER'])
            return 'ok';
        //Bài viết người xem được xem vài viết ở chế độ cá nhân của chính mình => ok
        if($baiviet['MODE'] == 'private' && $baiviet['ID_OWNER'] == $_SESSION['USER'])
            return 'ok';
        //Những trương hợp còn lại => no
        return 'no';
    }

    function LoadDanhSachBaiViet()
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from post order by DATE desc");
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row)
        {
            //Lọc ra những bài viết không được xem
            if(LocBaiViet($row)=='no')
                continue;

            $image = $row['IMAGE'];
            if($row['IMAGE']=='no')
                $image = '';

            $html = '
            <div id ="Posts">
            <a href="profile.php?ID='.$row['ID_OWNER'].'">
                <span class="friendAvatar" style="background-image: url(\''.layAvatar($row['ID_OWNER']).'\');"></span>
                <span class="friendName" style="color: rgb(0, 99, 124); font-weight: bold;">'.layTen($row['ID_OWNER']).'</span>
                <span class="postMode" style="color: rgb(0, 99, 124); font-weight: bold;">Chế độ công khai: '.$row['MODE'].'</span>
            </a>
            <div class="postContent">'.$row['CONTENT'].'</div>
            <img src="'.$image.'"/>
            </br>
            <div class="postLike" onclick="likePost(\''.$row['ID'].'\');" >❤ '.DemLuotLike($row['ID']).'</div>
                <div class="postComment">
                    <div id="addcomment">
                        <input type="text" placeholder="Hãy bình luận cho bài viết này..." class="addcommentTEXTBOX" id="'.$row['ID'].'"/>
                        <input type="button" id="addcommentBTN" onclick="comment(\''.$row['ID'].'\')" value="Đăng"/>
                    </div>
                <p style="font-size:12px; color: gray; margin-top: 5px;">Bình luận: </p>
                
                    '.LoadComment($row['ID']).'
                
            </div>
        </div>
            ';
        echo $html;
        }
    }

    function LoadDanhSachBaiVietCaNhan($ID)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from post where ID_OWNER = :id order by DATE desc");
        $result->execute(array('id'=>$ID));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row)
        {
            //Lọc ra những bài viết không được xem
            if(LocBaiViet($row)=='no')
                continue;
                
            $image = $row['IMAGE'];
            if($row['IMAGE']=='no')
                $image = '';

            $html = '
            <div id ="Posts">
            <a href="profile.php?ID='.$row['ID_OWNER'].'">
                <span class="friendAvatar" style="background-image: url(\''.layAvatar($row['ID_OWNER']).'\');"></span>
                <span class="friendName" style="color: rgb(0, 99, 124); font-weight: bold;">'.layTen($row['ID_OWNER']).'</span>
                <span class="postMode" style="color: rgb(0, 99, 124); font-weight: bold;">Chế độ công khai: '.$row['MODE'].'</span>
            </a>
            <div class="postContent">'.$row['CONTENT'].'</div>
            <img src="'.$image.'"/>
            </br>
            <div class="postLike" onclick="likePost(\''.$row['ID'].'\');" >❤ '.DemLuotLike($row['ID']).'</div>
                <div class="postComment">
                    <div id="addcomment">
                        <input type="text" placeholder="Hãy bình luận cho bài viết này..." class="addcommentTEXTBOX" id="'.$row['ID'].'"/>
                        <input type="button" id="addcommentBTN" onclick="comment(\''.$row['ID'].'\')" value="Đăng"/>
                    </div>
                <p style="font-size:12px; color: gray; margin-top: 5px;">Bình luận: </p>
                
                    '.LoadComment($row['ID']).'
                
            </div>
        </div>
            ';
        echo $html;
        }
    }


    function LoadComment($idpost)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from commentpost where ID_POST = :idpost");
        $result->execute(array('idpost'=>$idpost));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $html ='';

        foreach($rows as $row)
        {
            $temp='
            <div class="comment">
            <a href="profile.php?ID='.$row['COMMENTATOR'].'">
            <span class ="friendAvatar" style="background-image: url(\''.layAvatar($row['COMMENTATOR']).'\');"></span>
            <span class="friendName" style="color: rgb(0, 99, 124)">'.layTen($row['COMMENTATOR']).'</span>
            </a>
            <div class ="content">'.$row['CONTENT'].'</div>
            </div>
            ';
            $html .= $temp;
        }
        return $html;
    }

    function GuiBinhLuan($idPost, $comment)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("insert into commentpost values (:idPost,:COMMENTATOR,:content)");
        $stmt->execute(array('idPost'=>$idPost , 'COMMENTATOR'=>$_SESSION['USER'],'content' => $comment));
        return 'Gửi bình luận thành công!';
    }

    function DemLuotLike($idPost)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from likedpost where ID_POST = :idpost");
        $result->execute(array('idpost'=>$idPost));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return count($rows);
    }

    function Like($postID)
    {
        //Kiểm tra xem đã like chưa ?
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from likedpost where ID_POST = :idpost and CLICKER = :clicker");
        $result->execute(array('idpost'=>$postID, 'clicker'=>$_SESSION['USER']));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) >= 1)
        {
            global $conn;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("delete from likedpost where ID_POST = :idPost");
            $stmt->execute(array('idPost'=>$postID));
            return 'Bạn đã unlike bài viết này!';
        }

        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("insert into likedpost values (:idPost,:clicker)");
        $stmt->execute(array('idPost'=>$postID , 'clicker'=>$_SESSION['USER']));
        return 'Like thành công!';
    }
    function generateRandomString($length=10){
        $character='0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $characterLength=strlen($character);
        $randomString='';
        for($i=0;$i<$length;$i++){
            $randomString.=$character[rand(0,$characterLength-1)];
        }
        return $randomString; 
    }
    function findUserByEmail($email){
    global $conn;
    $stmt = $conn->prepare("SELECT*FROM account WHERE email=? LIMIT 1");
    $stmt -> execute(array($email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
    }
    function createResetPassword($userId){
        global $conn;
        $secret =generateRandomString();
        $stmt=$conn->prepare("insert into reset_passwords(userId,secret,used)values(?,?,0)");
        $stmt->execute(array($userId,$secret));
        return $secret;
    }
    function findResetPassword($secret){
        global $conn;
    $stmt = $conn->prepare("SELECT*FROM reset_passwords WHERE secret=? LIMIT 1");
    $stmt -> execute(array($secret));
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function updatePassword($userId,$password){
        global $conn;
        $secret =generateRandomString();
        $stmt=$conn->prepare("UPDATE account SET PASSWORD=? WHERE ID=?");
        $stmt->execute(array($password,$userId));
    }
    function markResetPassword($secret){
        global $conn;
        $stmt=$conn->prepare("UPDATE ​reset_passwords SET used = 1 WHERE secret=?");
        $stmt->execute(array($secret));
    }
    function sendEmail($email,$receiver,$subject,$content){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                       // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'longluonnhoban@gmail.com';                 // SMTP username
            $mail->Password = '35291998';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('longluonnhoban@gmail.com', 'Mailer');
            $mail->addAddress($email,$receiver);     // Add a recipient          
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->send();
            return true;
    }

    function LoadDanhSachNguoiDungTheoTuKhoa($keyword)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from account");
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        $friend_htmlcode = '';

        foreach($rows as $row)
        {
            if(strpos($row['NAME'], $keyword)==false)
            {
                if($row['ID'] != $keyword)
                {
                    continue;
                }
            }
            $friend_htmlcode = '<li>
                                    <a href="profile.php?ID='.$row['ID'].'">
                                        <span class="friendAvatar" style="background-image: url(\''.$row['AVATAR_LINK'].'\');"></span>
                                        <span class="friendName">'.$row['NAME'].'</span>
                                    </a>
                                </li>';
            echo $friend_htmlcode;
        }
    }

    function LoadDanhSachBaiVietTheoTuKhoa($keyword)
    {
        global $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->prepare("select * from post order by DATE desc");
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row)
        {
            if(strpos($row['CONTENT'], $keyword)==false)
                continue;

            //Lọc ra những bài viết không được xem
            if(LocBaiViet($row)=='no')
                continue;

            $image = $row['IMAGE'];
            if($row['IMAGE']=='no')
                $image = '';

            $html = '
            <div id ="Posts">
            <a href="profile.php?ID='.$row['ID_OWNER'].'">
                <span class="friendAvatar" style="background-image: url(\''.layAvatar($row['ID_OWNER']).'\');"></span>
                <span class="friendName" style="color: rgb(0, 99, 124); font-weight: bold;">'.layTen($row['ID_OWNER']).'</span>
                <span class="postMode" style="color: rgb(0, 99, 124); font-weight: bold;">Chế độ công khai: '.$row['MODE'].'</span>
            </a>
            <div class="postContent">'.$row['CONTENT'].'</div>
            <img src="'.$image.'"/>
            </br>
            <div class="postLike" onclick="likePost(\''.$row['ID'].'\');" >❤ '.DemLuotLike($row['ID']).'</div>
                <div class="postComment">
                    <div id="addcomment">
                        <input type="text" placeholder="Hãy bình luận cho bài viết này..." class="addcommentTEXTBOX" id="'.$row['ID'].'"/>
                        <input type="button" id="addcommentBTN" onclick="comment(\''.$row['ID'].'\')" value="Đăng"/>
                    </div>
                <p style="font-size:12px; color: gray; margin-top: 5px;">Bình luận: </p>
                
                    '.LoadComment($row['ID']).'
                
            </div>
        </div>
            ';
        echo $html;
        }
    }
?>