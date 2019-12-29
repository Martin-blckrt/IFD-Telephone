<?php
session_start();
include("connexion_bdd.php");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Historique des parties</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Historique des parties</h1>
	<p><i>Les heures indiquées ci-dessous sont des heures UTC.</i></p>
	<?php
	$reqgen = $bdd->prepare('SELECT parties.ID AS ID_partie, parties.date_debut AS debdate, parties.date_fin AS enddate, game_masters.nom AS gmname, game_masters.prenom AS gmfname FROM parties INNER JOIN game_masters ON (parties.ID_gamemaster = game_masters.ID) WHERE parties.date_fin !=0 ORDER BY parties.ID DESC');
	$reqgen->execute();
	while($partie = $reqgen->fetch()){
		?>

		<button type="button" class="collapsible">Partie commencée le <b><?php echo $partie['debdate']; ?></b>, terminée le <b><?php echo $partie['enddate']; ?></b>, gérée par <b><?php echo $partie['gmfname']." ".$partie['gmname']; ?></b></button>
		<div class="content">
			<table>
				<thead>
					<tr>
						<th>Ordre de résolution</th>
						<th>Nom de l'énigme</th>
						<th>État final - Temps de résolution</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$req_details = $bdd->prepare('SELECT enigmes.ID AS ID, enigmes.ordre_apparition AS ordre, enigmes.nom AS nom_enigme, enigmes.type_signal_fin AS type_signal,  details_parties.etat AS state, details_parties.duree_resolution AS duree FROM details_parties INNER JOIN enigmes ON (details_parties.ID_enigme = enigmes.ID) WHERE details_parties.ID_partie = ? ORDER BY enigmes.ordre_apparition');
					$req_details->execute(array($partie['ID_partie']));
					while($ligne=$req_details->fetch()){
						?>
						<tr>
							<td><?php echo $ligne['ordre']; ?></td>
							<td><?php echo $ligne['nom_enigme']; ?></td>
							<?php echo "<td class=\"_". $ligne['state'] ."\"><font color=\"black\"><b>";
							$correspondance_etats=array("Non-résolue","Indice 1 délivré","Indice 2 délivré", "Résolue avec 1 indice", "Résolue avec 2 indices", "Résolue en autonomie");
							if($ligne['state']<3){
								echo $correspondance_etats[$ligne['state']];	
							}else{
								echo $correspondance_etats[$ligne['state']]." - ". $ligne['duree'];
							}
							?>
						</b></font></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
	}
	?>
	<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
			coll[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var content = this.nextElementSibling;
				if (content.style.display === "block") {
					content.style.display = "none";
				} else {
					content.style.display = "block";
				}
			});
		}
	</script>
	<br><br><br><br>
	<form action="menu_partie.php">
		<button><b>Retour</b></button>
	</form>
</body>
</html>
