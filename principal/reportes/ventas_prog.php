<?php 
//ini_set('max_execution_time', 900);
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<?php 
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
		$user    = $row['nomusu'];
	}
}
$date   = date('d/m/Y');
$hour  = date('G');  
$min	= date('i');
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
$valTipoDoc   = $_REQUEST['valTipoDoc'];
$desc   = $_REQUEST['desc'];
$desc1  = $_REQUEST['desc1'];
$date1  = $_REQUEST['date1'];
$date2  = $_REQUEST['date2'];
$ck     = $_REQUEST['ck'];
$ck1    = $_REQUEST['ck1'];
$ck2    = $_REQUEST['ck2'];
$ckloc  = $_REQUEST['ckloc'];
$ckprod = $_REQUEST['ckprod'];
$local  = $_REQUEST['local'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$from = $_REQUEST['from'];
$until = $_REQUEST['until'];
$tipoDoc = $_REQUEST['tipoDoc'];

$dat1	 = $date1;
$dat2	 = $date2;
$date1	 = fecha1($dat1);
$date2   = fecha1($dat2);
$registros  = $_REQUEST['registros'];
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
if ($local <> 'all')
{
	$sql="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
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
}
?>
<body>

<table width="930" border="0" align="center">
  <tr>
    <td>
    <table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td  width="380"><div align="center"><strong>REPORTE DE CIERRE DEL DIA - 
          <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $locals;}?>
        </strong></div></td>
        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>

    </table>
      <table width="914" border="0">
        <tr>
          <td width="134"><strong>PAGINA <?php echo $pagina;?> de <?php echo $tot_pag?></strong></td>
          <td width="633"><div align="center"><b><?php if ($val == 1){?>NRO DE VENTA ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?> FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php echo $dat2; }?></b></div></td>
          <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
<?php 
if ($ckprod == 1)
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    	<table width="926" border="0" align="center">
      		<tr>
            <td width="57"><div align="left"><strong>TIENDA   </strong></div></td>
            <td width="74"><div align="left"><strong>RESPONSABLE  </strong></div></td>
            <td width="48"><div align="left"><strong>NUMERO</strong></div></td>
            <td width="50"><div align="left"><strong>FECHA</strong></div></td>
            <td width="54"><div align="left"><strong>CLIENTE</strong></div></td>
            <td width="308"><div align="left"><strong>PRODUCTO</strong></div></td>
            <td width="61"><div align="left"><strong>MARCA</strong></div></td>
            <td width="60"><div align="right"><strong>PRECIO VTA.</strong></div></td>
      		<td width="60"><div align="right"><strong>PRECIO LTA.</strong></div></td>
            <td width="60"><div align="right"><strong>DIFERENCIA</strong></div></td>
            <td width="60"><div align="right"><strong>PRECIO DIST</strong></div></td>
            <td width="60"><div align="right"><strong>DIFERENCIA</strong></div></td>
            </tr>
      	</table>
               <?php 
				$zz = 0;
				if ($val == 1){ ///	PRIMER BOTON
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
					$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' order by nrovent";
					}
					else ///UN SOLO LOCAL
					{
					$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local' order by nrovent";
					}
				}
				elseif ($vals == 2)///	SEGUNDO BOTON
				{
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
						//echo $date1; echo "<br>";
						//echo $date2;
						$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and invtot <> '0' and estado = '0' order by nrovent";
					}
					else ///UN SOLO LOCAL
					{
						$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' order by nrovent";
					}
				} else {
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
						$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0' order by sucursal, nrovent";
					}
					else ///UN SOLO LOCAL
					{
						$sql="SELECT detalle_venta.usecod,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0' order by sucursal, nrovent";
					}
				}
				error_log("Consulta doc: ".$sql);
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				?>
                <table width="926" border="0" align="center">
                    <?php 
					while ($row = mysqli_fetch_array($result)){
						$usecod    = $row['usecod'];
						$sucursal  = $row['sucursal'];
						$nrovent   = $row['nrovent'];
						$invfec    = fecha($row['invfec']);
						$cuscod    = $row['cuscod'];
						$codpro    = $row['codpro'];
						$codmar    = $row['codmar'];
						$prisal    = $row['prisal'];
						$factor    = $row['factor'];////
						$canpro    = $row['canpro'];////
						$cospro    = $row['cospro'];////
						$fraccion  = $row['fraccion'];/////
						$plista	   = 0;
						$dif = 0;
						$sql1="SELECT desprod,destab,pdistribuidor,abrev FROM producto inner join titultabladet on codmar = codtab where codpro = '$codpro'";
						$result1 = mysqli_query($conexion,$sql1);
						if (mysqli_num_rows($result1)){
						while ($row1 = mysqli_fetch_array($result1)){
						$desprod    = $row1['desprod'];
						$destab     = $row1['destab'];
						$abrev      = $row1['abrev'];
						if ($abrev <> '')
						{
						$destab = $abrev;
						}
						$pdistribuidor     = $row1['pdistribuidor'];
						}}
						$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
						$result3 = mysqli_query($conexion,$sql3); 
						if (mysqli_num_rows($result3)){
						while ($row3 = mysqli_fetch_array($result3)){ 
						$nloc	= $row3["nomloc"];
						$nombre	= $row3["nombre"];}}
						$plista	   = $prisal - $cospro;
						$dif 	   = $prisal - $pdistribuidor;
						if ($nombre == "")
						{
						$nombre = $nloc;
						}
						
					?>
                    <tr>
                        <td width="57"><div align="left"><?php echo $nombre;?>   </div></td>
						<td width="74"><div align="left">RESPONSABLE</div></td>
						<td width="48"><div align="left"><?php echo $nrovent?></div></td>
						<td width="50"><div align="left"><?php echo $invfec;?></div></td>
						<td width="54"><div align="left">CLIENTE</div></td>
						<td width="308"><div align="left"><?php echo $desprod?></div></td>
						<td width="61"><div align="left"><?php echo $destab?></div></td>
						<td width="60"><div align="right"><?php echo $numero_formato_frances = number_format($prisal, 2, '.', ' ');?></div></td>
						<td width="60"><div align="right"><?php echo $numero_formato_frances = number_format($cospro, 2, '.', ' ');?></div></td>
						<td width="60"><div align="right"><?php echo $numero_formato_frances = number_format($plista, 2, '.', ' ');?></div></td>
						<td width="60"><div align="right"><?php echo $numero_formato_frances = number_format($pdistribuidor, 2, '.', ' ');?></div></td>
						<td width="60"><div align="right"><?php echo $numero_formato_frances = number_format($dif, 2, '.', ' ');?></div></td>
                    </tr>
                    <?php 
					}
					?>
                </table>
                <?php 
				}
				?>
    </td>
  </tr>
