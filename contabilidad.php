<?php
//SELECT * FROM `autorizaciones` WHERE STR_TO_DATE(`autorizaciones`.fechadesolicitud, '%m/%d/%Y') between STR_TO_DATE('01/01/2016', '%m/%d/%Y') AND STR_TO_DATE('03/01/2016', '%m/%d/%Y')
/*
Ingresos: SELECT SUM(cast(ingresos as DECIMAL(10,2))) from autorizaciones
		<br>
		Egresos: SELECT SUM(cast(cantidadcheque as DECIMAL(10,2))) from cheques
		<br>+<br>
		SELECT SUM(cast(cantidad as DECIMAL(10,2))) from transferencias
*/
?>
<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Contabilidad</h3> 
	</div>
	<div class="panel-body">
		<div class="panel panel-success">
			<div class="panel-heading"> 
				<h3 class="panel-title">Historico</h3> 
			</div>
			<div class="panel-body">
				<table>
				<?php
					include "connect.php";
					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					    die("Connection failed: " . $conn->connect_error);
					}
					$sql = "SELECT SUM(cast(ingresos as DECIMAL(10,3))) as totalingresos from autorizaciones";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					$totalingresos = $row["totalingresos"];
					echo "<tr><td><b>Ingresos:</b>&emsp;</td><td class='pull-right'>". number_format($totalingresos,3) . "</td></tr>";
					$conn->close();
					//
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT SUM(TRUNCATE(cast(cantidadcheque as DECIMAL(10,3)),3)) as totalcheques from cheques where cheques.cancelado=0";
					$result1 = $conn1->query($sql1);
					$row1 = $result1->fetch_assoc();
					$chequestotal = $row1["totalcheques"];
					$conn1->close();
					//
					$conn2 = new mysqli($servername, $username, $password, $dbname);
					if ($conn2->connect_error) {
					    die("Connection failed: " . $conn2->connect_error);
					}
					$sql2 = "SELECT SUM(cast(cantidad as DECIMAL(10,3))) as totaltransferencias from transferencias";
					$result2 = $conn2->query($sql2);
					$row2 = $result2->fetch_assoc();
					$transferenciastotal = $row2["totaltransferencias"];
					$conn2->close();
					//
					$totalegresos = $transferenciastotal+$chequestotal;
					echo "<tr ><td><b>Egresos:</b>&emsp;</td><td style='border-bottom: 1px #000 solid;' class='pull-right'>". number_format($totalegresos,3) . "</td></tr>";
					//
					echo "<tr><td><b>Total:</b>&emsp;</td><td class='pull-right'>". number_format(($totalingresos - $totalegresos),3) . "</td></tr>";
				?>
				</table>
			</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading"> 
				<h3 class="panel-title">Reportes</h3> 
			</div>
			<div class="panel-body">
				<form id="formgenerarreporte" enctype="multipart/form-data" method="post" action="reportegenerator.php" target="_blank">
					<div class="form-group">
					    <label for="labeleditfechade">Tipo de Egreso</label>
					    <select class="form-control" name="tipodeegreso" id="tipodeegreso">
					    	<option value='ch'>Cheques</option>
					    	<option value='tra'>Transferencias</option>
					    </select>
					</div>
					<div class="form-group">
					    <label for="labelconsulado">Consulado</label>
					    <select class="form-control" name="consulado" id="consulado">
					    <option></option>
						  <?php
						  	include "connect.php";
							$conn1 = new mysqli($servername, $username, $password, $dbname);
							if ($conn1->connect_error) {
							    die("Connection failed: " . $conn1->connect_error);
							}
							$sql1 = "SELECT id,ubicacion FROM `consulados`";
							$result1 = $conn1->query($sql1);
							if ($result1->num_rows > 0) {
								while($row1 = $result1->fetch_assoc()) {
									echo "<option value='".$row1["id"]."'>".$row1["ubicacion"]."</option>";
								}
							}else{
								echo "<option>"."No hay consulados dados de alta."."</option>";	
							}
						  	$conn1->close();
						  ?>
						</select>
					  </div>
					 <div class="form-group">
					    <label for="labelprogramaproveedor">Programa</label>
					    <select class="form-control" name="programa" id="programa">
						  <option></option>
						  <?php
						  	include "connect.php";
							$conn15 = new mysqli($servername, $username, $password, $dbname);
							if ($conn15->connect_error) {
							    die("Connection failed: " . $conn15->connect_error);
							}
							$sql15 = "SELECT id,programa FROM `programas`";
							$result15 = $conn15->query($sql15);
							if ($result15->num_rows > 0) {
								while($row1 = $result15->fetch_assoc()) {
									echo "<option value='".$row1["id"]."'>".$row1["programa"]."</option>";
								}
							}else{
								echo "<option>"."No hay programas dados de alta."."</option>";	
							}
						  	
						  ?>
						</select>
					  </div>
					<div class="form-group">
					    <label for="labeleditfechade">Desde</label>
					    <input type="text" class="form-control" name="fechade" id="fechade" placeholder="Desde" value="<?php echo date("m/d/Y"); ?>">
					</div>
					<div class="form-group">
					    <label for="labeleditfechahasta">Hasta</label>
					    <input type="text" class="form-control" name="fechahasta" id="fechahasta" placeholder="Hasta" value="<?php echo date("m/d/Y"); ?>">
					</div>
					<button type="submit" class="btn btn-primary" onclick="">Generar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
  $( function() {
    $( "#fechade" ).datepicker();
    $( "#fechahasta" ).datepicker();
  } );
  </script>
