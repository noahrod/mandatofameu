<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnombreproveedor"] != "" &&  $_POST["editconsuladoproveedor"] != "" ){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_insert = "UPDATE `proveedores` SET `nombreproveedor` = '".$_POST["editnombreproveedor"]."', `personaautorizadarecursosfinancieros` = '".$_POST["editpersonaautorizadarecursosfinancieros"]."', `personaparaestablecercontacto` = '".$_POST["editpersonaparaestablecercontacto"]."', `telefonocontacto` = '".$_POST["edittelefonocontacto"]."', `emailcontacto` = '".$_POST["editemailcontacto"]."', `calleynumero` = '".$_POST["editcalleynumero"]."', `ciudad` = '".$_POST["editciudad"]."', `estado` = '".$_POST["editestado"]."', `codigopostal` = '".$_POST["editcodigopostal"]."', `telefono` = '".$_POST["edittelefono"]."', `nombredelbanco` = '".$_POST["editnombredelbanco"]."', `sucursal` = '".$_POST["editsucursal"]."', `numerodecuenta` = '".$_POST["editnumerodecuenta"]."', `claveinterbancaria` = '".$_POST["editclaveinterbancaria"]."', `consuladoproveedor` = '".$_POST["editconsuladoproveedor"]."', `programaproveedor` = '".$_POST["editprogramaproveedor"]."' WHERE `proveedores`.`id` = ".$_POST["proveid"].";";
		$conn->query($sql_insert);
		header("Location: system.php?l=proveedores");
		
}
?>