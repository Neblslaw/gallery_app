<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Nowy album</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<body <?php if(isset($_GET["error"])){echo("onload='check_name()'");} ?>>
<?php 
    include("../include/menu.php");
    if(session_id()==""){
      session_start(); 
    } 
    if(isset($_POST["nazwa"])){
        include("../include/baza.php");

        add_album($_SESSION["user"]["id"],$_POST["nazwa"]);
    } 
    ?>
<div id="background" style="display:grid; justify-content: center; align-content: start; padding-top:50px; padding-bottom:50px;">
    
    <div class="container" >
        <form method="post" action="dodaj-album.php" id="dodaj_album" oninput="check_name()">
            <label>Nazwa albumu:</label>
            <input type="text" name="nazwa" id="nazwa" require placeholder="Nazwa albumu" >
        </form>
        <p style="display:none" id="name_test">Nazwa nie może zawierać tylko spacji<br></p>
        <p style="display:none" id="name_test_2" >Nazwa nie może być dłuższa niż 100 znaków </p>
        <p id="blendy_nazwy" 
         <?php if(isset($_GET["error"])){echo("style='font-size:20px; color:red; display:block;'>");} else echo("style='font-size:20px; color:red; display:none;'");?>>
            <br>Nieprawidłowa nazwa
        </p>
        <br>
        <input type="button" value="Dodaj album" onclick="dodaj_album()">

    </div>
</div>




















<?php include("../include/footer.php");
?>
</body>
<footer>
    <script src="..\javascript\dodawanie.js"></script>
</footer>
</html>