<!DOCTYPE html>
<html>
<head>
	<title>Configuration Escape Room</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include "header.php";
	?>
	<center>
	<h1>Configuration de l'Escape Room</h1>
	<div class="ensemble_btns">
	<form action="ajout_enigme.php">
		<button>Ajouter une énigme</button>
	</form>
	<br>
	<form action="modif_ordre.php">
		<button>Modifier l'ordre des énigmes</button>
	</form>
	<br>
	<form action="suppr_enigme.php">
		<button>Supprimer une énigme</button>
	</form>
	</div>
	<br>
	<div class="ensemble_btns">
	<form action="ajout_bande.php">
		<button>Ajouter une bande son</button>
	</form>
	<br>
	<form action="ecouter_bandes.php">
		<button>Ecouter les bandes son</button>
	</form>
	<br>
	<form action="suppr_bande.php">
		<button>Supprimer une bande son</button>
	</form>
	</div>
	<br>
	<br>
	<form action="menu_partie.php">
		<button><b>Retour</b></button>
	</form>
	<br>
	</center>
	<?php
		include "footer.php";
	?>
</body>
</html>