<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod    	 = $_POST['cod'];			///invnum
$referencia  = $_POST['referencia'];	///referencia
$mont2  	 = $_POST['mont2'];			///monto total
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql="SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$usecod    = $row['usecod'];
}
}
$sql="SELECT codloc FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codloc    = $row['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}

$sql = "SELECT P.codpro, P.desprod,P.lotec FROM tempmovmov T, producto P where invnum = '$cod' and T.codpro=P.codpro and P.lotec='1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro = $row['codpro'];
        $lotec = $row['lotec'];
        $desprod = $row['desprod'];
        $sqlLote = "SELECT COUNT(codpro) contador FROM templote where invnum = '$cod' and codpro='$codpro'";
        $resultLote = mysqli_query($conexion, $sqlLote);
        if (mysqli_num_rows($resultLote)) {
            if ($rowLote = mysqli_fetch_array($resultLote)) {
                $contador = $rowLote['contador'];
                if ($contador<1) {
                    echo'<script type="text/javascript">
                    alert("No se ha asociado un lote para el producto: '.$desprod.'");
                    window.location.href="ingresos_varios.php";
                    </script>';
                    return;
                }

            }
        }
    }
}

require_once('../tabla_local.php');
$sql="SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];
		$costre    = $row['costre'];
		$costpr    = $row['costpr'];
		$numlote   = $row['numlote'];
		error_log("qtypro: ".$qtypro);
		error_log("numlote: ".$numlote);
		error_log("codpro: ".$codpro);
		$sql1="SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$factor    = $row1['factor'];
				$stopro    = $row1['stopro'];
				$cant_loc  = $row1[2];
//				$sactual   = $stopro;
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
		//echo "existe este producto";
		$cant_local = $cant_loc + $cant_unid ;
		$stopro = $stopro + $cant_unid;
		$stocklote = 0;
		/////////////////////////////////////////////////////////////////////

			/////////////////////////////////////////////////
		$sqlmovmov ="INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote, codloc, tipmov) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$numlote', '$codloc', '$tipmov')";
		mysqli_query($conexion,$sqlmovmov)	;
		error_log("Ingreso de movmov: ".$sqlkardex);	
		/////////////////////////////////////////////////////////////
		mysqli_query($conexion,"UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
		$sqlkardex = "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc')";
		error_log("Ingreso de kardex: ".$sqlkardex);
		mysqli_query($conexion,$sqlkardex);

		error_log("PRUEBA============");
		/////////////////////////////////////////////////
		$numlote = "";
		////////LOTES Y VENCIMIENTOS DE LA TABLA TEMPORAL///////////////////////////////////////
		$sql1 = "SELECT numerolote,vencim FROM templote where invnum = '$cod' and codpro = '$codpro' and codloc= '$codloc'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$numlote = $row1['numerolote'];
				$vencimi = $row1['vencim'];
			}
		}
		error_log("numlote: ".$numlote);
		error_log("vencimi: ".$vencimi);
		$stocklote = 0;
		///////REVISO SI EL NUMERO DEL TEMPORAL EXISTE EN MI TABLA ORIGINAL
		if ($numlote <> "") {
			$sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote' and codpro = '$codpro' and codloc= '$codloc'";
			error_log("Control 1: ".$sql1);
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$numerolote = $row1['numlote'];
					$fvencimi = $row1['vencim'];
					$stocklote = $row1['stock'];
					$stocklote = $stocklote + $cant_unid;
				}
				error_log("PRUEBA 2============");
				error_log("Control 2: "."UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote' and codloc= '$codloc'");
				
				mysqli_query($conexion, "UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote' and codloc= '$codloc'");
			} else {
				error_log("PRUEBA 3============");
				error_log("Control 3: "."INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro','$numlote','$vencimi','$cant_unid', '$codloc')");
				
				error_log("INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro','$numlote','$vencimi','$cant_unid', '$codloc')");
				mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro','$numlote','$vencimi','$cant_unid', '$codloc')");
			}
		}
			
	}
}
 if($lotec = 1){

        $sql="SELECT codkard,nrodoc,codpro,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal FROM kardex where invnum = '$cod' and codpro='$codpro' ";
        $result = mysqli_query($conexion,$sql);
        if (mysqli_num_rows($result)){
        while ($row = mysqli_fetch_array($result)){
    	$nrodoc     = $row['nrodoc'];
		$qtypro = $row['qtypro'];
		$codpro     = $row['codpro'];
		$fraccion    = $row['fraccion'];
		$factor = $row['factor'];
		$invnum     = $row['invnum'];
		$usecod     = $row['usecod'];
		$sactual     = $row['sactual'];
		$sucursal    = $row['sucursal'];
		$codkard     = $row['codkard'];
		
		
		if ($qtyprf <> "")
        {
        	$text_char = convertir_a_numero($qtyprf);
        	$cant_unid = $text_char;
        }
        else
        {
        	$cant_unid = $qtypro * $factor;
        
        }
        
	 $sql1 = "SELECT idlote,codpro,stock FROM movlote where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $idlote       = $row1['idlote'];
                    $codpro       = $row1['codpro'];
                    $stocklote      = $row1['stock'];

                }
            }
	        
	        	mysqli_query($conexion, "INSERT INTO kardexLote (codkard,IdLote,Cantidad) values ('$codkard','$idlote','$cant_unid')");
	
	        
        }

}
     
 }


//echo "UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', estado = '0', proceso = '0' where invnum = '$cod'";exit;
mysqli_query($conexion,"DELETE from tempmovmov where invnum = '$cod'")	;
mysqli_query($conexion, "DELETE from templote where invnum = '$cod'");
mysqli_query($conexion,"UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', estado = '0', proceso = '0' where invnum = '$cod'");
//header("Location: ../ing_salid.php"); 
header("Location: generaImpresion.php?Compra=$cod");
?>