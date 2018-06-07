<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnumerodeconfirmacion"] != "" && $_POST["tid"] != ""){
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql_insert = "UPDATE `transferencias` SET `confirmacion` = '".$_POST["editnumerodeconfirmacion"]."', `destino` = '".$_POST["editdestino"]."', `fechadeenvio` = '".$_POST["editfechadeenvio"]."', `autorizacion` = '".$_POST["editautorizaciontransferencia"]."', `consulado` = '".$_POST["editconsuladotransferencia"]."', `cantidad` = '".$_POST["editcantidadtransferencia"]."' WHERE `transferencias`.`id` = ".$_POST["tid"].";";
	$conn->query($sql_insert);
	header("Location: system.php?l=transferencias");
}
?>