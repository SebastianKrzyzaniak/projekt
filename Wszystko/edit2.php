<?php
	session_start();

	require_once ('connect_db.php');
	$connection = connect_db();
	if (isset($_POST['id']) && (isset($_POST['zadanie']) && isset ($_SESSION['login']))){
		$zadanie = $connection->real_escape_string($_POST['zadanie']);
		$id = $connection->real_escape_string($_POST['id']);
		$result = $connection->query("UPDATE lista_zadan SET zadanie='$zadanie' WHERE id=$id");
		if($result) $_SESSION['info'] = "Edycja zakończona sukcesem.";
		else $_SESSION['info'] = "Edycja zakończona niepowodzeniem.";
	}
	header("location: index.php");
	$connection->close();
?>
