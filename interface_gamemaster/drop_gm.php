<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Suppression compte Game Master</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Supprimer mon compte de Game Master</h1>
	<?php
	$erreur = 1;
	if(!empty($_POST)){
		if(empty($_POST['identifiant'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre identifiant.</p>";
		}
		if(empty($_POST['mdp'])){
			echo "<p class=\"erreur\">Vous n'avez pas saisi votre mot de passe.</p>";
		}
	}
	if(!empty($_POST['identifiant']) AND !empty($_POST['mdp'])){
		if($_POST['identifiant']!=$_SESSION['connected_gm_identifiant']){
			echo "<p class=\"erreur\">Erreur : la combinaison identifiant/mot de passe ne correspond pas à votre compte.</p>";
		}
		else{
			include("connexion_bdd.php");
			$requete = $bdd->prepare('SELECT * FROM game_masters WHERE identifiant = ?');
			$requete->execute(array(htmlspecialchars($_POST['identifiant'])));
			$result = $requete->fetch();
			if(!password_verify($_POST['mdp'], $result['hash_mdp'])){
				echo "<p class=\"erreur\">Erreur : la combinaison identifiant/mot de passe ne correspond pas à votre compte.</p>";
			}
			else{
				$erreur = 0;
				//on vérifie maintenant que le compte à supprimer n'est pas le dernier compte
				$nb_comptes = 0;
				$requete = $bdd->prepare('SELECT * FROM game_masters');
				$requete->execute(array(htmlspecialchars($_POST['identifiant'])));
				while($requete->fetch()){
					$nb_comptes++;
				}
				if($nb_comptes<=1){
					echo "<p class=\"erreur\">Erreur : vous êtes le dernier Game Master, vous ne pouvez donc pas supprimer votre compte.</p>";		
					echo "<form action=\"menu_partie.php\"><button type =\"submit\">Retour au menu principal</button></form>";
				}else{
					$requete = $bdd->prepare('DELETE FROM game_masters WHERE identifiant = ?');
					$requete->execute(array(htmlspecialchars($_POST['identifiant'])));
					echo "<p class=\"succes\">Votre compte a bien été supprimé.</p>";
					echo "<form action=\"deconnexion.php\"><button type =\"submit\">Retour à l'accueil</button></form>";
				}
			}
		}
	}

	if($erreur){
		echo "<form action=\"suppr_gm.php\"><button type=\"submit\" >Retour</button></form>";
	}

	include 'footer.php';

?>

</body>