</table>
<?php	
}
else
{
if (($ck == '') && ($ck1 == '') && ($ck2 == '')){
if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1))
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <?php if ($ckloc == 1){?>
		<td width="102"><strong>LOCAL</strong></td>
		<?php }?>
		<td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>"><strong>VENDEDOR</strong></td>
        <td width="57"><div align="right"><strong># VENTAS </strong></div></td>
        <td width="64"><div align="right"><strong>CONTADO</strong></div></td>
        <td width="68"><div align="right"><strong>CREDITO</strong></div></td>
        <td width="80"><div align="right"><strong>TARJETAS</strong></div></td>
        <td width="54"><div align="right"><strong>OTROS</strong></div></td>
        <td width="68"><div align="right" class="Estilo1">ANULADAS</div></td>
        <td width="61"><div align="right"><strong>TOTAL</strong></div></td>
        <td width="90"><div align="right"><strong>RENTABILIDAD</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php 
	$zz = 0;
	if ($val == 1){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' group by usecod,sucursal";}
			else{
			$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' group by usecod";}}
		else{
		$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod ";}}
	if ($vals == 2){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where invfec between '$date1' and '$date2' and invtot <> '0' and estado = '0' group by usecod,sucursal order by nrovent";}
			else{
			$sql="SELECT usecod FROM venta where invfec between '$date1' and '$date2' and estado = '0' and invtot <> '0' group by usecod order by nrovent";}}
		else{
		
		$sql="SELECT usecod FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod order by nrovent";}}
	if ($valTipoDoc == 1){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0' group by usecod,sucursal order by sucursal, nrovent";}
			else{
			$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' and invtot <> '0' group by usecod order by sucursal, nrovent";}}
		else{
		
		$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod order by sucursal, nrovent";}}
		error_log("Consulta doc 2: ".$sql);
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$usecod    = $row['usecod'];
		if ($ckloc == 1){
			$sucurs    = $row['sucursal'];}
		///////USUARIO QUE REALIZA LA VENTA
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];}}
		$e = 0;
		$t = 0;
		$c = 0;
		$e_tot = 0;
		$t_tot = 0;
		$c_tot = 0;
		$deshabil 	  = 0;
		$deshabil_tot = 0;
		$habil_tot    = 0;
		$count = 0;
		$sumpripro = 0;
		$sumpcosto = 0;
		$porcentaje= 0;
                $Rentabilidad = 0;
		if ($vals == 2){
			if ($local == 'all'){
				if ($ckloc == 1){
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and estado = '0' order by sucursal";}}
			else{
			$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and sucursal = '$local' and estado = '0'";}}
		if ($val == 1){
			if ($local == 'all'){
				if ($ckloc == 1){
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and estado = '0' order by sucursal";}}
			else{
			$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and sucursal = '$local' and estado = '0'";}}
		if ($valTipoDoc == 1){
			if ($local == 'all'){
				if ($ckloc == 1){
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' order by sucursal";}}
			else{
			$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and estado = '0' order by sucursal";}}
			error_log("Consulta doc 3: ".$sql1);
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$invnum    = $row1["invnum"];
				$forpag    = $row1["forpag"];
				$val_habil = $row1["val_habil"];
				$total     = $row1["invtot"];
				$sucursal  = $row1["sucursal"];
				$hora  = $row1["hora"];
				if ($ckloc == 1){
					if ($sucursal <> $suc[$zz]){
					$zz++;
					$suc[$zz] = $sucursal;}}
				else{
					if ($usecod <> $suc[$zz]){
					$zz++;
					$suc[$zz] = $usecod;}}
				$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
				$nloc	= $row3["nomloc"];
				$nombre	= $row3["nombre"];
					if ($nombre == ''){
					$sucur = $nloc;}
					else{
					$sucur = $nombre;}}
				if ($val_habil == 0){
					if ($forpag == "E"){
					$e = $e + 1;
					$e_tot = $e_tot + $total;
					$e_tot1[$zz] = $e_tot1[$zz] + $total;}
					if ($forpag == "T"){
					$t = $t + 1;
					$t_tot = $t_tot + $total;
					$t_tot1[$zz] = $t_tot1[$zz] + $total;}
					if ($forpag == "C"){
					$c = $c + 1;
					$c_tot = $c_tot + $total;
					$c_tot1[$zz] = $c_tot1[$zz] + $total;}
					$sql2="SELECT cospro,pripro,canpro,fraccion,factor,invfec,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
					$result2 = mysqli_query($conexion,$sql2);
					if (mysqli_num_rows($result2)){
					while ($row2 = mysqli_fetch_array($result2)){
                                                $pcostouni    = $row2["cospro"]; //costo del producto x caja
						$pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
						$canpro       = $row2['canpro'];
						$fraccion     = $row2['fraccion'];
						$factor       = $row2['factor'];
                                                $prisal       = $row2['prisal']; //precio de venta x unidad
                                                $costpr       = $row2['costpr']; //costo del producto x unidad
						
                                                if ($fraccion == "T")
                                                {
                                                    $RentPorcent  = (($prisal-$costpr) * $canpro);
                                                    $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                    
                                                    //$precio_costo = $pcostouni;
						}
						else
                                                {
                                                    //$precio_costo = $pcostouni/$factor;
                                                    //$canpros   = $canpro * $factor;
                                                    //$tot	   = $tot + $canpros;
                                                    $RentPorcent  = (($prisal-$pcostouni) * $canpro);
                                                    $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                }
                                            
                                                /*$pcostouni    = $row2["cospro"];
						$pripro       = $row2['pripro'];
						$canpro    	  = $row2['canpro'];
						$fraccion     = $row2['fraccion'];
						$factor       = $row2['factor'];
						$tot   	      = 0;
						$precio_costo = $pcostouni;
						if ($fraccion == "T"){
						$tot	   = $tot + $canpro;
						//$precio_costo = $pcostouni;
						}
						else{
						//$precio_costo = $pcostouni/$factor;
						$canpros   = $canpro * $factor;
						$tot	   = $tot + $canpros;}
						$sumpripro = $sumpripro + $pripro;
						$pcosto    = $tot * $precio_costo;
						$sumpcosto = $sumpcosto + $pcosto;*/}}}
				if ($val_habil == 1){
				$deshabil++;
				$deshabil_tot = $deshabil_tot + $total;
				$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;}
				else{
				$habil_tot = $habil_tot + $total;
				$habil_tot1[$zz] = $habil_tot1[$zz] + $total;}
				$count++;}}
                                $rentabilidad       = $Rentabilidad;
			 //$rentabilidad       = $sumpripro - $sumpcosto;
			 $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
			/*if ($sumpcosto > 0){
			$rentabilidad   = $sumpripro - $sumpcosto;
			$rentabilidad1[$zz] = $rentabilidad1[$zz] + $rentabilidad;}*/
		  if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		  ?>
            <tr bgcolor="#CCCCCC">
  			    <?php if ($ckloc == 1){?><td width="102"></td><?php }?>
				<td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>"></td>
				<td width="57"><div align="right"><strong>TOTAL</strong></div></div></td>
				<td width="64"><div align="right">
				<?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="54"><div align="right"></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz-1], 2, '.', ' '); ?></div></td>
            </tr>
	  <?php }?>
	  <tr>
        <?php if ($ckloc == 1){?><td width="102"><?php echo $sucur?></td><?php }?>
		<td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>">
		<?php echo $user?></td>
        <td width="57"><div align="right"><?php echo $count?></div></td>
        <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></div></td>
        <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ');?></div></td>
        <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot, 2, '.', ' ');?></div></td>
        <td width="54">&nbsp;</td>
        <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' ');?></div></td>
        <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></div></td>
        <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' '); ?></div></td>
      </tr>
	  <?php }?>
    </table>
		<?php if ($zz == 1){?>
		  <table width="926" border="0" align="center">
			  <tr bgcolor="#CCCCCC">
				<td width="407"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="54">&nbsp;</td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
			  </tr>
		  </table>
		<?php }else{
		?>
		  <table width="926" border="0" align="center">
            <tr bgcolor="#CCCCCC">
              <td width="407" colspan="2"><div align="right"><strong>TOTAL</strong></div></td>
              <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="54">&nbsp;</td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
            </tr>
          </table>
		  <?php }?>
	<?php }else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
</table>
<?php }}?>
<?php if (($ck == 1) || ($ck1 == 1)){
if (($val == 1) || ($vals == 2)){?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <?php if ($ckloc == 1){?><td width="82"><strong>LOCAL</strong></td><?php }?>
		<td width="<?php if ($ckloc == 1){?>180<?php }else{?>282<?php }?>"><strong>VENDEDOR</strong></td>
        <td width="50"><div align="left"><strong>HORA </strong></div></td>
		<td width="30"><div align="right"><strong>FECHA </strong></div></td>
	    <td width="57"><div align="right"><strong>N&ordm; DE VENTA </strong></div></td>
        <td width="64"><div align="right"><strong>CONTADO</strong></div></td>
        <td width="68"><div align="right"><strong>CREDITO</strong></div></td>
        <td width="80"><div align="right"><strong>TARJETAS</strong></div></td>
        <td width="54"><div align="right"><strong>OTROS</strong></div></td>
        <td width="68"><div align="right" class="Estilo1">ANULADAS</div></td>
        <td width="61"><div align="right"><strong>TOTAL</strong></div></td>
        <td width="90"><div align="right"><strong>RENTABILIDAD</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php if ($val == 1){
		if ($local == 'all'){
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";}
		else{
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' and estado = '0' and invtot <> '0'";}}
	if ($vals == 2){
		if ($local == 'all'){
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where invfec between '$date1' and '$date2' and estado = '0' and invtot <> '0' order by nrovent";}
		else{
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' order by nrovent";}}
	if ($valTipoDoc == 1){
		if ($local == 'all'){
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' and invtot <> '0' order by sucursal, nrovent";}
		else{
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0' order by sucursal, nrovent";}}
	$zz = 0;
	$i  = 0;
	error_log("Consulta doc 4: ".$sql);
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		$usecod    = $row['usecod'];
		$nrovent   = $row['nrovent'];
		$forpag    = $row["forpag"];
		$val_habil = $row["val_habil"];
		$total     = $row["invtot"];
		$sucursal  = $row["sucursal"];
		$hora	   = $row["hora"];
		$i++;
		$ssss[$i]  = $sucursal;
		if ($sucursal <> $suc[$zz]){
		$zz++;
		$suc[$zz] = $sucursal;}
		$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
				$nloc	= $row3["nomloc"];
				$nombre	= $row3["nombre"];
					if ($nombre == ''){
					$sucur = $nloc;}
					else{
					$sucur = $nombre;}}
		$e_tot = 0;
		$t_tot = 0;
		$c_tot = 0;
		$deshabil_tot = 0;
		$habil_tot = 0;
		$count = 0;
		$tot	   = 0;
                $Rentabilidad = 0;
		$sumpripro = 0;
		$sumpcosto = 0;
		$porcentaje= 0;
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];}}
			if ($val_habil == 0){
				if ($forpag == "E"){
				$e_tot = $total;
				$e_tot1[$zz] = $e_tot1[$zz] + $total;}
				if ($forpag == "T"){
				$t_tot = $total;
				$t_tot1[$zz] = $t_tot1[$zz] + $total;}
				if ($forpag == "C"){
				$c_tot = $total;
				$c_tot1[$zz] = $c_tot1[$zz] + $total;}
				$sql2="SELECT cospro,pripro,canpro,fraccion,factor,invfec,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
				$result2 = mysqli_query($conexion,$sql2);
				if (mysqli_num_rows($result2)){
				while ($row2 = mysqli_fetch_array($result2)){
                                        $pcostouni    = $row2["cospro"]; //costo del producto x caja
                                        $pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
                                        $canpro       = $row2['canpro'];
                                        $fraccion     = $row2['fraccion'];
                                        $factor       = $row2['factor'];
                                        $prisal       = $row2['prisal']; //precio de venta x unidad
                                        $costpr       = $row2['costpr']; //costo del producto x unidad
                                        $invfec       = $row2['invfec'];
                                        
                                        //FRACCIONADO
                                        if ($fraccion == "T")
                                        {
                                            $RentPorcent  = (($prisal-$costpr) * $canpro);
                                            $Rentabilidad = $Rentabilidad + $RentPorcent;
                                            //$precio_costo = $pcostouni;
                                        }
                                        else
                                        {
                                            //NO FRACCIONADO
                                            //$precio_costo = $pcostouni/$factor;
                                            //$canpros   = $canpro * $factor;
                                            //$tot	   = $tot + $canpros;
                                            $RentPorcent  = (($prisal-$pcostouni) * $canpro);
                                            $Rentabilidad = $Rentabilidad + $RentPorcent;
                                        }
					/*$pcostouni    = $row2["cospro"];
					$pripro       = $row2['pripro'];
					$canpro    	  = $row2['canpro'];
					$fraccion     = $row2['fraccion'];
					$factor       = $row2['factor'];
					$invfec       = $row2['invfec'];
					$tot   	      = 0;
					$precio_costo = $pcostouni;
					if ($fraccion == "T"){
					$tot	   = $tot + $canpro;}
					else{
					//$precio_costo = $pcostouni/$factor;
					$canpros   = $canpro * $factor;
					$tot	   = $tot + $canpros;}
					$sumpripro = $sumpripro + $pripro;
					$pcosto    = $tot * $precio_costo;
					$sumpcosto = $sumpcosto + $pcosto;*/}}}
			if ($val_habil == 1){
			$deshabil_tot = $total;
			$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;}
			else{
			$habil_tot = $total;
			$habil_tot1[$zz] = $habil_tot1[$zz] + $total;}
                        $rentabilidad       = $Rentabilidad;
			$rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
                        /*
			if ($sumpcosto > 0){
			$rentabilidad   = $sumpripro - $sumpcosto;
			$rentabilidad1[$zz] = $rentabilidad1[$zz] + $rentabilidad;}*/
		  if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		  if ($sucursal <> $ssss[$i-1]){
		  ?>
			<tr bgcolor="#CCCCCC">
			    <?php if ($ckloc == 1){?><td width="102"><?php ?></td><?php }?>
				<td width="<?php if ($ckloc == 1){?>180<?php } else {?>282<?php }?>" bgcolor="#CCCCCC"></td>
				<td width="20"><div align="right"></div></td>
				<td width="30"><div align="right"></div></td>
				<td width="67"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="54">&nbsp;</td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz-1], 2, '.', ' '); ?></div></td>
            </tr>
		  <?php }}?>
	  <tr>
        <?php if ($ckloc == 1){?><td width="82"><?php echo $sucur?></td><?php }?>
		<td width="<?php if ($ckloc == 1){?>180<?php } else {?>282<?php }?>">
		<a href="javascript:popUpWindow('ver_venta_usu.php?invnum=<?php echo $invnum?>', 30, 140, 975, 280)"><?php echo $user?></a></td>
        <td width="50"><div align="right"><?php echo $hora?></div></td>
		<td width="30"><div align="right"><?php echo fecha($invfec)?></div></td>
	    <td width="50"><div align="right"><?php echo $nrovent?></div></td>
        <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></div></td>
        <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ');?></div></td>
        <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot, 2, '.', ' ');?></div></td>
        <td width="54">&nbsp;</td>
        <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' ');?></div></td>
        <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></div></td>
        <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' ');?></div></td>
      </tr>
	  <?php }?>
    </table>
	<?php if ($zz == 1){
		?>
		  <table width="926" border="0" align="center">
			  <tr bgcolor="#CCCCCC">
				<td width="497"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="54">&nbsp;</td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
			  </tr>
	  </table>
		<?php }else{?>
		  <table width="926" border="0" align="center">
            <tr bgcolor="#CCCCCC">
              <td width="497" colspan="4"><div align="right"><strong>TOTAL</strong></div></td>
              <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="54">&nbsp;</td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
            </tr>
          </table>
		  <?php }}else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
</table>
<?php }}}?>
</body>
</html>
