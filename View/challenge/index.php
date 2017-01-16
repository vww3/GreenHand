<?php include('header.php'); ?>

<div class="img_defi">
	<h2>Défi :</h2>
	<h2><?= $challenge->title ?></h2>
</div>

<div class="main_container" id="single_defi">
	<div class="sidebar_defi">
		<!-- TITRE DU DEFI -->
		<div class="defi_title">
			<h3><?= $challenge->title ?></h3>
			<p><small><?= $nbParticipation ?> participant<?= $nbParticipation > 1 ? 's' : '' ?></small></p>
		</div>
		<!-- POURCENTAGE -->
		<div class="defi_pourcentage">
			<h4 class="defi_st">Défi terminé à : </h4>
			<h4><?= $challenge->achievement ?> %</h4>
		</div>
		<!-- BADGE -->
		<div class="defi_badge">
			<h4>Badge à gagner :</h4>
			<div><img src="<?= IMAGE ;?>/challenge/badge.svg" alt=""></div>
			<p>Badge de la patate</p>
		</div>
		<!-- DEFI REUSSI PAR -->
		<div class="defi_reussi">
			<!-- FAIRE L'AFFICHAGE EN FONCTION DE LA DATE -->
			<h4>Défi déjà réussi par : </h4>
			<?php foreach($participation as $participations) { ?>
			<span><a href=""><?= $participations->name ?></a></span>
			<?php } ?>
		</div>
		<!-- DEFI EN COURS PAR -->
		<div class="defi_en_cours">
			<?php foreach($participation as $participations) { ?>
			<span><a href=""><?= $participations->name ?></a></span>
			<?php } ?>
			<h4> participent actuellement au défi.</h4>
		</div>
	</div>

	<div class="content_defi">
		<div class="defi_info">
			<div class="defi_description">
				<p><?= $challenge->description ?></p>
			</div>
			<div class="defi_sous_info">
				<p>
					<span>Proposé par :</span>
					<span><a href=""><?= $challenge->author ?></a></span>
				</p>
				<p>
					<span>Catégorie :</span>
					<span><?= $challenge->category ?></span>
				</p>
				<p>
					<span>Créé le : </span>
					<span><?= $challenge->dateCreation ?></span>
				</p>
				<p>
					<span>Termine le :</span>
					<span><?= $challenge->dateEnd ?></span>
				</p>
			</div>
		</div>



		<!-- BOUTON PARTICIPATION/ABANDON -->
		<div class="defi_btn">
		<!-- 	<p><a href="<?= BASE ?>accueil" title="Revenir au tableau de bord">tableau de bord</a></p> -->

			<?php if(empty($_SESSION['user'])) { ?>
			<p>Pour participer à ce défi tu dois <a href="<?= BASE ?>connexion/challenge/<?= $challenge->id ?>/<?= $challenge->slug ?>" title='Se connecter pour participer au défi'>te connecter</a>.</p>
			<?php } else { ?>

				<?php if(empty($myParticipation->dateSuccess)) { ?>
				<a href="<?= $linkParticipation['href'] ?>"><?= $linkParticipation['title'] ?></a>
				<?php } else { ?>
				<div>
					<h2>Bravo <?= $_SESSION['user']->name ?></h2>
					<p>Tu as terminé avec succès ce défi le <?= $myParticipation->dateSuccess ?></p>
				</div>
				<?php } ?>

			<?php } ?>
		</div>

		<!-- MUR DEFI -->
		<div class="defi_mur">
			<h2>On en discute... ?</h2>
			<div class="poster_avis">
				<form action="POST">
					<input type="textarea" placeholder="Je m'exprime..." class="myMessage">
					<input type="submit" value="Poster">
				</form>
			</div>

			<div class="post">
				<div class="content_post">
					<div class="stream-item-header">
						<a href="#">
							<img src="<?= IMAGE ;?>/accueil/img_defi.jpg" alt="">
							<span>Mika LeBG</span>
							<span class="time"> - 2 h</span>
						</a>
					</div>
					<p class="text_post">Je trouve que ce défi est vraiment super cool. J'aimerais bien le refaire tellement c'est simple !!!</p>
				</div>
			</div>
			
		</div>
	</div>
</div>






<?php   System\Debug::show($this, CONTROLLER); System\Debug::session(); ?>