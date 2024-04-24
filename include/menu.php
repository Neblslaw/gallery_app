
<?php
    session_start();
    //session_destroy();
?>

<nav id='menu' >
    
    <input type='checkbox' id='responsive-menu' title='rozwin menu' ><label></label>
    <ul>
        <li> <a href="index.php" class= "menu-item" src="">Galeria</a></li>
        <li> <a href= <?php 
                    if(isset($_SESSION["user"]))
                    {
                        echo("dodaj-album.php");
                    }
                    else
                    {
                        echo("logreg.php");
                    }
                    ?> class= "menu-item" src="">Załóż album</a></li>
        <li><a href=<?php 
                    if(isset($_SESSION["user"]))
                    {
                        echo("wybierz-album.php");
                    }
                    else
                    {
                        echo("logreg.php");
                    }
                        ?> class= "menu-item" src="">Dodaj zdjęcie</a></li>
        <li> <a href="top-foto.php" class= "menu-item" src="">Najlepiej oceniane</a></li>
        <li><a href="nowe-foto.php" class= "menu-item" src="">Najnowsze</a></li>
        

        <?php 
            if(isset($_SESSION["user"]))
            {
                echo(' <li><a href="konto.php?page=dane.php" class= "menu-item" src="">Moje konto</a></li> ');
            }
        ?>
        <?php 
            if(isset($_SESSION["user"]))
            {
                echo('<li><a href="wyloguj.php" class= "menu-item" src="">Wyloguj się</a></li>');
                
            }
            else
            {
                echo('<li><a href="logreg.php" class= "menu-item" src="">Zaloguj się</a></li>
                <li><a href="logreg.php?register=true" class= "menu-item" src="">Zarejestruj się</a></li> 
                ');
            }
            if(isset($_SESSION["user"]) and $_SESSION["user"]["uprawnienia"]!="użytkownik"){
                echo(' <li><a href="../administrator/index.php" class= "menu-item" src="">Panel administracyjny</a></li> ');
            }
        //https://www.cssportal.com/css3-menu-generator/
        ?>

        
        
    </ul>
</nav>