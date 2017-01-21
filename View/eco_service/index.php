<?php 
include('header.php');

?>

<div class="main_container" id="eco_service">
	<h2>Les ressources Eco-responsable</h2>
	<nav>
	<?php foreach($categories as $category) { ?>
		<a href="#<?= $category->idAttr ?><?= $category->id ?>" id="<?= $category->idAttr ?>"><?= $category->title ?></a>
	<?php } ?>
	</nav>

	<p id="new_service">Proposez un nouveau service ? Pas de problème</p>

	<form method="post" id="form_service" enctype="multipart/form-data">
		<?= $formNewService->selection('category', $categoriesSelection) ?>
		<?= $formNewService->text('title', ['placeholder' => 'Titre du service']) ?>
		<?= $formNewService->text('link', ['placeholder' => 'Lien']) ?>
		<?= $formNewService->textarea('description', ['placeholder' => 'Description']) ?>
		<?= $formNewService->file('logo') ?>
		<?= $formNewService->sender('Envoyer la proposition') ?>
	</form>
		
	<?php foreach($services as $id => $category) { ?>
		<h3 id="<?= $category['id'] ?><?= $id ?>"><?= $category['title'] ?></h3>
		
		<div class="content_article">
		<?php foreach($category['services'] as $service) { ?>
			<a target="_blank" href="<?= $service->link ?>" class="col3">
				<img src="<?= IMAGE ?>eco_service/<?= $service->id ?>.jpg" alt="Logo GreenHand">
				<h4><?= $service->title ?></h4>
				<p><?= $service->description ?></p>
				<!--<div class="like">
					<span>2</span>
				</div>-->
			</a>
		<?php } ?>
		</div>
	<?php } ?>
</div>

