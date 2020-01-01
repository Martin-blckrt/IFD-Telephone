<!DOCTYPE html>
<html>
<head>
	<title>Ecouter demande d'aide</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
		<audio controls autoplay><source src="help.mp3" type="audio/mp3"></audio>
		<p>Attention, après avoir fermé cette page, vous ne pourrez plus écouter le message laissé par les joueurs.</p>
</body>

<?php
	include("connexion_bdd.php");
	$req_help = $bdd->prepare('SELECT MAX(ID) AS maxi FROM help_request');
	$req_help->execute();
	$rep = $req_help->fetch();
	$ID_max = $rep['maxi'];
	$req = $bdd->prepare('UPDATE help_request SET traitee=1 WHERE ID = ?');
	$req->execute(array($ID_max));
?>
