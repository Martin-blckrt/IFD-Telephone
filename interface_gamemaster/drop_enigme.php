<!DOCTYPE html>
<html>
<head>
	<title>Supprimer une énigme</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include "header.php";
	?>
	<h1>Supprimer une énigme de l'Escape Room</h1>
	<?php
	include("connexion_bdd.php");
	$requete = $bdd->prepare('DELETE FROM enigmes WHERE nom = ?');
	$requete->execute(array($_POST['rep']));
	header("Location: reorga_ordre.php");
	?>
</body>
</html>