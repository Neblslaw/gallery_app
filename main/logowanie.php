<?php
    include("../include/connect.php");
    session_start();
    echo(login($_POST["login_login"],$_POST["login_password"]));




    function login($username, $password){
        global $baza;
        $result = mysqli_query($baza , "SELECT * FROM uzytkownicy WHERE login='".$username."'");
        $user =mysqli_fetch_assoc($result);
        if($user["haslo"]==MD5($password)){
            if($user["aktywny"]){
                $_SESSION["user"]=$user;
                header("Location: index.php");
                exit();
            }
            else{
                header("Location: logreg.php?login_error=Konto zostało zablokowane");
                exit();
            }
        }
        header("Location: logreg.php?login_error=Użytkownik nie istnieje");
        exit();
        
    }
    mysqli_close($baza);
?>