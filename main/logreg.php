<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Logowanie</title>
	<link  rel="stylesheet" href="..\style\style.css">
  <link  rel="stylesheet" href="..\style\menu_style.css">
</head>
<body id="body1" <?php if(isset($_GET["register"])){echo('onload="display_register_form()"');}else{echo('onload="hide_register_form()"');}?>>
  <?php 
    include("../include/menu.php");
    if(session_id()==""){
      session_start(); 
    }   
    $invalid_user=false;
    if(isset($_SESSION["invalid_user"])){
      $invalid_user = $_SESSION["invalid_user"];
      $_SESSION["invalid_user"]=null;
    }

  ?>
  <div id="background" style="display:grid; justify-content: center; align-content: start; padding-top:50px; padding-bottom:50px;">
    
    <div class="container" id="login_form" >
    <p style="font-size:30px;"> Zaloguj się</p><br>
      <form method="post" action="logowanie.php" id="logowanie" oninput="">
        <label>Nazwa użytkownika:</label>
        <input type="text" name="login_login" id="login_login" require  ><br><br>
        <label>Hasło:</label>
        <input type="password" name="login_password" id="login_password" require  ><br>
          

        <br><p id="login_tests" style='font-size:20px; color:red; display:none;'> Nieprawidłowe dane</p>
          
          <?php
            if(isset($_GET["login_error"])){
              echo("<p style='font-size:20px; color:red;'>".$_GET['login_error']."<br></p>");
            }
          ?>
          
        <input type="button" id="login_submit1" name="Zaloguj" value="Zaloguj" onclick='login_submit()' ><br>
      </form>
      <p style="text-align: center; font-size:17px;"> Nie masz konta? 
              <button onclick="display_register_form()">Zarejestruj się!</button>
      </p>
    </div>
     
  
  <div class="container" id="register_form" >
  <p style="font-size:30px;"> Zarejestruj się</p><br>
    <form method="post" action="rejestracja.php" id="rejestracja" >
      <label>Nazwa użytkownika:</label>
      <input type="text" name="login" id="login" require  oninput="check_login()" value=<?php if($invalid_user)echo( $invalid_user["login"]);?>><br>
        <p id="login_test_all" style="display:none" >Login powinien:<br>
        <p id="login_test_1" style="display:none;" >Zawierać więcej niż 7 znaków</p>
        <p id="login_test_2" style="display:none;" >Nie zawierać więcej niż 18 znaków</p>
        <p id="login_test_3" style="display:none;" >Zawierać tylko litery i cyfry</p><br></p>
      <label>Hasło:</label>
      <input type="password" name="password" id="password" require  oninput="check_password()" value=<?php if($invalid_user)echo( $invalid_user["password"]);?>><br>
        <p style="display:none" id="password_test_all">Hasło powinno:<br>
        <p style="display:none" id="password_test_1" >Zawierać więcej niż 7 znaków</p>
        <p style="display:none" id="password_test_2" >Nie zawierać więcej niż 22 znaków</p>
        <p style="display:none" id="password_test_3" >Zawierać małą literę</p>
        <p style="display:none" id="password_test_4" >Zawierać wielką literę</p>
        <p style="display:none" id="password_test_5" >Zawierać cyfrę</p><br></p>
      <label>Potwierdź hasło:</label>
      <input type="password" name="password2" id="password_2"  require  oninput="check_password_2()" value=<?php if($invalid_user)echo( $invalid_user["password2"]);?>><br>
        <p style="display:none" id="password_2_test_1" >Hasła nie są takie same</p><br>
      <label>Adres email:</label>
      <input type="text" name="email" id="email" require  oninput="check_email()" value=<?php if($invalid_user)echo( $invalid_user["email"]);?>><br>
        <p style="display:none" id="email_test_1" >Taki email nie może istnieć</p><br>
        <?php 
          if(isset($_GET["register_errors"])){
            echo("<p style='font-size:20px; color:red;'>".$_GET['register_errors']."</p>");
          }
        ?>
        <p  style='font-size:20px; color:red; display:none;' id="blendy_rejestracji">Nieprawidłowe dane</p>
      <input type="button" id="register"  name="Zarejestruj" value="Zarejestruj" onclick="register_submit()"><br>
    </form>
    <p style="text-align: center; font-size:17px;"> Masz już konto? 
      <button onclick="hide_register_form()">Zaloguj się!</button>
    </p>
  </div>
</div>
        </div>
<?php include("../include/footer.php");?>
</body>

<footer>

   <script src="..\javascript\testy_register.js"></script>
</footer>
</hrml>