<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>zdjęcie</title>
    <link rel="stylesheet" href="../style/style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<script src="..\javascript\foto.js"></script>
<body>
   
<?php 
    include("../include/menu.php");
    if(session_id()==""){
        session_start(); 
    }
    if(isset($_GET["id"])){
        $_SESSION["id"]=$_GET["id"];
    }  
    include("../include/baza.php");
    $result=mysqli_fetch_assoc(mysqli_query($baza,"SELECT `zdjecia`.`id`,`zdjecia`.`data`, `zdjecia`.`opis`, `uzytkownicy`.`login`, `albumy`.`tytul`, `zdjecia`.`id_albumu` 
    FROM `zdjecia`, `uzytkownicy`, `albumy` WHERE `zdjecia`.`zaakceptowane`='1' AND `albumy`.`id`=`zdjecia`.`id_albumu` 
    AND `uzytkownicy`.`id`=`albumy`.`id_uzytkownika` AND `zdjecia`.`id`='".$_SESSION["id"]."'"));
    $album_id=$result["id_albumu"];
   
?>

<div id="background" style="text-align:center;">

<p style="text-align:left;">
<a href=<?php echo("'../main/album.php?id=".$result["id_albumu"]."'");?> style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block; " > Wróć do albumu</a><br></p>
    <div class="container" id="container" style="display:inline-block; width:95%; margin-top:0px;">
        <div>
            <?php
                
                $data = DateTime::createFromFormat("Y-m-d H:i:s",$result["data"])->format("d/m/Y");
                echo(
                    "<h1>Album: \"".$result["tytul"]."\"</h1>".
                    "<h2 style='text-align:left;'>Data dodania: ".$data."</h2>".
                    "<h2 style='text-align:left;'>Dodał: ".$result["login"]."</h2>"
                );
                if(strlen($result["opis"])>0){
                    echo("<h2 style='text-align:left;' >Opis: ".$result["opis"]."</h2>");
                }
                else{
                    echo("<h2 style='text-align:left;' >Brak opisu</h2>");
                }
            ?>
        </div>


        
            <div>
        
                <?php 
                $nx_photo = mysqli_query($baza, "SELECT `id` FROM `zdjecia` WHERE `id`>".$_SESSION["id"]." AND `id_albumu` = $album_id AND `zaakceptowane` =1 ORDER BY `id` ASC LIMIT 0,1  ;");
                if(mysqli_num_rows($nx_photo)==0){
                    $nx_photo = mysqli_query($baza, "SELECT MIN(`id`) as 'id' FROM `zdjecia` WHERE `id_albumu` = $album_id AND `zaakceptowane` = 1 ");
                }
                echo('
                <a href=foto.php?id='.mysqli_fetch_assoc($nx_photo)["id"].'><div style="width:5%; height:100px; float:left; background: white; margin:1px; color:black; margin-bottom:11px;" id="next_photo_left">< </div></a>
                ');
                   
                ?>
       
        <div id="zdjecie_div" style="width:calc(90% - 10px); float:left;  margin:2px; margin-top:0px;">
            <?php 
                
                echo("<img id='zdjecie' src='../photo/$album_id/".$_SESSION["id"].".png' onload='set_photo_dimensions()' style='margin:1px;'>");
            ?>
        </div>
        <?php 
             $nx_photo = mysqli_query($baza, "SELECT `id` FROM `zdjecia` WHERE `id`<".$_SESSION["id"]." AND `id_albumu` = $album_id AND `zaakceptowane` =1 ORDER BY `id` DESC LIMIT 0,1  ;");
             if(mysqli_num_rows($nx_photo)==0){
                 $nx_photo = mysqli_query($baza, "SELECT MAX(`id`) as 'id' FROM `zdjecia` WHERE `id_albumu` = $album_id AND `zaakceptowane` = 1 ");
             }
             echo('
             <a href=foto.php?id='.mysqli_fetch_assoc($nx_photo)["id"].'><div style="width:5%; height:100px; float:left; background: white; margin:1px; color:black; margin-bottom:11px;" id="next_photo_right">> </div></a>
             ');  
                ?>
        
        
            </div>


        <div style="width:100%;">
        <p style="clear:both;">
            <?php
                if(isset($_SESSION["user"])){
                    $user=$_SESSION["user"]["id"];
                }
                else{
                    $user=0;
                }
                $ocena=mysqli_fetch_assoc(mysqli_query($baza,"
                SELECT AVG(`zdjecia_oceny`.`ocena`) AS 'srednia', COUNT(`ocena`) AS 'ilosc'
                FROM `zdjecia_oceny` WHERE `id_zdjecia`='".$_SESSION["id"]."';"));
               
                if($ocena["ilosc"]==0 AND $user==0){
                    echo("Nikt jeszcze nie ocenił, zaloguj się żeby oceniać<br>");
                }
                elseif($ocena["ilosc"]==0 AND $user!=0){
                    echo("Nikt jeszcze nie ocenił, bądź pierwszy<br>");
                }
                else{
                    $srednia = round($ocena["srednia"],1);
                    echo("Średnia ocen: ".$srednia." Z: ".$ocena["ilosc"]." ocen<br>");
                }
                if($user!=0){
                    if(mysqli_num_rows(mysqli_query($baza,"SELECT * FROM `zdjecia_oceny` WHERE `id_zdjecia`= ".$_SESSION["id"]." AND `id_uzytkownika`=".$user.";"))>0){
                        
                        echo("To zdjęcie zostało już przez Ciebie ocenione");
                    }
                    else{
                        echo('
                        <span class="fa-star br" id="d1" onclick="vote(1)"></span>
                        <span class="fa-star br" id="d2" onclick="vote(2)"></span>
                        <span class="fa-star br" id="d3" onclick="vote(3)"></span>
                        <span class="fa-star br" id="d4" onclick="vote(4)"></span>
                        <span class="fa-star br" id="d5" onclick="vote(5)"></span>
                        <span class="fa-star br" id="d6" onclick="vote(6)"></span>
                        <span class="fa-star br" id="d7" onclick="vote(7)"></span>
                        <span class="fa-star br" id="d8" onclick="vote(8)"></span>
                        <span class="fa-star br" id="d9" onclick="vote(9)"></span>
                        <span class="fa-star br" id="d10" onclick="vote(10)"></span>
                        
                        <form method="post" action="kom_ocena.php" id="dodaj_ocene">
                            <input type="hidden" id="ocena_holder" name="wartoscoceny">
                            <input type="hidden" name="id_zdjecia" value='.$_SESSION["id"].'>
                        </form>');
                    }
                }
                else{
                    echo("Zaloguj się, żeby ocenić");
                }
                
           ?>
           <?php
                $komentarze = mysqli_query($baza,"SELECT  `zdjecia_komentarze`.`komentarz`,  `zdjecia_komentarze`.`data`, `uzytkownicy`.`login` FROM `zdjecia_komentarze`,`uzytkownicy` 
                WHERE `zaakceptowany`='1' AND `id_zdjecia`='".$_SESSION["id"]."' AND `uzytkownicy`.`id`=`zdjecia_komentarze`.`id_uzytkownika` ORDER BY `data` DESC;");
                if(mysqli_num_rows($komentarze)==0){
                    echo("<br>jeszce nikt nie komentował");
                }
                else{
                    echo("<p style='font-size:30px; text-align:left;'>Komentarze:</p>");
                    while($komentarz = mysqli_fetch_assoc($komentarze)){
                       // echo("<div class='comment' >".$komentarz['komentarz']."</div>");
                        echo(' <div style="text-align:left; border-top:1px solid var(--color3);">
                        <span style="font-size:19px;">'.$komentarz['login'].': </span><br>
                        <span style="font-weight:300;">'.$komentarz['komentarz'].' </span><br>
                        <span style="font-weight:100; font-size:15px; color:var(--color3);">'.$komentarz['data'].' </span>
                        </div>');
                    }
                }
                ?>
               
                <?php
                if(isset($_SESSION["user"])){
                    echo("<br>dodaj komentarz:");
                    echo('
                    <form method="post" action="kom_ocena.php" id="dodaj_komentarz">
                        <input type="text" name="komentarz" placeholder="komentarz">
                        <input type="hidden" name="id_zdjecia" value='.$_SESSION["id"].'>
                        <input type="submit" value="dodaj komentarz">
                    </form>');
                }
            ?>
            </p>
        </div>
    </div>

<p style="text-align:left;">
<a href=<?php echo("'../main/album.php?id=".$result["id_albumu"]."'");?> style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;" > Wróć do albumu</a><br></p>
</div>

<?php include("../include/footer.php");
?>
</body>
<footer>
    
   
</footer>
</html>
