<?php
session_start();
exec("sudo python /home/pi/cloturer_enigme.py ".$_POST['id_enigme']);
/*
include("connexion_bdd.php");
		if($_POST['state_enigme']==1 OR $_POST['state_enigme'] == 2){
			$new_state = $_POST['state_enigme']+2;
		}else{
			$new_state = 5;
		}

		$req1 = $bdd->prepare('SELECT date_debut FROM parties WHERE ID = ?');
		$req1->execute(array($_SESSION['partie_ouverte']));
		$date_deb = $req1->fetch();
		$date_deb = strtotime($date_deb['date_debut']);
		echo "Date de début : ".$date_deb;
		$new_duree = gmdate("H:i:s",time() - $date_deb);
		echo " Maintenant : ".time();
		//$new_duree = date_diff(time(),$date_deb);
		$requete = $bdd->prepare('UPDATE details_parties SET duree_resolution = :dur WHERE ID_enigme = :no_en AND ID_partie = :no_pa; UPDATE details_parties SET etat = :nouvel_etat WHERE ID_enigme = :no_en AND ID_partie = :no_pa');
		$requete->execute(array(
			'temps_deb' => $date_deb,
			'nouvel_etat' => $new_state,
			'no_en' => $_POST['id_enigme'],
			'no_pa' => $_SESSION['partie_ouverte'],
			'dur' => $new_duree
		));
*/
header("Location: interface_partie.php");
?>
