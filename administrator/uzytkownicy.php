<?php

if($_SESSION["user"]["uprawnienia"]!="administrator"){
    echo("nie jesteś administratorem");
}
else{
    if(isset($_GET["user_group"])){
        
        $_SESSION["user_group"]=$_GET["user_group"];
        
    }
    if(!isset($_SESSION["user_group"]) or $_SESSION["user_group"]==""){
        echo(
            '<table >
                <tr>
                    <td class="usable" ><a href="index.php?user_group=wszyscy">wszyscy</a></td>
                    <td class="usable" ><a href="index.php?user_group=użytkownik">uzytkownicy</a></td>
                    <td class="usable" ><a href="index.php?user_group=moderator">moderatorzy</a></td>
                    <td class="usable" ><a href="index.php?user_group=administrator">administratorzy</a></td>
                </tr>
            </table>');
    }
    else{
        echo('<a href="index.php?user_group="
        style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Wróć do wyboru</a><br></p>
        ');
        if($_SESSION["user_group"]=="wszyscy"){
            $result=mysqli_query($baza,'SELECT `id`,`login`,`uprawnienia`,`aktywny` FROM `uzytkownicy` WHERE 1;');
        }
        else{
            
            $result=mysqli_query($baza,'SELECT `id`,`login`,`uprawnienia`,`aktywny` FROM `uzytkownicy` WHERE `uzytkownicy`.`uprawnienia`="'.$_SESSION["user_group"].'";'); 
        }
        echo(' <table style="width:100%; border:1px solid white; border-collapse: collapse;">
        <tr>
            <th>login</th><th>uprawnienia</th><th>aktywny</th><th></th><th colspan="3">Opcje</th>
        </tr>          ');
        while($uzytkownicy=mysqli_fetch_assoc($result)){
        echo('   
        <tr >
            <td>'.$uzytkownicy["login"].'</td>
            <td>'.$uzytkownicy["uprawnienia"].'</td>
            <td>'.$uzytkownicy["aktywny"].'</td>
            <td class="usable" ><a href="index.php?edit_permissions='.$uzytkownicy["id"].'" style="height:100%">zmien uprawnienia</a></td>
            <td class="usable" ><a href="zmiany.php?block='.$uzytkownicy["id"].'" style="height:100%">zablokuj/odblokuj</a></td>
            <td class="usable" ><a href="index.php?delete_user='.$uzytkownicy["id"].'" style="height:100%">usuń</a></td>
        
        </tr>');
        }
        echo("</table>");
    }
    
    
if(isset($_GET["edit_permissions"]) or isset($_GET["delete_user"])){
    echo('
    <div id="" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
    top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
    <div style="width:100%; background:var(--color2); padding:10px;">
    ');
    if(isset($_GET["edit_permissions"])){
       
        echo(' <form method="post" action="zmiany.php" >
        <label>Wybierz nowe uprawnienia dla użytkownika:</label>
        <br>
        <input type="hidden" name="edit_permissions" value="'.$_GET["edit_permissions"].'">

        <input type="radio" id="użytkownik" name="nowe_uprawnienia" value="użytkownik">
        <label for="użytkownik">użytkownik</label><br>
        <input type="radio" id="moderator" name="nowe_uprawnienia" value="moderator">
        <label for="moderator">moderator</label><br>
        <input type="radio" id="administrator" name="nowe_uprawnienia" value="administrator" required>
        <label for="administrator">administrator</label>

        
        <input type="submit" value="Zapisz zmiany" style="background:red;"></form>');
    
        
    }
    else {
        echo('Czy na pewno chcesz usunąć konto tego użytkownika? <br>
        Ta akcja jest nieodwracalna.
        <a href="zmiany.php?delete_user='.$_GET["delete_user"].'" style="background: red; text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Usuń konto użytkownika</a></p><br>
        ');
        
    }
    echo('
    <a href="index.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
    </div>
    </div>
    ');
}
}

?>
