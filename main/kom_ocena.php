<?php
session_start();
include("../include/baza.php");
if(isset($_POST["wartoscoceny"])){
    //echo("wartość oceny".$_POST["wartoscoceny"]);
    mysqli_query($baza,"INSERT INTO `zdjecia_oceny` (`id_zdjecia`, `id_uzytkownika`, `ocena`) 
    VALUES ('".$_SESSION["id"]."', '".$_SESSION["user"]["id"]."', '".$_POST["wartoscoceny"] ."')");
}
if(isset($_POST["komentarz"])){
    mysqli_query($baza,"INSERT INTO `zdjecia_komentarze` (`id`, `id_zdjecia`, `id_uzytkownika`,  `komentarz`, `zaakceptowany`)
     VALUES (NULL, '".$_SESSION["id"]."', '".$_SESSION["user"]["id"]."',  '".$_POST["komentarz"]."', '0');");
}


header('Location: foto.php?id='.$_POST['id_zdjecia']);





?>