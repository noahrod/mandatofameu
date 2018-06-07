<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["destino"] != "" && $_POST["fechadeenvio"] != "" && $_POST["tracking"] != "" && $_POST["chequesenvio"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['imagencheque']['tmp_name']) && is_uploaded_file($_FILES['imagenetiqueta']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['imagencheque']['tmp_name']));
			$imgData1 =addslashes(file_get_contents($_FILES['imagenetiqueta']['tmp_name']));
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql_insert = "INSERT INTO `envios` (`id`, `imagencheque`, `destino`, `imagenetiqueta`, `fechadeenvio`, `tracking`, `cheque`, `status`) VALUES (NULL, '".$imgData."', '".$_POST["destino"]."','".$imgData1."' , '".$_POST["fechadeenvio"]."', '".$_POST["tracking"]."', '".$_POST["chequesenvio"]."', 0);";
			$conn->query($sql_insert);
			//echo $sql_insert;
			header("Location: system.php?l=envios&ev=newsuccessEnvio");
		}
	}
}
?>