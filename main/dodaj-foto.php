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
    if(isset($_GET["wybrany_album"])){
        $_SESSION["album"]=$_GET["wybrany_album"];
    }
    ?>
<div id="background" style="text-align:center; padding-top:50px; padding-bottom:50px;">
    
    <div class="container" style="display: inline-block; width:90%; min-height:200px;">



    <form method="post" action="dodaj-foto.php" enctype="multipart/form-data">
        <label>Opis (opcjonalny):</label>
        <input type="text" name="opis" id="foto_opis" >
        <input type="file" name="zdj" required>
    <input type="submit" value="dodaj zdjęcie">
    </div>


<?php
    if(isset($_FILES["zdj"])){
        if($_FILES["zdj"]["error"]==UPLOAD_ERR_OK){
            if(exif_imagetype($_FILES["zdj"]["tmp_name"])!=0){

                $new_id = add_photo();
                imagepng(imagecreatefromstring(file_get_contents($_FILES["zdj"]["tmp_name"])), "../photo/temporary/image.png");
                create_min();
                scale_image();

                if (file_exists("../photo/temporary/image.png")) {
                    unlink("../photo/temporary/image.png");
                }
            }
        }
        elseif ($_FILES["zdj"]["error"]==UPLOAD_ERR_NO_FILE) {
            echo("nie wysłano pliku<br>");
        }
        else{
            echo("Błąd wysyłanie pliku<br>");
        }
    }
    
    function add_photo(){
        global $baza;
        $opis = htmlspecialchars($_POST["opis"],ENT_QUOTES);
        $album = $_SESSION['album'];
        mysqli_query($baza, "INSERT INTO `zdjecia` SET opis='$opis', id_albumu='$album', zaakceptowane=0 ");
        
        return(mysqli_insert_id($baza));
    }

    function create_min(){
        global $new_id;

        list($width, $height)=GetImageSize("../photo/temporary/image.png");
        $new_height = 180;
        $new_width = intval($width * ($new_height / $height));
        if($new_width==0){
            $new_width =1;
        }
        $new_image = ImageCreateTrueColor($new_width,$new_height);
       
        $old_image = imagecreatefrompng("../photo/temporary/image.png");
        ImageCopyResampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        ImagePNG($new_image, "../photo/".$_SESSION["album"]."/$new_id-min.png");
        //ImagePNG($new_image, "../photo/39/$new_id-min.png");

    }
    function scale_image(){
        global $new_id;

        list($width, $height)=GetImageSize("../photo/temporary/image.png");

        if($width>$height){
            $new_width = 1200;
            $new_height = intval($height * ($new_width / $width));
        }
        else{
            $new_height = 1200;
            $new_width = intval($width * ($new_height / $height));
            
        }
        if($new_width==0){
            $new_width =1;
        }
        if($new_height==0){
            $new_height=1;
        }
        $new_image = ImageCreateTrueColor($new_width,$new_height);
       
        $old_image = imagecreatefrompng("../photo/temporary/image.png");
        ImageCopyResampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        ImagePNG($new_image, "../photo/".$_SESSION["album"]."/$new_id.png");
    }

?>


<div class="container" style=" display: inline-block; width:90%; min-height:200px;">
<?php
    $result = mysqli_query($baza,"SELECT `id` FROM `zdjecia` WHERE `id_albumu`=".$_SESSION["album"]);

    while($image_id = mysqli_fetch_assoc($result)){
        echo('<img src="../photo/'.$_SESSION["album"].'/'.$image_id["id"].'-min.png'.'" alt="" >');
    }

?>


</div>
</div>


<?php include("../include/footer.php");
mysqli_close($baza);?>

<footer>
</footer>
</body>
</html>