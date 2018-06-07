<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["cancelarcheque"] != "" && $_POST["razoncancelarcheque"] != "" ){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['chequecanceladoscan']['tmp_name']) && is_uploaded_file($_FILES['comunicacionchequecanceladoscan']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['chequecanceladoscan']['tmp_name']));
			$imgData1 =addslashes(file_get_contents($_FILES['comunicacionchequecanceladoscan']['tmp_name']));
			$connupdate = new mysqli($servername, $username, $password, $dbname);
			if ($connupdate->connect_error) {
			    die("Connection failed: " . $connupdate->connect_error);
			}
			$sql_update = "UPDATE `cheques` SET `cancelado` = '1' WHERE `cheques`.`id` =" . $_POST["cancelarcheque"];
			$connupdate->query($sql_update);
			$conninsert = new mysqli($servername, $username, $password, $dbname);
			if ($conninsert->connect_error) {
			    die("Connection failed: " . $conninsert->connect_error);
			}
			$sql_insert = "INSERT INTO `chequescancelados` (`id`, `chequeid`, `razon`, `chequecancelado`, `comunicacion`) VALUES (NULL, '".$_POST["cancelarcheque"]."', '".$_POST["razoncancelarcheque"]."', '".$imgData."', '".$imgData1."');";
			$conninsert->query($sql_insert);
		
			header("Location: system.php?l=cheques");
		}
	}
}
?>