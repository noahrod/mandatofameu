<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
  header("Location: index.php");
}

$header = '<img src="logo.png" style="width: 200px;">
    <div style="position: relative; top: -50px;">
          <center>
            <span><b>Reporte Mandato FAMEU</b></span><br/>
            <span><b>Desde:</b> '.$_POST["fechade"].' &nbsp; <b>Hasta:</b> '.$_POST["fechahasta"].'</span><br/>
            <span style="float: right; position: relative; top: -50px;">[[pagina]]</span>
          </center>
    </div>';

$sqlbody="";
$sqlbodypage[] = array();
$sqlheader="";
$sqlfooterfinal="";
$sqlfooter="";
$sumacheques=0;
$sumatransferencias=0;
$sqlheader.= '<table style="width: 100%;">';
$sqlheader.= '<thead style="text-align: left; border-bottom: 2px solid #000;">
    <tr>
    <th style="width: 150px;">Autorización</th>
    <th style="width: 150px;">Consulado</th>
    <th style="width: 120px;">Programa</th>
    <th style="width: 250px;">Proveedor</th>
    <th style="width: 80px;">Tipo</th>
    <th>#</th>
    <th style="width: 90px;">Fecha</th>
    <th style="width: 100px;text-align: right;">Cantidad</th>
    </tr>
    </thead>';
include "connect.php";
if($_POST["tipodeegreso"] == ""){
  $sql = "SELECT autorizaciones.numerodecorreo,consulados.ubicacion,proveedores.nombreproveedor,cheques.numerodecheque,cheques.cantidadcheque,cheques.fecha, programas.programa, cheques.autorizacioncheque, cheques.consuladocheque, cheques.proveedorcheque FROM cheques 
        LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
        LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
        LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
        LEFT JOIN programas ON proveedores.programaproveedor = programas.id
        WHERE CAST(`cheques`.`fecha` AS DATE) between STR_TO_DATE('".$_POST["fechade"]."', '%m/%d/%Y') AND STR_TO_DATE('".$_POST["fechahasta"]."', '%m/%d/%Y')";
        if($_POST["consulado"] != ""){
          $sql.=" AND cheques.consuladocheque = '".$_POST["consulado"]."'";
        }
        if($_POST["programa"] != ""){
          $sql.=" AND proveedores.programaproveedor = '".$_POST["programa"]."'";
        }
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $sqlbody.= "<tr>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["numerodecorreo"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["ubicacion"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["programa"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["nombreproveedor"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>CHEQUE</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["numerodecheque"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".date("m/d/Y", strtotime($row["fecha"]))."</td>";
      $sqlbody.= "<td style='text-align: right;padding-top: 5px;'>".number_format($row["cantidadcheque"],3)."</td>";
      $sumacheques = $sumacheques + floatval($row["cantidadcheque"]);
      $sqlbody.= "</tr>";
    }
  }
  $conn->close();
  $sql = "SELECT transferencias.id,transferencias.confirmacion, proveedores.nombreproveedor, transferencias.fechadeenvio, transferencias.destino, transferencias.consulado, consulados.ubicacion, transferencias.autorizacion, autorizaciones.numerodecorreo, transferencias.cantidad, programas.programa
        FROM `transferencias` 
        LEFT JOIN proveedores on transferencias.destino = proveedores.id
        LEFT JOIN consulados on transferencias.consulado = consulados.id
        LEFT JOIN autorizaciones on transferencias.autorizacion = autorizaciones.id
        LEFT JOIN programas on proveedores.programaproveedor = programas.id
        WHERE STR_TO_DATE(fechadeenvio, '%m/%d/%Y') between STR_TO_DATE('".$_POST["fechade"]."', '%m/%d/%Y') AND STR_TO_DATE('".$_POST["fechahasta"]."', '%m/%d/%Y')";;
        if($_POST["consulado"] != ""){
          $sql.=" AND transferencias.consulado = '".$_POST["consulado"]."'";
        }
        if($_POST["programa"] != ""){
          $sql.=" AND proveedores.programaproveedor = '".$_POST["programa"]."'";
        }
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $sqlbody.= "<tr>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["numerodecorreo"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["ubicacion"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["programa"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["nombreproveedor"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>TRANSF</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".$row["confirmacion"]."</td>";
      $sqlbody.= "<td style='padding-top: 5px;'>".date("m/d/Y", strtotime($row["fechadeenvio"]))."</td>";
      $sqlbody.= "<td style='text-align: right;padding-top: 5px;'>".number_format($row["cantidad"],3)."</td>";
      $sumatransferencias = $sumatransferencias + floatval($row["cantidad"]);
      $sqlbody.= "</tr>";
    }
  }
  $conn->close();
  $sqlbody.= '<tr><td colspan="8" style="border-bottom: 2px solid #000;">&nbsp;</td></tr>';
  $sqlbody.= '<tr>
              <td colspan="7" style="text-align: right;padding-top: 5px;"><b>Total:</b></td>
              <td style="text-align: right;">'.number_format(($sumatransferencias+$sumacheques),3).'</td>
            </tr>';
}

