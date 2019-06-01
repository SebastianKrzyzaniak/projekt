<?php
session_start();

echo '<pre>';
var_dump($_SESSION);
var_dump($_COOKIE);
echo '</pre>';

if(!isset($_SESSION['user'])){
    die("<h1>Musisz się <a href='index.php'>zalogować</a> by przejść do tej witryny</h1>");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Twój profil</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <div id="main">
        <h1>Witaj użytkowniku  
        <?php
            print($_SESSION['user']);
        ?>
        </h1>
        <div>
                Tutaj pojawią się szczegóły Twojego profilu.
        </div>
        <p>
            Aby się wylogować, zamknij przeglądarkę.
			<form action="index.php" method="post">
			<button type="submit" name="wyloguj" value="1">Wyloguj się</button>
			</form>
        </p>
</body>
</html>
