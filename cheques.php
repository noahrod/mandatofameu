<?php
include "connect.php";
$conncobrados = new mysqli($servername, $username, $password, $dbname);
if ($conncobrados->connect_error) {
    die("Connection failed: " . $conncobrados->connect_error);
}
$sqlcobrados = "SELECT id from cheques where cobrado=1";
$resultcobrados = $conncobrados->query($sqlcobrados);
$chequescobrados = $resultcobrados->num_rows;
?>
<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Cheques</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoCheque">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	<a href="chequevoider.php" target="_blank" type="button" class="btn btn-warning">Voider <span class="glyphicon glyphicon-alert" aria-hidden="true"></span></a>
	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalCancelCheck">Cancelar <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalSearch">Buscar <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	<span class="label label-primary pull-right">Cheques cobrados: <span class="badge"><?php echo $chequescobrados; ?></span></span>
	<?php
	if($_GET["search"] == 1){
	echo '<button class="btn btn-primary" type="button" onclick="loadCheques(0)"><span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></button>';
	}
	?>
	<br><br>
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
			if($_GET["search"] == 1){
				if($_GET["consuladosearch"] != ""){
					$sql = "SELECT cheques.id,autorizaciones.numerodecorreo,consulados.ubicacion,proveedores.nombreproveedor,cheques.numerodecheque,cheques.cantidadcheque,cheques.fecha, programas.programa, cheques.autorizacioncheque, cheques.consuladocheque, cheques.proveedorcheque, cheques.cobrado, cheques.cancelado FROM cheques 
						LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
						LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
						LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
						LEFT JOIN programas ON proveedores.programaproveedor = programas.id
						WHERE cheques.autorizacioncheque like '%".$_GET["autorizacionsearch"]."%'
						AND cheques.consuladocheque like '".$_GET["consuladosearch"]."'
						AND cheques.cantidadcheque like '%".$_GET["cantidadsearch"]."%'
						AND cheques.numerodecheque like '%".$_GET["chequesearch"]."%'
						ORDER by cheques.fecha DESC";
				}else{
					$sql = "SELECT cheques.id,autorizaciones.numerodecorreo,consulados.ubicacion,proveedores.nombreproveedor,cheques.numerodecheque,cheques.cantidadcheque,cheques.fecha, programas.programa, cheques.autorizacioncheque, cheques.consuladocheque, cheques.proveedorcheque, cheques.cobrado, cheques.cancelado FROM cheques 
						LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
						LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
						LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
						LEFT JOIN programas ON proveedores.programaproveedor = programas.id
						WHERE cheques.autorizacioncheque like '%".$_GET["autorizacionsearch"]."%'
						AND cheques.cantidadcheque like '%".$_GET["cantidadsearch"]."%'
						AND cheques.numerodecheque like '%".$_GET["chequesearch"]."%'
						ORDER by cheques.fecha DESC";
				}
			}else{
				$sql = "SELECT cheques.id,autorizaciones.numerodecorreo,consulados.ubicacion,proveedores.nombreproveedor,cheques.numerodecheque,cheques.cantidadcheque,cheques.fecha, programas.programa, cheques.autorizacioncheque, cheques.consuladocheque, cheques.proveedorcheque, cheques.cobrado, cheques.cancelado FROM cheques 
					LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
					LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
					LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
					LEFT JOIN programas ON proveedores.programaproveedor = programas.id
					ORDER by cheques.fecha DESC LIMIT ".$my_from.",20";
			}
			$result = $conn->query($sql);
			if($_GET["search"] == 1){
				echo 'Total de cheques: <span class="badge">'.$result->num_rows.'</span>';
			}
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Autorización</th>
					<th>Consulado</th>
					<th>Programa</th>
					<th>Proveedor</th>
					<th># de cheque</th>
					<th>Cantidad</th>
					<th>Fecha</th>
					<th>Cobrado?</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if($row["cancelado"] == 1){
						echo "<tr class='danger'>";
						echo "<td><div style='transform: rotate(-90deg); margin-top: 40px; position:absolute; left: -10px; font-size: 11px;'><b>CANCELADO</b></div>".$row["id"]."</td>";
					}else{
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";	
					}
					
					
					echo "<td>".$row["numerodecorreo"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>".$row["programa"]."</td>";
					echo "<td>".$row["nombreproveedor"]."</td>";
					echo "<td>".$row["numerodecheque"]."</td>";
					$leparts = explode(".", $row["cantidadcheque"]);
					$realamount = $leparts[0] . "." . substr($leparts[1], 0,2); 
					echo "<td>".number_format($realamount,2)."</td>";
					echo "<td>".date("m/d/Y", strtotime($row["fecha"]))."</td>";
					if($row["cobrado"] == 0){
						echo '<td><center><button type="button" class="btn btn-default" onclick="togglecobrocheque(\''.$row["id"].'\')" ';
						if($row["cancelado"] == 1){echo "disabled";}
						echo '><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></center></td>';
					}else{
						if($row["cobrado"] == 1){
							echo '<td><center><button type="button" class="btn btn-success" onclick="togglecobrocheque(\''.$row["id"].'\') ';
						if($row["cancelado"] == 1){echo "disabled";}
							echo '"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></center></td>';
						}
					}
					echo '<td><button type="button" class="btn btn-default" onclick="printCheque('.$row["id"].');" ';
						if($row["cancelado"] == 1){echo "disabled";}
						echo '><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button><br><button type="button" class="btn btn-default" onclick="editCheque(\''.$row["id"].'\', \''.$row["autorizacioncheque"].'\', \''.$row["consuladocheque"].'\', \''.$row["proveedorcheque"].'\', \''.$row["numerodecheque"].'\', \''.$row["cantidadcheque"].'\');" ';
						if($row["cancelado"] == 1){echo "disabled";}
						echo '><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><br>';
						if($row["cancelado"] == 1){
							echo '<button type="button" class="btn btn-danger" onclick="showcancelationinformation('.$row["id"].');"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></button>';
						}
					echo "</td></tr>";
					//editCheque(chid, ach, cch, pch, nch, canch)
				}
			}else{
				echo "<tr><td>No existen cheques en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
		<?php
	include "connect.php";
	$conn1 = new mysqli($servername, $username, $password, $dbname);
	if ($conn1->connect_error) {
	    die("Connection failed: " . $conn1->connect_error);
	}
	$sql_paginacion = "select * from cheques";
	$condecontar = $conn1->query($sql_paginacion);
	$cuantas_paginas = ceil ($condecontar->num_rows / 20);
	if($_GET["search"] == 1){
		echo '<br><center>
		<nav style="display: none;">
		  <ul class="pagination">';
	}else{
		echo '<br><center>
		<nav>
		  <ul class="pagination">';	
	}
	

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
		      <a href="#" onclick="loadCheques(\''.($my_from-20).'\')" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}

    
	$s =0;
	for ($i=1; $i < $cuantas_paginas+1; $i++){ 
		if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
		if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadConsulados(\"".$s."\")'>".$i."</a></li>";}
		else{ echo "<li><a href='#' onclick='loadCheques(\"".$s."\")'>".$i."</a></li>";}
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
			      <a href='#' onclick='loadCheques(\"".($my_from+20)."\")' aria-label='Next'>
			        <span aria-hidden='true'>&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
		</center><br><br>";
	 }
	 $conn1->close();
