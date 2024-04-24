
<table >
    <tr>
        <th> Tytuł</th>
        <th> Użytkownik</th>
        <th> Data</th>
        <th> niezaakceptowanych zdjęć</th>
        <th colspan="2"> opcje</th>
    </tr>

<?php
if($_SESSION["user"]["uprawnienia"]!="administrator"){
    echo("nie jesteś administratorem");
}
else{
    
    $ilosc_albumów = mysqli_fetch_row(mysqli_query($baza,'SELECT COUNT(`albumy`.`id`) AS "ilosc" FROM `albumy`;'))[0];

    $items_on_page=30;
    if(isset($_GET["page_nb"])){
        $_SESSION["page_nb"]=$_GET["page_nb"];
    }
    if(!isset($_SESSION["page_nb"])){
        $_SESSION["page_nb"]=0;
    }
    $result = mysqli_query($baza,'
        SELECT  `albumy`.`id`, `albumy`.`tytul`, `albumy`.`data`, `uzytkownicy`.`login`,
        COUNT(IF(`zdjecia`.`zaakceptowane`=0 AND `zdjecia`.`id_albumu`=`albumy`.`id`, 1, NULL)) AS "ilosc" 
        FROM `albumy`,`uzytkownicy`,`zdjecia`
        WHERE `albumy`.`id_uzytkownika`=`uzytkownicy`.`id`  
        GROUP BY `albumy`.`id` 
        ORDER BY COUNT(IF(`zdjecia`.`zaakceptowane`=0 AND `zdjecia`.`id_albumu`=`albumy`.`id`, 1, NULL))  DESC  
        LIMIT '.(int)$_SESSION["page_nb"]*($items_on_page).",".$items_on_page.';');

    while($album= mysqli_fetch_assoc($result)){
        echo(

            '   <tr>
                <td>'.$album["tytul"].'</td>
                <td>'.$album["login"].'</td>
                <td>'.$album["data"].'</td>
                <td>'.$album["ilosc"].'</td>
                
                <td class="usable" ><a href="index.php?change_title='.$album["id"].'">zmień tytuł</a></td>
                <td class="usable" ><a href="index.php?delete_album='.$album["id"].'">usuń album</a></td>
            </tr>'
        );
    }

    $pages_count=ceil($ilosc_albumów/$items_on_page);
    if($pages_count>1){
        echo("<p id='pages_links'> Strony: ");

        for($i=1;$i<=$pages_count;$i++){
            if($i==$_SESSION["page_nb"]+1){
                echo("<a style='color:var(--color4)' href='index.php?page_nb=".($i-1)."'>$i </a>");
            }
            else{
                echo("<a href='index.php?page_nb=".($i-1)."'>$i </a>");
            }
            
        }
        echo("</p>");
    }

    if(isset($_GET["delete_album"])){
        $tytul=mysqli_fetch_assoc(mysqli_query($baza,"SELECT `tytul` from `albumy` WHERE `id`=".$_GET["delete_album"].""))["tytul"];
        echo('
        <div id="usun_album" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
        
        <div style="width:100%; background:var(--color2); padding:10px;">
           
        Czy na pewno chcesz usunąć album pod tytułem: '.$tytul.'?
        <br> Spowoduje do też usunięcie wszystkich zdjęć należących do tego albumu.<br>
        Ta akcja jest nieodwracalna.<br>
        
        
        <a href="zmiany.php?album_del_id='.$_GET["delete_album"].'" style="background: red; text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Usuń album</a></p><br>
        <a href="index.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
        </div>
        </div>
        ');
    }
   

    elseif(isset($_GET["change_title"])){
        $tytul=mysqli_fetch_assoc(mysqli_query($baza,"SELECT `tytul` from `albumy` WHERE `id`=".$_GET["change_title"].""))["tytul"];
        echo('
        <div id="change_title" style="width:100%; height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
       
        <div style="width:100%; background:var(--color2); padding:10px;">
           <form method="post" action="zmiany.php" >
           <label>Podaj nowy tytuł dla albumu pod tytułem '.$tytul.'</label>
           <input type="hidden" name="album_edit_id" value="'.$_GET["change_title"].'">
           <input type="text" name="nowy_tytul" placeholder="wpisz nowy tytul" required>
           <input type="submit" value="Zapisz zmiany" style="background:red;"></form>
           <a href="index.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
        </div>
        </div>
        ');
    }
}
?>


</table>