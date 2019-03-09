function HuyKetBanBTN(YOU, ID)
{
    //Tạo ajax
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
           window.location="profile.php?ID="+ID;
        }
    }
    ajax.open("GET", "requests.php?relationship=1&YOU="+YOU+"&THATPERSION="+ID); 
    ajax.send();
}

function HuyLoiMoiKetBanBTN(YOU, ID)
{
    //Tạo ajax
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
           window.location="profile.php?ID="+ID;
        }
    }
    ajax.open("GET", "requests.php?relationship=2&YOU="+YOU+"&THATPERSION="+ID); 
    ajax.send();
}

function KetBanBTN(YOU, ID)
{
    //Tạo ajax
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
           window.location="profile.php?ID="+ID;
        }
    }
    ajax.open("GET", "requests.php?relationship=3&YOU="+YOU+"&THATPERSION="+ID); 
    ajax.send();
}

function ChapNhanKetBanBTN(YOU, ID)
{
    //Tạo ajax
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
           window.location="profile.php?ID="+ID;
        }
    }
    ajax.open("GET", "requests.php?relationship=4&YOU="+YOU+"&THATPERSION="+ID); 
    ajax.send();
}

function HienThiFormCapNhatThongTinCaNhan()
{
    var form = document.getElementById("UpdateProfileScreen");
    form.setAttribute("style","visibility: visible");
}

function TatHienThiFormCapNhatThongTinCaNhan(ID)
{
    window.location = "profile.php?ID="+ID;
}

function GuiThongTinCapNhat(ID)
{
    var name = document.getElementById("updateNameInput").value;
    var add = document.getElementById("updateAddrsInput").value;
    var email = document.getElementById("updateEmailInput").value;
    var hobby = document.getElementById("updateHobbyInput").value;

    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            alert(ajax.responseText);
            window.location = "profile.php?ID="+ID;
        }
    }
    ajax.open("GET", "requests.php?updateUser="+ID+"&name="+name+"&add="+add+"&email="+email+"&hobby="+hobby);
    ajax.send();
}

function DoiMatKhau(ID)
{
    var oldPass = document.getElementById("oldPass").value;
    var newPass1 = document.getElementById("newPass1").value;
    var newPass2 = document.getElementById("newPass2").value;

    var ajax =  new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            alert(ajax.responseText);
        }
    }
    ajax.open("GET", "requests.php?updatePass=1&oldPass="+oldPass+"&newPass1="+newPass1+"&newPass2="+newPass2);
    ajax.send();
}