<?php

//echo $_GET['cci'];

include "connect.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from chequescancelados where chequeid=". $_GET['cci'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
}else{
	echo "No existe proveedor con ese id en el sistema.";
}

echo '

<div class="form-group">
	<label for="labelcancelarcheque">Razón de la cancelación</label>
		<p style="white-space:pre-wrap;">'. $row["razon"].'</p>
</div>
<div class="form-group">
<label for="exampleInputFile">Escaneo del cheque cancelado</label>
	<br><a target=_blank href="downloadchequecancelado.php?cci='.$_GET['cci'].'"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> ESCANEOCHEQUECANCELADO-'.$_GET['cci'].'.pdf</a>
</div>
<div class="form-group">
<label for="exampleInputFile">Escaneo comunicación de la cancelacion</label>
	<br><a target=_blank href="downloadescaneocomunicacionchequecancelado.php?cci='.$_GET['cci'].'"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span>ESCANEOCOMUNICACIONCANCELACION-'.$_GET['cci'].'.pdf</a>
</div>
<p style="display:none;" id="ccia">'.$_GET['cci'].'</p>
<p style="display:none;" id="rccia">'.$row["razon"].'</p>
';

?>