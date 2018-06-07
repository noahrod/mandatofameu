<?php
	include "connect.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT proveedores.id,proveedores.nombreproveedor,proveedores.calleynumero,proveedores.ciudad,proveedores.estado,proveedores.codigopostal,proveedores.telefono,consulados.ubicacion,proveedores.telefono, proveedores.personaautorizadarecursosfinancieros, proveedores.personaparaestablecercontacto, proveedores.telefonocontacto, proveedores.emailcontacto, proveedores.nombredelbanco, proveedores.sucursal, proveedores.claveinterbancaria, proveedores.numerodecuenta, programas.programa FROM proveedores 
	    LEFT JOIN consulados ON proveedores.consuladoproveedor = consulados.id 
	    LEFT JOIN programas ON proveedores.programaproveedor = programas.id
	    WHERE proveedores.id = '".$_GET['pid']."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
	}else{
		echo "No existe proveedor con ese id en el sistema.";
	}
?>
<form id="" method="" action="">
			  <div class="form-group">
			    <label for="labelnombreproveedor">Nombre del proveedor: </label>
			    <?php echo $row['nombreproveedor']; ?>
			  </div>
			  <div class="form-group">
			    <label for="labelpersonaautorizadarecursosfinancieros">Nombre de la persona autorizada para recibir recursos financieros: </label>
			    <?php echo $row['personaautorizadarecursosfinancieros']; ?>
			  </div>
			  <div class="panel panel-primary">
			  <div class="panel-heading">Contacto</div>
			  <div class="panel-body">
			  <div class="form-group">
			    <label for="labelpersonaparaestablecercontacto">Nombre de la persona para establecer contacto: </label>
			    <?php echo $row['personaparaestablecercontacto']; ?><br>
			    <label for="labeltelefonocontacto">Teléfono de contacto: </label>
			    <?php echo $row['telefonocontacto']; ?><br>
			    <label for="labelemailcontacto">Email de contacto: </label>
			    <?php echo $row['emailcontacto']; ?><br>
			  </div>
			  </div>
			  </div>
			  <div class="row">
			  <div class="col-md-6">
			  <div class="panel panel-primary">
			  <div class="panel-heading">Dirección y Teléfono</div>
			  <div class="panel-body">
				  <div class="form-group">
				    <label for="labelcalleynumero">Calle y número: </label>
				    <?php echo $row['calleynumero']; ?>
				  </div>
				  <div class="form-group">
				    <label for="labelciudad">Ciudad: </label>
				    <?php echo $row['ciudad']; ?>
				  </div>
				  <div class="form-group">
				    <label for="labelciudad">Estado: </label>
				    <?php echo $row['estado']; ?>
				  </div>
				  <div class="form-group">
				    <label for="labelcodigopostal">Código Postal: </label>
				    <?php echo $row['codigopostal']; ?>
				  </div>
				  <div class="form-group">
				    <label for="labeltelefono">Teléfono</label>
				    <?php echo $row['telefono']; ?>
				  </div>
				</div>
				</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
					  <div class="panel-heading">Información Bancaria</div>
					  <div class="panel-body">
					  		<div class="form-group">
							    <label for="labelnombredelbanco">Nombre del Banco: </label>
							    <?php echo $row['nombredelbanco']; ?>
							 </div>
							 <div class="form-group">
							    <label for="labelsucursal">Sucursal: </label>
							    <?php echo $row['sucursal']; ?>
							 </div>
							 <div class="form-group">
							    <label for="labelnumerodecuenta">Número de cuenta: </label>
							    <?php echo $row['numerodecuenta']; ?>
							 </div>
							 <div class="form-group">
							    <label for="labelclaveinterbancaria">Clave Interbancaria: </label>
							    <?php echo $row['claveinterbancaria']; ?>
							 </div>
					  </div>
					</div>
				</div>
				</div>
			  <div class="form-group">
			    <label for="labelconsuladoproveedor">Consulado: </label>
			    <?php echo $row['ubicacion']; ?>
			  </div>
			  <div class="form-group">
			    <label for="labelconsuladoproveedor">Programa: </label>
			    <?php echo $row['programa']; ?>
			  </div>
			</form>