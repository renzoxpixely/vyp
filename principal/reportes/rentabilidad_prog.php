<?php include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');
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
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$date = date('d/m/Y');
$hour  = date(G);  
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
$date1  = fecha1($_REQUEST['date1']);
$date2  = fecha1($_REQUEST['date2']);
$local  = $_REQUEST['local'];
$det    = $_REQUEST['det'];
$ltdgen = $_REQUEST['ltdgen'];
$marca  = $_REQUEST['marca'];
if ($local <> 'all')
{
	$sql="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$nomloc    = $row['nomloc'];
		$nombre    = $row['nombre'];
	}
	}
	if ($nombre <> "")
	{
		$nomloc = $nombre;
		}
}
?>
<body>
<table width="930" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td><strong><?php echo $desemp?></strong></td>
        <td><div align="center"><strong>REPORTE DE RENTABILIDAD </strong></div></td>
        <td>&nbsp;</td>
        <td><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>
      <tr>
        <td width="361"><strong>PAGINA # </strong></td>
        <td width="221"><div align="center">
          <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $nomloc;}?>
        </div></td>
        <td width="30">&nbsp;</td>
        <td width="284"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span> </div></td>
        </tr>

    </table>
    <div align="center"></div></td>
  </tr>
</table>
<?php if ($val == 1)
{
?>
<table width="926" border="0" align="center">
  <tr>
    <td><div align="center"><strong>VENTAS</strong></div></td>
  </tr>
</table>
<?php if ($det == 1)
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <td width="29"><strong>N&ordm;</strong></td>
        <td width="126"><div align="left"><strong>MARCA</strong></div></td>
		<td width="170"><div align="left"><strong>PRODUCTO</strong></div></td>
		<td width="167"><div align="right"><strong>CAJAS Y UNIDADES</strong></div></td>
        <td width="102"><div align="right"><strong>MONTO VENTA</strong></div></td>
		<td width="100"><div align="right"><strong>COSTO VENTA</strong></div></td>
		<td width="97"><div align="right"><strong>RENTABILIDAD</strong></div></td>
		<td width="101"><div align="right"><strong>% RENTABILIDAD</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<?php 
	$Sumgenpripro = 0;
	$Sumgenpcosto = 0.01;
	if ($local == 'all')
	{
		if($marca == 'all')
		{
		$sql1="SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' group by producto.codmar, producto.codpro";
		}
		else
		{
		$sql1="SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and producto.codmar = '$marca' and val_habil = '0' group by producto.codmar, producto.codpro";
		}
	}
	else
	{
		if($marca == 'all')
		{
		$sql1="SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' group by producto.codmar, producto.codpro";
		}
		else
		{
		$sql1="SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and producto.codmar = '$marca' and val_habil = '0' group by producto.codmar, producto.codpro";
		}
	}
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		
		$codmar    = $row1['codmar'];
		$codpro    = $row1['codpro'];
		$sql2="SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result1)){
		while ($row2 = mysqli_fetch_array($result2)){
				$destab     = $row2['destab'];
				$abrev     = $row2['abrev'];
				if ($abrev <> '')
						{
						$destab = $abrev;
						}
		}
		}
		$sql2="SELECT desprod FROM producto where codpro = '$codpro'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
				$product     = $row2['desprod'];
		}
		}
		$precio_costo = 0;
		$nrooperacion = 0;
		$canprod1     = 0;
		$canprod      = 0;
		$tot          = 0;
		$sumpripro    = 0;
		$sumpcosto1	  = 0;
		$sumpcosto = 0.01;
		$rentabilidad = 0;
		$SumPorcent = 0;
		if ($local == 'all')
		{
		$sql2= "SELECT detalle_venta.pripro,detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.cospro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where producto.codmar = '$codmar' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and val_habil = '0' ";
		}
		else
		{
			$sql2="SELECT detalle_venta.pripro,detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.cospro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where producto.codmar = '$codmar' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0'";
		}
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result1)){
		while ($row2 = mysqli_fetch_array($result2)){
				$pripro    	  = $row2['pripro'];
				$canpro       = $row2['canpro'];
				$fraccion     = $row2['fraccion'];
				$factor       = $row2['factor'];
				$pcostouni    = $row2['cospro'];
				$tot          = 0;
				$precio_costo = $pcostouni;
				if ($fraccion == "T")
				{
				$canprod = $canprod + $canpro;
				$tot	 = $tot + $canpro;
				
				}
				else
				{
				$canprod1 = $caprod1 + $canpro;
				$canpros  = $canpro * $factor;
				$tot	  = $tot + $canpros;
				//$precio_costo = $pcostouni/$factor;
				//$precio_costo = number_format($precio_costo,2,',','.');
				}
				$sumpripro = $sumpripro + $pripro;
				$sumpcosto = $precio_costo * $tot;
				$sumpcosto1= $sumpcosto1 + $sumpcosto;
		}
		}
		//echo $tot; echo " "; echo $sumpcosto1; echo " , ";
		$rentabilidad = $sumpripro - $sumpcosto1;
		$porcentaje = 0;
		if ($sumpcosto1 <> 0){
		$porcentaje   = (($sumpripro - $sumpcosto1)/$sumpcosto1)*100;
		}
		$sumgenpripro 	= $sumgenpripro + $sumpripro;
		$sumgenpcosto 	= $sumgenpcosto + $sumpcosto;
		$trentabilidad 	= $sumgenpripro-$sumgenpcosto;
		$tporcentaje 	= ($trentabilidad / $sumgenpcosto) * 100;					
		$i++;
	?>
	  <tr>
        <td width="30"><?php echo $i?></td>
		<td width="124"><?php echo $destab?></td>
        <td width="172"><div align="left"><?php echo $product?></div></td>
        <td width="166"><div align="right"><?php echo $canprod1?> CAJAS - <?php echo $canprod?> UNIDADES</div></td>
		<td width="103"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' ');?></div></td>
		<td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($sumpcosto1, 2, '.', ' ');?></div></td>
		<td width="97"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' ');?></div></td>
		<td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' ');?> %</div></td>
      </tr>
	<?php } /////CIERRO EL WHILE
	?>
			<tr>
				<?php if ($marca == 'all') { ?>
					<td colspan="4"><center>TOTAL</center></td>
				<?php }  else { ?>
					<td colspan="3"><center>TOTAL</center></td>
				<?php } ?>
				<td width="103"><div align="right"><?php echo $numero_formato_frances = number_format($sumgenpripro, 2, '.', ' '); ?></div></td>
				<td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($sumgenpcosto, 2, '.', ' '); ?></div></td>
				<td width="97"><div align="right"><?php echo $numero_formato_frances = number_format($trentabilidad, 2, '.', ' '); ?></div></td>
				<td width="101"><div align="right"><?php echo $numero_formato_frances = number_format($tporcentaje, 2, '.', ' '); ?> %</div></td>
				
			</tr>
			<?php
	} /////CIERRO EL IF DE LA CONSULTA
	else
	{
	?><center>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS SELECCIONADOS</center>
	<?php }
    ?>
    </table>
	</td>
  </tr>
