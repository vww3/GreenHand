<div class="main_container" id="intro_accueil">
	<h2>Qu'est-ce que GreenHand ?</h2>
	<div class="presentation">
		<div class="col6">
			<p>Un site communautaire, un réseau social basé autour de l'environnement et de l'écologie. Des défis amusants et faciles vous sont proposés pour que chacun puisse réduire son impact environnemental sur notre planete.</p>
			<p>Le but de ce projet est de rassembler un maximum de personnes, pour que chacun et ensemble, nous puissions avancer vers un monde meilleur.</p>
			<p>Espace d'échange mis à disposition sur chaque défi pour que les membres puissent s'encourager, s'entraider et se conseiller.</p>
		</div>
		<div class="col6">
			<p>A chaque défi gagné, un badge reçu !</p>
			<p>Vous pourrez trouver et proposer des astuces, des informations et tout un tas de news sur l'écologie et l'environnement.</p>
			<p>Plus qu'un simple site, GreenHand se veut être une bibliothèque communautaire géante. Créons ensemble le Wikipédia de l'écologie.</p>
		</div>
	</div>
	<h2>Les créateurs</h2>
	<img src="<?= IMAGE ;?>/accueil/mik_em.jpg" alt="">
	<p>Dans le cadre du Projet de Fin d'Etude du master Produits et Services Multimédia, Mickaël et Emma ont voulu s'investir dans une cause qui leur tenait à coeur : l'écologie. Nous faisions chacun des efforts pour changer notre mode de vie. Malgré tout, nous nous sommes dit qu'il était plus judicieux de tous s'assembler et se soutenir pour faire avancer les choses plus efficacement. "Une bonne action, c'est peu. Mais multipliée par des milliers de personnes chaque jour, c'est énorme !". Ainsi, plutôt que de créé un nième service, nous avons voulu tout centraliser autour d'une base amusante : relever des défis et défier ses amis.</p>
</div>

<div class="main_container" id="accueil_dashboard">
	
	<div class="sidebar_accueil">

	Bonjour
		
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
			<h2>Connecte-toi</h2>
			<p>Pour pouvoir accéder au profil et participer aux défis, il faut que tu te connectes à ton compte. Si tu n'en n'as pas tu peux gratuitement <a href="<?= BASE ?>inscription">t'inscrire</a> dès maintenant.</p>
			<p><a href="<?= BASE ?>connexion" title="Aller sur la page de connexion et d'inscription">Connexion / Inscription</a></p>
		<?php } ?>
		</form>
	</div>

	<div class="dashboard">
		<h2>Tableau de bord</h2>
		<hr>
		
		<div class="content_dashboard">
			
			<?php foreach($challenges as $challenge) { ?>
			
			<div class="single_defi">
				<div class="single_defi__img">
					<img src="<?= IMAGE ;?>/accueil/img_defi.jpg" alt="">
				</div>

				<div class="single_defi_text">
					<h3><a href="<?= BASE ?>challenge/<?= $challenge->id ?>/<?= $challenge->slug ?>" title='Le défi "<?= $challenge->title ?>"'><?= $challenge->title ?></a></h3>
					<p><?= $challenge->description ?></p>

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

