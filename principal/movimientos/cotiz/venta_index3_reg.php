<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$venta      = $_SESSION['cotiz'];
$date = date("Y-m-d");
//$hour   = date(G)-5;
//$date	= CalculaFechaHora($hour);
$t1	 		= $_REQUEST['t1'];		////CANTIDAD
//$t2	 		= $_REQUEST['t2'];	////PRECIO
$t2	 		= $_REQUEST['t22'];		////PRECIO
//$t3	 		= $_REQUEST['t3'];	////SUBTOTAL
$t3 	 	= $_REQUEST['t33'];	////SUBTOTAL
$number	 	= $_REQUEST['number'];	////SI ES NUMERO O NO
$factor	 	= $_REQUEST['factor'];
$codpro   	= $_REQUEST['codpro'];	/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
$codtemp	= $_REQUEST['codtemp'];
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
/////FUNCION PARA CONVERTIR CADENA A NUMERO
function convertir_a_numero($str)
{
  $legalChars = "%[^0-9\-\. ]%";

  $str=preg_replace($legalChars,"",$str);
  return $str;
}						
///////////ACTUALIZO LA DATA HASTA ANTES DE HACER LA OPERACION
$sql="SELECT canpro,fraccion FROM cotizacion_det where codtemp = '$codtemp'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$canpro         = $row['canpro'];		////GENERAL
	$fraccion       = $row['fraccion'];
}
}
$sql="SELECT codpro,stopro,$tabla FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro         = $row['codpro'];		////CODIGO DEL PRODUCTO
	$stopro         = $row['stopro'];		////GENERAL
	$cant_loc  		= $row[2];
}
}
if ($fraccion == "F")						////INGRESO DE CAJAS
{
$canpro  	    = convertir_a_numero($canpro);	
$canpro1 	    = $canpro * $factor;			////CANTIDAD A SUMAR EN UNIDADES
$total_general 	= $stopro + $canpro1;
$total_local    = $cant_loc + $canpro1;
}
else
{
$total_general 	= $stopro + $canpro;
$total_local    = $cant_loc + $canpro;
}
//mysqli_query($conexion,"UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
///////////////////////////////////////////////////////////////////////////////////
/*$sql1="SELECT codpro,codkey,cajas FROM temp_vent_bonif where invnum = '$venta' and codprobonif = '$codpro'"; ///consulto si el producto que se esta vendiendo tiene bonificacion
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		$codprox   = $row1['codpro'];		/////codigo del producto bonificable
		$codkey    = $row1['codkey'];
		$cajas     = $row1['cajas'];
		$sql2="SELECT cajas,unid FROM ventas_bonif_unid where codkey = '$codkey'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
				$cajas1    = $row2['cajas'];
				$unid1     = $row2['unid'];	
		}
		}
		$sql2="SELECT stopro,$tabla FROM producto where codpro = '$codprox'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
				$stockx    = $row2['stopro'];
				$locx      = $row2[1];	
		}
		}
		$totcaja = $cajas + $cajas1;
		$unidadesx = $cajas * $unid1;
		$stockxx   = $stockx + $unidadesx;
		$locxx     = $locx + $unidadesx;
		mysqli_query($conexion,"UPDATE ventas_bonif_unid set cajas = '$totcaja' where codkey = '$codkey'");
		mysqli_query($conexion,"UPDATE producto set stopro = '$stockxx',$tabla = '$locxx' where codpro = '$codprox'");
}
}
*/
//mysqli_query($conexion,"DELETE from temp_vent_bonif where codprobonif = '$codpro' and invnum = '$venta'");
///////////////////////////////////////////////////////////////////////////////////
////////////////////NUEVA ACTUALIZACION CON LOS DATOS INGRESADOS///////////////////
$sql="SELECT codpro,stopro,$tabla FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro         = $row['codpro'];		////CODIGO DEL PRODUCTO
	$stopro         = $row['stopro'];		////GENERAL
	$cant_loc  		= $row[2];
}
}
if ($number == 1)					////ESTOY INGRESANDO CAJAS --- LETRA C
{
$t1 		= convertir_a_numero($t1);
$caja_bonifi= $t1;		/////CAJAS QUE DESEO VENDER
$creal 		= $t1;
$t1 		= $t1 * $factor;
$desc 		= "F";
$tt 		= 1;
	$sql1="SELECT codprobonif,codkey,cajas,unid FROM ventas_bonif_unid where codpro = '$codpro' and unid <> 0 order by codkey asc";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$codprodbonif  	= $row1['codprobonif'];	 /////PRODUCTO A BONIFICAR
		$codkey       	= $row1['codkey'];
		$cajas		 	= $row1['cajas'];		 /////CAJAS E BONIFICACION QUE TENGO EN STOCK
		$unid       	= $row1['unid'];
		$sql2="SELECT stopro,$tabla,factor,codmar,pcostouni,costpr,preuni FROM producto where codpro = '$codprodbonif'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
			$stockbonif       	= $row2['stopro'];		////STOCK GENERAL DEL PRODUCTO
			$tablabonif       	= $row2[1];				////STOCK POR LOCAL
			$factorbonif        = $row2['factor'];		////FACTOR
			$codmarbonif        = $row2['codmar'];		////MARCA
			$pcostounibonif     = $row2['pcostouni'];	////PRECIO DE COSTO UNT
			$costprbonif        = $row2['costpr'];		////COSTO PROMEDIO
			$preunibonif        = $row2['preuni'];		////PRECIO UNITARIO
		}
		}
		$sql2="SELECT canpro FROM cotizacion_det where invnum = '$venta' and codpro = '$codprodbonif' and pripro = '0' and bonif = '1'";		///si es venta por bonificacion
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
			$canprobonif       	= $row2['canpro'];	
			$bik				= 1;	
		}
		}
		else
		{
		$bik = 0;
		}
		if (($caja_bonifi <= $cajas) && ($tt <> 0))	//VENDO UNA CAJA Y MI STOCK BONIF ES DE 4 CAJAS
		{
		$total_reducir 		= $cajas - $caja_bonifi;
		$tot_reducir_unid   = $caja_bonifi * $unid;
		$stockbonif 		= $stockbonif - $tot_reducir_unid;
		$tablabonif 		= $tablabonif - $tot_reducir_unid;
		//mysqli_query($conexion,"UPDATE ventas_bonif_unid set cajas = '$total_reducir' where codkey = '$codkey'"); ///controla bonificaciones
		//mysqli_query($conexion,"UPDATE producto set stopro = '$stockbonif',$tabla = '$tablabonif' where codpro = '$codprodbonif'");
			if ($bik == 1)
			{
			$canprobonif = $canprobonif + $tot_reducir_unid;
			mysqli_query($conexion,"UPDATE cotizacion_det set canpro = '$canprobonif' where codpro = '$codprodbonif'");
			}
			else
			{
			mysqli_query($conexion,"INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif) values ('$venta','$date','$cuscod','$usuario','$codprodbonif','$tot_reducir_unid','T','$factorbonif','$preunibonif','0','$codmarbonif','$pcostounibonif','$costprbonif','1')");
			}
			//mysqli_query($conexion,"INSERT INTO temp_vent_bonif (invnum,codpro,codprobonif,codkey,cajas) values ('$venta','$codprodbonif','$codpro','$codkey','$caja_bonifi')");
			$tt = 0;
		}
		else	//VENDO 4 CAJAS Y MI STOCK BONIF ES DE 1 CAJA, BUSCO Y VEO SI TENGO MAS STOCKS
		{
			if (($caja_bonifi > $cajas) && ($tt <> 0))
			{
			$total_reducir 		= $cajas - $cajas;
			$tot_reducir_unid   = $cajas * $unid;
			$stockbonif 		= $stockbonif - $tot_reducir_unid;
			$tablabonif 		= $tablabonif - $tot_reducir_unid;
			$caja_bonifi		= $caja_bonifi - $cajas;
			//mysqli_query($conexion,"UPDATE ventas_bonif_unid set cajas = '$total_reducir' where codkey = '$codkey'");
			//mysqli_query($conexion,"UPDATE producto set stopro = '$stockbonif',$tabla = '$tablabonif' where codpro = '$codprodbonif'");
				if ($bik == 1)
				{
				$canprobonif = $canprobonif + $tot_reducir_unid;
				mysqli_query($conexion,"UPDATE cotizacion_det set canpro = '$canprobonif' where codpro = '$codprodbonif'");
				}
				else
				{
				mysqli_query($conexion,"INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif) values ('$venta','$date','$cuscod','$usuario','$codprodbonif','$tot_reducir_unid','T','$factorbonif','$preunibonif','0','$codmarbonif','$pcostounibonif','$costprbonif','1')");
				}
				//mysqli_query($conexion,"INSERT INTO temp_vent_bonif (invnum,codpro,codprobonif,codkey,cajas) values ('$venta','$codprodbonif','$codpro','$codkey','$caja_bonifi')");
			$tt = 1;
			}
		}
	}
	}
}
else
{
$desc   = "T";
$creal  = $t1;
}
$stock_general = $stopro - $t1;
$stock_local   = $cant_loc - $t1;
//mysqli_query($conexion,"UPDATE producto set stopro = '$stock_general', $tabla = '$stock_local' where codpro = '$codpro'");
mysqli_query($conexion,"UPDATE cotizacion_det set canpro = '$creal',fraccion = '$desc',prisal = '$t2',pripro = '$t3' where codtemp = '$codtemp'");
header("Location: venta_index1.php");
?>