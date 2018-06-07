<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Mandato FAMEU">
    <meta name="author" content="Noé Rodríguez Castro">
    <!-- Bootstrap core CSS -->
    <title>Mandato FAMEU</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="system.css" rel="stylesheet">
  </head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="system.php">Mandato FAMEU</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menú<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="loadConsulados(0)">Consulados</a></li>
            <li><a href="#" onclick="loadConsules(0)">Cónsules</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" onclick="loadProgramas()">Programas</a></li>
            <li><a href="#" onclick="loadAutorizaciones()">Autorizaciones</a></li>
            <li><a href="#" onclick="loadProveedor(0,'',0)">Proveedores</a></li>
            <li><a href="#" onclick="loadCheques(0)">Cheques</a></li>
            <li><a href="#" onclick="loadTransferencias()">Transferencias</a></li>
            <li><a href="#" onclick="loadOficios()">Oficios</a></li>
            <li><a href="#" onclick="loadCorreos()">Correos</a></li>
            <li><a href="#" onclick="loadEnvios(0)">Envíos</a></li>
            <li><a href="#" onclick="loadDevoluciones(0)">Devoluciones</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" onclick="loadContabilidad()">Contabilidad</a></li>
          </ul>
        </li>
       <li class=""><a href="logout.php">Cerrar sesión</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
 <div class="container">
  <div class="starter-template">
    <div class="row">
      <div class="col-md-12">
        <?php 
          if($_GET['ev']== "newsuccess"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Autorización agregada exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessConsul"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Cónsul agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessConsulate"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Consulado agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessProveedor"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Proveedor agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessCheques"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Cheque agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessPrograma"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Programa agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessEnvio"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Envío agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessTransferencia"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Transferencia agregada exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessOficio"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Oficio agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessCorreo"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Correo agregado exitosamente.</div>';
          }
          if($_GET['ev']== "newsuccessDevolucion"){
            echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Devolución agregada exitosamente.</div>';
          }
        ?>
      </div>
    </div>
    <div class="row">
         <div class="col-md-12">
           <div id="sitecontent">
                <div style="height: 100%;">
                  ¡Bienvenido <b><?php echo $_SESSION["lename"]; ?></b>!
                  <br><br>
                    <div class="panel panel-primary" style="">
                      <div class="panel-heading">
                        <h3 class="panel-title"><b>Indicadores</b></h3>
                      </div>
                      <div class="panel-body">
                         <?php
                            include "connect.php";
                          //
                          $conn3 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn3->connect_error) {
                              die("Connection failed: " . $conn3->connect_error);
                          }
                          $sql3 = "SELECT COUNT(*) as contados FROM `cheques` where `cancelado` = 0";
                          $result3 = $conn3->query($sql3);
                          $row3 = $result3->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-print" aria-hidden="true"></span> ' . $row3["contados"] . ' cheques impresos. &nbsp;&nbsp;&nbsp;';
                          $conn3->close();

                          $conn5 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn5->connect_error) {
                              die("Connection failed: " . $conn5->connect_error);
                          }
                          $sql5 = "SELECT COUNT(*) as contados FROM `cheques` where `cobrado` = 1";
                          $result5 = $conn5->query($sql5);
                          $row5 = $result5->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> ' . $row5["contados"] . ' cheques cobrados. &nbsp;&nbsp;&nbsp;';
                          $conn5->close();

                          $conn4 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn4->connect_error) {
                              die("Connection failed: " . $conn4->connect_error);
                          }
                          $sql4 = "SELECT COUNT(*) as contados FROM `cheques` where `cancelado` = 1";
                          $result4 = $conn4->query($sql4);
                          $row4 = $result4->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' . $row4["contados"] . ' cheques cancelados. &nbsp;&nbsp;&nbsp;';
                          $conn4->close();

                          echo "<br>";  
                          $conn2 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn2->connect_error) {
                              die("Connection failed: " . $conn2->connect_error);
                          }
                          $sql2 = "SELECT COUNT(*) as contados FROM `envios`";
                          $result2 = $conn2->query($sql2);
                          $row2 = $result2->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> ' . $row2["contados"] . ' envíos generados. &nbsp;&nbsp;&nbsp;';
                          $conn2->close();


                          $conn1 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn1->connect_error) {
                              die("Connection failed: " . $conn1->connect_error);
                          }
                          $sql1 = "SELECT COUNT(*) as contados FROM `envios` where status=1";
                          $result1 = $conn1->query($sql1);
                          $row1 = $result1->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> ' . $row1["contados"] . ' envíos recibidos.';
                          $conn1->close();

                          echo "<br>"; 

                          $conn6 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn6->connect_error) {
                              die("Connection failed: " . $conn6->connect_error);
                          }
                          $sql6 = "SELECT COUNT(*) as contados FROM `devoluciones`";
                          $result6 = $conn6->query($sql6);
                          $row6 = $result6->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> ' . $row6["contados"] . ' devoluciones recibidas. &nbsp;&nbsp;&nbsp;';
                          $conn6->close();

                          $conn7 = new mysqli($servername, $username, $password, $dbname);
                          if ($conn7->connect_error) {
                              die("Connection failed: " . $conn7->connect_error);
                          }
                          $sql7 = "SELECT COUNT(*) as contados FROM `devoluciones` where depositado = 1";
                          $result7 = $conn7->query($sql7);
                          $row7 = $result7->fetch_assoc();
                            echo '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . $row7["contados"] . ' devoluciones depositadas.';
                          $conn7->close();

                          ?>
                      </div>
                  </div>
                    <div class="panel panel-default" style="">
                      <div class="panel-heading">
                        <h3 class="panel-title"><b>Notas de desarrollo:</b></h3>
                      </div>
                      <div class="panel-body" style="max-height: 135px;  overflow: auto;">
                        <?php
                          $file_handle = fopen("notasdesarrollo.dev", "r");
                          while (!feof($file_handle)) {
                             $line = fgets($file_handle);
                             echo $line . "<br>";
                          }
                          fclose($file_handle);
                        ?>
                      </div>
                  </div>
              </div>
           </div>
         </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
