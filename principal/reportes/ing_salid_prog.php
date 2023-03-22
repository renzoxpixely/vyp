<?php include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>
<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$users    = $row['nomusu'];
}
}
function formato($c) {
printf("%06d",  $c);
} 
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
$val    = $_REQUEST['val'];
$vals   = $_REQUEST['vals'];
$desc   = $_REQUEST['desc'];
$desc1  = $_REQUEST['desc1'];
$date1  = $_REQUEST['date1'];
$date2  = $_REQUEST['date2'];
$mov    = $_REQUEST['mov'];
$user   = $_REQUEST['user'];
$local  = $_REQUEST['local'];
$dat1	= $date1;
$dat2   = $date2;
$date1  = fecha1($date1);
$date2  = fecha1($date2);
isset($_REQUEST['ck'])? $ck = $_REQUEST['ck'] : $ck = 0;
/////////////////////////////////////////////
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
/////////////////////////////////////////////
if ($local <> 'all')
{
	$sql="SELECT nomloc FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$nomloc    = $row['nomloc'];
	}
	}
}
?>
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
          <td width="366"><div align="center"><b><?php if ($val == 1){?>NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php echo $date2; }?></b></div></td>
          <td width="267"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $users?></span></div></td>
        </tr>
      </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<?php if (($val == 1) || ($vals == 2))
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <?php 
		if (($ck == 0) and ($mov == 4))
		{
		?>
		<td width="69"><strong>FECHA</strong></td>
        <td width="97"><div align="left"><strong>NRO DOCUMENTO</strong></div></td>
        <td width="150"><div align="center"><strong>PROVEEDOR </strong></div></td>
        <td width="127"><div align="left"><strong>RUC </strong></div></td>
        <td width="141"><div align="left"><strong>MONTO AFECTO</strong></div></td>
        <td width="146"><div align="left"><strong>MONTO INAFECTO</strong></div></td>
        <td width="82"><div align="right"><strong>IGV</strong></div></td>
		<td width="82"><div align="right"><strong>NETO</strong></div></td>
		<?php
		}
		else
		{
			if (($ck == 1) and ($mov == 4))
			{
			?>
			<td width="69"><strong>FECHA</strong></td>
			<td width="141"><div align="left"><strong>MONTO AFECTO</strong></div></td>
			<td width="146"><div align="left"><strong>MONTO INAFECTO</strong></div></td>
			<td width="82"><div align="right"><strong>IGV</strong></div></td>
			<td width="82"><div align="right"><strong>NETO</strong></div></td>
			<?php
			}
			else
			{
		?>
		<td width="69"><strong>FECHA</strong></td>
        <td width="57"><div align="left"><strong>INTERNO</strong></div></td>
        <td width="90"><div align="center"><strong>TIPO MOV </strong></div></td>
        <td width="127"><div align="left"><strong>N&ordm; DOCUMENTO </strong></div></td>
        <td width="183"><div align="left"><strong><?php echo $desc_user?></strong></div></td>
        <td width="288"><div align="left"><strong>REFERENCIA</strong></div></td>
        <td width="82"><div align="right"><strong>MONTO</strong></div></td>
		<?php }}?>
        </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php if ($val == 1)
	{
		if ($local == 'all')
		{
			if ($mov == 1)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' order by invfec,numdoc";
			}
			if ($mov == 2)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' order by invfec,numdoc";
			}
			if ($mov == 3)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' order by invfec,numdoc";
			}
			if ($mov == 4)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 5)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 6)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 7)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 8)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '5' order by invfec,numdoc";
			}
			if ($mov == 9)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 10)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 11)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 12)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 13)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '5' order by invfec,numdoc";
			}
		}
		else
		{
			if ($mov == 1)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 2)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 3)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 4)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 5)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 6)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 7)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 8)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and tipdoc = '5' order by invfec,numdoc";
			}
			if ($mov == 9)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 10)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 11)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 12)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 13)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and tipdoc = '5' order by invfec,numdoc";
			}
		}
	}
	if ($vals == 2)
	{
		if ($local == 'all')
		{
			if ($mov == 1)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' order by invfec,numdoc";
			}
			if ($mov == 2)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' order by invfec,numdoc";
			}
			if ($mov == 3)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' order by invfec,numdoc";
			}
			if ($mov == 4)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 5)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 6)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 7)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 8)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '5' order by invfec,numdoc";
			}
			if ($mov == 9)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '1' order by invfec,numdoc";
			}
			if ($mov == 10)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '2' order by invfec,numdoc";
			}
			if ($mov == 11)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '3' order by invfec,numdoc";
			}
			if ($mov == 12)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '4' order by invfec,numdoc";
			}
			if ($mov == 13)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '5' order by invfec,numdoc";
			}
		}
		else
		{
			if ($mov == 1)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 2)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 3)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 4)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '1' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 5)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '2' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 6)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '3' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 7)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '4' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 8)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '5' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 9)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '1' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 10)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '2' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 11)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '3' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 12)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '4' and sucursal = '$local' order by invfec,numdoc";
			}
			if ($mov == 13)
			{
			$sql="SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '5' and sucursal = '$local' order by invfec,numdoc";
			}
		}
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
				$invfec    = $row['invfec'];
				$invnum    = $row['invnum'];
				$tipmov    = $row['tipmov'];
				$tipdoc    = $row['tipdoc'];
				$numdoc    = $row['numdoc'];
				$cuscod    = $row['cuscod'];
				$refere    = $row['refere'];
				$monto     = $row['invtot'];
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
				if ($tipmov == 4)
				{
					$nro_compra     = $row['nro_compra'];
					$sql1="SELECT despro,rucpro FROM proveedor where codpro = '$provee'";
					$result1 = mysqli_query($conexion,$sql1);
					if (mysqli_num_rows($result1)){
					while ($row1 = mysqli_fetch_array($result1)){
					$despro    = $row1['despro'];
					$rucpro    = $row1['rucpro'];
					}}
				}
				if ($tipmov == 1)
				{
				$desctip_mov = "INGRESO";
				}
				else
				{
				$desctip_mov = "SALIDA";
				}
	  ?>
	  <tr>
	  		<?php 
			if (($ck == 0) and ($mov == 4)){
			?>
			<td width="69"><strong><a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&mov=<?php echo $mov?>&user=<?php echo $user?>&local=<?php echo $local?>', 20, 90, 985, 500)"><?php echo fecha($invfec)?></a></strong></td>
			<td width="97"><div align="left">
		<a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&mov=<?php echo $mov?>&user=<?php echo $user?>&local=<?php echo $local?>', 20, 90, 985, 500)"><?php echo formato($invnum)?></a></div></td>
			<td width="150"><?php echo $despro;?></td>
			<td width="127"><?php echo $rucpro?></td>
			<td width="141"></td>
			<td width="146"></td>
			<td width="82"></td>
			<td width="82"><div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' ');?></div></td>
			<?php
			}
			else
			{
				if (($ck == 1) and ($mov == 4))
				{
				?>
				<td width="69"><strong><a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&mov=<?php echo $mov?>&user=<?php echo $user?>&local=<?php echo $local?>', 20, 90, 985, 500)"><?php echo fecha($invfec)?></a></strong></td>
				<td width="141"></td>
				<td width="146"></td>
				<td width="82"></td>
				<td width="82"><div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' ');?></div></td>
				<?php
				}
				else
				{
			?>
			
		
        <td width="69">
		<a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&mov=<?php echo $mov?>&user=<?php echo $user?>&local=<?php echo $local?>', 20, 90, 985, 500)"><?php echo fecha($invfec)?></a></td>
        <td width="57"><div align="left">
		<a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&mov=<?php echo $mov?>&user=<?php echo $user?>&local=<?php echo $local?>', 20, 90, 985, 500)"><?php echo formato($invnum)?></a></div></td>
        <td width="90"><div align="center"><?php /*echo $desctip_mov*/ echo $desctip;?></div></td>
        <td width="127"><div align="left"><?php echo formato($numdoc);?></div></td>
        <td width="183"><div align="left"><?php ?></div></td>
        <td width="288"><?php if ($refere <> ""){?><?php echo substr($refere,0,20); echo "...";?><?php }?></td>
        <td width="82"><div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' ');?></div></td>
		<?php 
		}}
		?>
        </tr>
	  <?php }
	  ?>
    </table>
	<?php }
	else
	{
	?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }
	?>
	</td>
  </tr>
</table>
<?php }
?>
</body>
</html>