<?php
	session_start();
	include("verif_partie_en_cours.php");
	if($_SESSION['partie_en_cours']){	//une partie est en cours, on redirige le game-master vers l'interface de partie
		header("Location: interface_partie.php");
	}
	else{
?>

<!DOCTYPE html>
<html>
<head>
	<title>Menu Game Master</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include 'header.php';
	?>
	<h1>Menu principal</h1>
	<p class="temoin_connexion"><u><b>Game-Master connecté :</b></u>
		<?php
			echo " ".$_SESSION['connected_gm_prenom'] . " " . $_SESSION['connected_gm_nom'];
		?>
	</p>
	<center>
	<form action="deconnexion.php">
		<button>Me déconnecter</button>
	</form>
	<br>
	<br>
	<div class="ensemble_btns">
	<form action="interface_partie.php">
		<button><b>Démarrer une nouvelle partie</b></button>
	</form>
	<br>
	<form action="histo_parties.php">
		<button>Voir l'historique des parties</button>
	</form>
	</div>
	<br>
	<div class="ensemble_btns">
	<form action="config_room.php">
		<button>Configurer l'escape room</button>
	</form>
	</div>
	<br>
	<div class="ensemble_btns">
	<form action="ajout_gm.php">
		<button>Ajouter un compte de Game Master</button>
	</form>
	<br>
	<form action="suppr_gm.php">
		<button>Supprimer mon compte de Game Master</button>
	</form>
	</div>
	<br>
	<div class="ensemble_btns">
	<form action="eteindre_tel.php">
		<button>Éteindre le téléphone</button>
	</form><br>
	<form action="reboot_tel.php">
		<button>Redémarrer le téléphone</button>
	</form>
	</div>
	</center>
<?php
include "footer.php";
}

?>
