<!DOCTYPE html>
<html>
<head>
	<title>Ajout bande son</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include "header.php";
	?>
	<h1>Ajouter une bande son</h1>
	<center>
		<form method="post" action="record_bande_son.php" enctype="multipart/form-data"> 
			<label><u>Nom de la bande son :</u>&nbsp<input type="text" name="titre"></label><br><br>
			<label><u>Fichier :</u>&nbsp<i>Chargez la bande son (format .mp3, 1Mo max)</i>&nbsp<input type="file" name="fichier_bande"></label><br><br>
			<button type="submit">Enregistrer la bande son</button>
		</form>
	</center>
</body>
</html>