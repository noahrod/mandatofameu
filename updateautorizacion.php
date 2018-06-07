<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnumerodecorreo"] != "" && $_POST["editfechadesolicitud"] != "" && $_POST["editingresos"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['editimagenautorizacion']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['editimagenautorizacion']['tmp_name']));
			$sql_insert = "UPDATE `autorizaciones` SET `numerodecorreo` = '".$_POST["editnumerodecorreo"]."', `fechadesolicitud` = '".$_POST["editfechadesolicitud"]."', `ingresos` = '".$_POST["editingresos"]."', `imagen` = '".$imgData."' WHERE `autorizaciones`.`id` = " . $_POST["aid"];
		}else{
			$sql_insert = "UPDATE `autorizaciones` SET `numerodecorreo` = '".$_POST["editnumerodecorreo"]."', `fechadesolicitud` = '".$_POST["editfechadesolicitud"]."', `ingresos` = '".$_POST["editingresos"]."' WHERE `autorizaciones`.`id` = " . $_POST["aid"];
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=autorizaciones");
	}
}
?>