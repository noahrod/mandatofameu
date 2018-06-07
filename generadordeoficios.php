<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title"><button type="button" class="btn btn-primary" onclick="loadOficios();"><span class="glyphicon glyphicon-chevron-left"></span></button> Generador de Oficios</h3> 
	</div>
	<div class="panel-body">
		<form id="formgeneraroficio" enctype="multipart/form-data" method="post" action="oficiogenerator.php" target="_blank">
			<div class="form-group">
			    <label for="labeleditfechade">Número de Oficio</label>
			     <input type="text" class="form-control" name="numerodeoficio" id="numerodeoficio">
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Fecha</label>
			     <input type="text" class="form-control" name="fechadeoficio" id="fechadeoficio" value="<?php echo date("m/d/Y"); ?>">
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Consulado</label>
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
				    <label for="labelautorizacioncheque">Autorización</label>
				    <select class="form-control" name="autorizacionoficio" id="autorizacionoficio">
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
			    <label for="labeleditfechade">Correspondientes a:</label>
			    <textarea class="form-control" rows="5" name="correspondientesa" id="correspondientesa">En seguimiento a las instrucciones contenidas en la comunicación [[autorizacion]] del pasado [[fechaautorizacion]], relacionada con el ejercicio de los recursos del Mandato para la estrategia Fortalecimiento para la Atención a Mexicanos en Estados Unidos autorizado por la Secretaría de Hacienda y Crédito Público (SHCP), adjunto al presente se hacen llegar los cheques correspondientes a la Cuarta Radicación del Programa de Asistencia Jurídica a Mexicanos a través de Asesorías Legales Externas Ejercicio 2015-2018, mismos que se detallan a continuación:</textarea>
			</div>
			<div class="form-group">
			    <label for="exampleInputFile">Cheques <button type="button" class="btn btn-success" onclick="getchequeinfo($('#chequesenvio').val());">+</button></label>
			    <select class="form-control" name="chequesenvio" id="chequesenvio">
			    <option></option>
				  <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT numerodecheque,nombreproveedor FROM `cheques` left join proveedores on cheques.proveedorcheque = proveedores.id";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["numerodecheque"]."'>".$row1["numerodecheque"]." - ".$row1["nombreproveedor"]."</option>";
						}
					}else{
						echo "<option>Aún no hay cheques dados de alta.</option>";
					}
				  	$conn1->close();
				  ?>
				</select>
				
			  </div>
			  <div id="chequesoficio">
			  	<br>
			  </div>
			  <br>
			  <div class="form-group">
			    <label for="labeleditfechade">Acuse:</label>
			    <textarea class="form-control" rows="5" name="acuse" id="acuse">Se agradecerá el acuse de recibo correspondiente una vez que sean recibidos los cheques en esa Representación consular, mediante correo electrónico a este consulado con copia a la DGPME.</textarea>
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Con copia para:</label>
			    <textarea class="form-control" rows="2" name="leccp" id="leccp">c.c.p.-Dirección General de Protección a Mexicanos en el Exterior.- Para su conocimiento.
			    </textarea>
			</div>
			<button type="submit" class="btn btn-primary" onclick="">Generar</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	var contadorvariable = 0;
    function getchequeinfo(numerodecheque){
      contadorvariable++;
      $('#myModalShowProveedorFullInfo').modal('show');
      $.ajax({
        method: "POST",
        url: "getchequeinfo.php",
        data: { numerodecheque: numerodecheque, varnumba:  contadorvariable}
      })
        .done(function( msg ) {
          $("#chequesoficio").append(msg);
        });
    }
    $( "#fechadeoficio" ).datepicker();
</script>
