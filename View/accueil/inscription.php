<div class="topbar">
	<img src="<?= IMAGE ;?>/accueil/logo_blanc.svg" alt="Logo GreenHand">
</div>

<section class="container">
	
	<h1 id="joinus">Rejoins GreenHand aujourd'hui</h1>
	
	<!-- <p>Tu peux <a href="<?= BASE ?>accueil" title="Visiter GreenHand sans se connecter">visiter le site</a> si tu le désires</p> -->
	
	<?php if(!empty($formErrors)) { ?>
		<div>
			<ul class="bad">
			
			<?php foreach($formErrors as $error) { ?>
				<li><?= $error ?></li>
			<?php } ?>
		
			</ul>
		</div>
	<?php } ?>
	
	<?php if(!empty($confirmation)) { ?>
		<div class="good">			
			<?= $confirmation ?>
		</div>
	<?php } ?>
	
	<div class="col-3-m">
		<form method="post">
			<div>
				<?= $formRegister->text('name', [
					'required',
					'placeholder' => 'Votre pseudonyme'
				]) ?>
			</div>
			<div>
				<?= $formRegister->email('email', [
					'required',
					'placeholder' => 'Votre adresse e-mail (sert d\'identifiant)'
				]) ?>
			</div>
			<div>
				<?= $formRegister->password('password', [
					'required',
					'placeholder' => 'Votre mot de passe'
				]) ?>
			</div>
			<div>
				<?= $formRegister->password('verifyPassword', [
					'required',
					'placeholder' => 'Recopiez votre mot de passe'
				]) ?>
			</div>
			<?= $formRegister->sender('Rejoindre la communauté') ?>
		</form>
		<p>En vous inscrivant, vous acceptez les Conditions d'utilisation et la Politique de confidentialité, notamment l'utilisation de cookies. D'autres utilisateurs pourront vous trouver grâce à votre email ou votre numéro de téléphone s'ils sont renseignés.</p>

		<p><a href="#">Vous avez déjà un compte ? Connectez vous !</a> </p>
	</div>
		
</section>