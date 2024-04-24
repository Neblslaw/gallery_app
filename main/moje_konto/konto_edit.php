<?php
include("../../include/connect.php");
session_start();

if(isset($_POST["password_3"])){
    if(MD5($_POST["password_3"])==mysqli_fetch_assoc(mysqli_query($baza,"SELECT `haslo` FROM `uzytkownicy` WHERE id = ".$_SESSION["user"]["id"].""))["haslo"]){
        mysqli_query($baza,"UPDATE `uzytkownicy` SET `haslo`='".MD5($_POST["password"])."',`email`='".$_POST["email"]."' WHERE `id`='".$_SESSION["user"]["id"]."'");
        $_SESSION["user"]["email"] = $_POST["email"];
        header("Location: ../konto.php?zmieniono=true");
        exit();
    }
    header("Location: ../konto.php?zmieniono=false");
    exit();
}

if(isset($_POST["album_edit_id"])){
   // echo($_POST["album_edit_id"]);
   mysqli_query($baza, "UPDATE `albumy` SET `tytul`='".$_POST["nowy_tytul"]."' WHERE `id`=".$_POST["album_edit_id"]."");
}
if(isset($_GET["album_del_id"])){
    $_SESSION["acc_id_albumu"]="";
    mysqli_query($baza,"DELETE FROM `albumy` WHERE id=".$_GET["album_del_id"]."");
    array_map('unlink', glob("../../photo/".$_GET["album_del_id"]."/*.*"));
    rmdir("../../photo/".$_GET["album_del_id"]);

}


if(isset($_POST["nowy_opis"])){
    mysqli_query($baza, "UPDATE `zdjecia` SET `opis`='".$_POST["nowy_opis"]."' WHERE `id`=".$_POST["pchoto_desc_id"]."");
}
if(isset($_GET["delete_photo"])){
    mysqli_query($baza,"DELETE FROM `zdjecia` WHERE id=".$_GET["delete_photo"]."");
    array_map('unlink', glob("../../photo/".$_SESSION["acc_id_albumu"]."/".$_GET["delete_photo"].".*"));
    array_map('unlink', glob("../../photo/".$_SESSION["acc_id_albumu"]."/".$_GET["delete_photo"]."-min.*"));
}


if(isset($_POST["user_del"])){
    if(MD5($_POST["user_del"])==mysqli_fetch_assoc(mysqli_query($baza,"SELECT `haslo` FROM `uzytkownicy` WHERE id = ".$_SESSION["user"]["id"].""))["haslo"]){
        mysqli_query($baza,"DELETE FROM `uzytkownicy` WHERE id=".$_SESSION["user"]["id"]."");
        header("Location: ../wyloguj.php");
        exit(); 
    }
    else{
        header("Location: ../konto.php?usunieto=false");
        exit();
    }

}
header("Location: ../konto.php");
?>