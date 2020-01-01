<!DOCTYPE html>
<html>
<head>
	<title>Ajout compte Game Master</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Ajouter un compte de Game Master</h1>

	<?php
	$erreur = 1;
	if(!empty($_POST)){
		if(empty($_POST['nom'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre nom</p>";
		}
		if(empty($_POST['prenom'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre prénom</p>";
		}
		if(empty($_POST['identifiant'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre identifiant de connexion</p>";
		}
		if(empty($_POST['mdp'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre mot de passe</p>";
		}
	}
	if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['identifiant']) AND !empty($_POST['mdp'])){
		include("connexion_bdd.php");
		$reqprep = $bdd->prepare('SELECT ID FROM game_masters WHERE identifiant = ?');
		$reqprep->execute(array($_POST['identifiant']));
		if(!empty($reqprep->fetch())){
			echo "<p class=\"erreur\">Cet identifiant est déjà utilisé par un autre Game Master.</p>";
		}
		else{
			$erreur = 0;
			$requete = $bdd->prepare('INSERT INTO game_masters(nom, prenom, identifiant, hash_mdp) VALUES (:name, :firstname, :identifier, :passhash)');
			$requete->execute(array(
			'name' => htmlspecialchars($_POST['nom']),
			'firstname' => htmlspecialchars($_POST['prenom']),
			'identifier' => htmlspecialchars($_POST['identifiant']),
			'passhash' => password_hash($_POST['mdp'], PASSWORD_DEFAULT)
		));
			echo "<p class=\"succes\">Le nouveau compte a été créé avec succès.</p>";
			echo "<form action=\"menu_partie.php\"><button type=\"submit\">Retour au menu principal</button></form>";
		}
	}
	if($erreur){
		echo "<form action=\"ajout_gm.php\"><button type=\"submit\" >Retour</button></form>";
	}
	?>

	<?php
	include 'footer.php';
	?>
</body>
</html>