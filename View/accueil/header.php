<div class="main_container">
	<header>
		<h1><a href="<?= BASE ?>accueil"><img src="<?= IMAGE ;?>/accueil/logo.svg" alt="Logo GreenHand"></a></h1>
		
		<?php if(empty($_SESSION['user'])) { ?>
		
			<?php if(!empty($formErrors)) { ?>
			<div>
				<ul class="bad">
				
				<?php foreach($formErrors as $error) { ?>
					<li><?= $error ?></li>
				<?php } ?>
			
				</ul>
			</div>
			<?php } ?>
		
		<div class="baseline">
			<h2>Bienvenue ! </h2>
		</div>

		<div class="header_co">
			<div class="inscription"><a href="<?= BASE ?>inscription">Inscription</a></div>
			<div class="connexion">
				<h2>Connexion</h2>
				<form method="post" class="col-3">
					<?= $formSignIn->email('email', [
						'required',
						'placeholder' => 'Votre adresse e-mail'
					]) ?>
					<?= $formSignIn->password('password', [
						'required',
						'placeholder' => 'Votre mot de passe'
					]) ?>
					<?= $formSignIn->sender('Se connecter') ?>
				</form>
			</div>
		</div>
		
		<?php } else { ?>
		
		<div class="baseline">
			<h2>Défiez vos amis !</h2>
		</div>

		<div class="header_notif">
			<div class="header_notif_top">
				<div class="notif_top" id="notif_alert"></div>
				<div class="notif_top" id="notif_msg"></div>
				<div class="notif_top" id="notif_profil"></div>
			</div>

			<input type="search" name="main_search" class="header_notif_search" placeholder="rechercher du vert...">
		</div>
		
		<?php } ?>
		
	</header>



	<?php include('menu.php'); ?>

</div>


<div class="img_accueil">
	<h2>Il n'y a pas de petits gestes <br>quand on est 60 millions à le faire</h2>
</div>


