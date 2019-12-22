<?php
	session_start();
	//premiere chose a faire : inserer la nouvelle partie dans la table des parties et creer les details partie (initialiser tous les jeux a "En attente") si et seulement si il n'y a pas de partie en cours
	include("connexion_bdd.php");
	include("verif_partie_en_cours.php");
	if(!$_SESSION['partie_en_cours']){
		include("connexion_bdd.php");
		$requete = $bdd->prepare('INSERT INTO parties(date_debut,ID_gamemaster) VALUES(UTC_TIMESTAMP(),?)');
		$requete->execute(array($_SESSION['connected_gm_id']));
		$requete = $bdd->prepare('SELECT MAX(ID) AS num_partie FROM parties');
		$requete->execute();
		$result = $requete->fetch();
		$_SESSION['partie_ouverte'] = $result['num_partie'];

		//maintenant qu'on a créé la partie, on crée les détails de la partie en initialisant chaque énigme à non-résolue (1)

		$requete = $bdd->prepare('SELECT ID FROM enigmes');
		$requete->execute();
		while($donnees = $requete->fetch()){
			$req2 = $bdd->prepare('INSERT INTO details_parties(ID_partie,ID_enigme,etat,duree_resolution) VALUES (:id_p,:id_e,:state,:duree)');
			$req2->execute(array(
				'id_p' => $_SESSION['partie_ouverte'],
				'id_e' => $donnees['ID'],
				'state' => 0,
				'duree' => 0));
		}
	}
		
?>

<!DOCTYPE html>
<html>
<head>
	<title>Interface de commande</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include 'header.php';
	?>
	<h1>Interface de commande du téléphone - <font color="green">PARTIE EN COURS</font></h1>
	<p class="temoin_connexion"><u><b>Game Master connecté :</b></u>
		<?php
			echo " ".$_SESSION['connected_gm_prenom'] . " " . $_SESSION['connected_gm_nom'];
		?>
	</p>
	<h2><b><u>État des énigmes :</u></b></h2>
	<table>
		<thead>
			<tr>
				<th>Ordre de résolution</th>
				<th>Nom</th>
				<th>État - Temps de résolution</th>
				<th>Cloturer manuellement</th>
			</tr>
		</thead>
		<tbody>
			<?php
				include("connexion_bdd.php");
				$req_details = $bdd->prepare('SELECT enigmes.ID AS ID, enigmes.ordre_apparition AS ordre, enigmes.nom AS nom_enigme, enigmes.type_signal_fin AS type_signal,  details_parties.etat AS state, details_parties.duree_resolution AS duree FROM details_parties INNER JOIN enigmes ON (details_parties.ID_enigme = enigmes.ID) WHERE details_parties.ID_partie = ? ORDER BY enigmes.ordre_apparition');
				$req_details->execute(array($_SESSION['partie_ouverte']));
				while($ligne=$req_details->fetch()){
			?>
						<tr>
							<td><?php echo $ligne['ordre']; ?></td>
							<td><?php echo $ligne['nom_enigme']; ?></td>
							<?php echo "<td class=\"_". $ligne['state'] ."\">";
							$correspondance_etats=array("Non-résolue","Indice 1 délivré","Indice 2 délivré", "Résolue avec 1 indice", "Résolue avec 2 indices", "Résolue en autonomie");
							if($ligne['state']<3){
								echo $correspondance_etats[$ligne['state']];	
							}else{
								echo $correspondance_etats[$ligne['state']]." - ". $ligne['duree'];
							}
							?>
							</td>
							<?php
								if(!$ligne['type_signal'] AND $ligne['state']<3){
							?>
							<td class="no_border">
								<form action="cloturer_enigme.php" method="POST">
									<input type="hidden" name="id_enigme" value=<?php echo "\"".$ligne['ID']."\""; ?>>
									<input type="hidden" name="state_enigme" value=<?php echo "\"".$ligne['state']."\""; ?>>
									<button type="submit">Cloturer</button>
								</form>
							</td>
							<?php
								}
							?>
						</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<br>
		<button onclick="window.print();return false;"><b>Imprimer le rapport de partie</b></button>
	<br>
	<form action="cloture_partie.php">
		<button type="submit"><font color="red">Cloturer la partie</font></button>
	</form>
	<?php
		include 'footer.php';
	?>
</body>
</html>