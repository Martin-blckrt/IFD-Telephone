<?php
session_start();
include("connexion_bdd.php");
?>
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
							<?php echo "<td class=\"_". $ligne['state'] ."\"><font color=\"black\"><b>";
							$correspondance_etats=array("Non-résolue","Indice 1 délivré","Indice 2 délivré", "Résolue avec 1 indice", "Résolue avec 2 indices", "Résolue en autonomie");
							if($ligne['state']<3){
								echo $correspondance_etats[$ligne['state']];	
							}else{
								echo $correspondance_etats[$ligne['state']]." - ". $ligne['duree'];
							}
							?>
							</b></font></td>
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

<br><br>

<h2><b><u>Demande d'aide :</u>&nbsp
<?php
	$req_help = $bdd->prepare('SELECT MAX(ID) AS maxi FROM help_request');
	$req_help->execute();
	$rep = $req_help->fetch();
	$ID_max = $rep['maxi'];
	$req = $bdd->prepare('SELECT traitee FROM help_request WHERE ID = ?');
	$req->execute(array($ID_max));
	$donn = $req->fetch();
	$traitee = $donn['traitee'];
	if($traitee==0)
	{
		echo "<font class=\"succes\">Nouvelle demande d'aide - <a href=\"ecouter_help_request.php\" onclick=\"window.open(this.href, 'Popup', 'scrollbars=1,resizable=1,height=560,width=770'); return false;\">Ecouter l'enregistrement</a></font>";
	}
	else
	{
		echo "Aucune";
	}
?>
</b></h2>
