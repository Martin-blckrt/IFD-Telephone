<?php
	echo $_POST['bande'];
	//appel de exec avec en paramètre l'ID de la bande son
	$str = "sudo python /var/www/html/sonnerie.py 1 ";
	exec($str."\"".$_POST['bande']."\"");
	//coté téléphone, on fait sonner le buzzer tant que le HP est raccroché puis on lance la bande son
	//enfin, on redirige vers l'interface de la partie
	header("Location: interface_partie.php");
?>
