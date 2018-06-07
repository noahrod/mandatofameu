<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editchequesenvio"] != "" && $_POST["editdestino"] != "" && $_POST["editfechadeenvio"] != "" && $_POST["edittracking"] != "" && $_POST["enid"] != ""){
	if($_FILES['editimagencheque']['size'] > 0 || $_FILES['editimagenetiqueta']['size'] > 0) {
		$firstfile = 0;
		$secondfile = 0;
		if(is_uploaded_file($_FILES['editimagencheque']['tmp_name'])) {
			$imgDataCheque =addslashes(file_get_contents($_FILES['editimagencheque']['tmp_name']));
			$firstfile = 1;
		}
		if(is_uploaded_file($_FILES['editimagenetiqueta']['tmp_name'])) {
			$imgDataEtiqueta =addslashes(file_get_contents($_FILES['editimagenetiqueta']['tmp_name']));
			$secondfile = 1;
		}
		if($firstfile && $secondfile){
			$sql_insert="UPDATE `envios` SET `destino` = '".$_POST["editdestino"]."', `fechadeenvio` = '".$_POST["editfechadeenvio"]."', `tracking` = '".$_POST["edittracking"]."', `cheque` = '".$_POST["editchequesenvio"]."', `imagencheque` = '".$imgDataCheque."', `imagenetiqueta` = '".$imgDataEtiqueta."' WHERE `envios`.`id` = ".$_POST["enid"].";";
			//echo $sql_insert;
		}else{
			if($firstfile){
				$sql_insert="UPDATE `envios` SET `destino` = '".$_POST["editdestino"]."', `fechadeenvio` = '".$_POST["editfechadeenvio"]."', `tracking` = '".$_POST["edittracking"]."', `cheque` = '".$_POST["editchequesenvio"]."', `imagencheque` = '".$imgDataCheque."' WHERE `envios`.`id` = ".$_POST["enid"].";";
				//echo $sql_insert;
			}
			if($secondfile){
				$sql_insert="UPDATE `envios` SET `destino` = '".$_POST["editdestino"]."', `fechadeenvio` = '".$_POST["editfechadeenvio"]."', `tracking` = '".$_POST["edittracking"]."', `cheque` = '".$_POST["editchequesenvio"]."', `imagenetiqueta` = '".$imgDataEtiqueta."' WHERE `envios`.`id` = ".$_POST["enid"].";";
				//echo $sql_insert;
			}
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=envios");
	}else{
		$sql_insert="UPDATE `envios` SET `destino` = '".$_POST["editdestino"]."', `fechadeenvio` = '".$_POST["editfechadeenvio"]."', `tracking` = '".$_POST["edittracking"]."', `cheque` = '".$_POST["editchequesenvio"]."' WHERE `envios`.`id` = ".$_POST["enid"].";";
		//echo $sql_insert;
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=envios");
	}
}


?>


