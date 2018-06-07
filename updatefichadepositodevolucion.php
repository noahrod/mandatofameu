<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['imagenfichadepositodevolucion']['tmp_name']) && $_POST["fddevid"] != "") {
			$imgData =addslashes(file_get_contents($_FILES['imagenfichadepositodevolucion']['tmp_name']));
			$sql_insert = "UPDATE `devoluciones` SET `fichadeposito` = '".$imgData."' WHERE `devoluciones`.`id` = " . $_POST["fddevid"];
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=devoluciones");
	}
?>