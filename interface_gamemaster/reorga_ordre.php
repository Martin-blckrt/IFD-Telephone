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
	<p class="succes">L'énigme a bien été supprimée. Vous devez maintenant réorganiser les énigmes restantes : </p>
	<p><i>Chaque position dans cette colonne doit apparaître une et une seule fois pour que le nouveau classement soit accepté.</i></p>
	<center>
		<form method="post" action="record_reorga.php">
			<table>
				<thead>
					<tr>
						<th>Nom</th>
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

					$requete = $bdd->prepare('SELECT ID, nom, ordre_apparition FROM enigmes ORDER BY ordre_apparition');
					$requete->execute();
					while($donnees=$requete->fetch()){
						?>
						<tr>
							<td><?php echo $donnees['nom']; ?></td>
							<td><?php echo $donnees['ordre_apparition']; ?></td>
							<td><input type="number" min="1" max= <?php echo "\"".$nb_enigmes."\""; ?> name=<?php echo "\"".$donnees['ID']."\""; ?>></td>
						</tr>
						<?php
					}
					?>

				</tbody>
			</table>
			<br>
			<button type="submit">Enregistrer le nouvel ordre</button>
		</form>
	</center>
	<?php
	include "footer.php";
	?>
</body>
</html>