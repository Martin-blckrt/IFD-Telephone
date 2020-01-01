<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=telephone;charset=utf8','root','KqJ=4^QDf6._~]ET^k5u', 
		array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
	die('Erreur : '.$e->getMessage());
}
?>