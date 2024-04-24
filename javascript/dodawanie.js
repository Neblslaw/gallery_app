function check_name(){
    galery_name=document.getElementById("nazwa").value;
    
    if(galery_name.length>0){
        nameRegExp = new RegExp("^[ ]+$");
        valid=true;
        if(nameRegExp.test(galery_name)){
            document.getElementById("name_test").style.display="block";
            valid=false;
        }
        else{
            document.getElementById("name_test").style.display="none";
        }
        if(galery_name.length>100){
            document.getElementById("name_test_2").style.display="block";
            valid=false;
        }
        else{
            document.getElementById("name_test_2").style.display="none";
        }
        if(!valid){
            document.getElementById("nazwa").style.border="2px solid red";
            document.getElementById("blendy_nazwy").style.display="block";
        }
        else{
            document.getElementById("nazwa").style.border="0px";
            document.getElementById("blendy_nazwy").style.display="none";

        }
        return valid;
    }
    return false;
}
function dodaj_album(){
    if(check_name()){
        document.getElementById("dodaj_album").submit();
    }
}