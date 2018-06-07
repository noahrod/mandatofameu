<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["numerodecorreo"] != "" && $_POST["fechadesolicitud"] != "" && $_POST["ingresos"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['imagenautorizacion']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['imagenautorizacion']['tmp_name']));
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql_insert = "INSERT INTO `autorizaciones` (`id`, `imagen`, `numerodecorreo`, `fechadesolicitud`, `ingresos`) VALUES (NULL,'".$imgData."' , '".$_POST["numerodecorreo"]."','".$_POST["fechadesolicitud"]."', '".$_POST["ingresos"]."')";
			$conn->query($sql_insert);
			header("Location: system.php?l=autorizaciones&ev=newsuccess");
		}
	}
}
?>