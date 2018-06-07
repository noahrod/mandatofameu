<?php
include "connect.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT proveedores.nombreproveedor,cheques.cantidadcheque,cheques.fecha, cheques.numerodecheque FROM cheques 
	LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
	WHERE cheques.numerodecheque = '".$_POST["numerodecheque"]."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$valchqu =  $row["nombreproveedor"] . " | ". date("d/m/Y", strtotime($row["fecha"])) . " | ". $row["cantidadcheque"] . "|" . $row["numerodecheque"];
echo "<input type='hidden' value='".$valchqu."' id='ch".$_POST["varnumba"]."' name='ch".$_POST["varnumba"]."'>";
$leunique = uniqid("ch");
echo "<div id='".$leunique."'>".$valchqu ."&nbsp;<span class='glyphicon glyphicon-remove-circle' aria-hidden='true' onclick='removedach(\"".$leunique."\");removedach(\"ch".$_POST["varnumba"]."\");'></span></div>";
?>