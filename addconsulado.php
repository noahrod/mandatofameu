<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["ubicacionconsulado"] != "" && $_POST["calleynumero"] != "" && $_POST["ciudad"] != "" && $_POST["estado"] != "" && $_POST["codigopostal"] != "" && $_POST["telefono"] != "" ){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_insert = "INSERT INTO `consulados` (`id`, `ubicacion`, `calleynumero`, `ciudad`, `estado`, `codigopostal`, `telefono`) VALUES (NULL, '".$_POST["ubicacionconsulado"]."', '".$_POST["calleynumero"]."', '".$_POST["ciudad"]."', '".$_POST["estado"]."', '".$_POST["codigopostal"]."', '".$_POST["telefono"]."');";
		$conn->query($sql_insert);
		header("Location: system.php?l=consulados&ev=newsuccessConsulate");
		
}
?>