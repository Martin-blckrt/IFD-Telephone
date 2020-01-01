<?php
	session_start();
	if($_SESSION['partie_en_cours']){
		$_SESSION['partie_en_cours']=0;
		include("connexion_bdd.php");
		$requete = $bdd->prepare('UPDATE parties SET date_fin = UTC_TIMESTAMP() WHERE ID = ?');
		$requete->execute(array($_SESSION['partie_ouverte']));
	}
	exec("sudo systemctl stop indices.service");
	header("Location: menu_partie.php");
?>
