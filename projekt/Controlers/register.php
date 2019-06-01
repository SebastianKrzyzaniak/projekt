<?php
$username = $_POST['username'];
$password = $_POST['password'];
$town = $_POST['town'];
$usName;
$id;

$connection = new PDO('mysql:host=localhost;dbname=reustauracjaDB;charset=utf8', 'root', '');
$usName = $connection->query("SELECT `username` FROM `uzytkownicy` where `username` = '{$username}'")->fetchColumn();
$id = ($connection->query("SELECT max(`id`) FROM `uzytkownicy`")->fetchColumn())+1;

if($usName == null) //jezeli uzytkownika o takim username nie ma w bazie -> wykonuje zapis do bazy
{
$password = password_hash($password, PASSWORD_BCRYPT);
$sqlQuery="INSERT INTO `uzytkownicy` (`id`, `username`, `password`, `town`) VALUES({$id},'{$username}', '{$password}', '{$town}')";
 
$result=$connection->exec($sqlQuery);

    try
    {
        if($result>0) echo "kk";
        echo $id;
    }
    catch(Exception $ex)
    {
        echo ("error");
    }
}
else    
{
 header("Location: checkoption.php");
}
?>