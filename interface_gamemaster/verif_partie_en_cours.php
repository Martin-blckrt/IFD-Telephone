<?php
$_SESSION['partie_en_cours'] = 1;
	include("connexion_bdd.php");
	$requete = $bdd->prepare('SELECT ID,date_debut,date_fin,ID_gamemaster FROM parties WHERE ID_gamemaster = ? ORDER BY ID DESC LIMIT 1');
		$requete->execute(array($_SESSION['connected_gm_id']));
		$result = $requete->fetch();
	if(empty($result) OR  $result['date_fin']>$result['date_debut']){
		$_SESSION['partie_en_cours'] = 0;
	}
	else{
		$_SESSION['partie_ouverte'] = $result['ID'];
	}
?>