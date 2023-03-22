<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<?php require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min	= date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$invnum = $_REQUEST['invnum'];
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,sucursal,hora FROM venta where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum   = $row['invnum'];
		$nrovent  = $row['nrovent'];
		$invfec   = $row['invfec'];
		$cuscod   = $row['cuscod'];
		$usecod   = $row['usecod'];
		$bruto    = $row['bruto'];
		$valven   = $row['valven'];
		$invtot   = $row['invtot'];
		$forpag   = $row['forpag'];
		$sucursal = $row['sucursal'];
		$hora     = $row['hora'];
		$igv      = $row['igv'];
}
}
$sql="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
$result = mysqli_query($conexion,$sql); 
while ($row = mysqli_fetch_array($result)){ 
$nloc	= $row["nomloc"];
$nombre	= $row["nombre"];
	if ($nombre == '')
	{
	$locals = $nloc;
	}
	else
	{
	$locals = $nombre;
	}
}
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$descli    = $row['descli'];
}
}
$sql="SELECT nomusu FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nomusu    = $row['nomusu'];
}
}
$dcto = $bruto - $valven;
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REPORTE DE VENTA</title>
</head>

<body>
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="922"><table width="935" border="0" align="center">
      <tr>
        <td width="85"><strong>NUMERO</strong></td>
        <td width="81"><?php echo formato($nrovent)?></td>
        <td width="65"><strong>FECHA</strong></td>
        <td width="78"><?php echo fecha($invfec)?></td>
        <td width="99"><strong>FORMA DE PAGO </strong></td>
        <td width="212"><?php echo $forpag?></td>
        <td width="71"><strong>LOCAL</strong></td>
        <td width="210"><?php echo $locals?></td>
      </tr>
    </table>
      <table width="935" border="0" align="center">
        <tr>
          <td width="85"><strong>CLIENTE</strong></td>
          <td width="550"><?php echo $descli?></td>
          <td width="72"><div align="left"><strong>HORA VTA </strong></div></td>
          <td width="210"><?php echo $hora;?></td>
        </tr>
    </table>
      <table width="935" border="0" align="center">
        <tr>
          <td width="85"><strong>COD VENDEDOR </strong></td>
          <td width="81"><?php echo formato1($usecod)?></td>
          <td width="65"><div align="left"><strong>VENDEDOR</strong></div></td>
          <td width="686"><?php echo $nomusu?></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="937"><table width="935" border="0" align="center">
      <tr>
        <td width="34"><strong>N&ordm;</strong></td>
        <td width="471"><strong>PRODUCTO</strong></td>
        <td width="138"><strong>MARCA</strong></td>
        <td width="84"><div align="right"><strong>CANTIDAD</strong></div></td>
        <td width="89"><div align="right"><strong>PRECIO  </strong></div></td>
        <td width="93"><div align="right"><strong>SUB TOTAL </strong></div></td>
      </tr>
    </table>
    <hr/>
	<?php $i= 0;
	$sql="SELECT codpro,canpro,fraccion,factor,prisal,pripro,cospro,codmar FROM detalle_venta where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="935" border="0" align="center">
        <?php while ($row = mysqli_fetch_array($result)){
				$codpro    = $row['codpro'];
				$canpro    = $row['canpro'];
				$fraccion    = $row['fraccion'];
				$factor    = $row['factor'];
				$prisal    = $row['prisal'];
				$pripro    = $row['pripro'];
				$cospro    = $row['cospro'];
				$codmar    = $row['codmar'];
				$sql1="SELECT desprod FROM producto where codpro = '$codpro'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				}
				}
				$sql1="SELECT destab FROM titultabladet where codtab = '$codmar'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
				$destab    = $row1['destab'];
				}
				}
				$i++;
		?>
		<tr>
          <td width="34"><?php echo $i?></td>
          <td width="471"><?php echo $desprod?></td>
          <td width="138"><?php echo substr($destab,0,5)?></td>
          <td width="84"><div align="right"><?php echo $canpro?></div></td>
          <td width="89"><div align="right"><?php echo $prisal?></div></td>
          <td width="93"><div align="right"><?php echo $pripro?></div></td>
        </tr>
		<?php }
		?>
      </table>
	<?php }
	?>
	</td>
  </tr>
</table>
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="935" border="0" align="center">
      <tr>
        <td width="94"><strong>MONTO BRUTO </strong></td>
        <td width="103"><?php echo $numero_formato_frances = number_format($bruto, 2, '.', ' ');?></td>
        <td width="43"><strong>DCTO</strong></td>
        <td width="117"><?php echo $numero_formato_frances = number_format($dcto, 2, '.', ' ');?></td>
        <td width="99"><strong>VALOR VENTA </strong></td>
        <td width="151"><?php echo $numero_formato_frances = number_format($valven, 2, '.', ' ');?></td>
        <td width="32"><strong>IGV</strong></td>
        <td width="112"><?php echo $numero_formato_frances = number_format($igv, 2, '.', ' ');?></td>
        <td width="41"><strong>TOTAL</strong></td>
        <td width="101"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' ');?></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
