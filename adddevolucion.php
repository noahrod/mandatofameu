<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["consuladodevolucion"] != "" && $_POST["numerodecomunicaciondevolucion"] != "" && $_POST["proveedordevolucion"] != "" && $_POST["tipodedevolucion"] != "" && $_POST["cantidaddevolucion"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['imagencomunicacioncheque']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['imagencomunicacioncheque']['tmp_name']));
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql_insert = "INSERT INTO `devoluciones` (`id`, `consulado`, `numerocomunicacion`, `proveedor`, `tipodevolucion`,`cantidad`,`fecha`,`escaneo`,`depositado`,`fichadeposito`) VALUES (NULL,'".$_POST["consuladodevolucion"]."' , '".$_POST["numerodecomunicaciondevolucion"]."','".$_POST["proveedordevolucion"]."', '".$_POST["tipodedevolucion"]."', '".$_POST["cantidaddevolucion"]."', '".$_POST["fechadedevolucion"]."' ,'".$imgData."',0,'')";
			$conn->query($sql_insert);
			header("Location: system.php?l=devoluciones&ev=newsuccessDevolucion");
			//echo $sql_insert;
		}
	}
}
?>