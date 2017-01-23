<div class="main_container" id="accueil_dashboard">
	
	<div class="sidebar_accueil">

	<h4>Bienvenue sur GreenHand !</h4>
		
		<?php if(!empty($_SESSION['user'])) { ?>
		<form method="post" enctype="multipart/form-data">
			<img src="<?= $profil->photo ?>" alt="Photo de profil de <?= $_SESSION['user']->name ?>">
			<h2>Profil : <?= $_SESSION['user']->name ?> <small><a href="<?= BASE ?>byebye" title="Me deconnecter de mon compte">me deconnecter</a></small></h2>
			<hr>
			<div>
				<?= $profilForm->text('firstName', [
					'label' => 'Prénom',
					'placeholder' => 'Votre prénom'
				]) ?>
			</div>
			<div>
				<?= $profilForm->text('lastName', [
					'label' => 'Nom',
					'placeholder' => 'Votre nom'
				]) ?>
			</div>
			<div>
				<?= $profilForm->textarea('description', [
					'label' => 'Description',
					'placeholder' => 'Votre description'
				]) ?>
			</div>
			<div>
				<?= $profilForm->time('birth', [
					'label' => 'Date de Naissance',
					'placeholder' => 'Votre date de naissance'
				]) ?>
			</div>
			<div>
				<?= $profilForm->selection('gender', [0 => 'Femme', 1 => 'Homme'], [
					'label' => 'Sexe',
					'placeholder' => 'Votre date de naissance'
				]) ?>
			</div>
			<hr>
			<div>
				<?= $profilForm->text('facebook', [
					'label' => 'Facebook',
					'placeholder' => 'https://www.facebook.com/_________'
				]) ?>
			</div>
			<div>
				<?= $profilForm->text('twitter', [
					'label' => 'Twitter',
					'placeholder' => 'https://www.twitter.com/_________'
				]) ?>
			</div>
			<div>
				<?= $profilForm->text('URL', [
					'label' => 'URL',
					'placeholder' => 'http://__________________________'
				]) ?>
			</div>
			<hr>
			<div>
				<?= $profilForm->file('photo', [
					'label' => 'Nouvelle Photo'
				]) ?>
			</div>
			<hr>
			<?= $profilForm->sender('Mettre à jour') ?>
			
			<h2>Mes participations</h2>
			<?php if(!empty($myChallengeParticipations)) { ?>
				<?php foreach($myChallengeParticipations as $challenge) { ?>
				<div><a href="<?= BASE ?>challenge/<?= $challenge->id ?>/<?= $challenge->slug ?>" title='Je participe au défi "<?= $challenge->title ?>"'><?= $challenge->title ?></a></div>
				<?php } ?>
			<?php } else { ?>
			<div>Je ne participe à aucun défi pour le moment.</div>
			<?php } ?>
		<?php } else { ?>
			<p>Pour pouvoir accéder au profil et participer aux défis, il faut que tu te connectes à ton compte. Si tu n'en n'as pas tu peux gratuitement <a href="<?= BASE ?>inscription">t'inscrire</a> dès maintenant.</p>
			<p>Sinon, <a href="<?= BASE ?>connexion" title="Aller sur la page de connexion et d'inscription">connecte</a> toi en haut à droite de cette page !</p>
		<?php } ?>
		</form>
	</div>

	<div class="dashboard">
		<!-- <h2>Tableau de bord</h2>
		<hr> -->
		
		<div class="content_dashboard">
			
			<?php foreach($challenges as $challenge) { ?>
			
			<div class="single_defi">
				<div class="single_defi__img">
					<img src="<?= IMAGE ;?>/accueil/img_defi.jpg" alt="">
				</div>

				<div class="single_defi_text">
					<h3><a href="<?= BASE ?>challenge/<?= $challenge->id ?>/<?= $challenge->slug ?>" title='Le défi "<?= $challenge->title ?>"'><?= $challenge->title ?></a></h3>
					<p><?= substr($challenge->description, 0, 150) ?>...</p>

					<div class="single_defi_bottom">
						<div class="icon_partage">

							<!-- défi un ami -->
							<div class="defi_ami">
								<a href="">
								<img src="<?= IMAGE ;?>/accueil/defi_un_ami.svg" alt="Défi un ami">
								<span>Défie un ami !</span>
								</a>
							</div>

							<!-- partage -->
							<div class="defi_ami">
								<a href="">
								<img src="<?= IMAGE ;?>/accueil/partage.svg" alt="Partage">
								<span>Partage</span>
								</a>
							</div>
							
						</div>

						<div class="icon_info_defi">
					
								<!-- badge -->
								<div class="info_defi">
									<a href="">
									<img src="<?= IMAGE ;?>/accueil/badge.svg" alt="badge">
									<span><?= $challenge->objectives ?></span>
									</a>
								</div>
								
								<!-- nb like -->
								<div class="info_defi">
									<a href="">
									<img src="<?= IMAGE ;?>/accueil/like.svg" alt="like">
									<span><?= $challenge->numLikes ?></span>
									</a>
								</div>
								
								<!-- participants -->
								<div class="info_defi">
									<a href="">
									<img src="<?= IMAGE ;?>/accueil/participant.svg" alt="participant">
									<span><?= $challenge->numParticipant ?> participant<?= $challenge->numParticipant > 1 ? 's' : '' ?></span>
									</a>
								</div>
						
						</div>

					</div>
				</div>				
			</div>
			
			<?php } ?>

		</div>
	</div>

</div>

