<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Rejestracja-ok</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
    <body>
    <?php 
    include("../include/menu.php");
    ?>
    <div id="background" style="display:grid; justify-content: center; align-content: start; padding-top:50px; padding-bottom:50px; text-align:center;">
    <div class="container" style="height:160px;" >
        <p style="font-size:30px;">Zarejestrowano pomyślnie</p><br>
        <a href="index.php" style=" background:var(--color4); padding:10px; text-decoration:none; margin:10px;" > Wróć do strony głównej</a><br>
    </div>


</div>
<?php include("../include/footer.php");
mysqli_close($baza);?>
    </body>
   
</html>