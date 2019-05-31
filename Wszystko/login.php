<?php
	session_start();

	require_once ('connect_db.php');
	$connection = connect_db();
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login = $connection->real_escape_string($_POST['login']);
		$password = $connection->real_escape_string($_POST['password']);
		$password = sha1($password);
		$query = "SELECT login FROM uzytkownicy WHERE login='$login' AND password='$password'";
		$result = $connection->query($query);
		if($result){
			$user_amount = $result->num_rows;
			if($user_amount>0){
				$row=$result->fetch_object();
				$_SESSION['login'] = $row->login;
				$_SESSION['auth'] = true;
				$_SESSION['info'] = "Logowanie przebiegło pomyślnie.";
				$result->free_result();
			}
			else $_SESSION['info'] = "Niepoprawne dane logowania.";
		}	
		$result->free_result();
	}
	header("location: index.php");
	$connection->close();
?>
