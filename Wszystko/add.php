<?php
	session_start();

	require_once ('connect_db.php');
	$connection = connect_db();
	if(isset($_POST['zadanie']) && isset ($_SESSION['login'])){
		$zadanie = $connection->real_escape_string($_POST['zadanie']);
		$login = $_SESSION['login'];
		$result = $connection->query("SELECT id FROM uzytkownicy WHERE login='$login'");
		$data = $result->fetch_object();
		$id=$data->id;
		$result->free_result();
		$result2 = $connection->query("INSERT INTO lista_zadan (id_u, zadanie) VALUES ('$id','$zadanie')");
		if($result2) $_SESSION['info'] = "Dodawanie zakończone sukcesem.";
		else $_SESSION['info'] = "Dodawanie zakończone niepowodzeniem.";
	}
	header("location: index.php");
	$connection->close();
?>
