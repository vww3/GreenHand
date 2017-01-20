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
		</div>
		<!-- POURCENTAGE -->
		<div class="defi_pourcentage">
			<h4 class="defi_st"><?= empty($_SESSION['user']) ? 'Nombre d\'objectifs' : 'Défi terminé à' ?></h4>
			<h4><?= $challenge->objectives ?></h4>
		</div>
		
		<?php if (!empty($badge)) { ?>
		<!-- BADGE -->
		<div class="defi_badge">
			<h4><?= $badge->isWon == 1 ? 'Vous avez gagné le badge' : 'Badge à obtenir' ?></h4>
			<div><img src="<?= IMAGE ?>/challenge/<?= $badge->badge ?>.svg" alt=""></div>
			<p><b><?= $badge->title ?></b></p>
			<p><?= $badge->description ?></p>
		</div>
		<?php } ?>
		
		<!-- DEFI REUSSI PAR -->
		<div class="defi_reussi">
			<!-- FAIRE L'AFFICHAGE EN FONCTION DE LA DATE -->
			<h4>Défi déjà réussi par : </h4>
			<?php if(empty($winners)) { ?>
				
				<span>Personne pour le moment</span>
				
			<?php } else { ?>
			
				<?php foreach($winners as $winner) { ?>
				<span><a href="<?= $winner->linkUserprofil ?>"><?= $winner->name ?></a>, le <?= $winner->dateSuccess ?></span>
				<?php } ?>
				
			<?php } ?>
		</div>
		<!-- DEFI EN COURS PAR -->
		<div class="defi_en_cours">
			<h4><?= $nbParticipation ?> participant<?= $nbParticipation > 1 ? 's ' : '' ?> sur ce défi !</h4>
			<?php foreach($participation as $participations) { ?>
				<div>
					<a href="<?= $participations->linkUserprofil ?>" title="Voir le profil de <?= $participations->name ?>"><?= $participations->name ?></a> 
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="content_defi">
		<div class="defi_info">
			<div class="defi_description">
				<p><?= $challenge->description ?></p>
				
				<form method="post" enctype="multipart/form-data">
					<?php foreach($objectives as $objective) { ?>
					
					<div>
						<?php if($challengeIsAvaiable) { ?>
						<?= $objectiveForm->sender(
							"J'ai réussi !", 
							$objective->id, 
							$objective->completed ? ['disabled' => 'disabled'] : []
						) ?>
						<?php } ?>
						 <span><?= $objective->instruction ?></span>
					</div>
					
					<?php } ?>
					
					<?php if($challengeIsAvaiable) { ?>
						<?= $objectiveForm->file('evidence', ['label' => 'Ma preuve de réussite de l\'objectif (facultatif) : ']); ?>
					<?php } ?>
				</form>
				
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
				
			<?php } elseif(empty($myParticipation)) { ?>
			
			<form method="post">
				<?= $participationForm->sender('participer', 'action') ?>
			</form>
			
			<?php } elseif(!empty($myParticipation->giveUp)) { ?>
			
			<div>
				<h2>Dommage <?= $_SESSION['user']->name ?></h2>
				<p>Vous avez abandonné ce défi...</p>
			</div>
			
			<?php } elseif(empty($myParticipation->dateSuccess)) { ?>
			
			<form method="post">
				<?= $participationForm->sender('abandonner', 'action') ?>
			</form>
			
			<?php } else { ?>
			
			<div>
				<h2>Bravo <?= $_SESSION['user']->name ?></h2>
				<p>Tu as terminé avec succès ce défi le <?= $myParticipation->dateSuccess ?></p>
			</div>
			
			<?php } ?>
			
		</div>

		<!-- MUR DEFI -->
		<div class="defi_mur">
			<h2>On en discute... ?</h2>
			
			<?php if(!empty($postForm)) { ?>
			<div class="poster_avis">
				<form method="post">
					<?= $postForm->textarea('content', ['placeholder' => 'Je m\'exprime...', 'class' => 'myMessage']) ?>
					<?= $postForm->sender('Poster') ?>
				</form>
			</div>
			<?php } ?>

			
			<?php foreach($posts as $post) { ?>

			<div class="post">
				<div class="content_post">
					<div class="stream-item-header">
						<a href="<?= $post->linkUserProfil ?>" title="Voir le profil de <?= $post->author ?>">
							<img src="<?= IMAGE ;?>accueil/img_defi.jpg" alt="">
							<span><?= $post->author ?></span>
							<span class="time"><?= $post->date ?></span>
						</a>
					</div>
					<p><?= $post->content ?></p>
					<p class="text_post"><small><a href="<?= $post->linkReportPost ?>" title="Signaler ce post de <?= $post->author ?>">Signaler le post</a></small></p>
					<div></div>
				</div>
			</div>
			<?php } ?>
			
		</div>
	</div>
</div>






<?php   System\Debug::show($this, CONTROLLER); System\Debug::session(); ?>