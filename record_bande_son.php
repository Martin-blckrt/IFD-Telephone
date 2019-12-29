<!DOCTYPE html>
<html>
<head>
	<title>Ajout bande son</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include "header.php";
	?>
	<h1>Ajouter une bande son</h1>
	<center>
		<?php
		include("connexion_bdd.php");
		$erreur = 0;
		if(!empty($_POST)){
			if(empty($_POST['titre'])){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le nom de la bande sonore.</p>";
				$erreur = 1;
			}
			else{
				$req = $bdd->prepare('SELECT ID FROM bandes_son WHERE titre = ?');
				$req->execute(array($_POST['titre']));
				if(!empty($req->fetch())){
					echo "<p class=\"erreur\">Ce nom est déjà utilisé par une autre bande son, veuillez en choisir un autre.</p>";
					$erreur = 1;	
				}
			}
			if(empty($_FILES['fichier_bande']['name'])){
				echo "<p class=\"erreur\">Vous n'avez pas importé de fichier.</p>";	
				$erreur = 1;
			}
			if($_FILES['fichier_bande']['error']!=0){
				echo "<p class=\"erreur\">Une erreur est survenue lors de l'importation de la bande son. Veuillez réessayer avec un fichier plus léger. Code d'erreur : ".$_FILES['fichier_bande']['error']."</p>";
				$erreur = 1;
			}
			if($_FILES['fichier_bande']['size']>1000000){
				echo "<p class=\"erreur\">La taille du fichier importé dépasse 1 Mo.</p>";
				$erreur = 1;	
			}
			if($_FILES['fichier_bande']['type']!='audio/mpeg'){
				echo "<p class=\"erreur\">Le fichier importé n'est pas un fichier .mp3.</p>";
				$erreur = 1;		
			}	
		}

		if($erreur){
			echo "<form action=\"ajout_bande.php\"><button type=\"submit\">Retour</button></form>";
		}
		else{

			$req = $bdd->prepare('SELECT MAX(ID) AS next FROM bandes_son');
			$req->execute();
			$rep = $req->fetch();

			$next_id = $rep['next']+1;

			move_uploaded_file($_FILES['fichier_bande']['tmp_name'], 'bandes_sons/'.$next_id.'.mp3');
			$requete = $bdd->prepare('INSERT INTO bandes_son(ID, titre) VALUES (:newID, :newTitre)');
			$requete->execute(array(
				'newID' => $next_id,
				'newTitre' => $_POST['titre']
			));

			echo "<p class=\"succes\">La nouvelle bande son a été enregistrée avec succès.</p>";
			echo "<form action=\"config_room.php\"><button type=\"submit\">Retour au menu de configuration</button></form>";
		}

		?>
	</center>
</body>
</html>