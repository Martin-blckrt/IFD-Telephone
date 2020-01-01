<!DOCTYPE html>
<html>
<head>
	<title>Suppression compte Game Master</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include 'header.php';
	?>
	<h1>Supprimer mon compte de Game Master</h1>
	<p>Pour supprimer votre compte de Game Master, veuillez saisir votre identifiant et votre mot de passe.</p>
	<form method="POST" action="drop_gm.php">
		<label><u>Identifiant :</u>&nbsp<input type="text" name="identifiant"></label><br><br>
		<label><u>Mot de passe :</u>&nbsp<input type="password" name="mdp"></label><br><br>
		<p>Attention : en cliquant sur le bouton ci-dessous, vous perdrez votre compte et toutes les parties que vous gérez.</p>
		<button type="submit"><font color="red">Supprimer mon compte</font></button>
	</form>
	<?php
		include 'footer.php';
	?>
</body>
</html>