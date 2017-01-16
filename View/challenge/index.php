<p><a href="<?= BASE ?>accueil" title="Revenir au tableau de bord">tableau de bord</a></p>

<?php if(empty($_SESSION['user'])) { ?>
<p>Pour participer à ce défi tu dois <a href="<?= BASE ?>connexion/challenge/<?= $challenge->id ?>/<?= $challenge->slug ?>" title='Se connecter pour participer au défi'>te connecter</a>.</p>
<?php } else { ?>

	<?php if(empty($myParticipation->dateSuccess)) { ?>
	<form method="post">
		
		<?= $participationForm->sender($action, 'action') ?>
		
	</form>
	<?php } else { ?>
	<div>
		<h2>Bravo <?= $_SESSION['user']->name ?></h2>
		<p>Tu as terminé avec succès ce défi le <?= $myParticipation->dateSuccess ?></p>
	</div>
	<?php } ?>

<?php } ?>