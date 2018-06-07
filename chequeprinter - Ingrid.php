<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
  header("Location: index.php");
}
include "connect.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT cheques.id,autorizaciones.numerodecorreo,proveedores.nombreproveedor,cheques.cantidadcheque,cheques.fecha, consulados.ubicacion, programas.programa FROM cheques 
  LEFT JOIN autorizaciones ON cheques.autorizacioncheque = autorizaciones.id
  LEFT JOIN consulados ON cheques.consuladocheque = consulados.id
  LEFT JOIN proveedores ON cheques.proveedorcheque = proveedores.id
  LEFT JOIN programas ON proveedores.programaproveedor = programas.id
  WHERE cheques.id='".$_GET['checkid']."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>ChequePrinter</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.2.3/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
  <br>
  <?php
    echo '<span style="font-size: 14px; float: right; position: relative; top: -5px;text-transform: uppercase;font-weight: bold;">'.date("F d, Y", strtotime($row["fecha"])).'</span>';
  ?>
  <br>
  <br>
  <?php
    if(strlen($row["nombreproveedor"]) > 60){
      echo '<span style="position: relative; font-size: 12px; position: relative;top: 12px; left: 40px;text-transform: uppercase;font-weight: bold;">'.$row["nombreproveedor"].'</span>';
    }else{
      echo '<span style="position: relative; font-size: 14px; position: relative;top: 12px; left: 80px;text-transform: uppercase;font-weight: bold;">'.$row["nombreproveedor"].'</span>';
    }
    
  ?>
  <?php
    echo '<span style="position: relative; font-size: 14px; float: right; position: relative;top: 18px; left: -20px; text-transform: uppercase;font-weight: bold;">'.$row["cantidadcheque"].'</span>';
  ?>
  <br>
  <?php
    $explode = explode('.', $row["cantidadcheque"]);
    echo '<span style="position: relative; font-size: 12px; position: relative;top: 27px; left: 100px; text-transform: uppercase;font-weight: bold;"><i>'.convert_number($explode[0]).' DOLLARS AND '.convert_number($explode[1]).' CENTS</i></span>';
  ?>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <?php
    echo '<span style="position: relative; font-size: 12px; position: relative;top: 20px; left: 50px; text-transform: uppercase;font-weight: bold;">Autorización '.$row["numerodecorreo"].'</span>';
  ?>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="contenedorcopia1" style="text-transform: uppercase;">
  <b>Nombre del Proveedor: </b> <?php echo $row["nombreproveedor"]; ?><br>
  <b>Consulado: </b> <?php echo $row["ubicacion"]; ?><br>
  <b>Autorización: </b> <?php echo $row["numerodecorreo"]; ?><br>
  <b>Programa: </b> <?php echo $row["programa"]; ?><br>
  <b>Fecha: </b> <?php echo date("F d, Y", strtotime($row["fecha"])); ?><br>
  <b>Monto: </b> <?php echo $row["cantidadcheque"]; ?> USD<br>
  <br>
  <br>
  <br>
  <div id="firmacopia15" style="float: right; border-top: 1px solid #000;">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AUTORIZÓ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
  </div>
  <div id="firmacopia1" style="float: right; border-top: 1px solid #000; position: relative;left: -90px;">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REVISÓ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
  </div>
  
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="contenedorcopia2" style="text-transform: uppercase;">
  <b>Nombre del Proveedor: </b> <?php echo $row["nombreproveedor"]; ?><br>
  <b>Consulado: </b> <?php echo $row["ubicacion"]; ?><br>
  <b>Autorización: </b> <?php echo $row["numerodecorreo"]; ?><br>
  <b>Programa: </b> <?php echo $row["programa"]; ?><br>
  <b>Fecha: </b> <?php echo date("F d, Y", strtotime($row["fecha"])); ?><br>
  <b>Monto: </b> <?php echo $row["cantidadcheque"]; ?> USD<br>
  <br>
  <br>
  <br>
  <div id="firmacopia25" style="float: right; border-top: 1px solid #000;">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AUTORIZÓ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
  </div>
  <div id="firmacopia2" style="float: right; border-top: 1px solid #000;position: relative;left: -90px;">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REVISÓ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
  </div>

</div>



  </section>
<?php
function convert_number($number)  
{  
    if (($number < 0) || ($number > 999999999))  
    {  
        return "$number";  
    }  

    $Gn = floor($number / 1000000);  /* Millions (giga) */  
    $number -= $Gn * 1000000;  
    $kn = floor($number / 1000);     /* Thousands (kilo) */  
    $number -= $kn * 1000;  
    $Hn = floor($number / 100);      /* Hundreds (hecto) */  
    $number -= $Hn * 100;  
    $Dn = floor($number / 10);       /* Tens (deca) */  
    $n = $number % 10;               /* Ones */  

    $res = "";  

    if ($Gn)  
    {  
        $res .= convert_number($Gn) . " Million";  
    }  

    if ($kn)  
    {  
        $res .= (empty($res) ? "" : " ") .  
            convert_number($kn) . " Thousand";  
    }  

    if ($Hn)  
    {  
        $res .= (empty($res) ? "" : " ") .  
            convert_number($Hn) . " Hundred";  
    }  

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",  
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",  
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",  
        "Nineteen");  
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",  
        "Seventy", "Eigthy", "Ninety");  

    if ($Dn || $n)  
    {  
        if (!empty($res))  
        {  
//            $res .= " and ";  
           $res .= " ";  
        }  

        if ($Dn < 2)  
        {  
            $res .= $ones[$Dn * 10 + $n];  
        }  
        else  
        {  
            $res .= $tens[$Dn];  

            if ($n)  
            {  
                $res .= "-" . $ones[$n];  
            }  
        }  
    }  

    if (empty($res))  
    {  
        $res = "zero";  
    }  

    return $res;  
}  

?>
</body>

</html>