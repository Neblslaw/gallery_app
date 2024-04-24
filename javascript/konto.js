function show_datachange(){
    document.getElementById("zmien_dane").style.display="grid";
}
function show_delete_acc(){
    document.getElementById("usun_konto").style.display="grid";

}
function pokaz_zdj(album_id){
    javascript:location.replace('konto.php?page=zdjecia.php');
}
function zmien_tytul(album_id){
    console.log(album_id);
}
function usun_album(album_id){
    console.log(album_id);
}