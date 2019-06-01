<?php
session_start();
if (@$_POST['wyloguj']==1)
{
    unset($_SESSION['user']);
	// session_destroy();
	header("Location: index.php");
}

if(isset($_SESSION['user'])){
    header("location: profile.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Zaloguj się</title>
        <link href="css/register.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <div id="panel">
    <form action="login.php" method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" required>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" pattern="[A-Za-z0-9]{1,20}" required>
    <div id="lower">
    <input type="checkbox"><label class="check" for="checkbox">Zapamiętaj mnie!</label>
    <input type="submit" value="Login">
    <h3 style="color: red;">
    <?php if(isset( $_SESSION['badPass']) && !isset($_SESSION['user']))
    {
        print($_SESSION['badPass']);
    } ?>
    </h3>
</form>
</div>
<!-- <?php
if(!empty($_GET['side']))
{
    if($_GET['side'] == 'register')
    {
        include("../Controlers/register.php");
        include("register.html");
    }
}
?> -->
</body>
</html>
