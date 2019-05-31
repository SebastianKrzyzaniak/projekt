<?php
	function connect_db()
	{
//		@$db = new mysqli ('localhost','stazysta_www3','l1MYRS#LOdqX?oB0','stazysta_www3');
		@$db = new mysqli ('localhost','super_user','a1p5tTr34g','projekt');
		if (mysqli_connect_errno()) return false;
		else
			{
				$db->query ("set names utf8");
				return $db;
			}
	}
?>
//a1p5tTr34g haslo do bazy
