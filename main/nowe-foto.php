<!DOCTYPE html>
<head>
    <title>top-foto</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="..\style\style.css">
    <link rel="stylesheet" href="..\style\menu_style.css">
</head>
<body>
<?php 
  include("../include/menu.php");
  if(session_id()==""){
    session_start(); 
  }  
  ?>

<div id="background" style="text-align:center;">

<p style="text-align:left;">
<a href="../index.php" style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block" > Wróć do strony głównej</a><br></p>

<?php
include("../include/baza.php");
$result=mysqli_query($baza,"SELECT `zdjecia`.`id` as 'id_zdjecia', `zdjecia`.`data`, `albumy`.`tytul`, `uzytkownicy`.`login`, `zdjecia`.`id_albumu`
FROM `zdjecia` , `albumy`,`uzytkownicy`
WHERE `zdjecia`.`zaakceptowane`=1 AND `uzytkownicy`.`id`=`albumy`.`id_uzytkownika` AND `zdjecia`.`id_albumu`=`albumy`.`id`
ORDER BY `zdjecia`.`data` DESC
LIMIT 20");

while($zdjecie=mysqli_fetch_assoc($result)){
    $data = DateTime::createFromFormat("Y-m-d H:i:s",$zdjecie["data"])->format("d/m/Y");
    echo('
    <a href="foto.php?id='.$zdjecie['id_zdjecia'].'">
    <div 
        data-tooltipText="Tytuł albumu: '.$zdjecie["tytul"].' <br> Właściciel: '.$zdjecie["login"].' <br> Data dodania: '.$data.'" id= "zdj'.$zdjecie["id_zdjecia"].'" 
        class="miniaturka_zdj" onmouseover="show_tooltip(this.id)" onmouseout="hide_tooltip()">
        <img src="../photo/'.$zdjecie["id_albumu"].'/'.$zdjecie['id_zdjecia'].'-min.png'.'" alt="" style="height:180px;">
        </div></a>'); 

}

?>
</div>
<?php include("../include/footer.php");
?>
<footer>
    <script src="..\javascript\galeria.js"></script>
</footer>
</body>
</html>