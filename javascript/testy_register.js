function display_register_form(){
    document.getElementById("register_form").style.display="grid";
    document.getElementById("login_form").style.display="none";

}
function hide_register_form(){
    document.getElementById("register_form").style.display="none";
    document.getElementById("login_form").style.display="block";
}

document.getElementById("body1").addEventListener("keyup", function(event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        submit_proper_form();
    }
});

function submit_proper_form(){

    if(document.getElementById("zmiana_danych")){
        change_data_submit();
    }
        
    else if(document.getElementById("register_form").style.display!="none"){
        register_submit();
    }
    else if(document.getElementById("login_form").style.display!="none"){
        login_submit();
    }
        
}

function check_login(){

    login = document.getElementById("login").value;
    if(login.length>0){
        valid=true;

        //test 1
        if(login.length>=8){
            document.getElementById("login_test_1").style.display="none";
        }
        else{
            document.getElementById("login_test_1").style.display="block";
            valid=false;
        } 
    
        //test 2
        if(login.length<=16){
            document.getElementById("login_test_2").style.display="none";
        }
        else{
            document.getElementById("login_test_2").style.display="block";
            valid=false;
        } 
    
        //test 3
        loginRegExp = new RegExp("^[A-Za-z0-9]+$");
        if(loginRegExp.test(login)){
            document.getElementById("login_test_3").style.display="none";
        }
        else{
            document.getElementById("login_test_3").style.display="block";
            valid=false;
        } 
    
        if(valid){
            document.getElementById("login_test_all").style.display="none";
        }
        else{
            document.getElementById("login_test_all").style.display="block";
        }
        if(!valid){
            document.getElementById("login").style.border="2px solid red";
        }
        else{
            document.getElementById("login").style.border="0px";
        }
        return valid;
    }
    else{
        
        return false;
        
    }
   
}
function check_password(){
    password = document.getElementById("password").value;
    if(password.length>0){
        valid=true;

        //test 1
        if(password.length>=8){
            document.getElementById("password_test_1").style.display="none";
        }
        else{
            document.getElementById("password_test_1").style.display="block";
            valid=false;
        } 
    
        //test 2
        if(password.length<=20){
            document.getElementById("password_test_2").style.display="none";
        }
        else{
            document.getElementById("password_test_2").style.display="block";
            valid=false;
        } 
    
        //test 3
        passwordRegExp = new RegExp("[a-z]+");
        if(passwordRegExp.test(password)){
            document.getElementById("password_test_3").style.display="none";
        }
        else{
            document.getElementById("password_test_3").style.display="block";
            valid=false;
        } 
    
        //test 4
        passwordRegExp = new RegExp("[A-Z]+");
        if(passwordRegExp.test(password)){
            document.getElementById("password_test_4").style.display="none";
        }
        else{
            document.getElementById("password_test_4").style.display="block";
            valid=false;
        } 
    
        //test 5
        passwordRegExp = new RegExp("[0-9]+");
        if(passwordRegExp.test(password)){
            document.getElementById("password_test_5").style.display="none";
        }
        else{
            document.getElementById("password_test_5").style.display="block";
            valid=false;
        } 
    
        if(valid){
            document.getElementById("password_test_all").style.display="none";
        }
        else{
            document.getElementById("password_test_all").style.display="block";
        }
        if(!valid){
            document.getElementById("password").style.border="2px solid red";
        }
        else{
            document.getElementById("password").style.border="0px";
        }
        return valid;
    }
    else{
        return false;
    }
    
}

function check_password_2(){
    if(document.getElementById("password_2").value.length>0){
        if(document.getElementById("password").value == document.getElementById("password_2").value){
            document.getElementById("password_2_test_1").style.display="none";
            document.getElementById("password_2").style.border="0px";
            return true;
        }
        else{
            document.getElementById("password_2_test_1").style.display="block";
            document.getElementById("password_2").style.border="2px solid red";
            return false;
        }
    }
    else{
        return false;
    }
   
}

function check_email() {
    if(document.getElementById("email").value.length>0){
        var mailformat = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*[.][a-zA-Z]{2,3}$/
        if(document.getElementById("email").value.match(mailformat)){
            document.getElementById("email_test_1").style.display="none";
            document.getElementById("email").style.border="0px";
            return true;
        }
        else{
            document.getElementById("email_test_1").style.display="block";
            document.getElementById("email").style.border="2px solid red";
            return false;
        }
    }
    else{
        return false;
    }
    
}

function register_submit() {
    if (check_login() && check_password_2() && check_password() && check_email()){
        document.getElementById("rejestracja").submit();
    }
    else{
        document.getElementById("blendy_rejestracji").style.display="block";
    }
}
function change_data_submit() {

    if (check_password_2() && check_password() && check_email()){
        document.getElementById("zmiana_danych").submit();
    }
    else{
        document.getElementById("blendy_rejestracji").style.display="block";
    }
}

function login_submit() {
    console.log("   asddas");
    valid = true;
    //password
    password = document.getElementById("login_password").value;
   

    if(password.length<8  || password.length>20) valid = false;
  
    console.log(valid);
    if(!new RegExp("[a-z]+").test(password)) valid = false;
    if(!new RegExp("[A-Z]+").test(password)) valid = false;
    if(!new RegExp("[0-9]+").test(password)) valid = false;
    
    //login
    login = document.getElementById("login_login").value;
   

    loginRegExp = new RegExp("^[A-Za-z0-9]{8,20}$");
    if(!loginRegExp.test(login)){
        valid=false;
    }

   
    login_tests=document.getElementById("login_tests");
    login_submit2 = document.getElementById("login_submit1");
    if(valid){
        login_tests.style.display="none";
        document.getElementById("logowanie").submit();
    }
    else{
        login_tests.style.display="block";
        
    }
    
}