<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Galeria</title>
	<link  rel="stylesheet" href="..\style\style.css">
  <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<body>
<?php 
  include("../include/menu.php");
  if(session_id()==""){
    session_start(); 
  }  
  if(isset($_GET["page"])){
    $_SESSION["page"]=(int)$_GET["page"]-1;
  }
  else if(!isset($_SESSION["page"])){
    $_SESSION["page"]="0";
  }
  if(isset($_GET["id"])){
    $_SESSION["id_albumu"]=$_GET["id"];
  }
?>
<div id="background" style="text-align:center;">

<p style="text-align:left;">
<a href="../index.php" style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block" > Wróć do strony głównej</a><br></p>



<?php
  $items_on_page=20;
  include("../include/baza.php");

  $albumy=mysqli_query($baza , "SELECT `albumy`.`tytul` FROM albumy where id='".$_SESSION["id_albumu"]."'");
  $tytul = mysqli_fetch_assoc($albumy)["tytul"];

  echo("<p style='font-size:30px;'>".$tytul."</p>");

  $zdjecia=mysqli_query($baza , "SELECT `zdjecia`.`id` FROM zdjecia WHERE zaakceptowane = '1' AND id_albumu='".$_SESSION["id_albumu"]."' ORDER BY `zdjecia`.`data` DESC
  LIMIT ".(int)$_SESSION["page"]*$items_on_page.",".$items_on_page.";"
  );
  
  while($zdjecie = mysqli_fetch_assoc($zdjecia)) { 
    echo('<a href="foto.php?id='.$zdjecie['id'].'"><img src="../photo/'.$_SESSION["id_albumu"].'/'.$zdjecie['id'].'-min.png'.'" alt="" style="height:180px;"></a>');
  }
  ?>   



<?php
  $count = mysqli_query($baza , "SELECT COUNT(`zdjecia`.`id`) FROM `zdjecia` WHERE `zdjecia`.`id_albumu`='".$_SESSION["id_albumu"]."' AND `zdjecia`.`zaakceptowane`='1';");
  $pages_count=ceil(mysqli_fetch_row($count)[0]/$items_on_page);
  if($pages_count>1){
      echo("<p id='pages_links'> Strony: ");

      for($i=1;$i<=$pages_count;$i++){
          if($i==$_SESSION["page"]+1){
              echo("<a style='color:var(--color4)' href='album.php?page=$i'>$i </a>");
          }
          else{
              echo("<a href='album.php?page=$i'>$i </a>");
          } 
      }
      echo("</p>");
  }
           
?>


<p style="text-align:left;">
<a href="../index.php" style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block" > Wróć do strony głównej</a><br></p>
</div>




<?php include("../include/footer.php");
mysqli_close($baza);?>
</body>
<footer>
</footer>
</html>