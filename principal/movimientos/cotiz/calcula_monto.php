<?php ////////////////////////////////////////////////////////////////////////////////////////////////
$sql="SELECT invnum,invfec,cuscod,usecod,forpag FROM cotizacion where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$forpag       = $row['forpag'];
}
}
$sql="SELECT count(*) FROM cotizacion_det where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count        = $row[0];	////CANTIDAD DE REGISTROS EN EL GRID
}	
}
else
{
$count = 0;	////CUANDO NO HAY NADA EN EL GRID
}
///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
$sql="SELECT count(*) FROM cotizacion_det where invnum = '$invnum' and canpro = '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count1        = $row[0];	////CUANDO HAY UN GRID PERO CON DATOS VACIOS
}	
}
else
{
$count1 = 0;	////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
}
///////CONTADOR PARA CONTROLAR LOS TOTALES
$sql="SELECT count(*) FROM cotizacion_det where invnum = '$invnum' and canpro <> '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count2        = $row[0];	
}	
}
else
{
$count2 = 0;
}
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$porcent    = $row1['porcent'];
}
}
$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];
}
}
$sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$descli  = $row1['descli'];
}
}
$sql1="SELECT codpro,canpro,fraccion,factor,prisal,pripro,costpr,codmar,bonif FROM cotizacion_det where invnum = '$invnum'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	    $codpro    = $row1['codpro'];
		$canpro    = $row1['canpro'];
		$fraccion  = $row1['fraccion'];
		$factor    = $row1['factor'];
		$prisal    = $row1['prisal'];		////PRECIO UNITARIO
		$pripro    = $row1['pripro'];		////MONTO VENTA
		$costpr    = $row1['costpr'];
		$codmar    = $row1['codmar'];
		$bonif     = $row1['bonif'];
		if ($bonif <> 1)
		{
			$sql2="SELECT igv,prelis,factor,prevta,preuni,margene FROM producto where codpro = '$codpro'";////SI ESTA ACTIVADO EL IGV PARA ESTE PRODUCTO
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
					$igv        	= $row2['igv'];
					$referencial  	= $row2['prelis'];
					$factor      	= $row2['factor'];
					$prevta			= $row2['prevta'];
					$preuni     	= $row2['preuni'];
					$margene     	= $row2['margene'];
			}
			}
			//////////PRECIO REFERENCIAL UNITARIO
			if (($referencial <> 0) and ($referencial <> $prevta))
			{
				$margenes       = ($margene/100)+1;
				$precio_ref     = $referencial/$factor;
				$precio_ref		= $precio_ref * $margenes;
				//$precio_ref		= number_format($precio_ref,2,',','.');
			}
			else
			{
				$precio_ref		= $preuni;
			}
			//////////CANTIDAD COMPRADA
			if ($fraccion =="T")			
			{
				$cantidad_comp = $canpro;
			}
			else
			{
				$cantidad_comp = $canpro * $factor;
			}
			//////////CALCULO DEL MONTO BRUTO - SIN DESCUENTO CON IGV
			$sum_mont1 = $precio_ref * $cantidad_comp;
			$mont_bruto= $mont_bruto + $sum_mont1;
			//////////CALCULO DEL VALOR VENTA
			if ($igv == 1)
			{
			$valor_vent		= ($prisal/(($porcent/100)+1))*$cantidad_comp;
			//$valor_vent		= number_format($valor_vent,2,',','.');
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
			else
			{
			$valor_vent     = ($prisal * $cantidad_comp);
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
			/*$t = 0.1;
			$r = $monto_total;
			$n = (floor($monto_total*10)/10); 
			$monto_total    = $n + $t;
			$monto_total	= (floor(($monto_total + $pripro)*10)/10);
			$redondeo		= $monto_total - $r;
			*/
			$monto_total	= $monto_total + $pripro;
		}
}	
}
else
{

}
/////////////////////////////////////////
//$t = 0.1;
$r = $monto_total;
/////////////////////////////////////////
$nnn = $monto_total;
$nnn = $numero_formato_frances = number_format($nnn, 2, '.', ' ');
$aux = (string) $nnn;
$decimal = substr( $aux, strpos( $aux, "." ) );
$decimal  = explode(".",$nnn);
$decimal  = $decimal[1];
/////////////////////////////////////////
$n = (floor($monto_total*10)/10); 
//////////CALCULO DEL IGV///////////////
$rr= $valor_vent1;
$nn= (floor($valor_vent1*10)/10); 
/////////////////////////////////////////
if (($decimal%10) == 0)
{
$monto_total    = $n + $t;
$valor_vent1    = $nn + $t;
}
else
{
$monto_total    = $n;
$valor_vent1    = $nn;
}
//////////CALCULO DEL IGV///////////////
$total_des		= $mont_bruto - $valor_vent1;
$sum_igv		= ($monto_total - $valor_vent1);
$redondeo		= $monto_total - $r;
?>