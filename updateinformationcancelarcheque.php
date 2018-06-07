<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
//echo "a";
include "connect.php";
if($_POST["cciaf"] != "" && $_POST["editrazoncancelarcheque"] != ""){
	//echo "b";
	if($_FILES['editchequecanceladoscan']['size'] > 0 || $_FILES['editcomunicacionchequecanceladoscan']['size'] > 0) {
		$firstfile = 0;
		$secondfile = 0;
		//echo "c";
		if(is_uploaded_file($_FILES['editchequecanceladoscan']['tmp_name'])) {
			$imgData1 =addslashes(file_get_contents($_FILES['editchequecanceladoscan']['tmp_name']));
			$firstfile = 1;
			//echo "d";
		}
		if(is_uploaded_file($_FILES['editcomunicacionchequecanceladoscan']['tmp_name'])) {
			$imgData2 =addslashes(file_get_contents($_FILES['editcomunicacionchequecanceladoscan']['tmp_name']));
			$secondfile = 1;
			//echo "e";
		}
		if($firstfile && $secondfile){
			$sql_insert="UPDATE `chequescancelados` SET `razon` = '".$_POST["editrazoncancelarcheque"]."', `chequecancelado` = '".$imgData1."', `comunicacion` = '".$imgData2."' WHERE `chequescancelados`.`chequeid` = ".$_POST["cciaf"].";";
			//echo $sql_insert;
		}else{
			if($firstfile){
				$sql_insert="UPDATE `chequescancelados` SET `razon` = '".$_POST["editrazoncancelarcheque"]."', `chequecancelado` = '".$imgData1."' WHERE `chequescancelados`.`chequeid` = ".$_POST["cciaf"].";";
				//echo $sql_insert;
			}
			if($secondfile){
				$sql_insert="UPDATE `chequescancelados` SET `razon` = '".$_POST["editrazoncancelarcheque"]."', `comunicacion` = '".$imgData2."' WHERE `chequescancelados`.`chequeid` = ".$_POST["cciaf"].";";
				//echo $sql_insert;
			}
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=cheques");
	}else{
		$sql_insert="UPDATE `chequescancelados` SET `razon` = '".$_POST["editrazoncancelarcheque"]."' WHERE `chequescancelados`.`chequeid` = ".$_POST["cciaf"].";";
		//echo $sql_insert;
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=cheques");
	}
}


?>