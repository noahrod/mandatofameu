<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editubicacionconsulado"] != "" && $_POST["editcalleynumero"] != "" && $_POST["editciudad"] != "" && $_POST["editestado"] != "" && $_POST["editcodigopostal"] != "" && $_POST["edittelefono"] != "" && $_POST["cid"] != ""){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_update = "UPDATE `consulados` SET `ubicacion` = '".$_POST["editubicacionconsulado"]."', `calleynumero` = '".$_POST["editcalleynumero"]."', `ciudad` = '".$_POST["editciudad"]."', `estado` = '".$_POST["editestado"]."', `codigopostal` = '".$_POST["editcodigopostal"]."', `telefono` = '".$_POST["edittelefono"]."' WHERE `consulados`.`id` = '".$_POST["cid"]."';";
		$conn->query($sql_update);
		header("Location: system.php?l=consulados");
		
}
?>