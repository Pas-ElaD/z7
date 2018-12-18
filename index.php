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
    
    if ($_SESSION['zalogowany']) {


    
?>
<div id="pasek1">
       
       <?php 
            if ($_SESSION['zalogowany']==true){
             echo '<span style="color:white"><h1>Witaj: <b> '.$_SESSION['login'].' </h1></b><br /></span> ';
        }
        ?>
        
        <?php
            if (isset($_GET['wyloguj'])==1){
                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/logowanie.php\">";
                $_SESSION['zalogowany'] = false;
                session_destroy();
                }
        ?>

        <?php
            if ($_SESSION['zalogowany']==true){
            echo '<a href="?wyloguj=1"><h3><b>WYLOGUJ</b></h3></a><br>';
            }
        ?>
</div>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"> 
        <title>Duda Elżbieta</title>
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
         </link>
         <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    
     <body style="margin-left:2%;margin-right:2%;margin-top:2%;margin-bottom:2%;">
     
     <div id="pasek2">
        <?php
        
            $id = $_SESSION['login'];
            $id = addslashes($id);

        
        
        //    $logii = $polaczenie->query("SELECT * FROM logi WHERE 'uzytkownik'='$id' order by bledne desc limit 1");
         
      //           while ($log = $logii->fetch_assoc()) {
       
    //    echo '<span style="color:white"><h1>Witaj: <b> '.$_SESSION['login'].' </h1></b><br /></span> '; 
     // print "";  
      
      
            $lacze = mysqli_query($polaczenie, "SELECT * FROM logi WHERE uzytkownik = '$id' order by bledne desc limit 1");
            while($wybor=mysqli_fetch_array($lacze)){
                 // echo '<span style="color:white"><h1>Witaj: <b> '.$wybor['bledne'].' </h1></b><br /></span> '; 
                 echo '<span style="color:red"><h4>Ostatnie błędne logowanie: <b> '.$wybor['bledne'].' </b></h4><br /></span> ';
            }
        ?>
        
        </div>
        <div id="menu"></br></br>
        
        
        <h3>Dodaj nowy plik</h3>
        <label class="description" for=""><b>Wybierz plik</b> </label><br>
        <form action="" method="POST"  ENCTYPE="multipart/form-data">
        <input type="file" name="plik"/>
    	
		</br></br>
        <label class="description" for=""><b>Wybierz lokalizację</b></label>
        <div class="radio">
        <fieldset>
			<input type="radio" name="zapis" id="1" value="1" checked="checked" />Katalog macierzysty
            </br>
            <input type="radio" name="zapis" id="2" value="2"  />Podkatalog
        </fieldset>
		</div> 
          <select name="podk">
          
            <option value="<?php echo "$id"?> ">
                <?php 
                    echo "Wybierz podkatalog"
                ?>
            </option>
<?php
    chdir("./$id/");
    foreach (glob("*",GLOB_ONLYDIR) as $podf){
        if ($podf!="FILES"){
            echo "<option value ='".$podf."'>".$podf."</option>";
        }
    }
?>
</select>
          

             </br><br>
             <input id="saveForm" class="button_text" type="submit" name="submit" value="WYSLIJ" />
            
              </form>
		
        <br>
        <h3>Dodaj podkatalog</h3><br>
        
        <form method="post" action="utworz.php">
        <input type="text" name="nazwa_folderu" size="10" maxlength="10">
        <input type="submit" value="Utwórz">
       
        <br>
        <h3>Twoje pliki</h3>
        
<?php

    $katalog = '/z7/'.$_SESSION['login'].'/';

    function pokazzawartosc($katalog){

        $otwieranie = @opendir($katalog) or die("Unable to open $katalog");
        $nazwafolderu = end(explode("/", $katalog));
   
        //html wyswietlanie zawartosci
        echo ("<dt>$nazwafolderu</dt>\n");
        echo "<ul><ol>\n";

        while (false !== ($plik = readdir($otwieranie))){

            if($plik!="." && $plik!="..") {
            
                if (is_dir($katalog."/".$plik)){
                     pokazzawartosc($katalog."/".$plik);
                }
                else{
                    echo "<li><a href='$katalog/$plik' download>$plik</a></li>";   
                }
            }
        }
        echo "</ol></ul>\n";
    }
    pokazzawartosc($katalog);

?>
        
<?php
    $plik = "odbierz.php"; 
    $podf = $_POST['podk'];
    $podf = addslashes($podf);
        
    if ( isset($_POST["submit"]) ){
        if($_POST['zapis'] == "1"){
            include ($plik);
         // echo "Katalog Macierzysty";
        }
        if($_POST['zapis'] == "2"){    
            //  echo "$podf";
            $max_rozmiar = 1000000000;  
            if (is_uploaded_file($_FILES['plik']['tmp_name'])){
                if ($_FILES['plik']['size'] > $max_rozmiar){
                    echo "Przekroczenie rozmiaru $max_rozmiar"; 
                }
                 else{
                     echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=/z7/index.php\">";
                    move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']. "/z7/$id/$podf/" .$_FILES['plik']['name']);
                }     
            }     
            //    .'/'$podf .'/'
   
        } else {}        
    }
?>

        </div> 
        </form>
    </body>

</html>

<?php
    
}
else {
header('Location: logowanie.php');
}
?>