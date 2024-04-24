<?php
    if(isset($_GET["id_albumu"])){
        if($_GET["id_albumu"]!=""){
            $_SESSION["acc_id_albumu"]=$_GET["id_albumu"];
        }
        else{
            $_SESSION["acc_id_albumu"]="";
        }
    }
    if(!isset($_SESSION["acc_id_albumu"])){
        $_SESSION["acc_id_albumu"]="";
    }


    if($_SESSION["acc_id_albumu"]!=""){
        echo('<a href="konto.php?id_albumu="
        style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Wróć do wyboru albumów</a><br></p>
       ');
        $result=mysqli_query($baza,"SELECT `id`,`opis` FROM `zdjecia` WHERE `id_albumu`=".$_SESSION["acc_id_albumu"]." ORDER BY `data` DESC; ");
        echo('<table style="width:100%; border:1px solid white; border-collapse: collapse;">
        <tr>
            <th>Zdjęcie</th><th>Opis</th><th colspan="2">Opcje</th>
        </tr>          ');

        while($zdjecie = mysqli_fetch_assoc($result)){
            echo('
            <tr>
                <td><img src="../photo/'.$_SESSION["acc_id_albumu"].'/'.$zdjecie["id"].'-min.png" alt=""></td>
                <td>'.$zdjecie["opis"].'</td>
                <td class="usable" ><a href="konto.php?change_description='.$zdjecie["id"].'">zmień opis</a></td>
                <td class="usable" ><a href="konto.php?delete_photo='.$zdjecie["id"].'">usuń zdjęcie</a></td>
            </tr>
            ');
        }
        echo('</table>');
    }
    else{
        
        $result=mysqli_query($baza,'SELECT `albumy`.`tytul`,`albumy`.`id`,COUNT(`zdjecia`.`id_albumu`) AS "ilosc", `albumy`.`data` 
            FROM `albumy`,`zdjecia` 
            WHERE `zdjecia`.`id_albumu`=`albumy`.`id` AND `albumy`.`id_uzytkownika`='.$_SESSION["user"]["id"].'
            GROUP BY `albumy`.`id` 
            ORDER BY "ilosc" DESC;');
        if(mysqli_num_rows($result)==0){
            echo("Nie masz jeszcze albumów ani zdjęć");
        }
        else{
            echo("Wybierz album:");
            echo('<table style="width:100%; border:1px solid white; border-collapse: collapse;">
            <tr>
                <th>Tytuł albumu</th><th>data dodania</th><th>Ilość zdjęć</th><td>Edytuj</td>
            </tr>          ');
            while($album = mysqli_fetch_assoc($result)){
                echo('
                <tr >
                
                    <td>'.$album["tytul"].'</td>
                    <td>'.$album["data"].'</td>
                    <td>'.$album["ilosc"].'</td>
                    <td class="usable" ><a href="konto.php?id_albumu='.$album["id"].'" style="height:100%">Edytuj</a></td>
                </tr>
                ');
        } 
        }
        echo("</table>");
    }
?>
<style>
th,td{
    border:1px solid var(--color35);
    
}
.usable a{
    width: 100%;
    height: 207px;
    display: flex;
    padding: 5px;
    flex-direction: column;
    justify-content: space-evenly;
}
.usable a:hover{
    background:red;
    cursor:pointer;
}
.usable{
    padding:0px;
}
</style>


    

<?php
    if(isset($_GET["delete_photo"])){
        echo('
        <div id="usun_album" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
        
        <div style="width:100%; background:var(--color2); padding:10px;">
           
        Czy na pewno chcesz usunąć to zdjęcie? <br>
        <img src="../photo/'.$_SESSION["acc_id_albumu"].'/'.$_GET["delete_photo"].'-min.png" alt=""><br>
        Ta akcja jest nieodwracalna.
        
        
        <a href="moje_konto/konto_edit.php?delete_photo='.$_GET["delete_photo"].'" style="background: red; text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Usuń zdjęcie</a></p><br>
        <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
        </div>
        </div>
        ');
    }
   

    elseif(isset($_GET["change_description"])){
        echo('
        <div id="change_description" style="width:100%; height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
       
        <div style="width:100%; background:var(--color2); padding:10px;">
           <form method="post" action="moje_konto/konto_edit.php" >
           <label>Podaj nowy opis</label>
           <input type="hidden" name="pchoto_desc_id" value="'.$_GET["change_description"].'">
           <input type="text" name="nowy_opis" placeholder="wpisz nowy opis" required>
           <input type="submit" value="Zapisz zmiany" style="background:red;"></form>
           <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
        </div>
        </div>
        ');
    }

?>  
        
