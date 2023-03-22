<?php 
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('MontosText.php');

function pintaDatos($Valor)
{
    if ($Valor<> "")
    {
        return "<tr><td style:'text-align:center'><center>".$Valor."</center></td></tr>";
    }
}
function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp"> 
<script>
function imprimir()
{
    var f = document.form1;
    window.print();
    f.action = "venta_index.php";
    f.method = "post";
    f.submit();
}
</script>
<style>
    body, table
    {
        font-size:8px;
        font-weight: normal;
    }
</style>
</head>
<body onload="imprimir()">
    <form name="form1" id="form1">
    <?php 
    function cambiarFormatoFecha($fecha)
    {
        list($anio,$mes,$dia) = explode("-",$fecha);
        return $dia."-".$mes."-".$anio;
    }
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR  = 'temp/';
    
    include "../../phpqrcode/qrlib.php";    
    
    $filename     = $PNG_TEMP_DIR.'ventas.png';

    $matrixPointSize 		= 3;
    $errorCorrectionLevel 	= 'L';
    $framSize 			= 3; //Tamaño en blanco

    $rd			= $_REQUEST['rd'];
    $venta		= $_REQUEST['vt'];
    $seriebol           = "B001";
    $seriefac           = "F001";
    $serietic           = "T001";
    $filename = $PNG_TEMP_DIR.'test'.$venta.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    
    require_once('calcula_monto2.php');
    $sqlV="SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa "
       . "FROM venta where invnum = '$venta'";
    $resultV = mysqli_query($conexion,$sqlV);
    if (mysqli_num_rows($resultV))
    {
        while ($row = mysqli_fetch_array($resultV))
        {
            $invnum       = $row['invnum'];
            $nrovent      = $row['nrovent'];
            $invfec       = cambiarFormatoFecha($row['invfec']);
            $cuscod       = $row['cuscod'];
            $usecod       = $row['usecod'];
            $codven       = $row['codven'];
            $forpag       = $row['forpag'];
            $fecven       = $row['fecven'];
            $sucursal     = $row['sucursal'];
            $correlativo  = $row['correlativo'];
            $nomcliente   = $row['nomcliente'];
            $pagacon      = $row['pagacon'];
            $vuelto       = $row['vuelto'];
            $valven       = $row['valven'];
            $igv          = $row['igv'];
            $invtot       = $row['invtot'];
            $hora         = $row['hora'];
            $tipdoc       = $row['tipdoc'];
            $tipteclaimpresa = $row['tipteclaimpresa'];
            
            $sqlXCOM="SELECT seriebol,seriefac,serietic FROM xcompa where codloc = '$sucursal'";
            $resultXCOM = mysqli_query($conexion,$sqlXCOM);
            if (mysqli_num_rows($resultXCOM))
            {
                while ($row = mysqli_fetch_array($resultXCOM))
                {
                    $seriebol       = $row['seriebol'];
                    $seriefac       = $row['seriefac'];
                    $serietic       = $row['serietic'];
                }
            }
        }
    }
    
    //F9
    if ($tipteclaimpresa == "2")
    {
        if ($tipdoc == 1) 
        {
            $serie      = "F".$seriefac;
        }
        if ($tipdoc == 2) 
        {
            $serie      = "B".$seriebol;
        }
        if ($tipdoc == 4) 
        {
            $serie      = "T".$serietic;
        }
    }
    else
    { //F8
        $serie = $correlativo;
    }
    
    if ($tipdoc == 1) 
    {
        $TextDoc    = "Factura electr&oacute;nica";
    }
    if ($tipdoc == 2) 
    {
        $TextDoc    = "Boleta electr&oacute;nica";
    }
    if ($tipdoc == 4) 
    {
        $TextDoc    = "";
    }
    $SerieQR    = $serie;
    
    //TOMO LOS PATRAMETROS DEL TICKET
    $sqlTicket="SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '$sucursal'";
    $resultTicket = mysqli_query($conexion,$sqlTicket);
    if (mysqli_num_rows($resultTicket))
    {
        while ($row = mysqli_fetch_array($resultTicket))
        {
            $linea1       = $row['linea1'];
            $linea2       = $row['linea2'];
            $linea3       = $row['linea3'];
            $linea4       = $row['linea4'];
            $linea5       = $row['linea5'];
            $linea6       = $row['linea6'];
            $linea7       = $row['linea7'];
            $linea8       = $row['linea8'];
            $linea9       = $row['linea9'];
            $pie1         = $row['pie1'];
            $pie2         = $row['pie2'];
            $pie3         = $row['pie3'];
            $pie4         = $row['pie4'];
            $pie5         = $row['pie5'];
            $pie6         = $row['pie6'];
            $pie7         = $row['pie7'];
            $pie8         = $row['pie8'];
            $pie9         = $row['pie9'];
        }
    }
    else
    {
        $sqlTicket="SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '1'";
        $resultTicket = mysqli_query($conexion,$sqlTicket);
        if (mysqli_num_rows($resultTicket))
        {
            while ($row = mysqli_fetch_array($resultTicket))
            {
                $linea1       = $row['linea1'];
                $linea2       = $row['linea2'];
                $linea3       = $row['linea3'];
                $linea4       = $row['linea4'];
                $linea5       = $row['linea5'];
                $linea6       = $row['linea6'];
                $linea7       = $row['linea7'];
                $linea8       = $row['linea8'];
                $linea9       = $row['linea9'];
                $pie1         = $row['pie1'];
                $pie2         = $row['pie2'];
                $pie3         = $row['pie3'];
                $pie4         = $row['pie4'];
                $pie5         = $row['pie5'];
                $pie6         = $row['pie6'];
                $pie7         = $row['pie7'];
                $pie8         = $row['pie8'];
                $pie9         = $row['pie9'];
            }
        }
    }
    $sqlUsu="SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
    $resultUsu = mysqli_query($conexion,$sqlUsu);
    if (mysqli_num_rows($resultUsu))
    {
        while ($row = mysqli_fetch_array($resultUsu))
        {
            $nomusu       = $row['abrev'];
        }
    }

    $MarcaImpresion = 0;
    $sqlDataGen="SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
    $resultDataGen = mysqli_query($conexion,$sqlDataGen);
    if (mysqli_num_rows($resultDataGen))
    {
        while ($row = mysqli_fetch_array($resultDataGen))
        {
            $desemp         = $row['desemp'];
            $rucemp         = $row['rucemp'];
            $telefonoemp    = $row['telefonoemp'];
            $MarcaImpresion = $row["MarcaImpresion"];
        }
    }
    $departamento = "";
    $provincia    = "";
    $distrito     = "";
    $pstcli       = 0;
    $sqlCli="SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos FROM cliente where codcli = '$cuscod'";
    $resultCli = mysqli_query($conexion,$sqlCli);
    if (mysqli_num_rows($resultCli))
    {
        while ($row = mysqli_fetch_array($resultCli))
        {
            $descli       = $row['descli'];
            $dircli       = $row['dircli'];
            $ruccli       = $row['ruccli'];
            $dptcli       = $row['dptcli'];
            $procli       = $row['procli'];
            $discli       = $row['discli'];
            $pstcli       = $row['puntos'];
        }
        if (strlen($dircli)>0)
        {
            //VERIFICO LOS DPTO, PROV Y DIST
            if (strlen($dptcli)>0)
            {
                $sqlDPTO="SELECT destab FROM titultabladet where codtab = '$dptcli'";
                $resultDPTO = mysqli_query($conexion,$sqlDPTO);
                if (mysqli_num_rows($resultDPTO))
                {
                    while ($row = mysqli_fetch_array($resultDPTO))
                    {
                        $departamento   = $row['destab'];
                    }
                }
            }
            if (strlen($procli)>0)
            {
                $sqlDPTO="SELECT destab FROM titultabladet where codtab = '$procli'";
                $resultDPTO = mysqli_query($conexion,$sqlDPTO);
                if (mysqli_num_rows($resultDPTO))
                {
                    while ($row = mysqli_fetch_array($resultDPTO))
                    {
                        $provincia   = " | ".$row['destab'];
                    }
                }
            }
            if (strlen($discli)>0)
            {
                $sqlDPTO="SELECT destab FROM titultabladet where codtab = '$discli'";
                $resultDPTO = mysqli_query($conexion,$sqlDPTO);
                if (mysqli_num_rows($resultDPTO))
                {
                    while ($row = mysqli_fetch_array($resultDPTO))
                    {
                        $distrito   = " | ".$row['destab'];
                    }
                }
            }
            $Ubigeo = $departamento.$provincia.$distrito;
            if (strlen($Ubigeo)>0)
            {
                $dircli = $dircli."  - ".$Ubigeo;
            }
        }
    }
    $SumInafectos = 0;
    $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta'";
    $resultDetTot = mysqli_query($conexion, $sqlDetTot);
    if (mysqli_num_rows($resultDetTot)) {
        while ($row = mysqli_fetch_array($resultDetTot)) {
            $igvVTADet     = 0;
            $codproDet     = $row['codpro'];
            $canproDet     = $row['canpro'];
            $factorDet     = $row['factor'];
            $prisalDet     = $row['prisal'];
            $priproDet     = $row['pripro'];
            $fraccionDet   = $row['fraccion'];
            $sqlProdDet    = "SELECT igv FROM producto where codpro = '$codproDet'";
            $resultProdDet = mysqli_query($conexion, $sqlProdDet);
            if (mysqli_num_rows($resultProdDet)) 
            {
                while ($row1 = mysqli_fetch_array($resultProdDet)) 
                {
                    $igvVTADet        = $row1['igv'];
                }
            }
            if ($igvVTADet == 0)
            {
                $MontoDetalle = $prisalDet * $canproDet;
                $SumInafectos = $SumInafectos + $MontoDetalle;
            }
        }
    }
    $SumGrabado = $invtot - ($igv + $SumInafectos);
    ?>
        <table style="width: 100%;">
            <?php 
            echo pintaDatos($linea1);
            echo pintaDatos($linea2);
            echo pintaDatos($linea3);
            echo pintaDatos($linea4);
            if($tipdoc <> 4)
            {
                echo pintaDatos($linea5);
            }
            echo pintaDatos($linea6);
            echo pintaDatos($linea7);
            echo pintaDatos($linea8);
            echo pintaDatos($linea9);
            ?>
            <tr>
                <td style="text-align: left">Fecha: <?php echo $invfec;?> Hora: <?php echo substr($hora,0,5);?> Vendedor: <?php echo $nomusu;?></td>
            </tr>
            <tr>
                <td>Cliente: <?php echo $descli;?></td>
            </tr>
            <?php 
            if (($ruccli <> "") and ($tipdoc == 1))
            {
            ?>
            <tr>
                <td>RUC: <?php echo $ruccli;?></td>
            </tr>
            <?php 
            }
            if (strlen($dircli)>0)
            {
            ?>
            <tr>
                <td>Direcci&oacute;n: <?php echo $dircli;?></td>
            </tr>
            <?php 
            }
            if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL"))
            {
            ?>
            <tr>
                <td>Total de puntos acumulados hasta la fecha = <?php echo $pstcli;?></td>
            </tr>
            <?php 
            }
            ?>
            <tr>
                <td style="font-size: 16px;"><center><b><?php echo $TextDoc;?> - <?php echo $serie.'-'.zero_fill($correlativo,8);?></b></center></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%">
        <?php
        $i  = 1;
        $sqlDet="SELECT * FROM detalle_venta where invnum = '$venta'";
        $resultDet = mysqli_query($conexion,$sqlDet);
        if (mysqli_num_rows($resultDet))
        {
        ?>
            <tr>
                <td style="text-align: left; width:5%;">Cantidad</td>
                <td style="width:45%;">Nombre</td>
                <td style="width:20%;">Marca</td>
                <td style="text-align: right; width:15%;">Pre. Uni.</td>
                <td style="text-align: right; width:15%;">Sub Total</td>
                <!--<td style="width:10%;">Lote</td>
                <td style="text-align: right; width:20%;">Precio</td>
                <td style="text-align: right; width:20%;">Sub Total</td>-->
            </tr>
            <tr><td colspan="5"><hr></td></tr>
        <?php
            while ($row = mysqli_fetch_array($resultDet))
            {
                $codpro       = $row['codpro'];	
                $canpro       = $row['canpro'];
                $factor       = $row['factor'];
                $prisal       = $row['prisal'];	
                $pripro       = $row['pripro'];	
                $fraccion     = $row['fraccion'];
                $idlote       = $row['idlote'];
                
                $factorP = 1;
                $sqlProd="SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                $resultProd = mysqli_query($conexion,$sqlProd);
                if (mysqli_num_rows($resultProd))
                {
                    while ($row1 = mysqli_fetch_array($resultProd))
                    {
                        $desprod    = $row1['desprod'];
                        $codmar     = $row1['codmar'];
                        $factorP    = $row1['factor'];
                    }
                }
                if ($fraccion == "F")
                {
                    $cantemp = "C".$canpro;
                }
                else
                {
                    if ($factorP == 1)
                    {
                        $cantemp = $canpro;
                    }
                    else
                    {
                        $cantemp = "F".$canpro;
                    }
                }
                $Cantidad= $canpro;
                $numlote = "";
                $sqlLote="SELECT numlote FROM movlote where idlote = '$idlote'";
                $resulLote = mysqli_query($conexion,$sqlLote);
                if (mysqli_num_rows($resulLote))
                {
                    while ($row1 = mysqli_fetch_array($resulLote))
                    {
                        $numlote    = $row1['numlote'];
                    }
                }
                $sqlMarca="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                $resultMarca = mysqli_query($conexion,$sqlMarca);
                if (mysqli_num_rows($resultMarca)){
                    while ($row1 = mysqli_fetch_array($resultMarca))
                    {
                            $ltdgen     = $row1['ltdgen'];	
                    }
                }
                $marca = "";
                $sqlMarcaDet="SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                $resultMarcaDet = mysqli_query($conexion,$sqlMarcaDet);
                if (mysqli_num_rows($resultMarcaDet))
                {
                    while ($row1 = mysqli_fetch_array($resultMarcaDet))
                    {
                        $marca     = $row1['destab'];
                        $abrev     = $row1['abrev'];	
                        if ($abrev == '')
                        {
                            $marca = substr($marca,0,4);
                        }
                        else
                        {
                            $marca = substr($abrev,0,4);
                        }
                    }
                }
                
                if ($numlote <> "") 
                {
                    $Producto = $desprod . "-" . $numlote;
                } 
                else 
                {
                    $Producto = $desprod;
                }
            ?>
            <tr>
                <td><?php echo $cantemp;?></td>
                <td colspan="1"><?php echo $desprod?> </td>
                <td><?php echo $marca ?></td>
                <td><?php echo $numlote?></td>
                <td><?php echo number_format($prisal,2,'.','')?></td>
                <td colspan ="1"> <?php echo number_format($prisal*$Cantidad, 2, '.', '');?></td>
            </tr>
            <tr>
            </tr>
            
        <?php
            $i++;
            }
        }
        ?>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>Gravada: <?php echo number_format($SumGrabado, 2, '.', '');?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>Inafecto: <?php echo number_format($SumInafectos, 2, '.', '');?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>IGV: <?php echo ($igv);?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;font-size: 15px;"><b>Total: S/ <?php echo $invtot;?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;font-size: 15px;">Son: <?php echo valorEnLetras($invtot);?></td>
            </tr>
            <tr>
                <td colspan="5"><b>Pag&oacute; con: S/ <?php echo $pagacon;?></b></td>
            </tr>
            <tr>
                <td colspan="5"><b>Vuelto: S/ <?php echo $vuelto;?></b></td>
            </tr>
        </table>
        <table style="width: 100%">
            <?php 
            echo pintaDatos($pie1);
            echo pintaDatos($pie2);
            echo pintaDatos($pie3);
            echo pintaDatos($pie4);
            echo pintaDatos($pie5);
            echo pintaDatos($pie6);
            echo pintaDatos($pie7);
            echo pintaDatos($pie8);
            echo pintaDatos($pie9);
            ?>
        </table>
        <center>
            <?php 
            if (($tipdoc == 1) || ($tipdoc == 2))
            {
            QRcode::png($linea5.'|'.$SerieQR.'|'.zero_fill($correlativo,8).'|'.$igv.'|'.$invtot.'|'.$invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize); 
            echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
            }
            ?>
        </center>
    </form>
</body>
</html>