<div class="main_container">
	<header>
		<h1><a href="<?= BASE ?>accueil"><img src="<?= IMAGE ;?>/accueil/logo.svg" alt="Logo GreenHand"></a></h1>

		<div class="baseline">
			<h2>Bienvenue ! </h2>
		</div>

		<div class="header_co">
			<div class="inscription"><a href="#">Inscription</a></div>
			<div class="connexion">
				<h2>Connexion</h2>
				<form method="post" class="col-3">
					<input type='email' required="required" placeholder="Votre adresse e-mail" id="signIn-email" name="signIn[email]">
					<input type='password' required="required" placeholder="Votre mot de passe" id="signIn-password" name="signIn[password]">			
					<input type='submit' value="Se connecter">
				</form>
			</div>
		</div>
	</header>



	<?php include('menu.php'); ?>

</div>


<div class="img_accueil">
	<h2>Il n'y a pas de petits gestes <br>quand on est 60 millions à le faire</h2>
</div>


