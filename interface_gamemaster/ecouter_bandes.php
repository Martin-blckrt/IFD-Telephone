<!DOCTYPE html>
<html>
<head>
	<title>Ecouter bandes sons</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include "header.php";
	?>
	<center>
	<h1>Liste des bandes sons</h1>
	<?php
	include("connexion_bdd.php");
	$requete = $bdd->prepare('SELECT ID,titre FROM bandes_son ORDER BY titre');
	$requete->execute();
	while ($donnees = $requete->fetch()){
		?>
			<h4><?php echo $donnees['titre']; ?></h4>
			<audio controls><source src=<?php echo "bandes_sons/".$donnees['ID'].".mp3"; ?> type="audio/mpeg"/></audio>		
		<?php
	}

	?>
	<br>
	<br>
	<form action="config_room.php">
		<button><b>Retour</b></button>
	</form>
	<?php
	include "footer.php";
	?>
</body>
</html>