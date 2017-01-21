<?php 
include('header.php');

?>

<div class="main_container" id="eco_service">
	<h2>Annuaire des services éco-responsables</h2>
	<nav>
	<?php foreach($categories as $category) { ?>
		<a href="#<?= $category->idAttr ?><?= $category->id ?>" id="<?= $category->idAttr ?>"><?= $category->title ?></a>
	<?php } ?>
	</nav>

	<p id="new_service">Proposez un nouveau service ? Pas de problème</p>

	<form method="post" id="form_service" enctype="multipart/form-data">
		<section>
			<div class="half">
			<?= $formNewService->text('title', ['placeholder' => 'Titre du service']) ?>
			<?= $formNewService->text('link', ['placeholder' => 'Lien vers le service : http://................']) ?>
			<?= $formNewService->selection('category', $categoriesSelection) ?>
			<?= $formNewService->file('logo') ?>
			</div>
			<div class="half">
			<?= $formNewService->textarea('description', ['placeholder' => 'Une courte description du service que vous proposez']) ?>
			<?= $formNewService->sender('Envoyer la proposition') ?>
			</div>
		</section>
	</form>
		
	<?php foreach($services as $id => $category) { ?>
	<article>
		<h3 id="<?= $category['id'] ?><?= $id ?>"><?= $category['title'] ?></h3>
		
		<div class="content_article">
		<?php foreach($category['services'] as $service) { ?>
			<div class="service">
				<a class="card" target="_blank" href="<?= $service->link ?>">
					<div>
						<h4><?= $service->title ?></h4>
						<p><?= $service->description ?></p>
						<!--<div class="like">
							<span>2</span>
						</div>-->
						<p class="link"><b>Lien : </b><?= $service->link ?></p>
					</div>
					<img src="<?= IMAGE ?>eco_service/<?= $service->id ?>.jpg" alt="Logo GreenHand">
				</a>
			</div>
		<?php } ?>
		</div>
	</article>
	<?php } ?>
</div>

