<?php foreach ($test as $t) : ?>
	<h1><a href="<?php echo WEBROOT; ?>Test/view/<?php echo $t->id; ?>"><?php echo $t->name; ?></a></h1>
<?php endforeach; ?>