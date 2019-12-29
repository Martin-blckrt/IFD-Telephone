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

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
		$(document).ready(function(){
			$("#div_refresh").load("tableau_enigmes.php");
			setInterval(function() {
				$("#div_refresh").load("tableau_enigmes.php");
			}, 2000);
		});
	</script>

	<script>
			document.addEventListener("DOMContentLoaded", function(event) {
			document.getElementById('send').disabled = "true";
			document.getElementById('send2').disabled = "true";
			});

			function myFunction() {
			    var nameInput = document.getElementById('name').value;
			    console.log(nameInput);
			    if (nameInput === "") {
			        document.getElementById('send').disabled = true;
				document.getElementById('send').style.background='#E1E1E1';
			    } else {
			        document.getElementById('send').disabled = false;
 				document.getElementById('send').style.background='#34C800';

			    }
			}

			function myFunction2() {
				document.getElementById('send2').disabled = false;
				document.getElementById('send2').style.background='#34C800';

			}

			function AppuiBtnBandes(){
				document.getElementById('send2').style.background='#FF8000';
				document.getElementById('send2').innerHTML = "En attente de décrochage... La page rechargera une fois la bande son jouée";

			}

			function AppuiBtnMessage(){
				var Btn = document.getElementById("send");
				Btn.disabled= true;
				Btn.style.background='#FF8000';
				Btn.innerHTML = "En attente de décrochage... La page rechargera une fois le message lu";
			}

			
	</script>
</head>

<body>
	<?php
	include 'header.php';
	?>
	<h1>Interface de commande du téléphone - <font color="#0AFF0A">PARTIE EN COURS</font></h1>
	<p class="temoin_connexion"><u><b>Game Master connecté :</b></u>
		<?php
		echo " ".$_SESSION['connected_gm_prenom'] . " " . $_SESSION['connected_gm_nom'];
		?>
	</p>
	<div class="parent">
		<div id="div_refresh" class="tableau_enigmes"></div>
		<div class="cartoucheur">
		<form action="lancer_bande_son.php" method="post">
		<table>
			<thead>
				<tr>
					<th colspan="2"><font size="5pt">BANDES SONS</font></th>
				</tr>
				<tr>
					<th colspan="2"><i>Pour faire sonner le téléphone chez les joueurs et lancer un son lorsqu'ils décrochent, cochez premièrement une bande son dans la liste ci-dessous puis appuyez sur le bouton "FAIRE SONNER ET LANCER LE SON"</i></th>
				</tr>
				<tr>
					<th colspan="2">
					<button onclick="AppuiBtnBandes"  type="submit" id="send2" style="font-weight: bold; font-size: 13pt;">FAIRE SONNER ET LANCER LE SON</button>
				</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				$requete = $bdd->prepare('SELECT ID,titre FROM bandes_son ORDER BY titre');
				$requete->execute();
				while ($donnees = $requete->fetch()){
					?>
					<tr>
						<td>
							<input class="double" onclick="myFunction2()" type="radio" name="bande" value= <?php echo "\"".$donnees['ID']."\""; ?>>
						</td>
					<td>
					<h3><?php echo $donnees['titre']; ?></h3>
					<audio controls><source src=<?php echo "bandes_sons/".$donnees['ID'].".mp3"; ?> type="audio/mpeg"/></audio>		
					</td></tr>
						<?php
					}

					?>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	<div style="margin-top: 50px;">
		<form action="lire_message.php" method="post">
			<table>
				<thead>
					<tr>
						<th colspan="2"><font size="5pt">MESSAGE SYNTHÉTISÉ EN DIRECT</font></th>
					</tr>
					<tr>
						<th colspan="2"><p>Pour faire sonner le téléphone chez les jouers et faire lire un message par une voix synthétique, tapez votre message ci-dessous puis appuyez sur le bouton "FAIRE SONNER ET LIRE LE MESSAGE"</p></th>
					</tr>
					<tr>
						<th colspan="2">
						<button type="submit" onclick="AppuiBtnMessage()" id="send" style="font-weight: bold; font-size: 13pt;">FAIRE SONNER PUIS LIRE LE MESSAGE</font></b></button>
					</th>
				</thead>
				<tbody>
					<tr>
						<td>
							<input id="name" maxlength="200" style="width: 100%; height: 100%;" name="message" placeholder="Saisissez votre message ici... (200 caractères max.)" onkeyup="myFunction()">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<br>
		<button onclick="window.print();return false;"><b>Imprimer le rapport de partie</b></button>
		<br>
		<form action="cloture_partie.php">
			<button type="submit"><font color="red">Cloturer la partie</font></button>
		</form>
	</body>
	</html>
