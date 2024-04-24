<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Dodaj zdjęcia</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<body >
<?php 
    include("../include/menu.php");
    if(session_id()==""){
      session_start(); 
    } 
    include("../include/baza.php");
    ?>
    <div id="background" style="display:grid; justify-items: center; align-content: start; padding-top:50px; padding-bottom:50px;">
    
    
    <?php
    $user_albums_count = mysqli_num_rows(get_user_albums($_SESSION["user"]["id"]));
    if( $user_albums_count==0){
        echo('<div class="container" style="height:160px; text-align:center;" >');
        echo('<p style="font-size:30px;">Najpierw musisz dodać album</p><br>');
        echo('<a href="dodaj-album.php" style=" background:var(--color4); padding:10px; text-decoration:none; margin:10px;" > Dodaj album </a><br>');
    }
    
    else if ($user_albums_count==1){
        $result = get_user_albums($_SESSION["user"]["id"]);
        $album = mysqli_fetch_assoc($result);
        header("Location: dodaj-foto.php?wybrany_album=".$album["id"]);

    }
    else{
        echo('<div class="container" style="width:90%; min-height:200px;">');

        echo('<p style="font-size:30px;">Wybierz album</p>');
        echo("<div style='display: grid; grid-template-columns: auto auto; justify-content: space-between; padding-left: 50px;padding-right: 50px;'>
        <div style='padding:10px;'>Tytuł:</div><div style='padding:10px;'>Data utworzenia</div></div>" );
    
        $result = get_user_albums($_SESSION["user"]["id"]);
        while($album = mysqli_fetch_assoc($result)) {
            
            

            echo("<a  href='dodaj-foto.php?wybrany_album=".$album["id"]."' style='color:white;'>
            <div class='album_choise_list' >
            <div>".$album["tytul"]."</div>");
            echo("<div>".$album["data"]."</div></div></a>
            ");
            
        }
        echo("<a  href='dodaj-album.php' style='color:white;'>
        <div class='album_choise_list' >
        <div>Dodaj nowy album</div>");
        echo("<div></div></div></a>");
    }
?>
    

    <?php

?>
    
</div>

</div>










<?php include("../include/footer.php");
mysqli_close($baza);?>

<footer>
    <script src="..\javascript\dodawanie.js"></script>
</footer>
</body>
</html>