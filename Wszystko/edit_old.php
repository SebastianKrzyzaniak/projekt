<?php
	session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="shortcut icon" type="image/x-icon" href="img/notebook.png">
	<title>Edycja zadania</title>
</head>
<body>
	<?php
		require_once ('connect_db.php');
		$connection = connect_db();
		if (isset ($_SESSION['login']) && isset($_GET['id'])){
			$id_z = $connection->real_escape_string($_GET['id']);
			$result = $connection->query("SELECT id_u FROM lista_zadan WHERE id='$id_z'");
			$check = 0;
			while ($data = $result->fetch_object()){
				$id_u = $data->id_u;
				$check++;
			}
			$result->free_result();
			if ($check > 0){
				$login = $_SESSION['login'];
				$result2 = $connection->query("SELECT id FROM uzytkownicy WHERE login='$login'");
				$data2 = $result2->fetch_object();
				$id = $data2->id;
				$result2->free_result();
				if ($id_u == $id){
					$result3 = $connection->query("SELECT zadanie FROM lista_zadan WHERE id='$id_z'");
					$data3 = $result3->fetch_object();
					$zadanie = $data3->zadanie;
					echo "<div id='info'>";
					echo "Strona edycji wybranego zadania.</br></br>";
					echo "</div>";
					echo "<div id='cont1'>";
					echo "<div id='cont11'>";
					echo "<div id='cont121'>";
					echo "Edytuj swoje zadanie:</br>";
					echo "<form action='edit2.php' method='post'>";
					echo "<textarea name='zadanie' style='height:121px;width:320px' required>$zadanie</textarea></br>";
					echo "<input type='hidden' name = 'id' value='$id_z'>";
					echo "<input type='submit' value='zapisz zmiany'>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<div id='cont12'>";
					echo "<div id='cont121'>";
					echo 'Jesteś zalogowany jako <b>'.$_SESSION['login'].'.</b><br></br>';
					echo "<a href='index.php'><input type='button' value='Wróć do strony głównej'></a></br></br>";
					echo '<form action="logout.php">';
					echo '<input type="submit" value="Wyloguj">';
					echo '</form>';
					echo "</div>";
					echo "</div>";
				}
				else header("location: index.php");
			}
			else header("location: index.php");
		}
		else header("location: index.php");
		$connection->close();
	?>
</body>
</html>
