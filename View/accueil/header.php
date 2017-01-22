<div class="topbar_index">
	<div class="main_container" id="top_bar">

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
			<div class="inscription"><a href="<?= BASE ?>inscription">Inscription</a></div>

			<h1><a href="<?= BASE ?>accueil"><img src="<?= IMAGE ;?>/accueil/logo_blanc.svg" alt="Logo GreenHand"></a></h1>

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

		<?php } else { ?>
			<h1 style="width:100%;"><a href="<?= BASE ?>accueil"><img src="<?= IMAGE ;?>/accueil/logo_blanc.svg" alt="Logo GreenHand"></a></h1>
		<?php } ?>

	</div>
</div>

<div class="main_container">
	<?php include('menu.php'); ?>
</div>