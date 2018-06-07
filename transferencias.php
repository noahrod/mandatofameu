<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Transferencias</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevaTransferencia">Nueva <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
		<?php
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT transferencias.id,transferencias.confirmacion, proveedores.nombreproveedor, transferencias.fechadeenvio, transferencias.destino, transferencias.consulado, consulados.ubicacion, transferencias.autorizacion, autorizaciones.numerodecorreo, transferencias.cantidad, programas.programa
				FROM `transferencias` 
				LEFT JOIN proveedores on transferencias.destino = proveedores.id
				LEFT JOIN consulados on transferencias.consulado = consulados.id
				LEFT JOIN autorizaciones on transferencias.autorizacion = autorizaciones.id
                LEFT JOIN programas on proveedores.programaproveedor = programas.id";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Autorización</th>
					<th>Consulado</th>
					<th>Cantidad</th>
					<th># de confirmación</th>
					<th>Proveedor</th>
					<th>Programa</th>
					<th>Fecha de envío</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["numerodecorreo"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>".number_format($row["cantidad"],2)."</td>";
					echo "<td>".$row["confirmacion"]."</td>";
					echo "<td>".$row["nombreproveedor"]."</td>";
					echo "<td>".$row["programa"]."</td>";
					echo "<td>".$row["fechadeenvio"]."</td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editTransferencia(\''.$row["id"].'\',\''.$row["confirmacion"].'\',\''.$row["destino"].'\',\''.$row["fechadeenvio"].'\',\''.$row["consulado"].'\',\''.$row["cantidad"].'\',\''.$row["autorizacion"].'\')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen transferencias en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
	</div>
</div>
<script>
  $( function() {
    $( "#fechadeenvio" ).datepicker();
    $( "#editfechadeenvio" ).datepicker();
  } );
  </script>

<div class="modal fade" id="myModalNuevaTransferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Transferencia</h4>
      </div>

      <div class="modal-body">
      		<form id="formnuevatransferencia" method="post" action="addtransferencia.php">
      		<div class="form-group">
      		<label for="labelautorizaciontransferencia">Autorización</label>
				    <select class="form-control" name="autorizaciontransferencia" id="autorizaciontransferencia">
				    <option></option>
					  <?php
					  	include "connect.php";
						$conn0 = new mysqli($servername, $username, $password, $dbname);
						if ($conn0->connect_error) {
						    die("Connection failed: " . $conn0->connect_error);
						}
						$sql0 = "SELECT id,numerodecorreo FROM `autorizaciones`";
						$result0 = $conn0->query($sql0);
						if ($result0->num_rows > 0) {
							while($row0 = $result0->fetch_assoc()) {
								echo "<option value='".$row0["id"]."'>".$row0["numerodecorreo"]."</option>";
							}
						}else{
							echo "<option>"."No hay autorizaciones dadas de alta."."</option>";	
						}
					  	$conn0->close();
					  ?>
					</select>
				  </div>
			  <div class="form-group">
			    <label for="labelconsuladotransferencia">Consulado</label>
			    <select class="form-control" name="consuladotransferencia" id="consuladotransferencia">
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
			    <label for="labelprogramatransferencia">Cantidad</label>
			    <input type="text" class="form-control" name="cantidadtransferencia" id="cantidadtransferencia" placeholder="Cantidad">
			  </div>
			
			  <div class="form-group">
			    <label for="labelnumerodeconfirmacion">Número de confirmación</label>
			    <input type="text" class="form-control" name="numerodeconfirmacion" id="numerodeconfirmacion" placeholder="Número de confirmación">
			  </div>
			  <div class="form-group">
			    <label for="labelingresos">Proveedor</label>
			    <select class="form-control" name="destino" id="destino">
			    <option></option>
			    <option>-- PROOVEDORES --</option>
			    <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,nombreproveedor FROM `proveedores`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["id"]."'>".$row1["nombreproveedor"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				</select>
			  </div>
			  <div class="form-group">
			    <label for="labelfechadeenvio">Fecha de envío</label>
			    <input type="text" class="form-control" name="fechadeenvio" id="fechadeenvio" placeholder="Fecha de envío">
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertTransferencia();">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalEditTransferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Transferencia</h4>
      </div>
      <div class="modal-body">
			<form id="formedittransferencia" method="post" action="updatetransferencia.php">
			  <div class="form-group">
      		<label for="labeleditautorizaciontransferencia">Autorización</label>
				    <select class="form-control" name="editautorizaciontransferencia" id="editautorizaciontransferencia">
				    <option></option>
					  <?php
					  	include "connect.php";
						$conn0 = new mysqli($servername, $username, $password, $dbname);
						if ($conn0->connect_error) {
						    die("Connection failed: " . $conn0->connect_error);
						}
						$sql0 = "SELECT id,numerodecorreo FROM `autorizaciones`";
						$result0 = $conn0->query($sql0);
						if ($result0->num_rows > 0) {
							while($row0 = $result0->fetch_assoc()) {
								echo "<option value='".$row0["id"]."'>".$row0["numerodecorreo"]."</option>";
							}
						}else{
							echo "<option>"."No hay autorizaciones dadas de alta."."</option>";	
						}
					  	$conn0->close();
					  ?>
					</select>
				  </div>
			  <div class="form-group">
			    <label for="labeleditconsuladotransferencia">Consulado</label>
			    <select class="form-control" name="editconsuladotransferencia" id="editconsuladotransferencia">
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
			    <label for="labeleditprogramatransferencia">Cantidad</label>
			    <input type="text" class="form-control" name="editcantidadtransferencia" id="editcantidadtransferencia" placeholder="Cantidad">
			  </div>
			  <div class="form-group">
			    <label for="labeleditnumerodeconfirmacion">Número de confirmación</label>
			    <input type="text" class="form-control" name="editnumerodeconfirmacion" id="editnumerodeconfirmacion" placeholder="Número de confirmación">
			  </div>
			  <div class="form-group">
			    <label for="labelingresos">Proveedor</label>
			    <select class="form-control" name="editdestino" id="editdestino">
			    <option></option>
			    <option>-- PROOVEDORES --</option>
			    <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,nombreproveedor FROM `proveedores`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["id"]."'>".$row1["nombreproveedor"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				</select>
			  </div>
			  <div class="form-group">
			    <label for="labelfechadeenvio">Fecha de envío</label>
			    <input type="text" class="form-control" name="editfechadeenvio" id="editfechadeenvio" placeholder="Fecha de envío">
			  </div>
			  <input type="hidden" id="tid" name="tid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateTransferencia();">Actualizar</button>
      </div>
    </div>
  </div>
</div>



