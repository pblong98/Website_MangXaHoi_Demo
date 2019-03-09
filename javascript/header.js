function search()
{
    var keyword = document.getElementById("searchBox").value;
    window.location="./search.php?keyword="+keyword;
}