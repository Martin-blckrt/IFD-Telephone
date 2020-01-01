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
	?>
	<center>
		<form method="post" action="drop_bande_son.php">
			<label><u>Selectionnez le nom de la bande son à supprimer :</u>&nbsp
				<select name="rep">
				<?php
				$requete = $bdd->prepare('SELECT titre, ID FROM bandes_son ORDER BY titre');
				$requete->execute();
				while($donnees=$requete->fetch()){
				?>
					<option><?php echo $donnees['titre']; ?></option>
				<?php
				}
				?>
				</select>
			</label><br><br>
			<button type="submit"><font color="red">Supprimer la bande son</font></button>
		</form>
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