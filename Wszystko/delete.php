<?php
	session_start();

	require_once ('connect_db.php'); 
	$connection = connect_db();
	if(isset($_POST['id'])){
		foreach($_POST['id'] as $value){
			$result = $connection->query("DELETE FROM lista_zadan WHERE id = $value");
		}
		if($result) $_SESSION['info'] = 'Usunięto wybrane zadania.';
		else $_SESSION['info'] = 'Nie udało się usunąć wybranych zadań.';
	}
	header("location: index.php");
	$connection->close();
?>
