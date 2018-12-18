<?php
session_start();
  $dbhost="az-serwer1880693.online.pro"; $dbname="00167436_chmura"; $dbpassword="ElzDuda002"; $dbuser="00167436_chmura"; 
  $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("1");

    if ( !mysql_connect($dbhost, $dbuser, $dbpassword) ) {
        echo 'Nie moge polaczyc sie z baza danych';
         exit (0);
    }
    
    if ( !mysql_select_db($dbname) ) {
        echo 'Blad otwarcia bazy danych';
        exit (0);
    }
?>




       <?php 
            if ($_SESSION['zalogowany']==true){
    $max_rozmiar = 1000000000;  
    if (is_uploaded_file($_FILES['plik']['tmp_name'])){       
    
    if ($_FILES['plik']['size'] > $max_rozmiar){
        echo "Przekroczenie rozmiaru $max_rozmiar"; 
        }
    else{             
        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/index.php\">";
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']. "/z7/".$_SESSION['login']."" .'/'.$_FILES['plik']['name']);
        }     
    }     
    } 
            
?> 