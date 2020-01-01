<!DOCTYPE html>
<html>
<head>
	<title>Ajout énigme</title>
	<link rel="icon" href="favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
	include "header.php";
	?>
	<h1>Ajouter une énigme à l'Escape Room</h1>
	<center>
		<?php
		$erreur = 1;
		if(!empty($_POST)){
			if(empty($_POST['nom_enigme'])){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le nom de l'énigme</p>";
			}
			if(empty($_POST['type_signal'])){
				echo "<p class=\"erreur\">Vous n'avez pas choisi le type de signal de fin</p>";
			}
			if(empty($_POST['type_indice_1'])){
				echo "<p class=\"erreur\">Vous n'avez pas choisi le type d'indice 1</p>";
			}
			if(empty($_POST['type_indice_2'])){
				echo "<p class=\"erreur\">Vous n'avez pas choisi le type d'indice 2</p>";
			}
			if(empty($_POST['type_message_fin'])){
				echo "<p class=\"erreur\">Vous n'avez pas choisi le type de message de fin</p>";
			}
			if(empty($_POST['num_tel'])){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le numéro à composer sur le téléphone</p>";
			}
			if($_POST['num_tel']<=0 OR $_POST['num_tel']>999){
				echo "<p class=\"erreur\">Le numéro de téléphone que vous avez choisi est incorrect</p>";
			}
		}
		if(!empty($_POST['nom_enigme']) AND !empty($_POST['type_signal']) AND !empty($_POST['type_indice_1']) AND !empty($_POST['type_indice_2']) AND !empty($_POST['type_message_fin']) AND !empty($_POST['num_tel'])){
			include("connexion_bdd.php");
			$reqprep = $bdd->prepare('SELECT ID FROM enigmes WHERE nom = ?');
			$reqprep->execute(array($_POST['nom_enigme']));
			if(!empty($reqprep->fetch())){
				echo "<p class=\"erreur\">Ce nom d'énigme est déjà utilisé, veuillez en choisir un autre.</p>";
			}
			else{
				$reqprep = $bdd->prepare('SELECT ID FROM enigmes WHERE numero_tel = ?');
				$reqprep->execute(array($_POST['num_tel']));
				if(!empty($reqprep->fetch())){
					echo "<p class=\"erreur\">Ce numéro de téléphone est déjà utilisé par une autre énigme, veuillez en choisir un autre.</p>";
				}else{
					$erreur = 0;
					?>
					<div class="formulaire" >
						<form method="POST" action="record_enigme.php" enctype="multipart/form-data">
							<input type="hidden" name="nom_enigme" value=<?php echo "\"".$_POST['nom_enigme']."\""; ?>>
							<input type="hidden" name="type_signal" value=<?php echo "\"".$_POST['type_signal']."\""; ?>>
							<input type="hidden" name="type_indice_1" value=<?php echo "\"".$_POST['type_indice_1']."\""; ?>>
							<input type="hidden" name="type_indice_2" value=<?php echo "\"".$_POST['type_indice_2']."\""; ?>>
							<input type="hidden" name="type_message_fin" value=<?php echo "\"".$_POST['type_message_fin']."\""; ?>>
							<input type="hidden" name="num_tel" value=<?php echo "\"".$_POST['num_tel']."\""; ?>>
							<?php
							if($_POST['type_signal']=="auto") {
								?>
								<label><u>Topic MQTT :</u></span>&nbsp<input type="text" name="topic_MQTT"> <i><u>Note :</u> Le topic MQTT doit être renseigné ici pour cloturer automatiquement l'énigme. L'adresse IP du brocker MQTT doit être paramétrée dans le menu de configuration de l'Escape Room et doit être la même sur toutes les énigmes à cloture automatique.</i></label><br><br>
								<?php
							}
							switch ($_POST['type_indice_1']) {
								case 'texte':
								?>
								<label><u>Indice 1 :</u>&nbsp<textarea name="texte_indice_1"  maxlength="200" rows="3" cols="50" placeholder="Tapez ici le texte que vous voulez lire sur le téléphone en tant qu'indice de niveau 1 (200 caractères max). ATTENTION les accents sont interdits !"></textarea></label><br><br>
								<?php
								break;
								case 'son':
								?>
								<label><u>Indice 1 :</u>&nbsp<i>Chargez la bande son (format .mp3, 1Mo max)</i>
									<input type="file" name="son_indice_1" /></label><br><br>
									<?php
									break;
								}
								switch ($_POST['type_indice_2']) {
									case 'texte':
									?>
									<label><u>Indice 2 :</u>&nbsp<textarea name="texte_indice_2" maxlength="200" rows="3" cols="50" placeholder="Tapez ici le texte que vous voulez lire sur le téléphone en tant qu'indice de niveau 2 (200 caractères max). ATTENTION les accents sont interdits !"></textarea></label><br><br>
									<?php
									break;
									case 'son':
									?>
									<label><u>Indice 2 :</u>&nbsp<i>Chargez la bande son (format .mp3, 1Mo max)</i>
										<input type="file" name="son_indice_2" /></label><br><br>
										<?php
										break;
									}
									switch ($_POST['type_message_fin']) {
										case 'texte':
										?>
										<label><u>Message de fin :</u>&nbsp<textarea name="texte_message_fin"  maxlength="200" rows="3" cols="50" placeholder="Tapez ici le texte que vous voulez lire sur le téléphone lorsque l'énigme est cloturée (200 caractères max). ATTENTION les accents sont interdits !"></textarea></label><br><br>
										<?php
										break;
										case 'son':
										?>
										<label><u>Message de fin :</u>&nbsp<i>Chargez la bande son (format .mp3, 1Mo max)</i>
											<input type="file" name="son_message_fin" /></label><br><br>
											<?php
											break;
										}
										?>
										<br><br>
										<button type="submit" style="position: relative; left: 40%;"><b>Enregistrer l'énigme</b></button>
									</form>
								</div>
								<?php
							}
							
						}
					}
					?>
					<br>
					<form action="ajout_enigme.php"><button type="submit">Retour</button></form>

				</center>
				<?php
				include "footer.php";
				?>
			</body>
			</html>
