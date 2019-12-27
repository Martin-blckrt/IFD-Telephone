<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Erreur</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Erreur de connexion</h1>
	<?php
	$erreur = 1;
	if(!empty($_POST)){
		if(empty($_POST['identifiant'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre identifiant</p>";
		}
		if(empty($_POST['mdp'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre mot de passe</p>";
		}
	}
	if(!empty($_POST['identifiant']) AND !empty($_POST['mdp'])){
		include("connexion_bdd.php");
		$requete = $bdd->prepare('SELECT * FROM game_masters WHERE identifiant = ?');
		$requete->execute(array(htmlspecialchars($_POST['identifiant'])));
		$result = $requete->fetch();
		if(empty($result)){
			echo "<p class=\"erreur\">Désolé, la combinaison identifiant/mot de passe ne correspond à aucun Game-Master.</p>";
		} elseif(!password_verify($_POST['mdp'], $result['hash_mdp'])){
			echo "<p class=\"erreur\">Désolé, la combinaison identifiant/mot de passe ne correspond à aucun Game-Master.</p>";
		}
		else{
			$erreur = 0;
			$_SESSION['connected_gm_id'] = $result['ID'];
			$_SESSION['connected_gm_nom'] = $result['nom'];
			$_SESSION['connected_gm_prenom'] = $result['prenom'];
			$_SESSION['connected_gm_identifiant'] = $_POST['identifiant'];
			header("Location: menu_partie.php");
		}
	}
	if($erreur){
		echo "<form action=\"index.php\"><button type=\"submit\" >Retour</button></form>";
	}
include 'footer.php';
?>
</body>
</html>