?>
	</div>
</div>
<script>
  </script>

<div class="modal fade" id="myModalNuevoCheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Cheque</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevocheque" method="post" action="addcheque.php">
				<div class="form-group">
				    <label for="labelautorizacioncheque">Autorización</label>
				    <select class="form-control" name="autorizacioncheque" id="autorizacioncheque">
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
			    <label for="labelconsuladocheque">Consulado</label>
			    <select class="form-control" name="consuladocheque" id="consuladocheque">
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
			    <label for="labelproveedorcheque">Proveedor</label>
			    <select class="form-control" name="proveedorcheque" id="proveedorcheque">
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
				<br>
				<div class="form-group">
				    <label for="labelnumerodecheque">Número de cheque</label>
				    <input type="text" class="form-control" name="numerodecheque" id="numerodecheque" placeholder="Número de cheque">
			  	</div>
			  	<div class="form-group">
				    <label for="labelcantidadcheque">Cantidad</label>
				    <input type="text" class="form-control" name="cantidadcheque" id="cantidadcheque" placeholder="Cantidad">
			  	</div>
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertCheque();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditCheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Cheque</h4>
      </div>
      <div class="modal-body">
			<form id="formeditcheque" method="post" action="updatecheque.php">
				<div class="form-group">
				    <label for="labeleditautorizacioncheque">Autorización</label>
				    <select class="form-control" name="editautorizacioncheque" id="editautorizacioncheque">
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
			    <label for="labeleditconsuladocheque">Consulado</label>
			    <select class="form-control" name="editconsuladocheque" id="editconsuladocheque">
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
			    <label for="labeleditproveedorcheque">Proveedor</label>
			    <select class="form-control" name="editproveedorcheque" id="editproveedorcheque">
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
				<br>
				<div class="form-group">
				    <label for="labeleditnumerodecheque">Número de cheque</label>
				    <input type="text" class="form-control" name="editnumerodecheque" id="editnumerodecheque" placeholder="Número de cheque">
			  	</div>
			  	<div class="form-group">
				    <label for="labeleditcantidadcheque">Cantidad</label>
				    <input type="text" class="form-control" name="editcantidadcheque" id="editcantidadcheque" placeholder="Cantidad">
			  	</div>
			  </div>
			  <input type="hidden" id="chid" name="chid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateCheque();">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Buscar</h4>
      </div>
      <div class="modal-body">
      	 <div class="form-group">
		    <label for="labelconsuladosearch">Consulado</label>
		    <select class="form-control" name="consuladosearch" id="consuladosearch">
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
		    <label for="labelautorizacionsearch">Autorización</label>
		    <select class="form-control" name="autorizacionsearch" id="autorizacionsearch">
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
			    <label for="cantidadsearch">Cantidad</label>
			    <input type="text" class="form-control" name="cantidadsearch" id="cantidadsearch" placeholder="Cantidad">
		  	</div>
		  <div class="form-group">
			    <label for="chequesearch">Cheque</label>
			    <input type="text" class="form-control" name="chequesearch" id="chequesearch" placeholder="# de cheque">
		  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="searchCheques($('#autorizacionsearch').val(),$('#consuladosearch').val(),$('#cantidadsearch').val(),$('#chequesearch').val())">Buscar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModalCancelCheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancelar Cheque</h4>
      </div>
      <form id="formcancelcheck" name="formcancelcheck" enctype="multipart/form-data" method="post" action="cancelarcheque.php">
      <div class="modal-body">
      	 <div class="form-group">
		    <label for="labelcancelarcheque">Cheque</label>
		    <select class="form-control" name="cancelarcheque" id="cancelarcheque">
		    <option></option>
			  <?php
			  	include "connect.php";
				$conn1 = new mysqli($servername, $username, $password, $dbname);
				if ($conn1->connect_error) {
				    die("Connection failed: " . $conn1->connect_error);
				}
				$sql1 = "SELECT id,numerodecheque FROM `cheques` where cancelado=0";
				$result1 = $conn1->query($sql1);
				if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc()) {
						echo "<option value='".$row1["id"]."'>".$row1["numerodecheque"]."</option>";
					}
				}else{
					echo "<option>"."No hay cheques dados de alta en el sistema."."</option>";	
				}
			  	$conn1->close();
			  ?>
			</select>
		  </div>
		  <div class="form-group">
		    	<label for="labelcancelarcheque">Razón de la cancelación</label>
		  		<textarea class="form-control" rows="3" name="razoncancelarcheque" id="razoncancelarcheque"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">Escaneo del cheque cancelado</label>
		    <input type="file" id="chequecanceladoscan" name="chequecanceladoscan">
		    <p class="help-block">En formato *.pdf</p>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">Escaneo comunicación de la cancelacion</label>
		    <input type="file" id="comunicacionchequecanceladoscan" name="comunicacionchequecanceladoscan">
		    <p class="help-block">En formato *.pdf</p>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-danger" value="Cancelar"/>
      </div>
  	 </form>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalShowCancelationInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Información de la cancelación</h4>
      </div>
      <div class="modal-body">
      	<div id="myModalShowCancelationInformationBody">
      		
      	</div> 
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" onclick="updatecancelacioncheque();"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
  	 </form>
    </div>
  </div>
