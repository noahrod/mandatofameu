<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["nombreproveedor"] != "" &&  $_POST["consuladoproveedor"] != "" ){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_insert = "INSERT INTO `proveedores` (`id`, `nombreproveedor`, `personaautorizadarecursosfinancieros`, `personaparaestablecercontacto`, `telefonocontacto`, `emailcontacto`, `calleynumero`, `ciudad`, `estado`, `codigopostal`, `telefono`, `nombredelbanco`, `sucursal`, `numerodecuenta`, `claveinterbancaria`, `consuladoproveedor`, `programaproveedor`) VALUES (NULL, '".$_POST["nombreproveedor"]."', '".$_POST["personaautorizadarecursosfinancieros"]."', '".$_POST["personaparaestablecercontacto"]."', '".$_POST["telefonocontacto"]."', '".$_POST["emailcontacto"]."', '".$_POST["calleynumero"]."', '".$_POST["ciudad"]."', '".$_POST["estado"]."', '".$_POST["codigopostal"]."', '".$_POST["telefono"]."', '".$_POST["nombredelbanco"]."', '".$_POST["sucursal"]."', '".$_POST["numerodecuenta"]."', '".$_POST["claveinterbancaria"]."', '".$_POST["consuladoproveedor"]."', '".$_POST["programaproveedor"]."');";
		$conn->query($sql_insert);
		header("Location: system.php?l=proveedores&ev=newsuccessProveedor");
		
}
?>