<?php
$baza = mysqli_connect("localhost", "root", "", "gielczynski_4tb");
mysqli_query($baza, 'SET NAMES utf8');
mysqli_query($baza, 'SET CHARACTER SET utf8');
mysqli_query($baza, "SET collation_connection = utf8_polish_ci");

?>
