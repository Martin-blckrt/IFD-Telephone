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
	<center>
		<?php
			include("connexion_bdd.php");
			$reqprep = $bdd->prepare('SELECT COUNT(ID) AS total FROM enigmes');
			$reqprep->execute();
			$rep = $reqprep->fetch();
			$nb_enigmes=$rep['total'];
			$comp = range(1,$nb_enigmes);

			$dedoublon = array_unique($_POST);
			sort($dedoublon);

			if($dedoublon==$comp){
				foreach ($_POST as $ID => $new_ordre) {
					$requete = $bdd->prepare('UPDATE enigmes SET ordre_apparition = :nouvel_ordre WHERE ID = :ident');
					$requete->execute(array(
						'nouvel_ordre' => $new_ordre,
						'ident' => $ID
					));
				}
				echo "<p class=\"succes\">Votre nouvel ordre a été enregistré avec succès.</p>";
				echo "<form action=\"config_room.php\"><button type=\"submit\" >Retour au menu de configuration</button></form>";

			}else{
				echo "<p class=\"erreur\">Votre classement est incohérent, veuillez recommencer.</p>";
				echo "<form action=\"reorga_ordre.php\"><button type=\"submit\" >Retour</button></form>";
			}

		?>
	</center>
</body>
</html>