function loadAutorizaciones(){
  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "autorizaciones.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadEnvios(start){
  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "envios.php?start="+start,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadOficios(){
  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "oficios.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadCorreos(){
  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "correos.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadConsulados(start){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "consulados.php?start="+start,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadConsules(start){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "consules.php?start="+start,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadDevoluciones(start){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "devoluciones.php?start="+start,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadProgramas(){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "programas.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadContabilidad(){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "contabilidad.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadProveedor(start,filtroprograma,filtroconsulado){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "proveedores.php?start="+start,
    data: { filtroprograma:  filtroprograma, filtroconsulado: filtroconsulado}
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
      if(filtroprograma != 0 || filtroconsulado != 0){
        removepagination();
      }
    });
}

function loadCheques(start){
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "cheques.php?start="+start,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function searchCheques(autorizacionsearch,consuladosearch,cantidadsearch,chequesearch){
   $('myModalSearch').modal('hide');
   $('body').removeClass('modal-open');
   $('.modal-backdrop').remove();
   $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "cheques.php?search=1&autorizacionsearch="+autorizacionsearch+"&consuladosearch="+consuladosearch+"&cantidadsearch="+cantidadsearch+"&chequesearch="+chequesearch,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function loadTransferencias(){
  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
  $.ajax({
    method: "POST",
    url: "transferencias.php",
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#sitecontent").html(msg);
    });
}

function insertAuth(){
  $("#formnuevaautorizacion").submit();
}
function insertPrograma(){
  $("#formnuevoprograma").submit();
}
function insertConsulate(){
  $("#formnuevoconsulado").submit();
}
function insertConsul(){
  $("#formnuevoconsul").submit();
}
function insertProveedor(){
  $("#formnuevoproveedor").submit();
}
function insertCheque(){
  $("#formnuevocheque").submit();
}
function updateConsulate(){
   $("#formeditconsulado").submit();
}
function insertEnvio(){
  $("#formnuevoenvio").submit();
}

function insertTransferencia(){
  $("#formnuevatransferencia").submit();
}

function insertOficio(){
  $("#formnuevooficio").submit();
}

function insertCorreo(){
  $("#formnuevocorreo").submit();
}

function insertDevolucion(){
  $("#formnuevadevolucion").submit();
}

function editAuth(aid,nc,fs,ingre){
    $('#editnumerodecorreo').val(nc);
    $('#editfechadesolicitud').val(fs);
    $('#editingresos').val(ingre);
    $('#aid').val(aid);
    $('#editfileanchor').text(nc+".pdf");
    $("#editfileanchor").attr("href", "downloadauth.php?id="+aid)
    $('#myModalEditAutorizacion').modal('show');
}

function editDevolucion(did,con,numcom,prove,tipodev,cant){
    $('#editconsuladodevolucion').val(con);
    $('#editproveedordevolucion').val(prove);
    $('#editnumerodecomunicaciondevolucion').val(numcom);
    $('#edittipodedevolucion').val(tipodev);
    $('#editcantidaddevolucion').val(cant);
    $('#devid').val(did);
    $('#editfileanchor').text(numcom+".pdf");
    $("#editfileanchor").attr("href", "downloaddevolucion.php?id="+did)
    $('#myModalEditDevolucion').modal('show');
}


function editOficio(oid,no,f,co){
    $('#editnumerodeoficio').val(no);
    $('#editfechadeoficio').val(f);
    $('#editconsuladooficio').val(co);
    $('#oid').val(oid);
    $('#editfileanchor').text(no+".pdf");
    $("#editfileanchor").attr("href", "downloadoficio.php?id="+oid)
    $('#myModalEditOficio').modal('show');
}

function editCorreo(cid,nc,f,co){
    $('#editnumerodecorreo').val(nc);
    $('#editfechadecorreo').val(f);
    $('#editconsuladocorreo').val(co);
    $('#cid').val(cid);
    $('#editfileanchor').text(nc+".pdf");
    $("#editfileanchor").attr("href", "downloadcorreo.php?id="+cid)
    $('#myModalEditCorreo').modal('show');
}

function updateOficio(){
  $("#formeditoficio").submit();
}

function updateCorreo(){
  $("#formeditcorreo").submit();
}

function updateAuth(){
  $("#formeditautorizacion").submit();
}

function updateDevolucion(){
  $("#formeditdevolucion").submit();
}

function addfichadeposito(){
  $("#formfichadepositodevolucion").submit();
}


function editTransferencia(tid,confirmacion,destino,fechadeenvio,consulado,cantidad, autorizacion){
  $('#editnumerodeconfirmacion').val(confirmacion);
  $('#editdestino').val(destino);
  $('#editfechadeenvio').val(fechadeenvio);
  $('#editconsuladotransferencia').val(consulado);
  $('#editcantidadtransferencia').val(cantidad);
  $('#editautorizaciontransferencia').val(autorizacion);
  $('#tid').val(tid);
  $('#myModalEditTransferencia').modal('show');
}
function editConsulado(cid, ubicacion,calleynumero,ciudad,estado,codigopostal,telefono){
  $('#editubicacionconsulado').val(ubicacion);
  $('#editcalleynumero').val(calleynumero);
  $('#editciudad').val(ciudad);
  $('#editestado').val(estado);
  $('#editcodigopostal').val(codigopostal);
  $('#edittelefono').val(telefono);
  $('#cid').val(cid);
  $('#myModalEditConsulado').modal('show');
}

function editConsul(coid, consulado,consul,cargo,tipodeconsulado){
  $('#editconsuladoconsul').val(consulado);
  $('#editconsul').val(consul);
  $('#editcargo').val(cargo);
  $('#edittipodeconsulado').val(tipodeconsulado);
  $('#coid').val(coid);
  $('#myModalEditConsul').modal('show');
}

function updateConsul(){
  $("#formeditconsul").submit();
}

function removepagination(){
  //$("#pagination").css("display","none");
}



function editEnvio(enid, chch,dech, fechch,trach){
  $('#editchequesenvio').val(chch);
  $('#editdestino').val(dech);
  $('#editfechadeenvio').val(fechch);
  $('#edittracking').val(trach);
  $('#enid').val(enid);
  $('#editfilecheque').text("Cheque"+chch+".pdf");
  $("#editfilecheque").attr("href", "downloadcheque.php?id="+enid);
  $('#editfileetiqueta').text("EtiquetaCheque"+chch+".pdf");
  $("#editfileetiqueta").attr("href", "downloadetiqueta.php?id="+enid);
  $("#editlistchequesenvio").html(chch + ",");
  $('#myModalEditEnvio').modal('show');
}

function editCheque(chid, ach, cch, pch, nch, canch){
  $('#editautorizacioncheque').val(ach);
  $('#editconsuladocheque').val(cch);
  $('#editproveedorcheque').val(pch);
  $('#editnumerodecheque').val(nch);
  $('#editcantidadcheque').val(canch);
  $('#chid').val(chid);
  $('#myModalEditCheque').modal('show');
}

function updateEnvio(){
  $("#formeditenvio").submit();
}

function updateCheque(){
  $("#formeditcheque").submit();
}

function updateTransferencia(){
   $("#formedittransferencia").submit();
}

function updatePrograma(){
   $("#formeditprograma").submit();
}
function editPrograma(proid,programa){
  $('#editnombredelprograma').val(programa);
  $('#proid').val(proid);
  $('#myModalEditPrograma').modal('show');
}
function updateProveedor(){
   $("#formeditproveedor").submit();
}

function toggleenvio(id){
  $.ajax({
    method: "POST",
    url: "toggleenvio.php?id="+id,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      loadEnvios(0);
    });
}

function togglecobrocheque(id){
  $.ajax({
    method: "POST",
    url: "togglecobrocheque.php?id="+id,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      loadCheques(0);
    });
}

function toggledepositodevolucion(id){
  $.ajax({
    method: "POST",
    url: "toggledepositodevolucion.php?id="+id,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      loadDevoluciones(0);
    });
}

function removedach(uniqueidch){
  $("#"+uniqueidch).remove();
}

function removedaaut(uniqueidaut){
  $("#"+uniqueidaut).remove();
}

function editProovedor(proveid,np,parf,ppec,tc,ec,cyn,c,e,cp,t,ndb,s,ndc,ci,cp,pp){
  $('#editnombreproveedor').val(np);
  $('#editpersonaautorizadarecursosfinancieros').val(parf);
  $('#editpersonaparaestablecercontacto').val(ppec);
  $('#edittelefonocontacto').val(tc);
  $('#editemailcontacto').val(ec);
  $('#editcalleynumero').val(cyn);
  $('#editciudad').val(c);
  $('#editestado').val(e);
  $('#editcodigopostal').val(cp);
  $('#edittelefono').val(t);
  $('#editnombredelbanco').val(ndb);
  $('#editsucursal').val(s);
  $('#editnumerodecuenta').val(ndc);
  $('#editclaveinterbancaria').val(ci);
  $('#editconsuladoproveedor').val(cp);
  $('#editprogramaproveedor').val(pp);
  $('#proveid').val(proveid);
  $('#myModalEditProveedor').modal('show');
}

function showfullinfoProveedor(pid){
  $('#myModalShowProveedorFullInfo').modal('show');
  $.ajax({
    method: "POST",
    url: "proveedordetail.php?pid="+pid,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#myModalShowProveedorFullInfoBody").html(msg);
    });
}

function copytoclipboard() {
  document.execCommand("Copy");
}

function addenviochequelist(){
  $('#listchequesenvio').append( $('#chequesenvio1').val() + ",");
  $('#chequesenvio').val($('#listchequesenvio').html());
  var stripval = $('#chequesenvio').val().slice(0,-1).trim();
  $('#chequesenvio').val(stripval);
}

function addenviochequelistedit(){
  $('#editlistchequesenvio').append( $('#editchequesenvio1').val() + ",");
  $('#editchequesenvio').val($('#editlistchequesenvio').html());
  var stripval = $('#editchequesenvio').val().slice(0,-1).trim();
  $('#editchequesenvio').val(stripval);
}

function removelastenviochequelist(){
  var dacheque = $('#chequesenvio').val();
  var loscheques = dacheque.split(",");
  var result = "";
  for (var i = 0; i < (loscheques.length-1); i++) {
      result = result + loscheques[i] + ",";
  }
  $('#listchequesenvio').html(result);
  var regresalo = result.slice(0,-1)
  $('#chequesenvio').val(regresalo);
}

function removelastenviochequelistedit(){
  var dacheque = $('#editchequesenvio').val();
  var loscheques = dacheque.split(",");
  var result = "";
  for (var i = 0; i < (loscheques.length-1); i++) {
      result = result + loscheques[i] + ",";
  }
  $('#editlistchequesenvio').html(result);
  var regresalo = result.slice(0,-1)
  $('#editchequesenvio').val(regresalo);
}


function printCheque(checkID){
  var win = window.open('chequeprinter.php?checkid='+checkID, '_blank');
  win.focus();
}

function showcancelationinformation(cci){
  $('#myModalShowCancelationInformation').modal('show');
  $.ajax({
    method: "POST",
    url: "showcancelationinformation.php?cci="+cci,
    data: { london: "eye" }
  })
    .done(function( msg ) {
      $("#myModalShowCancelationInformationBody").html(msg);
    });
}

function updatecancelacioncheque(){
   $('#myModalShowCancelationInformation').modal('hide');
   var chequenumero = $('#ccia').html();
   var chequerazon = $('#rccia').html();
   $('#myModaleditCancelCheck').modal('show');
   $('#editcancelarcheque').val(chequenumero.toString());
   $('#editrazoncancelarcheque').val(chequerazon.toString());
   $('#editfileanchoreditchequecanceladoscan').text("ESCANEOCHEQUECANCELADO-"+chequenumero.toString()+".pdf");
  $("#editfileanchoreditchequecanceladoscan").attr("href", "downloadchequecancelado.php?cci="+chequenumero.toString());
   $('#editfileanchoreditcomunicacionchequecanceladoscan').text("ESCANEOCOMUNICACIONCANCELACION-"+chequenumero.toString()+".pdf");
  $("#editfileanchoreditcomunicacionchequecanceladoscan").attr("href", "downloadescaneocomunicacionchequecancelado.php?cci="+chequenumero.toString());
  $('#cciaf').val(chequenumero.toString());
}

<?php 
  if($_GET['l']== "autorizaciones"){
    echo "loadAutorizaciones();";
  }
  if($_GET['l']== "consulados"){
    echo "loadConsulados(0);";
  }
  if($_GET['l']== "consules"){
    echo "loadConsules(0);";
  }
  if($_GET['l']== "proveedores"){
    echo "loadProveedor(0,'',0);";
  }
  if($_GET['l']== "cheques"){
    echo "loadCheques(0);";
  }
  if($_GET['l']== "programas"){
    echo "loadProgramas();";
  }
  if($_GET['l']== "envios"){
    echo "loadEnvios(0);";
  }
  if($_GET['l']== "oficios"){
    echo "loadOficios();";
  }
  if($_GET['l']== "correos"){
    echo "loadCorreos();";
  }
  if($_GET['l']== "transferencias"){
    echo "loadTransferencias();";
  }
  if($_GET['l']== "devoluciones"){
    echo "loadDevoluciones(0);";
  }

?>
</script>
</body>
</html>