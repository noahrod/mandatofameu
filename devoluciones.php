<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Devoluciones</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevaDevolucion">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
		<?php
		
			if($_GET["start"] != ""){
				$my_from = $_GET["start"];
			}else{
				$my_from = 0;
			}
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT devoluciones.*, consulados.ubicacion,proveedores.nombreproveedor, proveedores.programaproveedor, programas.programa FROM `devoluciones`
					LEFT JOIN  `consulados` on devoluciones.consulado = consulados.id
					LEFT JOIN  `proveedores` on devoluciones.proveedor = proveedores.id
					LEFT JOIN `programas` on proveedores.programaproveedor = programas.id
					LIMIT ".$my_from.",20";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Consulado</th>
					<th>Número de comunicación</th>
					<th>Proveedor</th>
					<th>Programa</th>
					<th>Tipo de devolución</th>
					<th>Cantidad</th>
					<th>Fecha de devolución</th>
					<th>Escaneo</th>
					<th>Depositado?</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>".$row["numerocomunicacion"]."</td>";
					echo "<td>".$row["nombreproveedor"]."</td>";
					echo "<td>".$row["programa"]."</td>";
					echo "<td>".$row["tipodevolucion"]."</td>";
					echo "<td>".$row["cantidad"]."</td>";
					echo "<td>".$row["fecha"]."</td>";
					echo "<td><a target=_blank href='downloaddevolucion.php?id=".$row["id"]."' >".$row["numerocomunicacion"].".pdf</a>";
					if($row["tipodevolucion"] == "Cheque" && $row["fichadeposito"] == ""){
						echo "<br>
						<small><a target=_blank href='#' data-toggle='modal' data-target='#myModalAgregarFichaDeposito' onclick='$(\"#fddevid\").val(\"".$row["id"]."\");'><span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span>&nbsp;Agregar ficha de deposito</a></small>";
					}else{
						if($row["tipodevolucion"] == "Cheque" && $row["fichadeposito"] != ""){
							echo "<br><br>
							<a target=_blank href='downloadfichadepositodevolucion.php?id=".$row["id"]."' >FICHADEPOSITO-".$row["numerocomunicacion"].".pdf</a>
							";
						}
					}
					echo "</td>";
					if($row["depositado"] == 0){
						echo '<td><center><button type="button" class="btn btn-default" onclick="toggledepositodevolucion(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></center></td>';
					}else{
						if($row["depositado"] == 1){
							echo '<td><center><button type="button" class="btn btn-success" onclick="toggledepositodevolucion(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></center></td>';
						}
					}
					echo '<td><button type="button" class="btn btn-default" onclick="editDevolucion(\''.$row["id"].'\',\''.$row["consulado"].'\',\''.$row["numerocomunicacion"].'\',\''.$row["proveedor"].'\',\''.$row["tipodevolucion"].'\',\''.$row["cantidad"].'\')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
					</td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen devoluciones en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
<?php
	include "connect.php";
	$conn1 = new mysqli($servername, $username, $password, $dbname);
	if ($conn1->connect_error) {
	    die("Connection failed: " . $conn1->connect_error);
	}
	$sql_paginacion = "select * from devoluciones";
	$condecontar = $conn1->query($sql_paginacion);
	$cuantas_paginas = ceil ($condecontar->num_rows / 20);
	echo '<br><center>
		<nav>
		  <ul class="pagination">';

	if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
	if($my_from ==0){
		echo '
		    <li class="disabled">
		      <a href="system.php" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}else{

		echo '
		    <li>
		      <a href="#" onclick="loadConsulados(\''.($my_from-20).'\')" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}

    
	$s =0;
	for ($i=1; $i < $cuantas_paginas+1; $i++){ 
		if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
		if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadConsulados(\"".$s."\")'>".$i."</a></li>";}
		else{ echo "<li><a href='#' onclick='loadConsulados(\"".$s."\")'>".$i."</a></li>";}
		$s= $s + 20;
	}

	if(($my_from + 20) > $condecontar->num_rows){
		echo "  <li class='disabled'>
			      <a href='system.php' aria-label='Next'>
			        <span aria-hidden='true'>&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
		</center><br><br>";
	}else{
		echo "  <li>
			      <a href='#' onclick='loadConsulados(\"".($my_from+20)."\")' aria-label='Next'>
			        <span aria-hidden='true'>&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
		</center><br><br>";
	 }
	 
?>



	</div>
</div>
<script>
  $( function() {
    $( "#fechadedevolucion" ).datepicker();
	$( "#editfechadedevolucion" ).datepicker();
  } );
  </script>

