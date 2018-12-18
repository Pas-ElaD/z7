<?php

$folder = $_POST['login'];
mkdir ("$folder", 0777);
 echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/logowanie.php\">";


?>