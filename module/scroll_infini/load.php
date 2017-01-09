<?php 

include("connect.php");

	if($_GET['lastid']){


		//on récupère l'id plus grand que celui qui est passé en url
		$result = $bdd->query('SELECT * FROM defi WHERE id < "'.$_GET['lastid'].'" ORDER BY id DESC LIMIT 0, 10');

		while ($data = $result->fetch()) {
			echo '<div class="item" id=" '.$data['id'].' "><h2>Le défi : '.$data['id'].'</h2><br>' .$data['text']. '"</div>';
		}
	}


	


 ?>