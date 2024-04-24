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
$result=mysqli_query($baza,"SELECT `zdjecia_oceny`.`id_zdjecia`, AVG(`zdjecia_oceny`.`ocena`) as srednia, `zdjecia`.`id_albumu` , `uzytkownicy`.`login`, `albumy`.`tytul`
FROM `zdjecia_oceny`,`zdjecia`,`uzytkownicy`,`albumy`
WHERE `zdjecia`.`id`=`zdjecia_oceny`.`id_zdjecia` AND `albumy`.`id`=`zdjecia`.`id_albumu`
AND `uzytkownicy`.`id`=`albumy`.`id_uzytkownika`
GROUP BY `id_zdjecia` ORDER BY srednia DESC LIMIT 20");

while($zdjecie=mysqli_fetch_assoc($result)){
    $srednia = round($zdjecie["srednia"],1);
    echo('
    <a href="foto.php?id='.$zdjecie['id_zdjecia'].'">
    <div 
        data-tooltipText="Tytuł albumu: '.$zdjecie["tytul"].' <br> Właściciel: '.$zdjecie["login"].' <br> Średnia ocen: '.$srednia.'" id= "zdj'.$zdjecie["id_zdjecia"].'" 
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