<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editautorizacioncheque"] != "" && $_POST["editconsuladocheque"] != "" && $_POST["editproveedorcheque"] != "" && $_POST["editnumerodecheque"] != "" && $_POST["editcantidadcheque"] != "" && $_POST["chid"] != ""){
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql_insert = "UPDATE `cheques` SET `autorizacioncheque` = '".$_POST["editautorizacioncheque"]."', `consuladocheque` = '".$_POST["editconsuladocheque"]."', `proveedorcheque` = '".$_POST["editproveedorcheque"]."', `numerodecheque` = '".$_POST["editnumerodecheque"]."', `cantidadcheque` = '".$_POST["editcantidadcheque"]."' WHERE `cheques`.`id` = ".$_POST["chid"].";";
	$conn->query($sql_insert);
	header("Location: system.php?l=cheques");
}
?>