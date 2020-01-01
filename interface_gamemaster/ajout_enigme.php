<!DOCTYPE html>
<html>
<head>
	<title>Ajout énigme</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include "header.php";
	?>
	<h1>Ajouter une énigme à l'Escape Room</h1>
	<center>
	<div class="formulaire" >
	<form method="POST" action="ajout_enigme_2.php">
		<label><u>Nom de l'énigme (titre) :</u>&nbsp<input size="50" type="text" name="nom_enigme"></label><br><br>
		<label><u>Type de signal de fin :</u>&nbsp
			<input type="radio" name="type_signal" value="auto" id="chx1">
			<label for="chx1">Automatique (cloture par message MQTT)</label>
			<input type="radio" name="type_signal" value="manu" id="chx2"></label>
			<label for="chx2">Manuel (cloture par le Game-Master)</label>
		<br><br>

		<label><u>Type d'indice 1 :</u>&nbsp
			<input type="radio" name="type_indice_1" value="texte" id="chx3">
			<label for="chx3">Texte lu par une voix synthétique</label>
			<input type="radio" name="type_indice_1" value="son" id="chx4"></label>
			<label for="chx4">Bande son (format .mp3)</label>
			<input type="radio" name="type_indice_1" value="vide" id="chx5"></label>
			<label for="chx5">Pas d'indice 1</label>
		<br><br>

		<label><u>Type d'indice 2 :</u>&nbsp
			<input type="radio" name="type_indice_2" value="texte" id="chx6">
			<label for="chx6">Texte lu par une voix synthétique</label>
			<input type="radio" name="type_indice_2" value="son" id="chx7"></label>
			<label for="chx7">Bande son (format .mp3)</label>
			<input type="radio" name="type_indice_2" value="vide" id="chx8"></label>
			<label for="chx8">Pas d'indice 2</label>
		<br><br>

		<label><u>Type de message de fin :</u>&nbsp
			<input type="radio" name="type_message_fin" value="texte" id="chx9">
			<label for="chx9">Texte lu par une voix synthétique</label>
			<input type="radio" name="type_message_fin" value="son" id="chx10"></label>
			<label for="chx10">Bande son (format .mp3)</label>
			<input type="radio" name="type_message_fin" value="vide" id="chx11"></label>
			<label for="chx11">Pas de message de fin</label>
		<br><br>

		<label><u>Numéro à composer sur le téléphone à 3 chiffres, différent de 000 (= numéro réservé pour le contact Game-Master) :</u>&nbsp<input type="text" name="num_tel" placeholder="XXX" pattern="^[0-9]{3}$"></label><br><br>

		<button type="submit" style="position: relative; left: 40%;">Suivant</button>
	</form>
	</div>
	<br>
	<br>
	<form action="config_room.php">
		<button><b>Retour</b></button>
	</form>
	</center>
	<?php
		include "footer.php";
	?>
</body>
</html>
