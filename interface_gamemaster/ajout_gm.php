<!DOCTYPE html>
<html>
<head>
	<title>Ajout compte Game Master</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Ajouter un compte de Game Master</h1>
		<p>Demandez à votre nouveau collaborateur de s'inscrire ci-dessous pour qu'il puisse utiliser l'interface.</p>
		<form action="record_gm.php" method="POST">
			<label><u>Nom :</u>&nbsp<input type="text" name="nom"></label><br><br>
			<label><u>Prénom :</u>&nbsp<input type="text" name="prenom"></label><br><br>
			<label><u>Identifiant de connexion :</u>&nbsp<input type="text" name="identifiant"></label><br><br>
			<label><u>Mot de passe :</u>&nbsp<input type="password" name="mdp"></label><br><br>
			<button type="submit">Enregistrer le compte</button>
		</form>
	<?php
	include "footer.php";
	?>
</body>
</html>