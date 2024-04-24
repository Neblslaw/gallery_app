<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Galeria</title>
	<link  rel="stylesheet" href="..\style\style.css">
    <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<body onkeypress="enter()" >
<?php 
    include("../include/menu.php");
    if(session_id()==""){
      session_start(); 
    }  
    if(isset($_POST["sort"])){
        $_SESSION["sort"]=$_POST["sort"];
    }
    else if(!isset($_SESSION["sort"])){
        $_SESSION["sort"]="`albumy`.`tytul`";
    }

    if(isset($_GET["page"])){
        $_SESSION["page"]=(int)$_GET["page"]-1;
    }
    else if(!isset($_SESSION["page"])){
        $_SESSION["page"]="0";
    }
?>


<div id="background" style="text-align:center;">
<div style="width:100%; height:50px; display:grid; grid-template-columns:30% 40% 30%;">
<div></div>
    <span style="font-size:30px;  width:50%;">Galeria</span>

    
   
    <form action="index.php" method="post" id="sort_form" style="float:right; padding:5px;">
    <label for="sort">Sortuj według:</label>
    <select name="sort" id="sort" onchange="submit_sort()" default="Daty dodania" style="border:0px;">
        <option class="select-option" <?php if($_SESSION["sort"]=="`uzytkownicy`.`login`"){echo("selected");}?> value="`uzytkownicy`.`login`">Twórcy</option>
        <option <?php if($_SESSION["sort"]=="`albumy`.`data`"){echo("selected");}?> value="`albumy`.`data` DESC">Daty dodania</option>
        <option <?php if($_SESSION["sort"]=="`albumy`.`tytul`"){echo("selected");}?> value="`albumy`.`tytul`">Tytułu albumu</option>
    </select>
    </form>
    
</div>


    
    <?php
        $items_on_page=20;


        include("../include/baza.php");
        
        $albumy=mysqli_query($baza , 
        "SELECT DISTINCT `uzytkownicy`.`login`,`albumy`.`id`,`albumy`.`tytul`,`albumy`.`data` , MIN( `zdjecia`.`id`) AS 'PHOTO'
        FROM `uzytkownicy`, `albumy`, `zdjecia` 
        WHERE `albumy`.`id_uzytkownika` = `uzytkownicy`.`id` AND `zdjecia`.`id_albumu`=`albumy`.`id` AND `zdjecia`.`zaakceptowane`='1' GROUP BY `albumy`.`id`
        ORDER BY ".$_SESSION["sort"]."
        LIMIT ".(int)$_SESSION["page"]*$items_on_page.",".$items_on_page.";"
        
    );
    
        while($album = mysqli_fetch_assoc($albumy)) { 
            
           // $zdjecie_result = mysqli_query($baza, "SELECT `zdjecia`.`id` FROM `zdjecia` WHERE `zdjecia`.`id_albumu`=".$album["id"]." ORDER BY `zdjecia`.`id` LIMIT 0,1 ;");
            //$zdjecie = mysqli_fetch_row($zdjecie_result);

            $data = DateTime::createFromFormat("Y-m-d H:i:s",$album["data"])->format("d/m/Y");
            echo("<a href='album.php?id=".$album['id']."'>");
            echo('<div 
            data-tooltipText="Tytuł: '.$album["tytul"].' <br> Właściciel: '.$album["login"].' <br> Data utworzenia: '.$data.'" id= "ablum'.$album["id"].'" 
            class="miniaturka_albumu" onmouseover="show_tooltip(this.id)" onmouseout="hide_tooltip()">
            <img src="../photo/'.$album["id"].'/'.$album["PHOTO"].'-min.png'.'" alt="" style=" height:180px;">
            </div>'); 
            echo("</a>
            ");
            
            }



            $count = mysqli_query($baza , "
            SELECT COUNT(DISTINCT `albumy`.`id` )  
            FROM `uzytkownicy`, `albumy`, `zdjecia` 
            WHERE `albumy`.`id_uzytkownika` = `uzytkownicy`.`id` AND `zdjecia`.`id_albumu`=`albumy`.`id` AND `zdjecia`.`zaakceptowane`='1';");
            $pages_count=ceil(mysqli_fetch_row($count)[0]/$items_on_page);
            if($pages_count>1){
                echo("<p id='pages_links'> Strony: ");

                for($i=1;$i<=$pages_count;$i++){
                    if($i==$_SESSION["page"]+1){
                        echo("<a style='color:var(--color4)' href='index.php?page=$i'>$i </a>");
                    }
                    else{
                        echo("<a href='index.php?page=$i'>$i </a>");
                    }
                    
                }
                echo("</p>");
            }
           
?>

</div>

<?php include("../include/footer.php");
mysqli_close($baza);?>

<footer>
    <script src="..\javascript\galeria.js"></script>
</footer>
</body>
</html>