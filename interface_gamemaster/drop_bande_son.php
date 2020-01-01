<!DOCTYPE html>
<html>
<head>
	<title>Supprimer bande son</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include "header.php";
	?>
	<h1>Supprimer une bande son</h1>
	<?php
	include("connexion_bdd.php");

	$reqprep = $bdd->prepare('SELECT ID FROM bandes_son WHERE titre = ?');
	$reqprep->execute(array($_POST['rep']));
	$result = $reqprep->fetch();
	$id_fichier = $result['ID'];
	$chemin_fichier = "bandes_sons/".strval($id_fichier).".mp3";
	if(!unlink($chemin_fichier)){
		?>
		<p class="erreur">Le fichier à supprimer est introuvable.</p>
		<?php
	}

	$requete = $bdd->prepare('DELETE FROM bandes_son WHERE titre = ?');
	$requete->execute(array($_POST['rep']));

	?>
	<p class="succes">La bande son a été supprimée avec succès.</p>
	<form action="config_room.php">
		<button type="submit">Retour au menu de configuration</button>
	</form>
	<?php
	include "footer.php";
	?>
</body>
</html>