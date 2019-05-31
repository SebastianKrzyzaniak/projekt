<?php
	session_start();
?>
<!doctype html>
<html>test
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="shortcut icon" type="image/x-icon" href="img/notebook.png">
	<title>Lista zadań</title>
	<script type="text/javascript">
		function Unlock(){
			var checked=false;
			var elements = document.getElementsByName("id[]");
      console.log(elements);
			for(var i=0; i < elements.length; i++){
				if(elements[i].checked) {
					checked = true;
				}
			}
			if (!checked)
				document.getElementById("del").disabled = true;
			else
				document.getElementById("del").disabled = false;
			return checked;
		}
	</script>
</head>
<body>
	<?php
		require_once ('connect_db.php');
		$connection = connect_db();
		if(isset($_SESSION['login'])){
			echo '<div id="info">';
  			if(isset($_SESSION['info'])){
    				echo $_SESSION['info'];
    				unset($_SESSION['info']);
    				echo '</br></br>';
  			}
	       echo 'Jesteś zalogowany jako <b>'.$_SESSION['login'].'.</b><br></br>';
         echo '<form action="logout.php">';
  			   echo '<input type="submit" value="Wyloguj">';
          echo '</form>';
			echo '</div>';
			echo '<div id="cont1">';
    			echo '<div id="cont11">';
    			$login = $_SESSION['login'];
    			$result = $connection->query("SELECT id FROM uzytkownicy WHERE login='$login'");
    			$data = $result->fetch_object();
    			$id = $data->id;
    			$result->free_result();
    			$result2 = $connection->query("SELECT COUNT(id) AS amount FROM lista_zadan WHERE id_u='$id'");
    			$data2 = $result2->fetch_object();
    			$amount = $data2->amount;
    			$result2->free_result();
    			if($amount>0){
  				echo '<form action="delete.php" method="post"></br>';
    				echo '<table id="zadania">';
      				echo '<tr>';
      			    echo '<th id="wide">Lista zadań</th>';
        				echo '<th>Usuwanie</th>';
        				echo '<th>Edycja</th>';
      				echo '</tr>';
      				$result3 = $connection->query("SELECT id, zadanie FROM lista_zadan WHERE id_u='$id'");
      				while ($data3 = $result3->fetch_object()){
      					echo '<tr>';
        					echo "<td id='wide'>$data3->zadanie</td>";
        					echo "<td><input type='checkbox' name='id[]' value='$data3->id' onclick='Unlock()'</td>";
        					echo "<td><a href='edit.php?id=$data3->id'><img src='img/edit.png'></a></td>";
      					echo '</tr>';
      				}
      				$result3->free_result();
    				echo '</table></br>';
    				echo "<input type=\"submit\" id=\"del\" value=\"Usuń zaznaczone zadania\"  onclick=\"return confirm('Na pewno?')\" disabled>";
  				echo '</form>';
  			}
  			else echo"Nie masz żadnych zadań na liście.<br>";
		echo '</div>';
			echo '<div id="cont12">';
  			echo '<div id="cont121">';
    			echo '<form action="add.php" method="post">';
    			   echo '<textarea name="zadanie" style="height:121px;width:320px" placeholder="Tu możesz dodać nowe zadanie" required></textarea></br></br>';
    			   echo '<input type="submit" value="Dodaj zadanie">';
    			echo '</form>';
	       echo '</div>';
			echo '</div>';
		}

    // nie zalogowany typ
		else{
			echo '<div style="width: 700px;position: relative;"><iframe width="700" height="440" src = "https://maps.google.com/maps?q=10.305385,77.923029&hl=es;z=14&amp;output=embed"></iframe></div>';
			echo '<div style="width: 700px;position: relative;"><iframe width="700" height="440" src="https://maps.google.com/maps?width=700&amp;height=440&amp;hl=en&amp;q=poznan(Tytu%C5%82)&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div style="position: absolute;width: 80%;bottom: 10px;left: 0;right: 0;margin-left: auto;margin-right: auto;color: #000;text-align: center;"><small style="line-height: 1.8;font-size: 2px;background: #fff;">Powered by <a href="http://www.googlemapsgenerator.com/da/">googlemapsgenerator.com/da/</a> & <a href="https://vaticaanstadtickets.nl/alles-wat-jij-moet-weten-over-de-sint-pieterbasiliek/">www.vaticaanstadtickets.nl/alles-wat-jij-moet-weten-over-de-sint-pieterbasiliek/</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><br />';
			echo '<div style="width: 700px;position: relative;"><iframe width="700" height="440" src="https://maps.google.com/maps?width=700&amp;height=440&amp;hl=en&amp;q=Warsaw%2C%20Poland+(Tytu%C5%82)&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div style="position: absolute;width: 80%;bottom: 10px;left: 0;right: 0;margin-left: auto;margin-right: auto;color: #000;text-align: center;"><small style="line-height: 1.8;font-size: 2px;background: #fff;">Powered by <a href="http://www.googlemapsgenerator.com/pl/">googlemapsgenerator.com/pl/</a> & <a href="https://vaticaanstadtickets.nl/alles-wat-jij-moet-weten-over-de-sint-pieterbasiliek/">www.vaticaanstadtickets.nl/alles-wat-jij-moet-weten-over-de-sint-pieterbasiliek/</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><br />';
			echo '<div id="info">';
			   echo '<b>Witaj w menu logowania do listy zadań!</b></br></br></br>';
			echo '</div>';
		//	echo '<div id="cont1">';
			echo '<div id="cont11">';
  			echo 'Zaloguj się:</br></br>';
  			echo '<form action="login.php" method="post">';
    			echo '<input type="text" name="login" placeholder="Podaj login" required></br>';
    			if(isset($_SESSION['err_login'])){
    				echo $_SESSION['err_login'];
    				unset($_SESSION['err_login']);
    				echo '</br>';
    			}
    			echo '<input type="password" name="password" placeholder="Podaj hasło" required></br>';
    			if(isset($_SESSION['err_password'])){
      				  echo $_SESSION['err_password'];
      				unset($_SESSION['err_password']);
      				echo '</br>';
    			}
  			   echo '<input type="submit" value="Login">';
  			echo '</form>';
			echo '</div>';
			echo '<div id="cont12">';
        echo 'Zarejestruj się:</br></br>';
		    echo '<form action="register.php" method="post">';
    			echo '<input type="text" name="login" placeholder="Podaj login" pattern="[A-Za-z0-9]{3,20}" title="Dozwolone wielkie i małe litery alfabetu łacińskiego oraz cyfry. Login musi mieć od 3 do 20 znaków."  required></br>';
    			echo '<input type="password" name="password" placeholder="Podaj hasło" pattern=".{8,}" title="Hasło musi mieć co najmniej 8 znaków."  required></br>';
    			echo '<input type="password" name="vpassword" placeholder="Potwierdź hasło" pattern=".{8,}" title="Hasło musi mieć co najmniej 8 znaków." required></br></br>';
    			echo '<input type="submit" value="Rejestracja">';
        echo '</form>';
			echo '</div>';
		}
		//echo '</div>';
		if(isset($_SESSION['info'])){
			echo $_SESSION['info'];
			unset($_SESSION['info']);
		}
			$connection->close();
	?>

</body>
</html>
