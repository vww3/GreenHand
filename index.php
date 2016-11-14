<?php require('core/core.php'); ?>
<?php $model = Model::load("Categorie"); ?>

<?php 

if(!empty($_POST)){
	print_r($model->save($_POST));
}

if(isset($_GET["suppr"])){
	$model->delete($_GET["suppr"]);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GreenHand</title>
</head>
<body>

<div class="container">
	<ul>
	<?php 
	$cat1 = $model->find(array(
		"order" => " position ASC",
		"field" => "id, name"
		));

	echo '<pre>' . print_r($cat1, true). '</pre>';


	foreach ($cat1 as $c) :?>
		<li><a href="index.php?id=<?= $c->id?>"><?= $c->name ?></a> <a href="index.php?suppr=<?= $c->id?>">[x]</a> </li>
		

	<?php endforeach;?>
	 <li><a href="index.php">Ajouter une catégorie</a></li>
	</ul>

	<p>
		<form action="index.php" method="post">
			<?php
			if(!empty($_GET["id"])){
				$id = $_GET["id"];
				$model->id = $id;
				$cat = $model->read();

				echo '<input type="hidden" name="id" value="'. $cat->id.'">';
			}else{
				$cat = new StdClass();
				$cat->name = "";
				$cat->position = 0;
			}
			 ?>

			 <input type="text" name="name" value="<?php echo $cat->name;?>">
			 <input type="text" name="position" value="<?php echo $cat->position;?>">
			 <input type="submit" value="Envoyer">
		</form>
	</p>
</div>
	
</body>
</html>