if($_POST["tipodeegreso"] != "" ){
  if($_POST["tipodeegreso"] == "ch"){
    $sql = "SELECT autorizaciones.numerodecorreo,consulados.ubicacion,proveedores.nombreproveedor,cheques.numerodecheque,cheques.cantidadcheque,cheques.fecha, programas.programa, cheques.autorizacioncheque, cheques.consuladocheque, cheques.proveedorcheque, cheques.cancelado FROM cheques 
        LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
        LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
        LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
        LEFT JOIN programas ON proveedores.programaproveedor = programas.id
        WHERE cheques.cancelado=0 AND CAST(`cheques`.`fecha` AS DATE) between STR_TO_DATE('".$_POST["fechade"]."', '%m/%d/%Y') AND STR_TO_DATE('".$_POST["fechahasta"]."', '%m/%d/%Y') ";
        if($_POST["consulado"] != ""){
          $sql.=" AND cheques.consuladocheque = '".$_POST["consulado"]."'";
        }
        if($_POST["programa"] != ""){
          $sql.=" AND proveedores.programaproveedor = '".$_POST["programa"]."'";
        }
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    $cuantas_paginas = ceil ($result->num_rows / 11);
    //echo $cuantas_paginas . " " .$result->num_rows ."<br>";
    $contadorrowspagina = 0;
    $contadorarray = 1;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $sqlbody = "";
        if($contadorrowspagina > 10){
          $contadorrowspagina = 0;
          $contadorarray++;
        }
        $sqlbody.= "<tr>";
        $sqlbody.= "<td style='padding-top: 5px; '><div class='min41'>".$row["numerodecorreo"]."</div></td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>".$row["ubicacion"]."</td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>".$row["programa"]."</td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>".$row["nombreproveedor"]."</td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>CHEQUE</td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>".$row["numerodecheque"]."</td>";
        $sqlbody.= "<td style='padding-top: 5px;' valign='top'>".date("m/d/Y", strtotime($row["fecha"]))."</td>";
        $nam = number_format($row["cantidadcheque"],3);
        if(substr($nam, -1) == "0")
          $sqlbody.= "<td  valign='top' style='text-align: right;padding-top: 5px;'>".substr($nam, 0,-1)."</td>";
        else
          $sqlbody.= "<td  valign='top' style='text-align: right;padding-top: 5px;'>".$nam."</td>";
        $sumacheques = $sumacheques + floatval($row["cantidadcheque"]);
        $sqlbody.= "</tr>";
        $sqlbodypage[$contadorarray].= $sqlbody;
        $contadorrowspagina++;
      }
      $sqlfooterfinal.= '<tr><td colspan="8" style="border-bottom: 2px solid #000;">&nbsp;</td></tr>';
      $nam = number_format($sumacheques,3);
      if(substr($nam, -1) == "0")
        $nom = substr($nam, 0,-1);
      else
        $nom= $nam;
      $sqlfooterfinal.= '<tr>
                  <td colspan="7" style="text-align: right;padding-top: 5px;"><b>Total:</b></td>
                  <td style="text-align: right;padding-top: 5px;" valign="middle">'.$nom.'</td>
                </tr>';
    }
    $conn->close();
  }else{
    if($_POST["tipodeegreso"] == "tra"){
        $sql = "SELECT transferencias.id,transferencias.confirmacion, proveedores.nombreproveedor, transferencias.fechadeenvio, transferencias.destino, transferencias.consulado, consulados.ubicacion, transferencias.autorizacion, autorizaciones.numerodecorreo, transferencias.cantidad, programas.programa
        FROM `transferencias` 
        LEFT JOIN proveedores on transferencias.destino = proveedores.id
        LEFT JOIN consulados on transferencias.consulado = consulados.id
        LEFT JOIN autorizaciones on transferencias.autorizacion = autorizaciones.id
        LEFT JOIN programas on proveedores.programaproveedor = programas.id
        WHERE STR_TO_DATE(fechadeenvio, '%m/%d/%Y') between STR_TO_DATE('".$_POST["fechade"]."', '%m/%d/%Y') AND STR_TO_DATE('".$_POST["fechahasta"]."', '%m/%d/%Y')";
        if($_POST["consulado"] != ""){
          $sql.=" AND transferencias.consulado = '".$_POST["consulado"]."'";
        }
        if($_POST["programa"] != ""){
          $sql.=" AND proveedores.programaproveedor = '".$_POST["programa"]."'";
        }
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $result = $conn->query($sql);
        $cuantas_paginas = ceil ($result->num_rows / 11);
        $contadorrowspagina = 0;
        $contadorarray = 1;
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $sqlbody = "";
            if($contadorrowspagina > 10){
              $contadorrowspagina = 0;
              $contadorarray++;
            }
            $sqlbody.= "<tr>";
            $sqlbody.= "<td style='padding-top: 5px;'>".$row["numerodecorreo"]."</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>".$row["ubicacion"]."</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>".$row["programa"]."</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>".$row["nombreproveedor"]."</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>TRANSF</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>".$row["confirmacion"]."</td>";
            $sqlbody.= "<td style='padding-top: 5px;'>".date("m/d/Y", strtotime($row["fechadeenvio"]))."</td>";
            $nam = number_format($row["cantidad"],3);
            if(substr($nam, -1) == "0")
              $nom = substr($nam, 0,-1);
            else
              $nom= $nam;
            $sqlbody.= "<td style='text-align: right;padding-top: 5px;'>".$nom."</td>";
            $sumatransferencias = $sumatransferencias + floatval($row["cantidad"]);
            $sqlbody.= "</tr>";
            $sqlbodypage[$contadorarray].= $sqlbody;
            $contadorrowspagina++;
          }
        }
        $conn->close();
        $sqlfooterfinal.= '<tr><td colspan="8" style="border-bottom: 2px solid #000;">&nbsp;</td></tr>';
        $nam = number_format($sumatransferencias,3);
        if(substr($nam, -1) == "0")
          $nom = substr($nam, 0,-1);
        else
          $nom= $nam;
        $sqlfooterfinal.= '<tr>
                    <td colspan="7" style="text-align: right;padding-top: 5px;"><b>Total:</b></td>
                    <td style="text-align: right;">'.$nom.'</td>
                  </tr>';
    }
  }
}

$sqlfooter.= '</table>';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Reporte Mandato FAMEU</title>
  <style type="text/css">
    tr:nth-child(even) {background: #eee}
    .min41{
      min-height: 41px;
    }
  </style>
  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.2.3/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: landscape;}</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="landscape letter">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  
 <?php
    //echo $sqlbody;
    for($i=1;$i<=$cuantas_paginas;$i++){
      echo '<section class="sheet padding-10mm">
            ' .str_replace("[[pagina]]", "<small>Página ". $i . "</small>", $header).$sqlheader. $sqlbodypage[$i];
      if($i == $cuantas_paginas){
        echo $sqlfooterfinal;
      }
      echo  $sqlfooter .'
            </section>';
    }
 ?> 
  

  
</body>

</html>