<?php
	echo "Message : ".$_POST['message'];
	//on vérifie que le message fait bien moins de 500 caractères
	$str = "sudo python /var/www/html/sonnerie.py 0 ";
	exec($str."\"".addslashes($_POST['message'])."\"");
	//appel de exec avec en paramètre le message complet

	//coté téléphone, on fait sonner le buzzer tant que le HP est raccroché puis on lit le message
	//enfin, on redirige vers l'interface de la partie
	header("Location: interface_partie.php");
?>
