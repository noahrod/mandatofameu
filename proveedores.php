<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Proveedores</h3> 
	</div>
	<div class="panel-body">
	<button style="float:left;" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoProveedor">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	<div style="width: 200px; float: left; position: relative; left: 10px;">
	    <select class="form-control" name="filterconsuladoproveedor" id="filterconsuladoproveedor">
		  <option>Filtrar por Consulado</option>
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

	<div class="pull-right">
	<?php
	  	include "connect.php";
		$conn15 = new mysqli($servername, $username, $password, $dbname);
		if ($conn15->connect_error) {
		    die("Connection failed: " . $conn15->connect_error);
		}
		$sql15 = "SELECT COUNT(proveedores.id) as total,proveedores.programaproveedor, programas.programa FROM proveedores 
 		LEFT JOIN programas ON proveedores.programaproveedor = programas.id
		GROUP BY proveedores.programaproveedor";
		$result15 = $conn15->query($sql15);
		if ($result15->num_rows > 0) {
			while($row15 = $result15->fetch_assoc()) {
				echo '<button class="btn btn-primary" type="button" onclick="loadProveedor(0,\''.$row15["programaproveedor"].'\',0);">
  						'.$row15["programa"].' <span class="badge">'.$row15["total"].'</span>
				</button>&nbsp;';
			}
		}
	?>
	<button class="btn btn-primary" type="button" onclick="loadProveedor(0,'',0)"><span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></button>
	</div>

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
			if($_POST['filtroconsulado'] != 0){
				echo "<script>$('#filterconsuladoproveedor').val(".$_POST['filtroconsulado'].")</script>";
				$sql = "SELECT proveedores.id,proveedores.nombreproveedor,proveedores.calleynumero,proveedores.ciudad,proveedores.estado,proveedores.codigopostal,consulados.ubicacion,proveedores.telefono,proveedores.personaautorizadarecursosfinancieros,proveedores.personaparaestablecercontacto, proveedores.telefonocontacto, proveedores.emailcontacto, proveedores.numerodecuenta, proveedores.sucursal, proveedores.claveinterbancaria, proveedores.nombredelbanco, proveedores.consuladoproveedor, proveedores.programaproveedor, programas.programa FROM proveedores 
			    LEFT JOIN consulados ON proveedores.consuladoproveedor = consulados.id 
			    LEFT JOIN programas ON proveedores.programaproveedor = programas.id
			    WHERE programaproveedor like '".$_POST['filtroprograma']."%'
			    AND consuladoproveedor = '".$_POST['filtroconsulado']."'";
			}else{
				if($_POST['filtroprograma'] != ""){
					$sql = "SELECT proveedores.id,proveedores.nombreproveedor,proveedores.calleynumero,proveedores.ciudad,proveedores.estado,proveedores.codigopostal,consulados.ubicacion,proveedores.telefono,proveedores.personaautorizadarecursosfinancieros,proveedores.personaparaestablecercontacto, proveedores.telefonocontacto, proveedores.emailcontacto, proveedores.numerodecuenta, proveedores.sucursal, proveedores.claveinterbancaria, proveedores.nombredelbanco, proveedores.consuladoproveedor, proveedores.programaproveedor, programas.programa FROM proveedores 
				    LEFT JOIN consulados ON proveedores.consuladoproveedor = consulados.id 
				    LEFT JOIN programas ON proveedores.programaproveedor = programas.id
				    WHERE programaproveedor like '".$_POST['filtroprograma']."%'";
				
				}else{
					$sql = "SELECT proveedores.id,proveedores.nombreproveedor,proveedores.calleynumero,proveedores.ciudad,proveedores.estado,proveedores.codigopostal,consulados.ubicacion,proveedores.telefono,proveedores.personaautorizadarecursosfinancieros,proveedores.personaparaestablecercontacto, proveedores.telefonocontacto, proveedores.emailcontacto, proveedores.numerodecuenta, proveedores.sucursal, proveedores.claveinterbancaria, proveedores.nombredelbanco, proveedores.consuladoproveedor, proveedores.programaproveedor, programas.programa FROM proveedores 
					    LEFT JOIN consulados ON proveedores.consuladoproveedor = consulados.id 
					    LEFT JOIN programas ON proveedores.programaproveedor = programas.id
					    WHERE programaproveedor like '".$_POST['filtroprograma']."%'
					    LIMIT ".$my_from.",20";
				}
			}
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Consulado</th>
					<th>Programa</th>
					<th>Nombre del Proveedor</th>
					<th>Dirección</th>
					<th>Teléfono</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>".$row["programa"]."</td>";
					echo "<td>".$row["nombreproveedor"]."</td>";
					echo "<td>".$row["calleynumero"]."<br>".$row["ciudad"].", ".$row["estado"]."<br>".$row["codigopostal"]."</td>";
					echo "<td>".$row["telefono"]."</td>";
					echo '<td><button type="button" class="btn btn-default" onclick="showfullinfoProveedor('.$row["id"].')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>&nbsp;<button type="button" class="btn btn-default" onclick="editProovedor(\''.$row["id"].'\',\''.htmlspecialchars($row["nombreproveedor"], ENT_QUOTES).'\',\''.$row["personaautorizadarecursosfinancieros"].'\',\''.$row["personaparaestablecercontacto"].'\',\''.$row["telefonocontacto"].'\',\''.$row["emailcontacto"].'\',\''.$row["calleynumero"].'\',\''.$row["ciudad"].'\',\''.$row["estado"].'\',\''.$row["codigopostal"].'\',\''.$row["telefono"].'\',\''.$row["nombredelbanco"].'\',\''.$row["sucursal"].'\',\''.$row["numerodecuenta"].'\',\''.$row["claveinterbancaria"].'\',\''.$row["consuladoproveedor"].'\',\''.$row["programaproveedor"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen proveedores en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
<?php
	include "connect.php";
	$conn1 = new mysqli($servername, $username, $password, $dbname);
	if ($conn1->connect_error) {
	    die("Connection failed: " . $conn1->connect_error);
	}
	$sql_paginacion = "select * from proveedores";
	$condecontar = $conn1->query($sql_paginacion);
	$cuantas_paginas = ceil ($condecontar->num_rows / 20);
	echo '<br><center>
		<nav>';
	if($_POST['filtroconsulado'] != 0){
		echo '<ul class="pagination" id="pagination" style="display: none;">';
	}else{
		if($_POST['filtroprograma'] != ""){
			echo '<ul class="pagination" id="pagination" style="display: none;">';
		}else{
			echo '<ul class="pagination" id="pagination">';
		}
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
		      <a href="#" onclick="loadProveedor(\''.($my_from-20).'\')" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}

    
	$s =0;
	for ($i=1; $i < $cuantas_paginas+1; $i++){ 
		if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
		if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadProveedor(\"".$s."\")'>".$i."</a></li>";}
		else{ echo "<li><a href='#' onclick='loadProveedor(\"".$s."\")'>".$i."</a></li>";}
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
			      <a href='#' onclick='loadProveedor(\"".($my_from+20)."\")' aria-label='Next'>
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
  </script>

<div class="modal fade" id="myModalNuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Proveedor</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevoproveedor" method="post" action="addproveedor.php">
			  <div class="form-group">
			    <label for="labelnombreproveedor">Nombre del proveedor</label>
			    <input type="text" class="form-control" name="nombreproveedor" id="nombreproveedor" placeholder="Nombre del proveedor">
			  </div>
			  <div class="form-group">
			    <label for="labelpersonaautorizadarecursosfinancieros">Nombre de la persona autorizada para recibir recursos financieros</label>
			    <input type="text" class="form-control" name="personaautorizadarecursosfinancieros" id="personaautorizadarecursosfinancieros" placeholder="Nombre de la persona autorizada para recibir recursos financieros">
			  </div>
			  <div class="panel panel-primary">
			  <div class="panel-heading">Contacto</div>
			  <div class="panel-body">
			  <div class="form-group">
			    <label for="labelpersonaparaestablecercontacto">Nombre de la persona para establecer contacto</label>
			    <input type="text" class="form-control" name="personaparaestablecercontacto" id="personaparaestablecercontacto" placeholder="Nombre de la persona para establecer contacto">
			    <label for="labeltelefonocontacto">Teléfono de contacto</label>
			    <input type="text" class="form-control" name="telefonocontacto" id="telefonocontacto" placeholder="Teléfono de contacto">
			    <label for="labelemailcontacto">Email de contacto</label>
			    <input type="text" class="form-control" name="emailcontacto" id="emailcontacto" placeholder="Email de contacto">
			  </div>
			  </div>
			  </div>
			  <div class="row">
			  <div class="col-md-6">
			  <div class="panel panel-primary">
			  <div class="panel-heading">Dirección y Teléfono</div>
			  <div class="panel-body">
				  <div class="form-group">
				    <label for="labelcalleynumero">Calle y número</label>
				    <input type="text" class="form-control" name="calleynumero" id="calleynumero" placeholder="Calle y número">
				  </div>
				  <div class="form-group">
				    <label for="labelciudad">Ciudad</label>
				    <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ciudad">
				  </div>
				  <div class="form-group">
				    <label for="labelciudad">Estado</label>
				    <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado">
				  </div>
				  <div class="form-group">
				    <label for="labelcodigopostal">Código Postal</label>
				    <input type="text" class="form-control" name="codigopostal" id="codigopostal" placeholder="Código Postal">
				  </div>
				  <div class="form-group">
				    <label for="labeltelefono">Teléfono</label>
				    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono">
				  </div>
				</div>
				</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
					  <div class="panel-heading">Información Bancaria</div>
					  <div class="panel-body">
					  		<div class="form-group">
							    <label for="labelnombredelbanco">Nombre del Banco</label>
							    <input type="text" class="form-control" name="nombredelbanco" id="nombredelbanco" placeholder="Nombre del Banco">
							 </div>
							 <div class="form-group">
							    <label for="labelsucursal">Sucursal</label>
							    <input type="text" class="form-control" name="sucursal" id="sucursal" placeholder="Sucursal">
							 </div>
							 <div class="form-group">
							    <label for="labelsucursal">Número de cuenta</label>
							    <input type="text" class="form-control" name="numerodecuenta" id="numerodecuenta" placeholder="Número de cuenta">
							 </div>
							 <div class="form-group">
							    <label for="labelclaveinterbancaria">Clave Interbancaria</label>
							    <input type="text" class="form-control" name="claveinterbancaria" id="claveinterbancaria" placeholder="Clave Interbancaria">
							 </div>
					  </div>
					</div>
				</div>
				</div>
			  <div class="form-group">
			    <label for="labelconsuladoproveedor">Consulado</label>
			    <select class="form-control" name="consuladoproveedor" id="consuladoproveedor">
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
			    <label for="labelprogramaproveedor">Programa</label>
			    <select class="form-control" name="programaproveedor" id="programaproveedor">
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
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertProveedor();">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalShowProveedorFullInfo" tabindex="-1" role="dialog" aria-labelledby="myModalShowProveedorFullInfoLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalShowProveedorFullInfoLabel">Información del Proveedor</h4>
      </div>
      <div class="modal-body" id="myModalShowProveedorFullInfoBody">
        <img src='loader.gif' style='height: 50px;'/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModalEditProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Proveedor</h4>
      </div>
      <div class="modal-body">
			<form id="formeditproveedor" method="post" action="updateproveedor.php">
			  <div class="form-group">
			    <label for="labeleditnombreproveedor">Nombre del proveedor</label>
			    <input type="text" class="form-control" name="editnombreproveedor" id="editnombreproveedor" placeholder="Nombre del proveedor">
			  </div>
			  <div class="form-group">
			    <label for="labeleditpersonaautorizadarecursosfinancieros">Nombre de la persona autorizada para recibir recursos financieros</label>
			    <input type="text" class="form-control" name="editpersonaautorizadarecursosfinancieros" id="editpersonaautorizadarecursosfinancieros" placeholder="Nombre de la persona autorizada para recibir recursos financieros">
			  </div>
			  <div class="panel panel-primary">
			  <div class="panel-heading">Contacto</div>
			  <div class="panel-body">
			  <div class="form-group">
			    <label for="labeleditpersonaparaestablecercontacto">Nombre de la persona para establecer contacto</label>
			    <input type="text" class="form-control" name="editpersonaparaestablecercontacto" id="editpersonaparaestablecercontacto" placeholder="Nombre de la persona para establecer contacto">
			    <label for="labeledittelefonocontacto">Teléfono de contacto</label>
			    <input type="text" class="form-control" name="edittelefonocontacto" id="edittelefonocontacto" placeholder="Teléfono de contacto">
			    <label for="labeleditemailcontacto">Email de contacto</label>
			    <input type="text" class="form-control" name="editemailcontacto" id="editemailcontacto" placeholder="Email de contacto">
			  </div>
			  </div>
			  </div>
			  <div class="row">
			  <div class="col-md-6">
			  <div class="panel panel-primary">
			  <div class="panel-heading">Dirección y Teléfono</div>
			  <div class="panel-body">
				  <div class="form-group">
				    <label for="labeleditcalleynumero">Calle y número</label>
				    <input type="text" class="form-control" name="editcalleynumero" id="editcalleynumero" placeholder="Calle y número">
				  </div>
				  <div class="form-group">
				    <label for="labeleditciudad">Ciudad</label>
				    <input type="text" class="form-control" name="editciudad" id="editciudad" placeholder="Ciudad">
				  </div>
				  <div class="form-group">
				    <label for="labeleditestado">Estado</label>
				    <input type="text" class="form-control" name="editestado" id="editestado" placeholder="Estado">
				  </div>
				  <div class="form-group">
				    <label for="labeleditcodigopostal">Código Postal</label>
				    <input type="text" class="form-control" name="editcodigopostal" id="editcodigopostal" placeholder="Código Postal">
				  </div>
				  <div class="form-group">
				    <label for="labeledittelefono">Teléfono</label>
				    <input type="text" class="form-control" name="edittelefono" id="edittelefono" placeholder="Teléfono">
				  </div>
				</div>
				</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
					  <div class="panel-heading">Información Bancaria</div>
					  <div class="panel-body">
					  		<div class="form-group">
							    <label for="labeleditnombredelbanco">Nombre del Banco</label>
							    <input type="text" class="form-control" name="editnombredelbanco" id="editnombredelbanco" placeholder="Nombre del Banco">
							 </div>
							 <div class="form-group">
							    <label for="labeleditsucursal">Sucursal</label>
							    <input type="text" class="form-control" name="editsucursal" id="editsucursal" placeholder="Sucursal">
							 </div>
							 <div class="form-group">
							    <label for="labeleditnumerodecuenta">Número de cuenta</label>
							    <input type="text" class="form-control" name="editnumerodecuenta" id="editnumerodecuenta" placeholder="Número de cuenta">
							 </div>
							 <div class="form-group">
							    <label for="labeleditclaveinterbancaria">Clave Interbancaria</label>
							    <input type="text" class="form-control" name="editclaveinterbancaria" id="editclaveinterbancaria" placeholder="Clave Interbancaria">
							 </div>
					  </div>
					</div>
				</div>
				</div>
			  <div class="form-group">
			    <label for="labeleditconsuladoproveedor">Consulado</label>
			    <select class="form-control" name="editconsuladoproveedor" id="editconsuladoproveedor">
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
			    <label for="labeleditprogramaproveedor">Programa</label>
			    <select class="form-control" name="editprogramaproveedor" id="editprogramaproveedor">
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
			  <input type="hidden" id="proveid" name="proveid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateProveedor();">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$( "#filterconsuladoproveedor" ).change(function() {
    	loadProveedor(0,'',$( "#filterconsuladoproveedor" ).val());
  });
</script>