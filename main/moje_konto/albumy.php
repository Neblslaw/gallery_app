<?php

    $albums = get_user_albums($_SESSION["user"]["id"]);
    if(mysqli_num_rows($albums)==0){
        echo("Nie masz jeszce żadnego albumu");
    }
    else{
        echo('<div style="width:100%;">
        <table style="width:100%; border:1px solid white; border-collapse: collapse;">
            <tr>
                <th>Tytuł</th><th>Data dodania</th><th colspan="3">Opcje</th>
            </tr>'           
        );
        while($album = mysqli_fetch_assoc($albums)){
            echo('<tr>
                <td>'.$album["tytul"].'</td>
                <td>'.$album["data"].'</td>
                <td class="usable" ><a href="konto.php?change_title='.$album["id"].'">zmień tytuł</a></td>
                <td class="usable" ><a href="konto.php?delete_album='.$album["id"].'">usuń album</a></td>
                <td class="usable" ><a href="konto.php?page=zdjecia.php&id_albumu='.$album["id"].'"> pokaż zdjecia</a></td>
            </tr>');
        }
        echo("</table>");
    }
    
?>
<style>
th,td{
    border:1px solid var(--color35);
    padding:5px;
}
.usable a{
    width:100%;
    height:100%;
    display:inline-block;
    padding:5px;
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
    if(isset($_GET["delete_album"])){
        $tytul=mysqli_fetch_assoc(mysqli_query($baza,"SELECT `tytul` from `albumy` WHERE `id`=".$_GET["delete_album"].""))["tytul"];
        echo('
        <div id="usun_album" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
        
        <div style="width:100%; background:var(--color2); padding:10px;">
           
        Czy na pewno chcesz usunąć album pod tytułem: '.$tytul.'?
        <br> Spowoduje do też usunięcie wszystkich zdjęć należących do tego albumu.<br>
        Ta akcja jest nieodwracalna.<br>
        
        
        <a href="moje_konto/konto_edit.php?album_del_id='.$_GET["delete_album"].'" style="background: red; text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Usuń album</a></p><br>
        <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
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
           <form method="post" action="moje_konto/konto_edit.php" >
           <label>Podaj nowy tytuł dla albumu pod tytułem '.$tytul.'</label>
           <input type="hidden" name="album_edit_id" value="'.$_GET["change_title"].'">
           <input type="text" name="nowy_tytul" placeholder="wpisz nowy tytul" required>
           <input type="submit" value="Zapisz zmiany" style="background:red;"></form>
           <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>
        </div>
        </div>
        ');
    }

?>

</div>
<script src="..\javascript\konto.js"></script>