<!DOCTYPE html>
<html>
<head>
	<title>Page de connexion</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include 'header.php';
	?>
	<h1>Interface de connexion - Game Master</h1>
	<form class="form_connexion" action="connect.php" method="POST">
		<label>Identifiant : <input type="text" name="identifiant"></label><br><br>
		<label>Mot de passe : <input type="password" name="mdp"></label><br><br>
		<button type="submit">Me connecter</button>
	</form>
	<?php
		include 'footer.php';
	?>
</body>
</html>