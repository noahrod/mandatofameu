<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editconsuladodevolucion"] != "" && $_POST["editnumerodecomunicaciondevolucion"] != "" && $_POST["edittipodedevolucion"] != "" && $_POST["editcantidaddevolucion"] != "" && $_POST["editproveedordevolucion"] != "" && $_POST["devid"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['editimagencomunicacioncheque']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['editimagencomunicacioncheque']['tmp_name']));
			$sql_insert = "UPDATE `devoluciones` SET `consulado` = '".$_POST["editconsuladodevolucion"]."', `numerocomunicacion` = '".$_POST["editnumerodecomunicaciondevolucion"]."', `proveedor` = '".$_POST["editproveedordevolucion"]."',`tipodevolucion` = '".$_POST["edittipodedevolucion"]."',`cantidad` = '".$_POST["editcantidaddevolucion"]."', `escaneo` = '".$imgData."', `fecha` = '".$_POST["editfechadedevolucion"]."' WHERE `devoluciones`.`id` = " . $_POST["devid"];
		}else{
			$sql_insert = "UPDATE `devoluciones` SET `consulado` = '".$_POST["editconsuladodevolucion"]."', `numerocomunicacion` = '".$_POST["editnumerodecomunicaciondevolucion"]."', `proveedor` = '".$_POST["editproveedordevolucion"]."',`tipodevolucion` = '".$_POST["edittipodedevolucion"]."',`cantidad` = '".$_POST["editcantidaddevolucion"]."', `fecha` = '".$_POST["editfechadedevolucion"]."' WHERE `devoluciones`.`id` = " . $_POST["devid"];
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=devoluciones");
	}
}
?>