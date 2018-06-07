<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["autorizacioncheque"] != "" && $_POST["consuladocheque"] != "" && $_POST["proveedorcheque"] != "" && $_POST["numerodecheque"] != "" && $_POST["cantidadcheque"] != ""){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_insert = "INSERT INTO `cheques` (`id`, `autorizacioncheque`, `consuladocheque`, `proveedorcheque`, `numerodecheque`, `cantidadcheque`, `fecha`, `cobrado`, `cancelado`) VALUES (NULL, '".$_POST["autorizacioncheque"]."', '".$_POST["consuladocheque"]."', '".$_POST["proveedorcheque"]."', '".$_POST["numerodecheque"]."', '".$_POST["cantidadcheque"]."', CURRENT_TIMESTAMP,0,0);";
		$conn->query($sql_insert);
		header("Location: system.php?l=cheques&ev=newsuccessCheques");
		
}
?>