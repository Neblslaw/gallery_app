<span style="font-size:30px;">Twoje dane:</span><br>
<?php echo(' Login: '.$_SESSION["user"]["login"].'<br>Adres email: '.$_SESSION["user"]["email"].'<br>');?>

        

    
<button onclick="show_datachange()" style="width:100%; margin: 5px 0px 5px 0px; height:50px; background:var(--color4);" >Zmień dane</button>

<div id="zmien_dane" style="width:100%; height:100vh; position:absolute; background:rgba(0,0,0,0.7); top: 0px; left: 0px; 
display: none; justify-content: center; align-content: center; z-index:10;">
<div style="width:100%; background:var(--color2); padding:10px;">
<span style="font-size:30px;">Zmień dane:</span><br>
<form method="post" action="moje_konto/konto_edit.php" id="zmiana_danych" >
    
    <label>Nowe hasło:</label>
    <input type="password" name="password" id="password" require  oninput="check_password()" >
        <p style="display:none" id="password_test_all">Hasło powinno:<br>
        <p style="display:none" id="password_test_1" >Zawierać więcej niż 7 znaków</p>
        <p style="display:none" id="password_test_2" >Nie zawierać więcej niż 22 znaków</p>
        <p style="display:none" id="password_test_3" >Zawierać małą literę</p>
        <p style="display:none" id="password_test_4" >Zawierać wielką literę</p>
        <p style="display:none" id="password_test_5" >Zawierać cyfrę</p><br></p>
    <label>Powtórz nowe hasło:</label>
    <input type="password" name="password2" id="password_2"  require  oninput="check_password_2()">
        <p style="display:none" id="password_2_test_1" >Hasła nie są takie same</p>
    <label>Nowy adres email:</label>
    <input type="text" name="email" id="email" require  oninput="check_email()" value="<?php echo($_SESSION["user"]["email"]);?>"><br>
        <p style="display:none" id="email_test_1" >Taki email nie może istnieć</p>

    <label>Podaj stare hasło, żeby potwierdzić:</label>
    <input type="password" name="password_3" id="password_3"  require ><br>
        <p  style="font-size:20px; color:red; display:none;" id="blendy_rejestracji">Nieprawidłowe dane</p>
    <input type="button" id="register"  name="change_data" value="Zmień dane" onclick="change_data_submit()"><br>
    <p style=" text-align:center;">
    <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%;">Anuluj</a></p><br>

</form>
</div>
</div>
<br>
<br>
<br>

<div id="usun_konto" style="width:100%; height:100vh; position:absolute; background:rgba(0,0,0,0.7);
 top: 0px; left: 0px; display: none; justify-content: center; align-content: center; z-index:10;">

<div style="width:100%; background:var(--color2); padding:10px;">
    <form method='post' action="moje_konto/konto_edit.php" >
    <label>Aby usunąć konto podaj swoje hasło:</label>
    <input type='password' name='user_del' required>
    <input type='submit' value='Usuń konto' style='background:red;'></form>
    <a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Anuluj</a></p><br>

</div>
</div>
 
<button onclick="show_delete_acc()" style="width:100%; margin: 5px 0px 5px 0px; height:50px; background:red;" >Usuń konto</button>     
<?php

    if(isset($_GET["usunieto"])){
        echo('
        <div style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
        
        <div style="width:100%; background:var(--color2); padding:30px;">');
        if($_GET["usunieto"]=="true"){
            echo('Poprawnie usunieto konto.<br>');
            echo('<a href="../index.php"  style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block;">Wróć do strony głównej</a>');
        }
        else{
            echo('Nieprawidłowe hasło.<br>');
            echo('<a href="konto.php"  style="background: var(--color4); text-decoration: none; margin: 10px; padding: 10px; display:inline-block; width:90%;">Wróć</a>');
        }
    }
    if(isset($_GET["zmieniono"])){
        echo('
        <div id="" style="width:100%;  height:100vh; position:absolute; background:rgba(0,0,0,0.7);
        top: 0px; left: 0px; display: grid; justify-content: center; align-content: center; z-index:10;">
        <div style="width:100%; background:var(--color2); padding:10px;">
        ');
        if($_GET["zmieniono"]=="true"){
            echo("Twoje dane zostały zmienione<br>");
        }
        else{
            echo("Twoje dane nie zostały zmienione, spróbuj ponownie<br>");
        }
        
        echo('<a href="konto.php" style="background: var(--color4); text-decoration: none; padding: 10px; display:inline-block; width:100%; text-align:center;">Ok</a></p></div></div>');
    }
    

?>


<footer>
    <script src="..\javascript\konto.js"></script>
    <script src="..\javascript\testy_register.js"></script>
</footer>