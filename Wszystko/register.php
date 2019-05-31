<?php
	session_start();

	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['vpassword'])){
		$check = true;
		if((strlen($_POST['login']) < 3) || (strlen($_POST['login']) > 20)){
			$check = false;
			$_SESSION['err_login'] = "Login musi posiadać od 3 do 20 znaków.";
		}
		if(ctype_alnum($_POST['login']) == false){
			$check = false;
			$_SESSION['err_login'] = "Login może się składać tylko z liter i cyfr (bez polskich znaków).";
		}
		if(strlen($_POST['password']) < 8){
			$check = false;
			$_SESSION['err_password'] = "Hasło musi mieć co najmniej 8 znaków.";
		}
		if(strlen($_POST['vpassword']) < 8){
			$check = false;
			$_SESSION['err_password'] = "Hasło musi mieć co najmniej 8 znaków.";
		}
		if($check = false){
			$_SESSION['info'] = 'Nie udało się zarejestrować.';
			header("location: index.php");	
			exit();
		}
		else{
			require_once ('connect_db.php');
			$connection = connect_db();	
			$login = $connection->real_escape_string($_POST['login']);
			$password = $connection->real_escape_string($_POST['password']);
			$vpassword = $connection->real_escape_string($_POST['vpassword']);
			if($password == $vpassword){
				$password = sha1($password);
				$selectquery = "SELECT id FROM uzytkownicy WHERE login='$login'";
				$result = $connection->query($selectquery);
				$user_check = $result->num_rows;
				$result->free_result();
				if($user_check>0) $_SESSION_INFO = "Ten login jest juz zajety.";
				else{
					$insertquery = "INSERT INTO uzytkownicy(login, password) VALUES ('$login','$password')";
					$result2 = $connection->query($insertquery);	
					if($result2) $_SESSION['info'] = 'Rejestracja pomyślna.';
					else $_SESSION['info'] = 'Nie udało się zarejestrować.';
				}
			}
			else $_SESSION['info'] = 'Podane hasła różnią się od siebie.';
		}
	}
	header("location: index.php");
	$connection->close();
?>
