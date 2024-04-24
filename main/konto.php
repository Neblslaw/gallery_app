<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Galeria</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<style>
#page_select_link :hover{
    color: var(--color3);
    background: var(--color1);
}
</style>
<body id="body1">
<?php 
    include("../include/menu.php");
    if(session_id()==""){
      session_start(); 
    }  
    include("../include/baza.php");
    if(isset($_GET["page"])){
        $_SESSION["page"]=$_GET["page"];
    }
?>


<div id="background" >
    <div  style="width:90%; padding-top:30px;  margin:auto;  display: grid; grid-template-columns: 33% 33% 33%; justify-content: space-around; align-items: end;">
        <a class= "page_select_link" href="konto.php?page=dane.php">
            <div class= "page_select_link" style=" width:100%; height:30px; text-align:center; <?php if($_SESSION["page"]=='dane.php')echo('background:var(--color25)');?>">Moje dane</div>
        </a>
        <a href="konto.php?page=albumy.php">
            <div class= "page_select_link" style="width:100%; height:30px; text-align:center; <?php if($_SESSION["page"]=='albumy.php')echo('background:var(--color25)');?>">Albumy</div>
        </a>
        <a href="konto.php?page=zdjecia.php">
            <div class= "page_select_link" style="width:100%; height:30px; text-align:center; <?php if($_SESSION["page"]=='zdjecia.php')echo('background:var(--color25)');?>">Zdjęcia</div>
        </a>
        <div style="background:var(--color25); padding: 30px; grid-column: 1/4;">
            <?php 
                include("moje_konto/".$_SESSION["page"]);
            ?>
        </div>
    </div>
</div>

<?php 
include("../include/footer.php");
mysqli_close($baza);?>

<footer>

</footer>
</body>
</html>