<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo2 {color: #FF0000}
-->
</style>
<?php require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$users    = $row['nomusu'];
}
}
$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min	   = date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$mov    = $_REQUEST['mov'];
$user   = $_REQUEST['user'];
$local  = $_REQUEST['local'];
$invnum = $_REQUEST['invnum'];
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
////////////////////////////
if ($mov == 1)
{
$desc_mov = "TODOS LOS MOVIMIENTOS";
}
if ($mov == 2)
{
$desc_mov = "SOLAMENTE INGRESOS";
}
if ($mov == 3)
{
$desc_mov = "SOLAMENTE SALIDAS";
}
if ($mov == 4)
{
$desc_mov = "COMPRAS";
}
if ($mov == 5)
{
$desc_mov = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 6)
{
$desc_mov = "DEVOLUCION EN BUEN ESTADO";
}
if ($mov == 7)
{
$desc_mov = "CANJE AL LABORATORIO";
}
if ($mov == 8)
{
$desc_mov = "OTROS INGRESOS";
}
if ($mov == 9)
{
$desc_mov = "SALIDAS VARIAS";
}
if ($mov == 10)
{
$desc_mov = "GUIAS DE REMISION";
}
if ($mov == 11)
{
$desc_mov = "SALIDA POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 12)
{
$desc_mov = "CANJE PROVEEDOR";
}
if ($mov == 13)
{
$desc_mov = "PRESTAMOS CLIENTE";
}
if ($user == 1)
{
$desc_user = "CLIENTE";
}
if ($user == 2)
{
$desc_user = "PROVEEDOR";
}
if ($user == 3)
{
$desc_user = "SUCURSAL";
}
////////////////////////////
$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,sucursal1,usecod,codusu FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invfec    = $row['invfec'];
	$invnum    = $row['invnum'];
	$tipmov    = $row['tipmov'];
	$tipdoc    = $row['tipdoc'];
	$numdoc    = $row['numdoc'];
	$cuscod    = $row['cuscod'];
	$refere    = $row['refere'];
	$monto     = $row['invtot'];
	$sucursal  	  = $row['sucursal'];
	$sucursal1    = $row['sucursal1'];
	$usecod       = $row['usecod'];
		$codusu       = $row['codusu'];
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$nomusuorig      = $row1['nomusu'];
		}}
		$sql1="SELECT nomusu FROM usuario where usecod = '$codusu'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$nomusudest      = $row1['nomusu'];
		}}
		if ($sucursal <> "")
		{
		$sql1="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$nomloc       = $row1['nomloc'];
		$nombre       = $row1['nombre'];
		if ($nombre <> "")
		{
		$nombre = $nombre;
		}
		else
		{
		$nombre = $nomloc;
		}
		}}
		}
		if ($sucursal1 <> "")
		{
		$sql1="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal1'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$nomloc1       = $row1['nomloc'];
		$nombre1      = $row1['nombre'];
		if ($nombre1 <> "")
		{
		$nombre1 = $nombre1;
		}
		else
		{
		$nombre1 = $nomloc1;
		}
		//isset($nombre1)? $nombre1 = $nombre1 : $nombre1 = $nomloc1;
		}}
		}
	if ($tipmov == 1)
				{
					if ($tipdoc == 1)
					{
					$desctip = "INGRESO POR COMPRA";
					}
					if ($tipdoc == 2)
					{
					$desctip = "INGRESO POR TRANSF";
					}
					if ($tipdoc == 3)
					{
					$desctip = "DEVOLUCI�N";
					}
					if ($tipdoc == 4)
					{
					$desctip = "CANJE AL LABORATORIO";
					}
					if ($tipdoc == 5)
					{
					$desctip = "OTROS INGRESOS";
					}
				}
				if ($tipmov == 2)
				{
					if ($tipdoc == 1)
					{
					$desctip = "SALIDAS VARIAS";
					}
					if ($tipdoc == 2)
					{
					$desctip = "GUIAS DE REMISION";
					}
					if ($tipdoc == 3)
					{
					$desctip = "SALIDA POR TRANSF";
					}
					if ($tipdoc == 4)
					{
					$desctip = "CANJE PROVEEDOR ";
					}
					if ($tipdoc == 5)
					{
					$desctip = "PRESTAM CLIENTE ";
					}
				}
				if (($tipmov == 9) && ($tipdoc == 9))
				{
					$desctip = "VENTA";
				}
				if (($tipmov == 10) && ($tipdoc == 9))
				{
					$desctip = "VENTA DESHAB";
				}
				if (($tipmov == 10) && ($tipdoc == 10))
				{
					$desctip = "VENTA HAB";
				}
				if (($tipmov == 11) && ($tipdoc == 11))
				{
					$desctip = "ING DE BONIF";
				}
				if (($tipmov == 9) && ($tipdoc == 11))
				{
					$desctip = "VENTAS POR BONIF";
				}
	if ($tipmov == 1)
	{
	$desctip_mov = "INGRESO";
	}
	else
	{
	$desctip_mov = "SALIDA";
	}
}
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>

