<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["numerodeconfirmacion"] != ""){
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql_insert = "INSERT INTO `transferencias` (`id`, `confirmacion`, `destino`, `fechadeenvio`, `autorizacion`, `consulado`, `cantidad`) VALUES (NULL, '".$_POST['numerodeconfirmacion']."', '".$_POST['destino']."', '".$_POST['fechadeenvio']."', '".$_POST['autorizaciontransferencia']."', '".$_POST['consuladotransferencia']."', '".$_POST['cantidadtransferencia']."');";
	$conn->query($sql_insert);
	header("Location: system.php?l=transferencias&ev=newsuccessTransferencia");
}
?>