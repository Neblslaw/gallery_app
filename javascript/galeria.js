function show_tooltip(id){
    album = document.getElementById(id);
    

    var tooltipWrap = document.createElement("div"); //creates div
    tooltipWrap.className = 'tooltip'; //adds class

    //var text=album.getAttribute("data-tooltipText");
    tooltipWrap.innerHTML=album.getAttribute("data-tooltipText");
   
    //tooltipWrap.appendChild(document.createTextNode(text)); //add the text node to the newly created div.
 
    var firstChild = document.body.firstChild;//gets the first elem after body
    firstChild.parentNode.insertBefore(tooltipWrap, firstChild); //adds tt before elem 

    var padding = 5;
    var album_position = album.getBoundingClientRect();
    var tooltip_position = tooltipWrap.getBoundingClientRect(); 

    var topPos = album_position.y - (tooltip_position.height + padding);
    tooltipWrap.setAttribute('style','top:'+topPos+'px;'+'left:'+album_position.left+'px; z-index:10;')
}
function hide_tooltip(){
    document.querySelector(".tooltip").remove();
}
function submit_sort() {
    document.getElementById("sort_form").submit();
}
