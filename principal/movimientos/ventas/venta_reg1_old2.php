<?php
require_once('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
require_once('../../local.php');

$mont1      = $mont_bruto;   ///PRECIO BRUTO
$mont2      = $total_des;   ///CON DESCUENTO
$mont3      = $valor_vent1;  ///PRECIO VENTA
$mont4      = $sum_igv;   ///IGV
$mont5      = $monto_total;  ///TOTAL
$hour       = date("G");
$date       = date("Y-m-d");
//$date	= CalculaFechaHora($hour);
$FechaSeg   = date("Y-m-d");
$total_costo= 0;
$incentivo  = "";

function tablaslocal($nomloc) 
{
    // Tomar los ultimos digitos de "nomloc" para construir el nombre de columna saldo de local
    $numero = substr($nomloc, 5, 2);
    $tabla = "s" . str_pad($numero, 3, "0", STR_PAD_LEFT);
    return $tabla;
}

function callLotes($Conexion, $CodPro, $Tipo, $codloc) 
{
    $sqlLote = "SELECT idlote,stock FROM movlote where codpro = '$CodPro' 
         and codloc= '$codloc'
        and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW()
        ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
    $resultLote = mysqli_query($Conexion, $sqlLote);
    if (mysqli_num_rows($resultLote)) {
        while ($rowLote = mysqli_fetch_array($resultLote)) {
            $CLote = $rowLote['idlote'];
            $Stock = $rowLote['stock'];
        }
        if ($Tipo == 1) 
        {
            return $CLote;
        }
        if ($Tipo == 2) 
        {
            return $Stock;
        }
    } 
    else 
    {
        return 0;
    }
}

function callUpdateLote($Conexion, $Clote, $StockActualLote) 
{
    $sql1 = "UPDATE movlote set stock = '$StockActualLote' where idlote = '$Clote'";
    $result2 = mysqli_query($Conexion, $sql1);
    // if (mysqli_errno($Conexion))
    // {
    //     error_log("Actualiza producto SQL(" . $sql1 . ")\nError(" . mysqli_error($Conexion) . ")");
    // }
}


$tablalocals = tablaslocal($tablanom_local);
$cuscod = 0;
$sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,tipdoc,tipteclaimpresa FROM venta where invnum = '$venta'";
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row1 = mysqli_fetch_array($resultV))
    {
        $invnum             = $row1['invnum'];  //codgio
        $nrovent            = $row1['nrovent'];
        $invfec             = $row1['invfec'];
        $cuscod             = $row1['cuscod'];
        $usecod             = $row1['usecod'];
        $codven             = $row1['codven'];
        $forpag             = $row1['forpag'];
        $fecven             = $row1['fecven'];
        $tipdoc             = $row1['tipdoc'];          //4=TICKET, 2=BOLETA, 1=FACTURA
        $tipteclaimpresa    = $row1['tipteclaimpresa']; //0=nada,1=F8, 2=F9
        $sucursal           = $row1['sucursal'];
        $correlativo        = $row1['correlativo'];
        switch ($forpag) 
        {
            case 'E':
                $forma_pago = 'EFECTIVO';
                break;
            case 'T':
                $forma_pago = 'TARJETA';
                break;
            case 'C':
                $forma_pago = 'correlativo';
                break;
        }
        //SOLO CUANDO ES F9
        if ($tipteclaimpresa == 2)
        {
            $NuevoCorrelativo = 0;
            //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
            $sqlXCOM="SELECT seriebol,seriefac,serietic,numbol,numfac,numtic FROM xcompa where codloc = '$sucursal'";
            $resultXCOM = mysqli_query($conexion,$sqlXCOM);
            if (mysqli_num_rows($resultXCOM))
            {
                while ($row = mysqli_fetch_array($resultXCOM))
                {
                    $seriebol       = $row['seriebol'];
                    $seriefac       = $row['seriefac'];
                    $serietic       = $row['serietic'];
                    $numbol         = $row['numbol'];
                    $numfac         = $row['numfac'];
                    $numtic         = $row['numtic'];
                    // BOLETA
                    if ($tipdoc == 1)
                    {
                        $serie      = "F".$seriefac;
                        $NuevoCorrelativo = $numbol + 1;
                        mysqli_query($conexion, "UPDATE xcompa set numbol = '$NuevoCorrelativo' where codloc = '$sucursal'");
                    }
                    // FACTURA
                    if ($tipdoc == 2)
                    {
                        $serie      = "B".$seriebol;
                        $NuevoCorrelativo = $numfac + 1;
                        mysqli_query($conexion, "UPDATE xcompa set numfac = '$NuevoCorrelativo' where codloc = '$sucursal'");
                    }
                    //TICKET
                    if ($tipdoc == 4)
                    {
                        $serie      = "T".$serietic;
                        $NuevoCorrelativo = $numtic + 1;
                        mysqli_query($conexion, "UPDATE xcompa set numtic = '$NuevoCorrelativo' where codloc = '$sucursal'");
                    }
                }
                $PrintSerie = $serie.'-'.$NuevoCorrelativo;
                mysqli_query($conexion, "UPDATE venta set nrovent = '$NuevoCorrelativo', correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie' where invnum = '$venta'");
               
            }
        }
    }
}
if ($forpag <> 'T') 
{
    mysqli_query($conexion, "UPDATE venta set codtab = '0' where invnum = '$venta'");
}

