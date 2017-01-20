<?php 
include('header.php');

?>


<div class="main_container" id="eco_service">
	<h2>Les ressources Eco-responsable</h2>
	<nav>
		<a href="#nourrir1" id="nourrir">Mieux se nourrir</a>
		<a href="#jardin1" id="jardin">   Jardinage écolo</a>
		<a href="#soigner1" id="soigner">    Se soigner naturellement</a>
		<a href="#others1" id="others">    Autres</a>
	</nav>

	<h3 id="nourrir1">Mieux se nourrir</h3><br><br><br><br><br><br><br><br><br>
	<h3 id="jardin1">Jardinage écolo</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<h3 id="soigner1">Se soigner naturellement</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<h3 id="others1">Autres</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<script>
	$(document).ready(function() {
		$('.js-scrollTo').on('click', function() { // Au clic sur un élément
			var page = $(this).attr('href'); // Page cible
			var speed = 750; // Durée de l'animation (en ms)
			$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
			return false;
		});
	});
</script>