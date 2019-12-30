<!DOCTYPE html>
<html>
<head>
	<title>Modification de l'ordre des énigmes</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include "header.php";
	?>
	<h1>Modifier l'ordre des énigmes de l'Escape Room</h1>
	<p><i>Pour modifier l'ordre d'apparition des énigmes, remplissez la dernière colonne du tableau ci-dessous. Chaque position dans cette colonne doit apparaître une et une seule fois pour que le nouveau classement soit accepté.</i></p>
	<center>
		<form method="post" action="record_ordre.php">
			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Numéro de téléphone</th>
						<th>Ordre actuel</th>
						<th>Nouvel ordre</th>
					</tr>
				</thead>
				<tbody>

					<?php
					include("connexion_bdd.php");
					$reqprep = $bdd->prepare('SELECT COUNT(ID) AS total FROM enigmes');
					$reqprep->execute();
					$rep = $reqprep->fetch();
					$nb_enigmes=$rep['total'];

					$requete = $bdd->prepare('SELECT ID, nom, ordre_apparition, numero_tel FROM enigmes ORDER BY ordre_apparition');
					$requete->execute();
					$i=1;
					while($donnees=$requete->fetch()){
						?>
						<tr>
							<td><?php echo $donnees['nom']; ?></td>
							<td><?php echo $donnees['numero_tel']; ?></td>
							<td><?php echo $donnees['ordre_apparition']; ?></td>
							<td><input type="number" min="1" max= <?php echo "\"".$nb_enigmes."\""; ?> name=<?php echo "\"".$donnees['ID']."\""; ?> value=<?php echo $i; ?>></td>
						</tr>
						<?php
						$i++;
					}
					?>

				</tbody>
			</table>
			<br>
			<button type="submit">Enregistrer le nouvel ordre</button>
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
