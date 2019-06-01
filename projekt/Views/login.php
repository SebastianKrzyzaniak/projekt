<?php
session_start();
	 $user=$_POST['username'];
    $password=$_POST['password']; //przepisanie nazwy użytkownikado i hasła do odpowiednich zmiennych
     //stworzenie połączenia do bazy danych używając biblioteki PDO 
    $polaczenie = new PDO('mysql:host=localhost;dbname=reustauracjaDB;charset=utf8', 'root', '');
     //$password= password_hash($password, PASSWORD_BCRYPT); // funkcja służąca do szyfrowania hasła
	 //echo $password;
	 
	 $sql="SELECT `password` FROM `uzytkownicy` WHERE `username`='{$user}'";
	 //echo '<br/>',$sql;
     //wykonanie zapytania na bazie danych - zapytanie zwraca zaszyfrowane hasło. 
    $wynik=$polaczenie->query($sql);
     //ściągnięcie wyniku zapytania do zmiennej $hash
     $hash=$wynik->fetchColumn();
	 
	 if(password_verify($password, $hash)) { //funkcja weryfikująca poprawność hasła - szyfruje hasło i porównuje z zaszyfrowanym hasłem
            $_SESSION['user']=$user;  //ustawienie zmiennej user w sesji serwera
            unset($_SESSION['badPass']);
            header("location: profile.php");  //przekierowanie do pliku profile.php
         } else {
            $_SESSION['badPass'] = "Bad username or password!";
            header('location: index.php');
         }
?>