<?php

    include("../include/connect.php");
   

function validate_username( $new_username)
{
    global $baza;
    $result = mysqli_query($baza , "SELECT * FROM uzytkownicy WHERE login='".$new_username."'");
    if(mysqli_num_rows($result)){
        return false;
    }
    else{
        return true;
    }
}

function add_user($username, $password, $email)
{
    $locale = array( "pl_PL", "polish_pol" );
    setlocale( LC_ALL, $locale );

    $data=date("Y")."-".date("m")."-".date("d");

    global $baza;
    mysqli_query($baza,"INSERT INTO uzytkownicy SET login='$username', haslo=MD5('$password'), email='$email', uprawnienia='użytkownik', aktywny=1, zarejestrowany='$data'");
}
function validate_album_name($name){
    if(strlen($name)>0 and strlen($name)<100){
        if(!preg_match("/^[ ]+$/",$name)) return true;
    }
    return false;
}
function add_album($user_id, $name){
    global $baza;
    if(validate_album_name($name)){
        $name = htmlspecialchars($name,ENT_QUOTES);
        
        $xd=mysqli_query($baza, "INSERT INTO `albumy`( `tytul`, `id_uzytkownika`) VALUES ('".$name."',".$user_id.")");
        $result=mysqli_query($baza, "SELECT `id` FROM `albumy` WHERE `tytul`='".$name."' AND `id_uzytkownika`='".$user_id."'");
        $id=mysqli_fetch_row($result)[0];
        mkdir("../photo/".$id, 7777);
        header("Location: dodaj-foto.php?wybrany_album=".$id);
    }
    else{
        header("Location: dodaj-album.php?error=true");
    }
}
function get_user_albums($id){
    global $baza;

    $result = mysqli_query($baza,"SELECT * FROM `albumy` WHERE `id_uzytkownika`= $id ORDER BY `data` DESC");
    return ($result);
    
}




?>