<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Infinite Scroll</title>
</head>

<style>
	#loader{
		display: none;
	}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script>
	$(window).scroll(function(){


		//si la position du scroll est égale à la fin du document (fin des derniers articles chargés, on va charger les autres)
		if($(window).scrollTop() == $(document).height() - $(window).height()){
			
			$('#loader').show("slow");
			$.ajax({
				url: "load.php?lastid=" + $(".item:last").attr("id"),
				success : function(html){
					if(html){
						$(".post").append(html);
						$('#loader').hide();
					}else{
						alert('ya plus de post');
					}
				}
			});

			
		}

	});


</script>
<body>

<div class="wrap">
	<h1 class="alert-message">Infinite DEFiii</h1>

	<div class="post">


		<?php 
			include("connect.php");

			$result = $bdd->query('SELECT * FROM defi ORDER BY id DESC LIMIT 0,10');

			$data = $result->fetch();

			while ($data = $result->fetch()){
				echo '<div class="item" id=" '.$data['id']. '"><h2>Le défi : '.$data['id'].'</h2><br>' .$data['text']. '</div>';
			}
				

		 ?>
		
	</div>

	<div id="loader"><img src="balls.gif" alt="loader"></div>
</div>




	
</body>




</html>