<?php
    $errors="";
    include("../include/baza.php");
    session_start();
   

    if(validate_username($_POST["login"])){
       
    }
    else{
        $errors =$errors."Użytkownik o podanym loginie już istnieje<br>";
    }
    if( preg_match("/^[A-Za-z0-9]{8,16}$/",$_POST["login"])){
        echo("login ok");
    }
    else{
        $errors=$errors."Nieprawidłowy login<br>";
    }
    
    check_password($_POST["password"]);
    $errors=$errors.check_password($_POST["password"]);
   

    if($_POST["password"] != $_POST["password2"]){
        $errors=$errors."Hasła nie są takie same<br>";
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errors=$errors."Nieprawidłowy adres email<br>";
    }

    
    if($errors==""){
        
        add_user($_POST["login"],$_POST["password"],$_POST["email"]);
        $result = mysqli_query($baza , "SELECT * FROM uzytkownicy WHERE login='".$_POST["login"]."'");
        $_SESSION["user"] =mysqli_fetch_assoc($result);
       
        header("Location: rejestracja-ok.php");
        exit();
    }
    else{
        $_SESSION["invalid_user"]=$_POST;
        header("Location: logreg.php?register=true&register_errors=".$errors);
        exit();
        //Jeżeli są jakiekolwiek błędy to powrót do formularza rejestracji, wyświetlenie pod formularzem
        //informacji jakie to błędy i zachowaniem wpisanych przez użytkownika danych.
    }

   
 
    
    
function check_password( $password) 
{
    if( strlen($password)>7 and strlen($password)<21){
        if(preg_match("/[A-Z]+/",$password)){
            if(preg_match("/[a-z]+/",$password)){
                if(preg_match("/[0-9]+/",$password)){
                    return("");
                }
            }
        }
        
    }
    return ("Nieprawidłowe hasło<br>");
}
mysqli_close($baza);
?>
