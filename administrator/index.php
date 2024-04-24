<?php
   // mysqli_query($baza,"UPDATE `zdjecia` SET `zaakceptowane`='1' WHERE 1;");
   // mysqli_query($baza,"UPDATE `zdjecia_komentarze` SET `zaakceptowany`='1' WHERE 1;");
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Galeria</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
    <link  rel="stylesheet" href="admin.css">
</head>
<body>
<?php 
include("../include/connect.php");
session_start();
    if(isset($_GET["adm_page"])){
        $_SESSION["adm_page"]=$_GET["adm_page"];
    }
    if(!isset($_SESSION["adm_page"])){
        $_SESSION["adm_page"]="";
    }
    
?>


<div id="background" style="min-height:calc(100vh - 30px);">
    <div  style="width:90%; padding-top:30px;  margin:auto;  display:grid;
        <?php 
        if($_SESSION["user"]["uprawnienia"]=="administrator"){
            echo("grid-template-columns: 20% 20% 20% 20% 20%;");
        }
        else{
                echo("grid-template-columns: 33% 33% 33%;");
        }
        ?>   justify-content: space-around; align-items: end;">
        <a  href="index.php?adm_page=albumy.php" style="<?php  if($_SESSION["user"]["uprawnienia"]!="administrator")echo("display:none;"); ?>">
            <div  style=" width:100%; height:30px; text-align:center; 
            <?php 
            if($_SESSION["adm_page"]=='albumy.php')echo('background:var(--color25);');
            ?>">Albumy</div>
        </a>
        <a  href="index.php?adm_page=zdjecia.php">
            <div  style=" width:100%; height:30px; text-align:center; 
            <?php if($_SESSION["adm_page"]=='zdjecia.php')echo('background:var(--color25);');?>">Zdjęcia</div>
        </a>
        <a  href="index.php?adm_page=komentarze.php">
            <div  style=" width:100%; height:30px; text-align:center; 
            <?php if($_SESSION["adm_page"]=='komentarze.php')echo('background:var(--color25);');?>">Komentarze</div>
        </a>
        <a  href="index.php?adm_page=uzytkownicy.php" style="<?php  if($_SESSION["user"]["uprawnienia"]!="administrator")echo("display:none;"); ?>">
            <div  style=" width:100%; height:30px; text-align:center; 
            <?php if($_SESSION["adm_page"]=='uzytkownicy.php')echo('background:var(--color25);');?>">Użytkownicy</div>
        </a>
        <a  href="../index.php">
            <div  style=" width:100%; height:30px; text-align:center; ">Powrót</div>
        </a>
       
        <div style="background:var(--color25); padding: 30px; grid-column:<?php 
        if($_SESSION["user"]["uprawnienia"]=="administrator"){
            echo("1/6");
        }
        else{
            echo("1/4");
        }
        ?>">
            <?php 
                if($_SESSION["adm_page"]!=""){
                    include($_SESSION["adm_page"]);
                }
                else{
                   echo("Wybierz podstronę");
               }
            ?>
        </div>
    </div>
</div>

<?php
if(isset($_GET["blad"])){
    echo('
    <div id="" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
    top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
    <div style="width:100%; background:var(--color2); padding:10px;">
    ');
    echo($_GET["blad"]."<br>");
    echo('<a href="index.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Ok</a></p></div></div>');

}

?>
<?php 
include("../include/footer.php");
mysqli_close($baza);?>

<footer>

</footer>
</body>
</html>