var Global_mode = "hide";
function DangNhapMode()
{
    var KNbtn = document.getElementById("KNbtn");
    KNbtn.setAttribute("style","background-image: linear-gradient(to top left,red,yellow);");
    KNbtn = document.getElementById("KDbtn");
    KNbtn.setAttribute("style","background: none; color: rgb(0, 81, 128);");
    var Items = document.getElementsByClassName('DangKyItem');
    var slPT = Items.length;
    for(var i = 0; i < slPT;i++){
        Items[i].setAttribute("style", "position: absolute; visibility: hidden;")
    }
    Items = document.getElementsByClassName('DangNhapItem');
    for(var i = 0; i < slPT;i++){
        Items[i].setAttribute("style", "")
    }
    Global_mode = "DANGNHAP";
}

function DangKyMode()
{
    var KDbtn = document.getElementById("KDbtn");
    KDbtn.setAttribute("style","background-image: linear-gradient(to top left,red, yellow);");
    KDbtn = document.getElementById("KNbtn")
    KDbtn.setAttribute("style","background: none; color: rgb(0, 81, 128);");
    var Items = document.getElementsByClassName('DangKyItem');
    var slPT = Items.length;
    for(var i = 0; i < slPT;i++)
    {
        Items[i].setAttribute("style", "")
    }
    Items = document.getElementsByClassName('DangNhapItem');
    for(var i = 0; i < slPT;i++){
        Items[i].setAttribute("style", "position: absolute; visibility: hidden;")
    }
    Global_mode = "DANGKY";
}

function Xacnhan()
{
    if(Global_mode == "DANGNHAP")
    {
        DangNhap();
        return;
    }
    if(Global_mode == "DANGKY")
    {
        DangKy();
        return;
    }
    alert('Lỗi hàm xác nhận, Có điều đó vô cùng sai đã sảy ra !');
}

function Notification (mode)
{
    var ntb = document.getElementById("notificationBox");
    if(mode == 'show')
    {
        ntb.classList.add("show");
        setTimeout(
            () => {
                Notification("hide");
            },
            4000
        );
    }
    if(mode == 'hide')
    {
        ntb.classList.remove("show");
    }
}

function DangNhap()
{
    if(Global_mode == "DANGNHAP")
    {
        var tendn = document.getElementById("TenDN").value;
        var mk = document.getElementById("MatKhau1").value;
        var notif = document.getElementById("notificationBox");
        //Tạo ajax
        var ajax = new XMLHttpRequest();
        //Tạo listener
        ajax.onreadystatechange=function()
        {
            if(ajax.readyState == 4 && ajax.status == 200)
            {
                Notification("show");
                notif.innerHTML = ajax.responseText;
                //Chuyển qua trang cá nhân nếu đăng nhập thành công
                if(notif.innerHTML == "Đăng nhập thành công")
                {
                    setTimeout(
                        ()=>{
                            window.location="./wall.php?ID="+tendn+"&PASS="+mk;
                        },1500
                    );
                }
            }
        }
        ajax.open("GET", "./requests.php?name="+tendn+"&pass="+mk);
        ajax.send();
    }
}

function DangKy()
{
    if(Global_mode == "DANGKY")
    {
        var tendn = document.getElementById("TenDN").value;
        var mk = document.getElementById("MatKhau1").value;
        var mk2 = document.getElementById("MatKhau2").value;
        var notif = document.getElementById("notificationBox");

        //Tạo ajax
        var ajax = new XMLHttpRequest();
        //Tạo listener
        ajax.onreadystatechange=function()
        {
            if(ajax.readyState == 4 && ajax.status == 200)
            {
                Notification("show");               
                notif.innerHTML = ajax.responseText;
                //Bắt người dùng đăng nhập từ đầu nếu đã đăng ký thành công
                if(notif.innerHTML == "Đăng ký thành công, xin mời đăng nhập !")
                {
                    //Ẩn box thông báo sau 1.5s
                    setTimeout(
                        ()=>{
                            window.location="./index.php";
                        },1500
                    );
                }
            }
        }
        ajax.open("GET", "./requests.php?name="+tendn+"&pass1="+mk+"&pass2="+mk2);
        ajax.send();
    }

}