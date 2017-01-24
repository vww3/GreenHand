<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">
	
	<head>
		
		<title>GreenHand | <?= $this->title ?></title>
		
		<meta charset="utf-8">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?= IMAGE ?>favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		
<?php foreach ($this->metadatas as $name => $value) { ?>

    <?php if (is_array($value)) { ?>
    
    	<?php foreach ($value as $type => $data) { ?>
        <meta property="<?= $name ?>:<?= $type ?>" content="<?= $data ?>">
        <?php } ?>
        
    <?php } else { ?>
        <meta name="<?= $name ?>" content="<?= $value ?>">
	<?php } ?>
	
<?php } ?>

		<!-- Générés par http://www.favicon-generator.org -->
		<link rel="apple-touch-icon icon" sizes="57x57" href="<?= IMAGE ?>favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon icon" sizes="60x60" href="<?= IMAGE ?>favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon icon" sizes="72x72" href="<?= IMAGE ?>favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon icon" sizes="76x76" href="<?= IMAGE ?>favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon icon" sizes="114x114" href="<?= IMAGE ?>favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon icon" sizes="120x120" href="<?= IMAGE ?>favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon icon" sizes="144x144" href="<?= IMAGE ?>favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon icon" sizes="152x152" href="<?= IMAGE ?>favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon icon" sizes="180x180" href="<?= IMAGE ?>favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?= IMAGE ?>favicon/favicon-16x16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?= IMAGE ?>favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?= IMAGE ?>favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?= IMAGE ?>favicon/android-icon-192x192.png">
		<link rel="manifest" href="<?= IMAGE ?>favicon/manifest.json">
	</head>
	<body>
		
		<?= $this->_contentForLayout ?>
		
		<footer>
			<div>
				<h2>GreenHand - <small>Il n'y a pas de petits gestes quand on est 60 millions à le faire</small></h2>
				<p>Projet étudiant mené par <a href="mailto:emma.louviot@gmail.com" title="Écrire à Emma">Emma Louviot</a> et <a href="mailto:mickael.boidin@icloud.com" title="Écrire à Mickaël">Mickaël Boidin</a> dans le cadre du projet de fin d'étude du <a href="http://stgi.univ-fcomte.fr/pages/fr/menu133/trouvez-votre-formation/nos-departements/3.3.2-multimedia-et-informatique-17393.html" title="En savoir plus sur le Master 2 PSM">Master 2 Produit et Services Multimédia (UFR STGI, département multimédia)</a>.</div>
			<img src="<?= IMAGE ?>accueil/logo_blanc.svg">
		</footer>
		
<?php foreach ($this->styles as $style) { ?>
        <link rel="stylesheet" href="<?= STYLE.$style ?>.css">
<?php } ?>

<?php foreach ($this->javascript as $script) { ?>
        <script src="<?= JAVASCRIPT.$script ?>.js"></script>
<?php } ?>
           	
	</body>

</html>