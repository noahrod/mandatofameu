<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title"><button type="button" class="btn btn-primary" onclick="loadCorreos();"><span class="glyphicon glyphicon-chevron-left"></span></button> Generador de Correos</h3> 
	</div>
	<div class="panel-body">
		<form id="formgeneraroficio" enctype="multipart/form-data" method="post" action="./word/correogenerator.php" target="_blank">
			<div class="form-group">
			    <label for="labeleditfechade">Número de Correo</label>
			     <input type="text" class="form-control" name="numerodecorreo" id="numerodecorreo">
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Fecha</label>
			     <input type="text" class="form-control" name="fechadecorreo" id="fechadecorreo" value="<?php echo date("m/d/Y"); ?>">
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
							echo "<option value='".$row1["ubicacion"]."'>".$row1["ubicacion"]."</option>";
						}
					}else{
						echo "<option>"."No hay consulados dados de alta."."</option>";	
					}
				  	$conn1->close();
				  ?>
				</select>
			</div>
			<div class="form-group">
				    <label for="labelautorizacioncheque">Autorización <button type="button" class="btn btn-success" onclick="getauthoinfo($('#autorizacioncorreo').val());">+</button></label> 
				    <select class="form-control" name="autorizacioncorreo" id="autorizacioncorreo">
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
				  <div id="autorizacioncorreodiv">
				  </div>
				  <br>
			<div class="form-group">
			    <label for="labeleditfechade">Oficios</label>
			     <input type="text" class="form-control" name="oficios" id="oficios">
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Número de Cheques</label>
			     <input type="text" class="form-control" name="numcheques" id="numcheques">
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Correspondientes a:</label>
			    <textarea class="form-control" rows="5" name="correspondientesa" id="correspondientesa">En seguimiento a las comunicaciones de referencia relativas al ejercicio de los recursos del Mandato para la estrategia Fortalecimiento para la Atención a Mexicanos en Estados Unidos autorizado por la Secretaría de Hacienda y Crédito Público (SHCP), se remite anexa copia de nuestras comunicaciones [[oficios]], las cuales contienen información relativa al envío de [[numcheques]] cheques correspondientes al pago de: </textarea>
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Tipo de Pago</label>
			     <select class="form-control" name="tpago" id="tpago">
			    <option></option>
			    <option value="adenda">Adenda</option>
			    <option value="pale">PALE</option>
			    <option value="ime">IME</option>
			    <option value="adendapale">Adenda y PALE</option>
			    <option value="adendaime">Adenda e IME</option>
			    <option value="paleime">PALE e IME</option>
			    <option value="adendapaleime">Adenda, PALE e IME</option>
				</select>
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Envío</label>
			     <select class="form-control" name="envio" id="envio">
			    <option></option>
				  <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,tracking FROM `envios`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["tracking"]."'>".$row1["tracking"]."</option>";
						}
					}else{
						echo "<option>"."No hay envíos dados de alta."."</option>";	
					}
				  	$conn1->close();
				  ?>
				</select>
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Información envío:</label>
			    <textarea class="form-control" rows="5" name="textoenvio" id="textoenvio">Al respecto, se hace de su conocimiento que dichos valores fueron enviados mediante el servicio de mensajería USPS, los cuales pueden ser rastreados bajo el número de guía [[trackingenvio]].</textarea>
			</div>
			<div class="form-group">
			    <label for="labeleditfechade">Solicitud de notificación</label>
			    <textarea class="form-control" rows="5" name="textoenviocierre" id="textoenviocierre">Se agradecerá notificar la recepción de los cheques mediante correo electrónico a esta Representación consular con copia a la DGPME.</textarea>
			</div>
			  <br>
			<button type="submit" class="btn btn-primary" onclick="">Generar</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	var contadorvariable = 0;
    function getauthoinfo(autorizacion){
      contadorvariable++;
      $.ajax({
        method: "POST",
        url: "getauthoinfo.php",
        data: {autorizacion:autorizacion, varnumba:contadorvariable}
      })
        .done(function( msg ) {
          $("#autorizacioncorreodiv").append(msg);
        });
    }
    $( "#fechadecorreo" ).datepicker();
</script>
