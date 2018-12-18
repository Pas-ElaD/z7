<html lang="pl">
  <head>
    <meta charset="utf-8">
    <title>Duda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </link>
  </head>
  <body>
  <input style="margin-top: 20px; margin-left: 5px; width: 120px; height: 30px;" type="button" value="Strona Główna" onclick="window.location.href='http://pas-eduda.pl/' "    />
  <input style="margin-top: 20px; margin-left: 5px; width: 120px; height: 30px;" type="button" value="Wstecz" onclick="window.location.href='http://pas-eduda.pl/z7/logowanie.php' "    />
  <br><br/>

<center>
<b><h1>REJESTRACJA DO PORTALU</h1><b> <br>
<form method="POST" >
        <b>Login:</b> <input type="text" name="login"><br><br>
        <b>Hasło:</b> <input type="password" name="haslo1"><br></br>
        <b>Powtórz hasło:</b> <input type="password" name="haslo2"><br><br>
        <input type="submit" value="Utwórz konto" name="rejestruj"><br>
        Masz już konto? <a href="logowanie.php">Zaloguj</a>
</form>
</center>
 </body>
    <?php

    $dbhost="az-serwer1880693.online.pro"; $dbname="00167436_chmura"; $dbpassword="ElzDuda002"; $dbuser="00167436_chmura";

    if ( !mysql_connect($dbhost, $dbuser,$dbpassword) ) {
        echo 'Nie moge polaczyc sie z baza danych';
        exit (0);
    }
    if ( !mysql_select_db($dbname) ) {
        echo 'Blad otwarcia bazy danych';
        exit (0);
    }

$folder = "nowyfolder.php"; 

    if ( isset($_POST["login"]) ){
        SkorygujZmienneZFormularza($login,$haslo1,$haslo2);
        
        $czy_poprawne_dane = SprawdzPoprawnoscDanych ($login, $haslo1, $haslo2);
        if ($czy_poprawne_dane == "dane_ok") {
             // sprawdzenie czy login jest wolny
   if (mysql_num_rows(mysql_query("SELECT login FROM users WHERE login = '".$login."';")) == 0){
            // sprawdzenie czy hasla sa takie same 
        if ($_POST['haslo1'] == $_POST['haslo2']) {
            $zapytanie = "INSERT INTO `users` (`login`, `haslo`)";
            $zapytanie .= "VALUES ('$login', md5('$haslo2'))";
            }
            else { 
                echo"Podane hasła różnią się od siebie.";
            }
            
            if ($_POST['haslo1'] == $_POST['haslo2']) {
            $zapytanie2 = "INSERT INTO `logi` (`uzytkownik`)";
            $zapytanie2 .= "VALUES ('$login')";
            }
            else { 
                echo"Podane hasła różnią się od siebie.";
            }
   
            $wynik_zapytania = mysql_query($zapytanie);
            $wynik_zap = mysql_query($zapytanie2);
            
            if (!$wynik_zapytania) {

                echo("<br />Nie moge dodać rekordu do bazy!<br /><br />");
            } else {
                    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/logowanie.php\">";
                    include ($folder);
            }
            
            if (!$wynik_zap) {

                echo("<br />Nie moge dodać rekordu do bazy logowanie!<br /><br />");
            } else {
                
            }
            

            
   }
   else{ echo "Podany login jest już zajęty.";}
        } else {

            echo "Sprawdz dane, wszystkie pola muszą być uzupełnione, a hasło musi zawierać:";
            echo "<br />- od 8 do 30 znaków,";
            echo "<br />- jedną małą literę,";
            echo "<br />- jedną dużą literę,";
            echo "<br />- jedną cyfrę,";
            echo "<br />- jeden znak specjalny. ";
        }
    	
    }
    
   

    if ( !mysql_close() ) {
        echo 'Nie moge zakonczyc polaczenia z baza danych';
        exit (0);
    }

    function SkorygujZmienneZFormularza(&$login,&$haslo1,&$haslo2) {
        if ( isset($_POST["login"]) )
            $login = trim($_POST["login"]);
        else
            $login = "";
            
        if ( isset($_POST["haslo1"]) ){
            $haslo1 = trim($_POST["haslo1"]);}
           // $haslo1 = preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+|-]).{8,30}$/",$haslo);}
        else{
            $haslo1 = "";
    }
        if ( isset($_POST["haslo2"]) )
            $haslo2 = trim($_POST["haslo2"]);
        else
            $haslo2 = "";
            
    }

    function SprawdzPoprawnoscDanych ($login, $haslo1, $haslo2) {
        if ( ($login=="") || ($haslo1=="") || ($haslo2=="") )
            return "zle_dane";
        return "dane_ok";
    }

    ?>
</body>
</html>