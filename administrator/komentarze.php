<?php



if($_SESSION["user"]["uprawnienia"]=="administrator"){
    $admin = TRUE;
}
else{
    $admin = FALSE;
}
if(isset($_GET["display_com"])){
    $_SESSION["display_com"]=$_GET["display_com"];
}

if(!isset($_SESSION["display_com"]) or $_SESSION["display_com"]==""){
    $_SESSION["display_com"]="";
    echo('<a href="index.php?display_com=wszystkie"
    style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Pokaż wszystkie komentarze</a><br></p>
    ');
    echo('<a href="index.php?display_com=niezaakceptowane"
        style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Pokaż tylko niezaakceptowane komentarze</a><br></p>
    ');
}
else{

    if($_SESSION["display_com"]=="wszystkie"){
        $result=mysqli_query($baza,"SELECT `zdjecia_komentarze`.`id`,`data`,`komentarz`,`zaakceptowany`,`uzytkownicy`.`login` FROM `zdjecia_komentarze`, `uzytkownicy` 
        WHERE `uzytkownicy`.`id`=`zdjecia_komentarze`.`id_uzytkownika`  ORDER BY `zdjecia_komentarze`.`zaakceptowany` ASC;");
    }
    else {
        $result=mysqli_query($baza,"SELECT `zdjecia_komentarze`.`id`,`data`,`komentarz`,`zaakceptowany`,`uzytkownicy`.`login` FROM `zdjecia_komentarze`, `uzytkownicy` 
        WHERE `uzytkownicy`.`id`=`zdjecia_komentarze`.`id_uzytkownika` AND `zdjecia_komentarze`.`zaakceptowany`=0  ORDER BY `zdjecia_komentarze`.`zaakceptowany` ASC;");
    }
    echo('<a href="index.php?display_com="
    style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Wróć do wyboru</a><br></p>
    ');
    if(!mysqli_num_rows($result)>0){
        echo("brak komentarzy do pokazania");
    }
    else{
        echo('<table style="width:100%; border:1px solid white; border-collapse: collapse;">
        <tr>
            <th>Komentarz</th><th>Użytkownik</th><th>data</th><th>zaakceptowane</th><th colspan="');
            if($admin)echo"3";
            else echo"2";
        echo('">Opcje</th>
        </tr>          ');
        
        while($komentarz = mysqli_fetch_assoc($result)){
            echo('
                <tr >
                    <td>'.$komentarz["komentarz"].'</td>
                    <td>'.$komentarz["login"].'</td>
                    <td>'.$komentarz["data"].'</td>
                    <td>'.$komentarz["zaakceptowany"].'</td>');
            if($admin){
                echo('<td class="usable" ><a href="index.php?edit_com='.$komentarz["id"].'" style="height:100%">Edytuj</a></td>');
            }
            echo(   '<td class="usable" ><a href="index.php?delete_com='.$komentarz["id"].'" style="height:100%">Usuń</a></td>');
            if(!$komentarz["zaakceptowany"])echo('<td class="usable" ><a href="zmiany.php?accept_com='.$komentarz["id"].'" style="height:100%">Zaakceptuj</a></td>');
            echo('      
            </tr>
            ');
        }
        
        echo("</table>");
    }
}


if(isset($_GET["delete_com"]) or isset($_GET["edit_com"])){
    echo('
    <div id="usun_album" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
    top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
    
    <div style="width:100%; background:var(--color2); padding:10px;">
    ');
    if(isset($_GET["edit_com"])){
        if($admin){
            echo(' <form method="post" action="zmiany.php" >
            <label>Podaj nowy komentarz</label>
            <input type="hidden" name="edit_com" value="'.$_GET["edit_com"].'">
            <input type="text" name="edited_com_value" placeholder="wpisz nowy komentarz" required>
            <input type="submit" value="Zapisz zmiany" style="background:red;"></form>');
        }
        else{
            echo("Nie jesteś administratorem");
        }
        
    }
    else {
        echo('Czy na pewno chcesz usunąć ten komentarz? <br>
        Ta akcja jest nieodwracalna.
        <a href="zmiany.php?delete_com='.$_GET["delete_com"].'" style="background: red; text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Usuń komentarz</a></p><br>
        ');
        
    }
    echo('
    <a href="zmiany.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
    </div>
    </div>
    ');
}

?>