$sqlxc = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
$resultxc = mysqli_query($conexion, $sqlxc);
if (mysqli_num_rows($resultxc)) {
    while ($row1 = mysqli_fetch_array($resultxc))
    {
        $localp = $row1['codloc'];
    }
}

if (isset($_SESSION['arr_detalle_venta'])) {
	$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
	$arr_detalle_venta = array();
}
if (!empty($arr_detalle_venta)) {
	foreach ($arr_detalle_venta as $row1)
    {
        $canprocajas        = 0;
        $stockcentralactual = 0;
        $stocklocalactual   = 0;
        $codpro             = $row1['codpro'];
        $date               = $row1['invfec'];
        $cuscod             = $row1['cuscod'];
        $usuario            = $row1['usecod'];
        $codmar             = $row1['codmar'];
        $canpro             = $row1['canpro'];
        $cospro             = $row1['cospro'];
        $costpr             = $row1['costpr'];
        $fraccion           = $row1['fraccion'];
        $factor             = $row1['factor'];
        $prisal             = $row1['prisal'];  ////PRECIO UNITARIO
        $pripro             = $row1['pripro'];  ////MONTO VENTA
        if (isset($row['bonif']) && $row['bonif'] != '') {
			$bonif         = $row['bonif'];
		} else {
			$bonif = 0;
		}
        
        if ($factor == 0) 
        {
            $factor = 1;
        }
        
        $sqlXX = "SELECT invnum FROM incentivadodet where estado = '1' and codpro = '$codpro' and ((codloc = '$sucursal') or (codloc = '$localp')) group by invnum";
        $resultXX = mysqli_query($conexion, $sqlXX);
        if (mysqli_num_rows($resultXX)) 
        {
            while ($rowXX = mysqli_fetch_array($resultXX)) 
            {
                $incentivo = $rowXX[0];
            }
        }
        
        $sql = "SELECT stopro,costpr,costre,utlcos,$tablalocals FROM producto where codpro = '$codpro'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) 
        {
            while ($row = mysqli_fetch_array($result)) 
            {
                $sactual    = $row[0];
                //$costpr     = $row[1];
                $costre     = $row[2];
                $utlcos     = $row[3];
                $slocals    = $row[4];
            }
        }

        if (($incentivo <> "") and ( $incentivo <> 0)) 
        {
            $sql2 = "SELECT incentivado.invnum FROM incentivadodet inner join incentivado on incentivadodet.invnum = incentivado.invnum where codpro = '$codpro'  
                    and dateini <= '$FechaSeg' and datefin >= '$FechaSeg' and incentivado.estado = '1' and incentivadodet.estado = '1'";
            $result2 = mysqli_query($conexion, $sql2);
            if (mysqli_num_rows($result2)) 
            {
                while ($row2 = mysqli_fetch_array($result2)) 
                {
                    $yesincentivo = $row2[0];
                }
            } 
            else 
            {
                $yesincentivo = 0;
            }
        } 
        else 
        {
            $yesincentivo = 0;
        }
        
        $total_costo = $total_costo + $cospro;
        
        // error_log($fraccion);
        // error_log($sactual);
        // error_log($canpro);
        // error_log($factor);

        if ($fraccion == "T")
        {
            $fraccion           = "T";
            $cantidad_kardex    = "f" . $canpro;
            $stockcentralactual = $sactual - $canpro;
            $stocklocalactual   = $slocals - $canpro;
            $CantidadLotes      = $canpro;
        } 
        else
        {
            $fraccion           = "F";
            $cantidad_kardex    = $canpro;
            $canprocajas        = $canpro * $factor;
            $stockcentralactual = $sactual - $canprocajas;
            $stocklocalactual   = $slocals - $canprocajas;
            $CantidadLotes      = $canprocajas;
        }

        $sql1 = "UPDATE producto set stopro = '$stockcentralactual',$tablalocals = '$stocklocalactual' where codpro = '$codpro'";
        // error_log($sql1);
        $result2 = mysqli_query($conexion, $sql1);
        // if (mysqli_errno($conexion))
        // {
        //     error_log("Actualiza producto SQL(" . $sql1 . ")\nError(" . mysqli_error($conexion) . ")");
        // }
        
        $campo  = ($fraccion == "T") ? "fraccion" : "qtypro";
        $tipdoc = ($bonif == 1) ? "11" : "9";

        //INSERTO KARDEX
        $sqlKR = "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc," . $campo . ",factor,invnum,usecod,sactual,sucursal) 
        values ('$nrovent','$codpro','$date','9',$tipdoc,'$cantidad_kardex','$factor','$venta','$usuario','$slocals','$sucursal')";
        $resultKR = mysqli_query($conexion, $sqlKR);
        // $last_idKardex = mysqli_insert_id($conexion);
        // if (mysqli_errno($conexion)) 
        // {
        //     error_log("Agrega kardex SQL(" . $sql1 . ")\nError(" . mysqli_error($conexion) . ")");
        // }
        
        //VERIFICO SI HAY LOTES
        $Clote = 0;
        $sqlLote = "SELECT idlote from movlote where codpro = '$codpro'  and codloc= '$sucursal' AND stock <> 0";
        $resultLote = mysqli_query($conexion, $sqlLote);
        if (mysqli_num_rows($resultLote)) 
        {
            //ACTUALIZO LOS LOTE
            //********************************************
            $CantDetalle = 0;
            $StockDescontar = $CantidadLotes;
            while ($StockDescontar <> 0) {
                
                $Clote     = callLotes($conexion, $codpro, 1, $sucursal);
                $stocklote = callLotes($conexion, $codpro, 2, $sucursal);
                if ($StockDescontar <= $stocklote) 
                { 
                    $StockActualLote = $stocklote - $StockDescontar;
                    $CantDetalle     = $StockDescontar;
                    $CantDetalleColm = $CantDetalle;
                    //ACTUALIZO EL STOCK DE LOTES
                    callUpdateLote($conexion, $Clote, $StockActualLote);
                    $StockDescontar = 0;
                } 
                else 
                {
                    //ACTUALIZO EL STOCK DEL ANTERIOR Y SIGO BUSCANDO DE OTRO LOTE CON EL STOCK POR DESCONTAR
                    $StockDescontar = $StockDescontar - $stocklote;
                    $CantDetalle    = $stocklote;
                    //ACTUALIZO EL STOCK DE LOTES
                    callUpdateLote($conexion, $Clote, 0);
                }
                //INSERTO DETALLEVENTA
                $CantDetalleAux = $CantDetalle;
                if ($fraccion == "F")
                {
                    $cajasADescontar = floor($CantDetalleAux / $factor);
                    if ($cajasADescontar>0) {
                        $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos) 
                            values ('$venta','$date','$cuscod','$usuario','$codpro','$cajasADescontar','$fraccion','$factor','$prisal','$pripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ")";
                        $result2 = mysqli_query($conexion, $sql1);
                        $CantDetalleAux = $CantDetalleAux - $cajasADescontar*$factor;
                    }
                }
                if ($CantDetalleAux>0) {
                    $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos) 
                        values ('$venta','$date','$cuscod','$usuario','$codpro','$CantDetalleAux','T','$factor','$prisal','$pripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ")";
                    $result2 = mysqli_query($conexion, $sql1);
                    // if (mysqli_errno($conexion)) {
                    //     error_log("Agrega detalle SQL(" . $sql1 . "),\nerror(" . mysqli_error($conexion) . ")");
                    // }
                }

                //INSERTO EN KARDEX DETALLE
                // $sql1 = "INSERT INTO kardexLote(codkard,IdLote,Cantidad) values ('$last_idKardex','$Clote','$CantDetalle')";
                // $result2 = mysqli_query($conexion, $sql1);
                // if (mysqli_errno($conexion)) {
                //     error_log("Agrega detalle SQL(" . $sql1 . "),\nerror(" . mysqli_error($conexion) . ")");
                // }
            }
        } else {
            
            //INSERTO DETALLEVENTA
            $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos) 
            values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ")";
            $result2 = mysqli_query($conexion, $sql1);
            //echo $sql1;exit;
            // if (mysqli_errno($conexion)) {
            //     error_log("Agrega detalle SQL(" . $sql1 . "),\nerror(" . mysqli_error($conexion) . ")");
            // }
        }
    }
}

