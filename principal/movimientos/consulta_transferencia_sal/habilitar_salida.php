<?php include('../../session_user.php');
require_once ('../../../conexion.php');

$cod	 = $_POST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}

require_once('../tabla_local.php');
$sql="SELECT numdoc,invfec,tipmov,tipdoc,usecod,sucursal FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$numdoc    = $row['numdoc'];
			$invfec    = $row['invfec'];
			$tipmov    = $row['tipmov'];
			$tipdoc    = $row['tipdoc'];
			$usecod    = $row['usecod'];
			$sucursal  = $row['sucursal'];
	}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$sucursal'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}


            if ($nomloc == "LOCAL0")
            {
                $tabla = 's000';
            }
            if ($nomloc == "LOCAL1")
            {
                $tabla = 's001';
            }
            if ($nomloc == "LOCAL2")
            {
                $tabla = 's002';
            }
            if ($nomloc == "LOCAL3")
            {
                $tabla = 's003';
            }
            if ($nomloc == "LOCAL4")
            {
                $tabla = 's004';
            }
            if ($nomloc == "LOCAL5")
            {
                $tabla = 's005';
            }
            if ($nomloc == "LOCAL6")
            {
                $tabla = 's006';
            }
            if ($nomloc == "LOCAL7")
            {
                $tabla = 's007';
            }
            if ($nomloc == "LOCAL8")
            {
                $tabla = 's008';
            }
            if ($nomloc == "LOCAL9")
            {
                $tabla = 's009';
            }
            if ($nomloc == "LOCAL10")
            {
                $tabla = 's010';
            }
            if ($nomloc == "LOCAL11")
            {
                $tabla = 's011';
            }
            if ($nomloc == "LOCAL12")
            {
                $tabla = 's012';
            }
            if ($nomloc == "LOCAL13")
            {
                $tabla = 's013';
            }
            if ($nomloc == "LOCAL14")
            {
                $tabla = 's014';
            }
            if ($nomloc == "LOCAL15")
            {
                $tabla = 's015';
            }
            if ($nomloc == "LOCAL16")
            {
                $tabla = 's016';
            }
            if ($nomloc == "LOCAL17")
            {
                $tabla = 's017';
            }
            if ($nomloc == "LOCAL18")
            {
                $tabla = 's018';
            }
            if ($nomloc == "LOCAL19")
            {
                $tabla = 's019';
            }
            if ($nomloc == "LOCAL20")
            {
                $tabla = 's020';
            }
}
$sql="SELECT codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr,numlote FROM movmov where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];	//precio incluyendo el descuento e igv
		$prisal    = $row['prisal'];	//precio sin igv ni descuento
		$costre    = $row['costre'];	//costo real del producto. el pripro * la cantidad
		$desc1     = $row['desc1'];
		$desc2     = $row['desc2'];
		$desc3     = $row['desc3'];
		$costpr    = $row['costpr'];
		$numlote    = $row1['numlote'];
		$stopro = 0;
		$cant_local = 0;
		/////////SELECCIONO EL PRODUCTO Y VEO SU FACTOR Y STOCK EN GENERAL
		$sql1="SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$factor    = $row1['factor'];
				$stopro    = $row1['stopro'];
				$cant_loc  = $row1[2];
				//$sactual   = $stopro;
                $sactual   = $cant_loc;
		}
		}
		if ($qtyprf <> "")
		{
			$text_char =  convertir_a_numero($qtyprf);
			$cant_unid = $text_char;
		}
		else
		{
			$cant_unid = $qtypro * $factor;
		}
		/////////////////////////////////////////////////////////////
	    $cant_local = $sactual - $cant_unid ;
		$stopro2 = $stopro - $cant_unid;
		
		mysqli_query($conexion,"UPDATE producto set stopro = '$stopro2', $tabla = '$cant_local' where codpro = '$codpro'");
		mysqli_query($conexion,"UPDATE movlote set stock = $stopro2 where codloc='$sucursal' and numlote='$numlote' and codpro = '$codpro'");
		/////////////////////////////////////////////////////////////
		//mysqli_query($conexion,"DELETE from kardex where codpro = '$codpro' and nrodoc = '$numdoc' and tipmov = '1' and tipdoc = '1'")	;
		$date   = date('Y-m-d');
		$sqlInsert = "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal, eliminado) values ('$numdoc','$codpro','$invfec','1','1','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$sucursal','2')";
		error_log($sqlInsert);
		mysqli_query($conexion, $sqlInsert)	;
}
}
mysqli_query($conexion,"UPDATE movmae set val_habil = '0' where invnum = '$cod'");
header("Location: cons_transferencia_sal.php"); 
?>