<?php 
$invnum = "";
$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,sucursal FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
error_log($sql);
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
        $invnum       = $row['invnum'];
        $nrovent      = $row['nrovent'];
        $invfec       = $row['invfec'];
        $cuscod       = $row['cuscod'];
        $usecod       = $row['usecod'];
        $codven       = $row['codven'];
        $forpag       = $row['forpag'];
        $fecven       = $row['fecven'];
        $sucursal     = $row['sucursal'];
    }
}
error_log("INICIO DE CALCULO DE MONTOS======================================".$invnum);
//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG  = "";
$sqlLocal   = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion,$sqlLocal);
if (mysqli_num_rows($resultLocal))
{
    while ($rowLocal = mysqli_fetch_array($resultLocal))
    {
        $nomlocalG    = $rowLocal['nomloc'];
    }
}

$TablaPrevtaMain = "prevta";
$TablaPreuniMain = "preuni";
if ($nomlocalG <> "")
{
    if ($nomlocalG == "LOCAL1")
    {
        $TablaPrevta = "prevta1";
        $TablaPreuni = "preuni1";
    }
    else
    {
        if ($nomlocalG == "LOCAL2")
        {
            $TablaPrevta = "prevta2";
            $TablaPreuni = "preuni2";
        }
        else
        {
            $TablaPrevta = "prevta";
            $TablaPreuni = "preuni";
        }
    }
}
else
{
    $TablaPrevta = "prevta";
    $TablaPreuni = "preuni";
}
//**FIN_CONFIGPRECIOS_PRODUCTO**//

$count = 0;
$count1 = 0;
$count2 = 0;

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

foreach ($arr_detalle_venta as $row)
{
    error_log("Codigo Venta: ".$row['invnum']);
    $invnumTemp       = $row['invnum'];
    $canproTemp       = $row['canpro'];
    //if ($invnumTemp ==$invnum) {
        $count++;
        if ($canproTemp == '0') {
            $count1++;
        } else {
            $count2++;
        }
    //}
}

$sql4="SELECT porcent FROM datagen";
$result4 = mysqli_query($conexion,$sql4);
if (mysqli_num_rows($result4))
{
    while ($row4 = mysqli_fetch_array($result4))
    {
        $porcent    = $row4['porcent'];
    }
}

$sql5="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result5 = mysqli_query($conexion,$sql5);
if (mysqli_num_rows($result5))
{
    while ($row5 = mysqli_fetch_array($result5))
    {
        $user    = $row5['nomusu'];
    }
}

$sql6="SELECT descli FROM cliente where codcli = '$cuscod'";
$result6 = mysqli_query($conexion,$sql6);
if (mysqli_num_rows($result6))
{
    while ($row6 = mysqli_fetch_array($result6))
    {
        $descli  = $row6['descli'];
    }
}

$monto_total = 0;
//error_log("Monto total : ". $monto_total);
$valor_vent1 = 0;
$mont_bruto  = 0;


if (!empty($arr_detalle_venta))
{
    foreach ($arr_detalle_venta as $row7)
    {
        $codpro    = $row7['codpro'];
        $canpro    = $row7['canpro'];
        $fraccion  = $row7['fraccion'];
        $factor    = $row7['factor'];
        $prisal    = $row7['prisal'];
        $pripro    = $row7['pripro'];
        $costpr    = $row7['costpr'];
        $codmar    = $row7['codmar'];
        $bonif     = $row7['bonif'];
        error_log("Monto total : ". $pripro);
        if ($bonif <> 1)
        {
            $sql2="SELECT igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni "
                    . "FROM producto where codpro = '$codpro'";
            $result2 = mysqli_query($conexion,$sql2);
            if (mysqli_num_rows($result2))
            {
                while ($row2 = mysqli_fetch_array($result2)){
                    $igv        	= $row2['igv'];
                    $referencial  	= $row2['prelis'];
                    $factor      	= $row2['factor'];
                    $margene     	= $row2['margene'];
                    $prevtaMain		= $row2['PrevtaMain'];
                    $preuniMain     	= $row2['PreuniMain'];
                    $prevta		= $row2[6];
                    $preuni     	= $row2[7];
                }
            }
            
            //**CONFIGPRECIOS_PRODUCTO**//
            if (($prevta == "") || ($prevta == 0))
            {
                $prevta = $prevtaMain;
            } 
            if (($preuni  == "") || ($preuni  == 0))
            {
                $preuni  = $preuniMain;
            } 
            
            //**FIN_CONFIGPRECIOS_PRODUCTO**//
            
            if ($factor == 0)
            {
                $factor = 1;
            }
            // Determina si debe calcular precio referencial
            if (($referencial <> 0) and ($referencial <> $prevta))
            {
                $margenes       = ($margene/100)+1;
                $precio_ref     = $referencial * $margenes;
                //$precio_ref	= $precio_ref * $margenes;
            }
            else
            {
                $precio_ref	= $preuni;
            }
            // Calcular cantidad y precios sub-totales
            $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0
            // Si el producto se vende fraccionado
            if ($fraccion == 'T')
            {
                $cantidad_comp  = $canpro;
                $sum_mont1      = ($precio_ref/$factor) * $cantidad_comp;
                $mont_bruto     = $mont_bruto + $sum_mont1;
                $valor_vent     = ($prisal/(($porcent_igv/100)+1))*$cantidad_comp;
            }
            else
            {
                $cantidad_comp  = $canpro * $factor;
                $sum_mont1      = $precio_ref * $canpro;
                $mont_bruto     = $mont_bruto + $sum_mont1;
                $valor_vent	    = ($pripro/(($porcent_igv/100)+1));
                //$valor_vent	= ($prisal/(($porcent_igv/100)+1))*$cantidad_comp;
            }

            $valor_vent1 = $valor_vent1 + $valor_vent;
            $monto_total = $monto_total + $pripro;
        }
    }
}
$t          = 0.0;
error_log("Monto total2 : ". $monto_total);
$r          = $monto_total;
$total_des  = $mont_bruto - $valor_vent1;
$sum_igv    = ($monto_total - $valor_vent1);
$redondeo   = $monto_total - $r;
error_log("Monto total2 : ". $monto_total);
error_log("Monto total_des : ". $total_des);
error_log("Monto sum_igv : ". $sum_igv);
error_log("Monto redondeo : ". $redondeo);
error_log("count : ". $count);
error_log("count1 : ". $count1);
error_log("count2 : ". $count2);
?>