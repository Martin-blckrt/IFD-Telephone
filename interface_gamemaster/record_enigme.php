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
		function clean($string, $charset='utf-8')
			{
				$string = str_replace('"', " ", $string);
				$string = str_replace("'", " ", $string);
				$string = htmlentities( $string, ENT_NOQUOTES, $charset );
    
				$string = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string );
				$string = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $string );
				$string = preg_replace( '#&[^;]+;#', '', $string );
				return $string;
			}
			
		$erreur = 0;
		if(!empty($_POST)){
			//on vérifie la présence des éventuelles données textuelles
			if(empty($_POST['topic_MQTT']) AND $_POST['type_signal']=="auto"){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le topic MQTT.</p>";
				$erreur = 1;	
			}
			if(empty($_POST['texte_indice_1']) AND $_POST['type_indice_1']=="texte"){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le texte de l'indice 1.</p>";
				$erreur = 1;
			}
			if(empty($_POST['texte_indice_2']) AND $_POST['type_indice_2']=="texte"){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le texte de l'indice 2.</p>";
				$erreur = 1;
			}
			if(empty($_POST['texte_message_fin']) AND $_POST['type_message_fin']=="texte"){
				echo "<p class=\"erreur\">Vous n'avez pas saisi le texte du message de fin.</p>";
				$erreur = 1;
			}
			//on vérifie la présence des éventuels fichiers
			if($_POST['type_indice_1']=="son" AND empty($_FILES['son_indice_1']['name'])){
				echo "<p class=\"erreur\">Vous n'avez pas importé la bande son de l'indice 1.</p>";
				$erreur = 1;
			}
			if($_POST['type_indice_2']=="son" AND empty($_FILES['son_indice_2']['name'])){
				echo "<p class=\"erreur\">Vous n'avez pas importé la bande son de l'indice 2.</p>";
				$erreur = 1;
			}
			if($_POST['type_message_fin']=="son" AND empty($_FILES['son_message_fin']['name'])){
				echo "<p class=\"erreur\">Vous n'avez pas importé la bande son du message de fin.</p>";
				$erreur = 1;
			}
			//on vérifie que les fichiers éventuels sont bien de taille inférieure ou égale à 1 Mo
			if($_POST['type_indice_1']=="son" AND $_FILES['son_indice_1']['size']>1000000){	//on limite la taille des bandes son à 1Mo
				echo "<p class=\"erreur\">La taille de la bande son de l'indice 1 dépasse 1 Mo.</p>";
				$erreur = 1;
			}
			if($_POST['type_indice_2']=="son" AND $_FILES['son_indice_2']['size']>1000000){
				echo "<p class=\"erreur\">La taille de la bande son de l'indice 2 dépasse 1 Mo.</p>";
				$erreur = 1;
			}
			if($_POST['type_message_fin']=="son" AND $_FILES['son_message_fin']['size']>1000000){
				echo "<p class=\"erreur\">La taille de la bande son du message de fin dépasse 1 Mo.</p>";
				$erreur = 1;
			}
			//on vérifie que les fichiers éventuels sont bien au format .mp3
			if($_POST['type_indice_1']=="son" AND $_FILES['son_indice_1']['type']!="audio/mpeg"){
				echo "<p class=\"erreur\">Le fichier importé en tant que bande son pour l'indice 1 n'est pas au format .mp3</p>";
				$erreur = 1;
			}
			if($_POST['type_indice_2']=="son" AND $_FILES['son_indice_2']['type']!="audio/mpeg"){
				echo "<p class=\"erreur\">Le fichier importé en tant que bande son pour l'indice 2 n'est pas au format .mp3</p>";
				$erreur = 1;
			}
			if($_POST['type_message_fin']=="son" AND $_FILES['son_message_fin']['type']!="audio/mpeg"){
				echo "<p class=\"erreur\">Le fichier importé en tant que bande son pour le message de fin n'est pas au format .mp3</p>";
				$erreur = 1;
			}

			//on vérifie que les fichiers éventuels sont bien au format .mp3
			if($_POST['type_indice_1']=="son" AND $_FILES['son_indice_1']['error']!=0){
				echo "<p class=\"erreur\">Une erreur est survenue lors de l'importation de la bande son de l'indice 1. Veuillez réessayer avec un fichier plus léger. Code d'erreur : ".$_FILES['son_indice_1']['error']."</p>";
				$erreur = 1;
			}
			if($_POST['type_indice_2']=="son" AND $_FILES['son_indice_2']['error']!=0){
				echo "<p class=\"erreur\">Une erreur est survenue lors de l'importation de la bande son de l'indice 2. Veuillez réessayer avec un fichier plus léger. Code d'erreur : ".$_FILES['son_indice_2']['error']."</p>";
				$erreur = 1;
			}
			if($_POST['type_message_fin']=="son" AND $_FILES['son_message_fin']['error']!=0){
				echo "<p class=\"erreur\">Une erreur est survenue lors de l'importation de la bande son du message de fin. Veuillez réessayer avec un fichier plus léger. Code d'erreur : ".$_FILES['son_message_fin']['error']."</p>";
				$erreur = 1;
			}
			
			//on vérifie que les textes d'indices et de messages de fin sont de longueur <= 200 caractères
			if(!empty($_POST['texte_indice_1']) AND strlen($_POST['type_indice_1'])>200){
				echo "<p class=\"erreur\">Le texte saisi en tant qu'indice 1 dépasse les 200 caractères.</p>";
				$erreur = 1;
			}
			if(!empty($_POST['texte_indice_2']) AND strlen($_POST['type_indice_2'])>200){
				echo "<p class=\"erreur\">Le texte saisi en tant qu'indice 2 dépasse les 200 caractères.</p>";
				$erreur = 1;
			}
			if(!empty($_POST['texte_message_fin']) AND strlen($_POST['texte_message_fin'])>200){
				echo "<p class=\"erreur\">Le texte saisi en tant que message de fin dépasse les 200 caractères.</p>";
				$erreur = 1;
			}
			
			if(!empty($_POST['texte_indice_1']) AND $_POST['type_indice_1']!=clean($_POST['type_indice_1'])){
				echo "<p class=\"warning\">Le texte saisi en tant qu'indice 1 contenait des accents et d'autres caractères spéciaux qui ont été supprimés automatiquement, attention cela peut changer la prononciation !</p>";
			}
			if(!empty($_POST['texte_indice_2']) AND $_POST['type_indice_2']!=clean($_POST['type_indice_2'])){
				echo "<p class=\"warning\">Le texte saisi en tant qu'indice 2 contenait des accents et d'autres caractères spéciaux qui ont été supprimés automatiquement, attention cela peut changer la prononciation !</p>";
			}
			if(!empty($_POST['texte_message_fin']) AND $_POST['texte_message_fin']!=clean($_POST['texte_message_fin'])){
				echo "<p class=\"warning\">Le texte saisi en tant que message de fin contenait des accents et d'autres caractères spéciaux qui ont été supprimés automatiquement, attention cela peut changer la prononciation !</p>";
			}
			
			
		}

		if($erreur){
			echo "<form action=\"ajout_enigme.php\"><button type=\"submit\">Recommencer</button></form>";
		}
		else{
			$erreur = 0;
			include("connexion_bdd.php");
			$req = $bdd->prepare('SELECT MAX(ID) AS next FROM enigmes');
			$req->execute();
			$rep = $req->fetch();

			$next_id = $rep['next']+1;
			switch ($_POST['type_signal']) {
				case 'auto':
					$type_signal_fin = 1;
					$new_topic_MQTT = $_POST['topic_MQTT'];
					break;
				
				case 'manu':
					$type_signal_fin = 0;
					$new_topic_MQTT = NULL;
					break;
			}

			switch ($_POST['type_indice_1']) {
				case 'texte':
					$texte_ind1 = $_POST['texte_indice_1'];
					$new_type_ind1 = 1;
					break;
				
				case 'son':
					move_uploaded_file($_FILES['son_indice_1']['tmp_name'], 'sons_enigmes/indices_1/'.$next_id.'.mp3');
					$texte_ind1 = NULL;
					$new_type_ind1 = 2;
					break;
				default:
					$texte_ind1 = NULL;
					$new_type_ind1 = 0;
					break;
			}

			switch ($_POST['type_indice_2']) {
				case 'texte':
					$texte_ind2 = $_POST['texte_indice_2'];
					$new_type_ind2 = 1;
					break;
				
				case 'son':
					move_uploaded_file($_FILES['son_indice_2']['tmp_name'], 'sons_enigmes/indices_2/'.$next_id.'.mp3');
					$texte_ind2 = NULL;
					$new_type_ind2 = 2;
					break;
				default:
					$texte_ind2 = NULL;
					$new_type_ind2 = 0;
					break;
			}

			switch ($_POST['type_message_fin']) {
				case 'texte':
					$texte_mf = $_POST['texte_message_fin'];
					$new_type_mf = 1;
					break;
				
				case 'son':
					move_uploaded_file($_FILES['son_message_fin']['tmp_name'], 'sons_enigmes/messages_fin/'.$next_id.'.mp3');
					$texte_mf = NULL;
					$new_type_mf = 2;
					break;
				default:
					$texte_mf = NULL;
					$new_type_mf = 0;
					break;
			}

			$reqprep = $bdd->prepare('SELECT COUNT(ID) AS total FROM enigmes');
			$reqprep->execute();
			$rep = $reqprep->fetch();
			$new_ordre=$rep['total']+1;

			$requete = $bdd->prepare('INSERT INTO enigmes(ID, nom, ordre_apparition, type_signal_fin, numero_tel, topic_MQTT, type_indice_1, texte_indice_1, type_indice_2, texte_indice_2, type_message_fin, texte_message_fin) VALUES (:newID, :newNom, :newOrdre, :newTypeSignalFin, :newNumeroTel, :newTopic, :newTypeInd1, :newTexteInd1, :newTypeInd2, :newTexteInd2, :newTypeMF, :newTexteMF)');
			$requete->execute(array(
				'newID' => $next_id,
				'newNom' => $_POST['nom_enigme'],
				'newOrdre' => $new_ordre,
				'newTypeSignalFin' => $type_signal_fin,
				'newNumeroTel' => $_POST['num_tel'],
				'newTopic' => $new_topic_MQTT,
				'newTypeInd1' => $new_type_ind1,
				'newTexteInd1' => clean($texte_ind1),
				'newTypeInd2' => $new_type_ind2,
				'newTexteInd2' => clean($texte_ind2),
				'newTypeMF' => $new_type_mf,
				'newTexteMF' => clean($texte_mf)
			));

			echo "<p class=\"succes\">L'énigme a été ajoutée avec succès. Par défaut, elle a été placée en dernière dans l'ordre d'apparition. Vous pouvez modifier cet ordre à partir du menu de configuration de l'Escape Room.</p>";
			echo "<form action=\"config_room.php\"><button type=\"submit\">Retour au menu de configuration</button></form>";	
		}
		?>
	</center>
</body>
</html>

<?php
include "footer.php";
?>