</div>






<div class="modal fade" id="myModaleditCancelCheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar información de cancelación de cheque</h4>
      </div>
      <form id="formeditcancelcheck" name="formeditcancelcheck" enctype="multipart/form-data" method="post" action="updateinformationcancelarcheque.php">
      <div class="modal-body">
      	 <div class="form-group">
		    <label for="labelcancelarcheque">Cheque</label>
		    <select class="form-control" name="editcancelarcheque" id="editcancelarcheque" disabled="">
		    <option></option>
			  <?php
			  	include "connect.php";
				$conn1 = new mysqli($servername, $username, $password, $dbname);
				if ($conn1->connect_error) {
				    die("Connection failed: " . $conn1->connect_error);
				}
				$sql1 = "SELECT id,numerodecheque FROM `cheques` where cancelado=1";
				$result1 = $conn1->query($sql1);
				if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc()) {
						echo "<option value='".$row1["id"]."'>".$row1["numerodecheque"]."</option>";
					}
				}else{
					echo "<option>"."No hay cheques dados de alta en el sistema."."</option>";	
				}
			  	$conn1->close();
			  ?>
			</select>
		  </div>
		  <div class="form-group">
		    	<label for="labelcancelarcheque">Razón de la cancelación</label>
		  		<textarea class="form-control" rows="3" name="editrazoncancelarcheque" id="editrazoncancelarcheque"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">Escaneo del cheque cancelado</label>
		    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchoreditchequecanceladoscan"></a>
		    <br>
		    <br>
		    <input type="file" id="editchequecanceladoscan" name="editchequecanceladoscan">
		    <p class="help-block">En formato *.pdf</p>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">Escaneo comunicación de la cancelacion</label>
		    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchoreditcomunicacionchequecanceladoscan"></a>
		    <br>
		    <br>
		    <input type="file" id="editcomunicacionchequecanceladoscan" name="editcomunicacionchequecanceladoscan">
		    <p class="help-block">En formato *.pdf</p>
		  </div>
		  <input type="hidden" id="cciaf" name="cciaf" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-danger" value="Guardar"/>
      </div>
  	 </form>
    </div>
  </div>
</div>