//$hour   = CalculaHora($hour);
$hora       = date('H:i:s a');

unset($_SESSION['arr_detalle_venta']);

$sqlV2 = "UPDATE venta set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',hora = '$hora',redondeo = '$redondeo' where invnum = '$venta'";
$result2 = mysqli_query($conexion, $sqlV2);
// if (mysqli_errno($conexion))
// {
//     error_log("Actualiza venta SQL(" . $sql1 . ")\nError(" . mysqli_error($conexion) . ")");
// }


$sqlCuota = "SELECT invfec,forpag,numeroCuota,invtot FROM venta where invnum = '$venta'";
			$resultCuota = mysqli_query($conexion, $sqlCuota);
			if (mysqli_num_rows($resultCuota)) {
            while ($rowCuota = mysqli_fetch_array($resultCuota)) {
                $invfec         = $rowCuota['invfec'];
                $forpag         = $rowCuota['forpag'];
                $numeroCuota    = $rowCuota['numeroCuota'];
                $invtot         = $rowCuota['invtot'];
                
                
                if($forpag == 'C'){
                    $montoCuotas= $invtot /$numeroCuota;
                    
                   //$montoCuotas=round($montoCuotas ,2);
                
                for ($i = 1; $i <= $numeroCuota; $i++) {
                    
                    $date1=date('Y-m-d');
                    $registro=date('Y-m-d H:m:s');
                    $fechaPago = date("Y-m-d", strtotime($date1 . "+ $i month"));
                    
                    $sqlCuota = "INSERT INTO venta_cuotas(venta_id,monto,fecha_pago,registro,montoCobro) values ('$venta','$montoCuotas','$fechaPago','$registro','$montoCuotas')";
                    $result2 = mysqli_query($conexion, $sqlCuota);
                    
                }
                }
                
            }
            
        }
//PUNTOS DE CLIENTES
if ($cuscod <> 0)
{
    $Puntos = 0;
    $sqlPuntos = "SELECT codcli,puntos FROM cliente where codcli = '$cuscod' AND ((descli <> 'PUBLICO EN GENERAL') OR (descli <> ''))";
    $resultPuntos = mysqli_query($conexion, $sqlPuntos);
    if (mysqli_num_rows($resultPuntos)) 
    {
        while ($row = mysqli_fetch_array($resultPuntos)) 
        {
            $codcli  = $row['codcli'];
            $Puntos  = $row['puntos'];
        }
        $Puntos = intval($mont5) + $Puntos;
        $sqlVP = "UPDATE cliente set puntos = '$Puntos' where codcli = '$codcli'";
        $result2 = mysqli_query($conexion, $sqlVP);
    }
}