<?php

include("../include/connect.php");
session_start();

//ablumy
if(isset($_POST["album_edit_id"])){
   mysqli_query($baza, "UPDATE `albumy` SET `tytul`='".$_POST["nowy_tytul"]."' WHERE `id`=".$_POST["album_edit_id"]."");
}

if(isset($_GET["album_del_id"])){
    $_SESSION["adm_id_albumu"]="";
    mysqli_query($baza,"DELETE FROM `albumy` WHERE id=".$_GET["album_del_id"]."");

    array_map('unlink', glob("../photo/".$_GET["album_del_id"]."/*.*"));
    rmdir("../photo/".$_GET["album_del_id"]);

}

//zdjecia
if(isset($_POST["nowy_opis"])){
    mysqli_query($baza, "UPDATE `zdjecia` SET `opis`='".$_POST["nowy_opis"]."' WHERE `id`=".$_POST["pchoto_desc_id"]."");
}
if(isset($_GET["delete_photo"])){
    mysqli_query($baza,"DELETE FROM `zdjecia` WHERE id=".$_GET["delete_photo"]."");
    array_map('unlink', glob("../photo/".$_SESSION["adm_id_albumu"]."/".$_GET["delete_photo"].".*"));
    array_map('unlink', glob("../photo/".$_SESSION["adm_id_albumu"]."/".$_GET["delete_photo"]."-min.*"));
}
if(isset($_GET["accept_photo"])){
    mysqli_query($baza,"UPDATE `zdjecia` SET `zaakceptowane` = 1 WHERE id=".$_GET["accept_photo"]."");
}

//komentarze
if(isset($_POST["edit_com"])){
    mysqli_query($baza, "UPDATE `zdjecia_komentarze` SET `komentarz`='".$_POST["edited_com_value"]."' WHERE `id`=".$_POST["edit_com"]."");
}
if(isset($_GET["delete_com"])){
    mysqli_query($baza,"DELETE FROM `zdjecia_komentarze` WHERE id=".$_GET["delete_com"]."");
}
if(isset($_GET["accept_com"])){
    mysqli_query($baza,"UPDATE `zdjecia_komentarze` SET `zaakceptowany` = 1 WHERE id=".$_GET["accept_com"]."");
}

//uzytkownicy
if(isset($_GET["block"])){
    if($_SESSION["user"]["id"]!=$_GET["block"]){
        $aktywny=mysqli_fetch_row(mysqli_query($baza,"SELECT `aktywny` FROM `uzytkownicy` WHERE `id`=".$_GET["block"].";"))[0];
        if($aktywny==1){
            mysqli_query($baza,"UPDATE  `uzytkownicy` SET `aktywny`=0 WHERE `id`=".$_GET["block"].";");
        }
        else{
            mysqli_query($baza,"UPDATE  `uzytkownicy` SET `aktywny`=1 WHERE `id`=".$_GET["block"].";");
        }
    }
    else{
        header("Location: index.php?blad=Nie możesz edytować swoich danych.");
        exit();
    }
}
if(isset($_POST["edit_permissions"])){
    if($_SESSION["user"]["id"]!=$_POST["edit_permissions"]){
        mysqli_query($baza,"UPDATE  `uzytkownicy` SET `uprawnienia`='".$_POST["nowe_uprawnienia"]."' WHERE `id`=".$_POST["edit_permissions"].";");
    }
    else{
        header("Location: index.php?blad=Nie możesz edytować swoich danych.");
        exit();
    }
}
if(isset($_GET["delete_user"])){
    if($_SESSION["user"]["id"]!=$_GET["delete_user"]){
        $result = mysqli_query($baza,"SELECT `id` FROM `albumy` WHERE `id_uzytkownika`=".$_GET["delete_user"].";");
        while($album = mysqli_fetch_row($result)[0]){
            array_map('unlink', glob("../photo/".$album."/*.*"));
            rmdir("../photo/".$album);
        }
        //usuwanie zdjęc z folderu
        mysqli_query($baza,"DELETE FROM `uzytkownicy` WHERE id=".$_GET["delete_user"]."");
    }
    else{
        header("Location: index.php?blad=Nie możesz usunąć swojego konta.");
        exit();
    }
}

header("Location: index.php");
?>