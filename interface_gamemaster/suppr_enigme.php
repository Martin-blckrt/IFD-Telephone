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
	<p><i>Attention, toute suppression d'énigme est définitive. Les indices (textes et bandes sons) seront supprimés en même temps que l'énigme.</i></p>
	<?php
		include("connexion_bdd.php");
	?>
	<center>
		<form method="post" action="drop_enigme.php">
			<label><u>Selectionnez le nom de l'énigme à supprimer :</u>&nbsp
				<select name="rep">
				<?php
				$requete = $bdd->prepare('SELECT nom FROM enigmes ORDER BY ordre_apparition');
				$requete->execute();
				while($donnees=$requete->fetch()){
				?>
					<option> <?php echo $donnees['nom']; ?></option>
				<?php
			}
			?>
				</select>
			</label><br><br>
			<button type="submit"><font color="red">Supprimer l'énigme</font></button>
	</form>
	<br>
	<br>
	<form action="config_room.php">
		<button><b>Retour</b></button>
	</form>
</center>

</body>
</html>
