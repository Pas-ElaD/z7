<?php
session_start();    
?>


<html lang="pl">
<head>
    <meta http-equiv=content-type content="text/html; charset=iso-8859-2" />
    <meta http-equiv="Content-Language" content="pl" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </link>
</head>

<body class="text-center">

<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////  Połączenie z bazą danych i warunki logowania ////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  $dbhost="az-serwer1880693.online.pro"; $dbname="00167436_chmura"; $dbpassword="ElzDuda002"; $dbuser="00167436_chmura";  
  $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if ( !mysql_connect($dbhost, $dbuser, $dbpassword) ) {
        echo 'Nie moge polaczyc sie z baza danych';
         exit (0);
    }
    
    if ( !mysql_select_db($dbname) ) {
        echo 'Blad otwarcia bazy danych';
        exit (0);
    }


    $id = $_POST['login'];
    $id = addslashes($id); 
    



    
  $rezultat2 = mysqli_query($polaczenie, "SELECT * FROM logi WHERE `uzytkownik`='$id' ");
                         while ($zlicz = mysqli_fetch_array ($rezultat2))
 
    $licz = "$zlicz[4]";
    
    $rez= mysqli_query($polaczenie, "SELECT * FROM logi WHERE `uzytkownik`='$id'");
    while ($rek = mysqli_fetch_array ($rez))
 
    $czas = "$rek[2]";
    $ck = $czas;
 
    $endtime = date('d-m-Y H:i:s', strtotime("+01 minutes", strtotime($ck)));
    $datateraz = date('d-m-Y H:i:s');

   $difference=round(strtotime($endtime)-strtotime($datateraz)); 

    if ($difference < 0) $time = -$difference; else $time = $difference; // jeśli różnica jest ujemna to zmienia znak na dodatni, jeśli dodatnia pozostaje bez zmian

    $days = floor($time/86400);
    $hours = floor(($time-($days*86400))/3600);
    $mins = floor (($time-($days*86400)-($hours*3600))/60);
    $mins = floor (($time-($days*86400)-($hours*3600))/60); // ilość minut
    $secs = floor ($time-($days*86400)-($hours*3600)-($mins*60)); // ilość sekund

    if ($difference <= 0) { // jesli różnica jest ujemna czyli data jest w przeszłości.
        $reset =  "UPDATE `logi` SET `proba`= '0' WHERE `uzytkownik`='$id' ";
        $koniec = $polaczenie->query($reset);
    }else{
        
    }
    if($licz >= 2){
        echo (" TWOJE KONTO ZOSTAŁO ZAWIESZONE NA 1 MINUTE");
        echo "</br>";
        echo 'Do końca zostało ';
        echo  $mins . ' minut ' . $secs . ' sekund'; // echowanie wartości.
    }
    else {
        if ( isset($_POST["login"]) ){
        $login = $_POST["login"];
        $haslo = ($_POST["haslo"]);
        $czy_poprawne_haslo = SprawdzCzyPoprawneHaslo($login,$haslo);
        if ($czy_poprawne_haslo) {
                $_SESSION['zalogowany'] = true;
                $_SESSION['login'] = $login;
                 echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/index.php\">";
                 $przekazanie =  "UPDATE `logi` SET `poprawne` = '".date('Y-m-d H:i:s')."' WHERE `uzytkownik`='$id' ";
                  $wynik = $polaczenie->query($przekazanie);
                  $ciasto = $_POST['login'];
         setcookie('login',$ciasto, time()+600);
      //header("Location: index.php");

            } else {

                         $rezultat = mysqli_query($polaczenie, "SELECT * FROM logi WHERE `uzytkownik`='$login'");
                         while ($rekord = mysqli_fetch_array ($rezultat))
 
                          $proby = "$rekord[4]"; 

                 $bladplus = $proby + 1;
           //     echo "<p>Podales bledne dane. Wpisz poprawny login i haslo.";
                $przekazanie =  "UPDATE `logi` SET `bledne` = '".date('Y-m-d H:i:s')."', `proba`= '".$bladplus."' WHERE `uzytkownik`='$id' ";
                 $wynik = $polaczenie->query($przekazanie);
            //   echo "$proby";
                }  
                
    }
    formularz();

}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Formularz logowania - pole tekstowe login haslo ////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function formularz(){
    
    print '<FORM method="POST" action="">';
    print '<b><h1>LOGOWANIE DO PORTALU</h1><b><br>';
    print '<b>Login:</b> <input type="text" name="login"><br></br>';
    print '<b>Hasło:</b> <input type="password" name="haslo"><br></br>';
    print '<input type="submit" value="Zaloguj" name="loguj"></br>';
           print '</FROM>';
           print 'Nie masz konta?';
print '<a href="http://pas-eduda.pl/z7/rejestracja.php"> Zarejestruj sie !</a></br>';
print '<a href="https://webspeed.intensys.pl/wyniki/137617/">Wyniki analizy serwisu</a></br>';    
}

  


//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Test dzialajacego prawie skryptu //////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////



 /* 
    if($proby >= 3){
     //   ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  //  $ipblok = $_SERVER["REMOTE_ADDR"]; 
    // echo "$ipblok";
       
    function checkIP($ip)
{
    
    $ipblok2 = $_SERVER["REMOTE_ADDR"]; 
  $arr = array(
   "$ipblok2"
  );
  foreach($arr as $ban){
    if($ip == $ban) return false;
  }
  return true;
}
       
       
       if(!checkIP($_SERVER['REMOTE_ADDR'])){
  echo('<HTML><HEAD><BODY>');
  echo('<H2 align="center">Przykro mi, ale Twój adres IP został zablokowany!</2>');
  echo('<center><h2>Twój dostęp do logowania został zablokowany na minutę za wpisanie trzykrotnie złego hasła</h2></center><p>');
  echo('</HEAD></BODY></HTML>');
}
       
       
       
    }
    else{
        
        formularz();
        
        $zostało = 3 - $proby;
        echo '<center> '.$login.' Zostały jeszcze <font color="red" size="5">'.$zostało.'</font> próba/y wpisania poprawnego hasła. 
                                                Jesli skończą ci sie próby twoje logowanie zostanie zawieszonena 1 minutę.</center>';
        $bladplus = $proby + 1;
        $ostatnio = 'UPDATE `users` SET `proba`= "'.$bladplus.'" WHERE `login`="'.$login.'"';
        $idostatnio = mysql_query($ostatnio) or die(mysql_error());
    }
    */
    
    
        
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Sprawdzanie poprawności hasła /////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function SprawdzCzyPoprawneHaslo($login,$haslo){

        $zapytanie = "SELECT * FROM `users` WHERE
                       `login`='$login' && `haslo`='".md5($haslo)."'";
     
        $wynik = mysql_query($zapytanie);
        if (!$wynik)
            return false;
        $liczba_wierszy = mysql_num_rows($wynik);
        if ($liczba_wierszy == 1)
            return true;
            return false;
    }


    if ( !mysql_close() ){
        echo 'Nie moge zakonczyc polaczenia z baza danych';
        exit (0);
     }
     

?>
</body>
</html>