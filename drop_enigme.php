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

	$reqprep = $bdd->prepare('SELECT ID, type_indice_1, type_indice_2, type_message_fin FROM enigmes WHERE nom = ?');
	$reqprep->execute(array($_POST['rep']));
	$result = $reqprep->fetch();
	if($result['type_indice_1']==2){
		$id_fichier = $result['ID'];
		$chemin_fichier = "sons_enigmes/indices_1/".strval($id_fichier).".mp3";
		if(!unlink($chemin_fichier)){
		?>
		<p class="erreur">Le fichier d'indice 1 à supprimer est introuvable.</p>
		<?php
		}
	}
	if($result['type_indice_2']==2){
		$id_fichier = $result['ID'];
		$chemin_fichier = "sons_enigmes/indices_2/".strval($id_fichier).".mp3";
		if(!unlink($chemin_fichier)){
		?>
		<p class="erreur">Le fichier d'indice 2 à supprimer est introuvable.</p>
		<?php
		}
	}
	if($result['type_message_fin']==2){
		$id_fichier = $result['ID'];
		$chemin_fichier = "sons_enigmes/messages_fin/".strval($id_fichier).".mp3";
		if(!unlink($chemin_fichier)){
		?>
		<p class="erreur">Le fichier de message de fin à supprimer est introuvable.</p>
		<?php
		}
	}

	$requete = $bdd->prepare('DELETE FROM enigmes WHERE nom = ?');
	$requete->execute(array($_POST['rep']));
	header("Location: reorga_ordre.php");
	?>
</body>
</html>