<body>
<table width="930" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td width="380"><div align="center"><strong>REPORTE DE INGRESOS Y SALIDAS  -
          <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $nomloc;}?>
        </strong></div></td>
        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>
    </table>
        <table width="914" border="0">
          <tr>
            <td width="267"><strong><?php echo $desc_mov?></strong></td>
            <td width="366"><div align="center"><b>
              <?php if ($val == 1){?>
              NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php echo $date2; }?></b></div></td>
            <td width="267"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $users?></span></div></td>
          </tr>
        </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <td width="49"><strong>FECHA</strong></td>
        <td width="174"><div align="center"><strong>TIPO MOV </strong></div></td>
        <td width="123"><div align="left"><strong>N&ordm; DOCUMENTO </strong></div></td>
        <td width="157"><div align="left"><strong><?php echo $desc_user?></strong></div></td>
        <td width="312"><div align="left"><strong>REFERENCIA</strong></div></td>
        <td width="85"><div align="right"><strong>MONTO</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
          <tr>
            <td width="50"><?php echo fecha($invfec)?></td>
            <td width="174"><div align="center"><?php echo $desctip?></div></td>
            <td width="124"><div align="left"><?php echo formato($numdoc);?></div></td>
            <td width="156"><div align="left">
              <?php ?>
            </div></td>
            <td width="311"><?php if ($refere <> ""){?>
                <?php echo $refere;?>
              <?php }?></td>
            <td width="85"><div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' ');?></div></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php
if ($tipmov == 1)
{
	if ($tipdoc == 2)
	{
	?>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td><table width="926" border="0" align="center">
		  <tr>
			<td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre1?></td>
			<td width="150"><strong>A LOCAL:</strong> <?php echo $nombre?></td>
			<td width="310"><strong>USUAURIO ORIG: </strong> <?php echo $nomusuorig;?></td>
			<td width="316"><strong>USUAURIO DEST: </strong><?php echo $nomusudest;?></td>
		  </tr>
		</table></td>
	  </tr>
	</table>
	<?php
	}
}
if ($tipmov == 2)
{
	if ($tipdoc == 3)
	{
	?>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td><table width="926" border="0" align="center">
		  <tr>			
			<td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre?></td>
			<td width="150"><strong>A LOCAL:</strong> <?php echo $nombre1?></td>
			<td width="310"><strong>USUAURIO ORIG: </strong> <?php echo $nomusudest;?></td>
			<td width="316"><strong>USUAURIO DEST: </strong><?php echo $nomusuorig;?></td>
		  </tr>
		</table></td>
	  </tr>
	</table>
	<?php
	}
}
?>
<div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
          <td width="20"><strong> N&ordm;</strong></td>
        <td width="343"><strong>PRODUCTO</strong></td>
        <td width="62"><div align="right"><strong>CANTIDAD</strong></div></td>
        <td width="76"><div align="right"><strong>PRECIO REF </strong></div></td>
        <td width="58"><div align="right"><strong>DESC 1 </strong></div></td>
        <td width="58"><div align="right"><strong>DESC 2 </strong></div></td>
        <td width="58"><div align="right"><strong>DESC 3 </strong></div></td>
        <td width="76"><div align="right"><strong>TOTAL DCTO </strong></div></td>
		<td width="63"><div align="right"><strong>COSTO UNI. </strong></div></td>
		<td width="64"><div align="right"><strong>SUB TOTAL </strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        
	<?php 

	$sql="SELECT * FROM movmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
		$i=1;
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php 
      
      while ($row = mysqli_fetch_array($result)){
	  		$codpro    = $row['codpro'];
			$qtypro    = $row['qtypro'];
			$qtyprf    = $row['qtyprf'];
			$pripro    = $row['pripro'];
			$prisal    = $row['prisal'];
			$costre    = $row['costre'];
			$desc1     = $row['desc1'];
			$desc2     = $row['desc2'];
			$desc3     = $row['desc3'];
			$sql1="SELECT desprod,factor FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
	  		$desprod    = $row1['desprod'];
			$factor     = $row1['factor'];
			}
			}
			
			if ($qtyprf == "")
			{
			$cantidad = $qtypro;
			}
			else
			{
			$cantidad = $qtyprf;
			}
	  ?>
	  <tr>
	      <td width="20"><div align="LEFT"><?php echo $i?></div></td>
        <td width="343"><?php echo $desprod; echo " "; /*if ($pripro == 0){?>(BONIF)<?php }*/?></td>
        <td width="62"><div align="right"><?php echo $cantidad?></div></td>
        <td width="76"><div align="right"><?php echo $prisal?></div></td>
        <td width="58"><div align="right"><?php echo $desc1?></div></td>
        <td width="58"><div align="right"><?php echo $desc2?></div></td>
        <td width="58"><div align="right"><?php echo $desc3?></div></td>
        <td width="76"><div align="right"><?php echo $pripro?></div></td>
        <td width="63"><div align="right"></div></td>
		<td width="64"><div align="right"><?php echo $costre?></div></td>
      </tr>
	  <?php  $i++;}
	 
	  ?>
    </table>
	<?php }
	?>
	</td>
  </tr>
</table>
</body>
</html>
