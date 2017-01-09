<section class="container grid-6">
	
	<h1>Bienvenue chez GreenHand</h1>
	
	<?php
	if(!empty($errors)) {
		echo '<div><ul class="bad">';
		foreach($errors as $error)
			echo "<li>$error</li>";
		echo '</ul></div>';
	}
	?>
	
	<div class="col-3-m">
		<form method="post">
			<h2>Inscription</h2>
			<div>
				<?= $formRegister->text('name', [
					'label' => 'Pseudo',
					'required',
					'placeholder' => 'Votre pseudonyme'
				]) ?>
			</div>
			<div>
				<?= $formRegister->email('email', [
					'label' => 'E-mail', 
					'required',
					'placeholder' => 'Votre adresse e-mail (sert d\'identifiant)'
				]) ?>
			</div>
			<div>
				<?= $formRegister->password('password', [
					'label' => 'Mot de Passe', 
					'required',
					'placeholder' => 'Votre mot de passe'
				]) ?>
			</div>
			<div>
				<?= $formRegister->password('verifyPassword', [
					'label' => 'Vérification',
					'required',
					'placeholder' => 'Recopiez votre mot de passe'
				]) ?>
			</div>
			<?= $formRegister->sender('S\'inscrire') ?>
		</form>
	</div>
	
	<div class="col-3-m">
		<form method="post" class="col-3">
			<h2>Connexion</h2>
			<div>
				<?= $formSignIn->email('email', [
					'label' => 'E-mail', 
					'required',
					'placeholder' => 'Votre adresse e-mail'
				]) ?>
			</div>
			<div>
				<?= $formSignIn->password('password', [
					'label' => 'Mot de Passe', 
					'required',
					'placeholder' => 'Votre mot de passe'
				]) ?>
			</div>
			<?= $formSignIn->sender('Se connecter') ?>
		</form>
	</div>
	
</section>