<div class="modal fade" id="myModalNuevaDevolucion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Devolución</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevadevolucion" enctype="multipart/form-data" method="post" action="adddevolucion.php">
				<div class="form-group">
				    <label for="labelconsuladodevolucion">Consulado</label>
				    <select class="form-control" name="consuladodevolucion" id="consuladodevolucion">
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
					  	
					  ?>
					</select>
			  	</div>
			  	<div class="form-group">
				    <label for="labelnumerodecomunicaciondevolucion">Numero de comunicación</label>
				    <input type="text" class="form-control" name="numerodecomunicaciondevolucion" id="numerodecomunicaciondevolucion" placeholder="Numero de comunicación">
				</div>
				<div class="form-group">
				    <label for="labelproveedordevolucion">Proveedor</label>
				    <select class="form-control" name="proveedordevolucion" id="proveedordevolucion">
				    <option></option>
					  <?php
					  	include "connect.php";
						$conn2 = new mysqli($servername, $username, $password, $dbname);
						if ($conn2->connect_error) {
						    die("Connection failed: " . $conn2->connect_error);
						}
						$sql2 = "SELECT proveedores.id,proveedores.nombreproveedor,programas.programa FROM proveedores
							left JOIN programas
							on proveedores.programaproveedor = programas.id";
						$result2 = $conn2->query($sql2);
						if ($result2->num_rows > 0) {
							while($row2 = $result2->fetch_assoc()) {
								echo "<option value='".$row2["id"]."'>".$row2["nombreproveedor"]." | ".$row2["programa"] . "</option>";
							}
						}else{
							echo "<option>"."No hay proveedores dados de alta."."</option>";	
						}
					  	$conn2->close();
					  ?>
					</select>
				</div>
				<div class="form-group">
				    <label for="labeledittipodevolucion">Tipo de Devolución</label>
				    <select class="form-control" name="tipodedevolucion" id="tipodedevolucion">
				    	<option value=''></option>
				    	<option value='Cheque'>Cheque</option>
				    	<option value='Transferencia'>Transferencia</option>
				    </select>
				</div>
				<div class="form-group">
				    <label for="labelcantidaddevolucion">Cantidad</label>
				    <input type="text" class="form-control" name="cantidaddevolucion" id="cantidaddevolucion" placeholder="Cantidad">
				</div>
				<div class="form-group">
				    <label for="labelfechadedevolucion">Fecha de devolución</label>
				    <input type="text" class="form-control" name="fechadedevolucion" id="fechadedevolucion" placeholder="Fecha de devolución">
				  </div>
				 <div class="form-group">
				    <label for="exampleInputFile">Escaneo del la comunicación y/o el cheque</label>
				    <input type="file" id="imagencomunicacioncheque" name="imagencomunicacioncheque">
				    <p class="help-block">En formato *.pdf</p>
				  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertDevolucion();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditDevolucion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Devolución</h4>
      </div>
      <div class="modal-body">
			<form id="formeditdevolucion" enctype="multipart/form-data" method="post" action="updatedevolucion.php">
				<div class="form-group">
				    <label for="labeleditconsuladodevolucion">Consulado</label>
				    <select class="form-control" name="editconsuladodevolucion" id="editconsuladodevolucion">
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
					  	
					  ?>
					</select>
			  	</div>
			  	<div class="form-group">
				    <label for="labeleditnumerodecomunicaciondevolucion">Numero de comunicación</label>
				    <input type="text" class="form-control" name="editnumerodecomunicaciondevolucion" id="editnumerodecomunicaciondevolucion" placeholder="Numero de comunicación">
				</div>
				<div class="form-group">
				    <label for="labeleditproveedordevolucion">Proveedor</label>
				    <select class="form-control" name="editproveedordevolucion" id="editproveedordevolucion">
				    <option></option>
					  <?php
					  	include "connect.php";
						$conn2 = new mysqli($servername, $username, $password, $dbname);
						if ($conn2->connect_error) {
						    die("Connection failed: " . $conn2->connect_error);
						}
						$sql2 = "SELECT proveedores.id,proveedores.nombreproveedor,programas.programa FROM proveedores
							left JOIN programas
							on proveedores.programaproveedor = programas.id";
						$result2 = $conn2->query($sql2);
						if ($result2->num_rows > 0) {
							while($row2 = $result2->fetch_assoc()) {
								echo "<option value='".$row2["id"]."'>".$row2["nombreproveedor"]." | ".$row2["programa"] . "</option>";
							}
						}else{
							echo "<option>"."No hay proveedores dados de alta."."</option>";	
						}
					  	$conn2->close();
					  ?>
					</select>
				</div>
				<div class="form-group">
				    <label for="labeledittipodevolucion">Tipo de Devolución</label>
				    <select class="form-control" name="edittipodedevolucion" id="edittipodedevolucion">
				    	<option value=''></option>
				    	<option value='Cheque'>Cheque</option>
				    	<option value='Transferencia'>Transferencia</option>
				    </select>
				</div>
				<div class="form-group">
				    <label for="labeleditcantidaddevolucion">Cantidad</label>
				    <input type="text" class="form-control" name="editcantidaddevolucion" id="editcantidaddevolucion" placeholder="Cantidad">
				</div>
				<div class="form-group">
				    <label for="labeleditfechadedevolucion">Fecha de devolución</label>
				    <input type="text" class="form-control" name="editfechadedevolucion" id="editfechadedevolucion" placeholder="Fecha de devolución">
				  </div>
				 <div class="form-group">
				    <label for="exampleInputFile">Escaneo del la comunicación y/o el cheque</label>
				    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchor"></a>
				    <br>
				    <br>
				    <input type="file" id="editimagencomunicacioncheque" name="editimagencomunicacioncheque">
				    <p class="help-block">En formato *.pdf</p>
				  </div>
			  <input type="hidden" id="devid" name="devid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateDevolucion();">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalAgregarFichaDeposito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar ficha de deposito</h4>
      </div>
      <div class="modal-body">
      	<form id="formfichadepositodevolucion" enctype="multipart/form-data" method="post" action="updatefichadepositodevolucion.php">
      		<div class="form-group">
			    <label for="exampleInputFile">Escaneo ficha de deposito</label>
			    <input type="file" id="imagenfichadepositodevolucion" name="imagenfichadepositodevolucion">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			<input type="hidden" id="fddevid" name="fddevid" value="">
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="addfichadeposito();">Agregar</button>
      </div>
    </div>
  </div>
</div>