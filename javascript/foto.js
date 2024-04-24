
function set_photo_dimensions(){
    let _1vh = Math.round(window.innerHeight );
    console.log(_1vh);
    var photo = document.getElementById("zdjecie");
    console.log(photo.offsetHeight);
    console.log(photo.offsetWidth);
    console.log(document.getElementById("container").offsetWidth);
    
    console.log("zdjecie_div: "+document.getElementById("zdjecie_div").offsetWidth);
    photo.style.width = document.getElementById("zdjecie_div").offsetWidth+"px";
    photo.style.height="auto";

    if(_1vh<photo.offsetHeight){
        photo.style.height=_1vh-50 + "px";
        photo.style.width = "auto";
    }
    
    var next_photo_right = document.getElementById("next_photo_right");
    var next_photo_left = document.getElementById("next_photo_left");

    next_photo_right.style.height = photo.offsetHeight +"px";
    next_photo_left.style.height = photo.offsetHeight + "px";


    console.log("window:"+_1vh);
    console.log("photo h:"+photo.offsetHeight);
    console.log("photo w:"+photo.offsetWidth);
    console.log("container:"+document.getElementById("container").offsetWidth); 
}
function vote(ocena){
    document.getElementById("ocena_holder").value=ocena;
    document.getElementById("dodaj_ocene").submit();
    //console.log(document.getElementById("ocena_holder").value);
}
