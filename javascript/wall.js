function comment(IDpost)
{
    var comm = document.getElementById(IDpost).value;
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            alert(ajax.responseText);
            window.location="./wall.php";
        }
    }
    ajax.open("GET", "./requests.php?addcomment=1&postID="+IDpost+"&comment="+comm);
    ajax.send();
}

function likePost(IDpost)
{
    var comm = document.getElementById(IDpost).value;
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            alert(ajax.responseText);
            window.location="./wall.php";
        }
    }
    ajax.open("GET", "./requests.php?likePost="+IDpost);
    ajax.send();
}