</table>
<?php }
else
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="926" border="0" align="center">
      <tr>
        <td width="35"><strong>N&ordm;</strong></td>
        <td width="465"><div align="left"><strong>MARCA</strong></div></td>
        <td width="102"><div align="right"><strong>MONTO VENTA</strong></div></td>
        <td width="100"><div align="right"><strong>COSTO VENTA</strong></div></td>
        <td width="97"><div align="right"><strong>RENTABILIDAD</strong></div></td>
        <td width="101"><div align="right"><strong>% RENTABILIDAD</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<?php if ($local == 'all')
	{
		if($marca == 'all')
		{
		$sql1="SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' group by producto.codmar";
		}
		else
		{
		$sql1="SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' and producto.codmar = '$marca' group by producto.codmar";
		}
	}
	else
	{
		if($marca == 'all')
		{
		$sql1="SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' group by producto.codmar";
		}
		else
		{
		$sql1="SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' and producto.codmar = '$marca' group by producto.codmar";
		}
	}
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$codmar    = $row1['codmar'];
		$sql2="SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
				$destab     = $row2['destab'];
				$abrev     = $row2['abrev'];
				if ($abrev <> '')
						{
						$destab = $abrev;
						}
		}
		}
		$precio_costo = 0;
		$sumpripro    = 0;			///////
		$sumpcosto1	  = 0;			///////
		if ($local == 'all')
		{
		$sql2="SELECT detalle_venta.prisal,detalle_venta.pripro,detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.invfec between '$date1' and '$date2' and val_habil = '0'";
		}
		else
		{
		$sql2="SELECT detalle_venta.prisal,detalle_venta.pripro,detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0'";
		}
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
			$prisal    = $row2['prisal'];
			$pripro    = $row2['pripro'];
			$canpro    = $row2['canpro'];
			$fraccion  = $row2['fraccion'];
			$factor    = $row2['factor'];
			$pcostouni = $row2['cospro'];
			$precio_costo = $pcostouni;
			$tot       = 0;
				if ($fraccion == "T")
				{
				$tot	 = $tot + $canpro;
				
				}
				else
				{
				$canpros  = $canpro * $factor;
				$tot	  = $tot + $canpros;
				//$precio_costo = $pcostouni/$factor;
				//$precio_costo = number_format($precio_costo,2,',','.');
				}
				$sumpripro    = $sumpripro + $pripro;			////SUMAR EL TOTAL DE LA VENTA
				$sumpcosto    = $precio_costo * $tot;
				$sumpcosto1   = $sumpcosto1 + $sumpcosto;
		}
		}
		$sum_mont = $sumpripro - $sumpcosto1;
		$calc_pripro  = $sumpripro;
		$calc_pcosto  = $sumpcosto1;
		$porcentaje = 0;
		if ($calc_pcosto <> 0){
		$porcentaje   = (($calc_pripro - $calc_pcosto)/$calc_pcosto)*100;
		}
                $Sumgenpripro = $Sumgenpripro + $sumpripro;
                $Sumgenpcosto = $Sumgenpcosto + $sumpcosto;
                $trentabilidad = $Sumgenpripro-$Sumgenpcosto;
                $tporcentaje = ($trentabilidad / $Sumgenpcosto) * 100;
		$i++;
	?>
          <tr>
            <td width="35"><?php echo $i?></td>
            <td width="465"><?php echo $destab?></td>
            <td width="102"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' ');?></div></td>
            <td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($sumpcosto1, 2, '.', ' ');?></div></td>
            <td width="97"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' ');?></div></td>
            <td width="101"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' ');?> %</div></td>
          </tr>
	<?php } /////CIERRO EL WHILE
                            ?>
                        <tr>
                            <td colspan="2"><center>TOTAL</center></td>
                            <td width="102"><div align="right"><?php echo $numero_formato_frances = number_format($Sumgenpripro, 2, '.', ' '); ?></div></td>
                            <td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($Sumgenpcosto, 2, '.', ' '); ?></div></td>
                            <td width="97"><div align="right"><?php echo $numero_formato_frances = number_format($trentabilidad, 2, '.', ' '); ?></div></td>
                            <td width="101"><div align="right"><?php echo $numero_formato_frances = number_format($tporcentaje, 2, '.', ' '); ?> %</div></td>
                        </tr>
                        <?php
	} /////CIERRO EL IF DE LA CONSULTA
	else
	{
	?><center>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</center>
	<?php }
    ?>
        </table>
    </td>
  </tr>
</table>
<?php }
}
?>
</body>
</html>
