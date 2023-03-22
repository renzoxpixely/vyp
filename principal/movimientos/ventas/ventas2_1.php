<?php 

///////////////////////////////
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('MontosText.php');
require_once('../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');	//DESHABILITA TECLAS
require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
require_once('../../../funciones/funct_principal.php');	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once('../funciones/venta.php');	//FUNCIONES DE ESTA PANTALLA
require_once('../../local.php');	//LOCAL DEL USUARIO
//$venta     = $_SESSION['venta'];
//////////////////////////////

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
     
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<script>
function imprimir()
{
   
    window.print();
    window.history.go(-1)
    
    f.submit();
}
</script>
<style>
 body{
    font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
}

section{
    padding: 5px;
    border: 2px solid #0a6fc2;
    width: 95%;
     border-radius: 15px; 
}

.bodyy{
    
    
    overflow: hidden;
    width: 75%;
    height: 10%;
    margin-bottom: 10px;
}

.title{
    text-align: left;
    float: left;
    width: 30%;
    font-size: 75%;
    height: 95%;
    margin-left: -5px;
    
}

.title2{
    
    float: left;
    width: 30%;
    height: 95%;
   
    margin-left: -2px;
    
}

.div_ruc{
    float: right;
    width: 35%;
    height: 55%;
    border: 2px solid #0a6fc2;
    border-radius: 10px;
    margin-top: 25px;
    margin-right: 10px;
    text-align:  center;
    
}
.title_div{
    display: flex;
    
    /*background: #930;*/
    padding: 15px;
    overflow: hidden;
    margin-bottom: 10px;
    width: 100%;
    height: 150px;

}
.data_cliente{
     float: left;
    width: 50%;
    border: 2px solid#0a6fc2;
    border-radius: 5px;
    padding: 5px 12px;
    margin-right: 20px;
    border-radius: 15px;
}
.data_cliente2{
    width: 90%;
    padding: 6px 20px;

}
.div_ruc p{
    font-size: 16px;
}

.boleta33{
   
   border: solid 1px #000000; 
}
.letra{
    font-size: 18px;
}
.letra2{
    font-size: 22px;
}

.table_1, p {
    margin:1px;
    font-size: 87.5%;
}
.table_2, p{
    margin:1px;
    font-size: 87.5%;
    
}




.table_1{
    
    width: 100%;
  
 border-collapse: collapse;
    border: none;
}
/*
.table_1 th, td{
    
    border: 1px solid #000;
   padding: 5px;
   border: 1.5px solid #0a6fc2;
}
.table_2 th, td{
    
    border: 1px solid #000;
   padding: 5px;
   border: 1.5px solid #0a6fc2;
}
.table_2X th, td{
    
   border: 1px solid #000;
   padding: 5px;
   border: 1.5px solid #0a6fc2;
}
*/

.tdra{
    
   border: 1px solid #000;
   padding: 5px;
   border: 1.5px solid #0a6fc2;
}
.thra{
    
   border: 1px solid #000;
   padding: 5px;
   border: 1.5px solid #0a6fc2;
}



.table_1 th:first-child{
    font-size: 0.875em;
}
.table_1 th:nth-child(2){
    font-size: 0.875em;
}
.table_1 th:nth-child(3){
    font-size: 0.875em;
}
.table_1 th:nth-child(4){
    font-size: 0.875em;
}
.table_1 th:nth-child(5){
    font-size: 0.875em;
}

.table_1 td:first-child {
    width: 17%;
}
.table_1 td:nth-child(2) {
    width: 17%;
}
.table_1 td:nth-child(3) {
    width: 17%;
}
.table_1 td:last-child(4) {
    width: 17%;
}
.table_1 td:last-child(5) {
    width: 17%;
}

.table_2{
    width: 100%;
     border-collapse: collapse;
    border: none;
   
}
.table_2 th{
    font-size: 14px;
    background: black;
    color: white;
}

.table_2x{
    width: 100%;
    border-collapse: collapse;
    border: none;
}

.table_2x td:first-child {
    width: 50px;
   
    font-size: 11px;
    
}
.table_2x td:nth-child(2) {
     width: 50px;
  
    font-size: 11px;
}
.table_2x td:nth-child(3) {
    
     width: 200px;
    
    font-size: 11px;
}
.table_2x td:nth-child(4) {
     width: 80px;
   
   font-size: 11px;
}
.table_2x td:nth-child(5) {
     width: 80px;
    
    font-size: 11px;
}
.table_2x td:nth-child(6) {
     width: 70px;
   
    font-size: 11px;
}
.table_2x td:nth-child(7) {
     width: 70px;
   
    font-size: 11px;
}

.table_2 th:first-child {
     background: black;
    color: white;
    font-size: 1em ;
}
.table_2 th:nth-child(2) {
     background: black;
    color: white;
    font-size: 1em ;
}
.table_2 th:nth-child(3) {
     background: black;
    color: white;
    font-size: 1em ;
}
.table_2 th:nth-child(4) {
     background: black;
    color: white;
    font-size: 1em ;
}
.table_2 th:nth-child(5) {
     background: black;
    color: white;
    font-size: 1em;
}
.table_2 th:nth-child(6) {
     background: black;
    color: white;
    font-size: 1em ;
}
.table_2 th:nth-child(7) {
     background: black;
    color: white;
    font-size: 1em ;
}
/*
.div_end{
    display: grid;
    grid-template-columns: 34% 22% 22% 22%;
    width: 90%;: 800px;
    color:#e03232;
    font-size: 14px;
}
.div_end p{
    font-weight: 700;
}*/


.div_end{
   
    padding: 10px;
    overflow: hidden;
    margin-bottom: 10px;
    width: 100%;
    height: 100px;
}

.f1{
    float: left;
    width: 42%;
   
    margin-right: 5px;
   margin-left: -10px;
}
.f2{
    float: left;
    width: 22%;
   
   margin-right: 5px;
}
.f3{
    float: left;
    width: 15%;
   
   margin-right: 5px;
}
.f4{
     
    float: left;
    width: 20%;
    
   
  
}
.money{
    font-weight: 800;
    padding-left: 65%;
}



.table_T{
         line-height: 100%;
        font-family:times;
        font-size:11px;
        font-weight: normal;
}

.table_T2{
         line-height: 100%;
        font-family:times;
        font-size:11px;
        font-weight: normal;
    }
    
    
</style>
</head>
<body onload="imprimir()" >
    
    <?php
      
              $venta = $_REQUEST['invnum'];
   // echo $invnum;
    $sql="SELECT codpro,canpro,fraccion,prisal,pripro,usecod FROM detalle_venta where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
    $i = 0;
	while ($row = mysqli_fetch_array($result)){
			++$i;
			$codpro         = $row['codpro'];
			$canpro         = $row['canpro'];	
			$fraccion       = $row['fraccion'];
			$prisal         = $row['prisal'];	
			$pripro         = $row['pripro'];	
			$usecod         = $row['usecod'];	
                        
        }}
			$sql1="SELECT porcent,formadeimpresion FROM datagen";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
                            $porcent          = $row1['porcent'];
                            $formadeimpresion = $row1['formadeimpresion'];
			}
			}
          
                  
                  $sql1="SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
			}
			}
			$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}
			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];	
			}
			}
                        
                        $sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
                        $result1 = mysqli_query($conexion,$sql1);
                        if (mysqli_num_rows($result1)){
                        while ($row1 = mysqli_fetch_array($result1)){
                                $user_venta    = $row1['nomusu'];
                        }
                        }
function cambiarFormatoFecha($fecha)
    {
        list($anio,$mes,$dia) = explode("-",$fecha);
        return $dia."/".$mes."/".$anio;
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

    error_log("Num copias: ".$_REQUEST['numCopias']);
    error_log("Num copias: ".$_REQUEST['numCopias']);
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
    
    
    if($forpag == "E"){
        $forma = "EFECTIVO";
    }
    if($forpag == "C"){
         $forma = "CREDITO";
    }
    if($forpag == "T"){
         $forma = "TARJETA";
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
        $TextDoc    = "Boleta de Venta electr&oacute;nica";
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
    $sqlCli="SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos,dnicli FROM cliente where codcli = '$cuscod'";
    $resultCli = mysqli_query($conexion,$sqlCli);
    if (mysqli_num_rows($resultCli))
    {
        while ($row = mysqli_fetch_array($resultCli))
        {
            $descli       = $row['descli'];
            $dnicli       = $row['dnicli'];
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
    
    <form name="form1" id="form1" style="width: 100%">
        
        
        <?php
           
         
       
        if(($formadeimpresion == '1') && ($tipdoc <> 4) ){
    
    ?>
    <section >
          
        <div class="bodyy" style="width: 100%">
            <div class="title" style="text-align: left" >
               <p><?php echo pintaDatos($linea1);?></p>
                <p><?php echo pintaDatos($linea2);?></p>
                <p><?php echo pintaDatos($linea3);?></p>
                <p><?php echo pintaDatos($linea4);?></p>
                <?php if($tipdoc <> 4){?>
                <p> <?PHP echo pintaDatos($linea5);?> </p>
                <?PHP }?>
                <p><?php echo pintaDatos($linea6);?></p>
                <p><?php echo pintaDatos($linea7);?></p>
                <p><?php echo pintaDatos($linea8);?></p>
                <p><?php echo pintaDatos($linea9);?></p>
            </div>
            
            <div class="title2">
                  <img src="logo.jpg">
                 
            </div>
            
            <div class="div_ruc">

                <?php 
            if (($ruccli <> "") and ($tipdoc == 1))
            {
            ?>
                <p >RUC: <?php echo $ruccli;?></p>

            <?php 
            }
            ?>
                 <p class="boleta" style="font-weight: 1990; "><font  color = "#0a6fc2" style="font-weight: 1990; " ><?php echo $TextDoc;?></font></p>
                <p ><?php echo $serie.'-'.zero_fill($correlativo,8);?></p>
            </div>
        </div>
        
        
        
        
        <div class="title_div" style="width: 100%">
            <div class="data_cliente">
                <p class="letra">Cliente &nbsp;&nbsp;&nbsp;: <?php echo $descli;?></p>
         <?php if (strlen($dircli)>0){?>
                <p class="letra">Direcci&oacute;n : <?php echo $dircli;?></p>
         <?php  } ?>
                
                <p class="letra">DNI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<?php echo  $dnicli;?></p>
                
                <?php  if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL"))
                  { ?>
                <p class="letra">PUNTOS ACUMULADOS HASTA LA FECHA : <?php echo $pstcli;?></p>
            <?php }?>
            </div>
            
            
            <div class="data_cliente2">
                <p class="letra">Feha de emisi&oacute;n: <?php echo $invfec;?></p>
                <br>
                <p class="letra">Hora: <?php echo substr($hora,0,5);?></p>
            </div>
        </div>
  
 
        
       
            
            <table class="table_1"  >
                <tr >
                    <th class="thra">VENDEDOR</th>
                    <th class="thra">COND. PAGO</th>
                    <th class="thra">FECHA DE VENCIMIENTO</th>
                    <th class="thra">GUIA DE REMISION</th>
                    <th class="thra">NRO ORDEN DE VENTA</th>
                </tr>
                <tr>
                    <td class="tdra"><?php echo $nomusu;?></td>
                    <td class="tdra" align="center" ><?php echo $forma;?></td>
                    <td class="tdra">&nbsp;</td>
                    <td class="tdra">&nbsp;</td>
                    <td class="tdra" align="center" ><?php echo zero_fill($correlativo,8);?></td>
                </tr>
            </table>
            
        <table   class="table_2" style="width: 100%;" frame="hsides" rules="groups" >
            
               <COLGROUP align="center" style="color: #0a6fc2" ></COLGROUP>
            <COLGROUP align="left"   style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
        <?php
        $i  = 1;
        $sqlDet="SELECT * FROM detalle_venta where invnum = '$venta'";
        $resultDet = mysqli_query($conexion,$sqlDet);
        if (mysqli_num_rows($resultDet))
        {
        ?>
            <tr>
                    <th class="thra" style="width: 43px;">CANT</th>
                    <th class="thra" style="width: 48px;">LAB.</th>
                    <th class="thra" style="width: 340px;">DESCRIPTION</th>
                    <th class="thra" style="width: 74px;">LOTE</th>
                    <th class="thra" style="width: 67px;">FECH VCTO.</th>
                    <th class="thra" style="width: 64px;">P. UNITA</th>
                    <th class="thra" style="width: 64px;">P. VENTA</th>
             </tr>
       <!-- </table>
           
           <TABLE class="table_2x"  style="border: 1px solid #00FF00; width: 100%;"  frame="hsides" rules="groups">-->
         
                  
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
                $numlote = "......";
                $vencim  = "";
                $sqlLote="SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                $resulLote = mysqli_query($conexion,$sqlLote);
                if (mysqli_num_rows($resulLote))
                {
                    while ($row1 = mysqli_fetch_array($resulLote))
                    {
                        $numlote    = $row1['numlote'];
                        $vencim     = $row1['vencim'];
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
                $producto2=$desprod ;
                if (strlen($numlote) > 0) 
                {
                    $producto = $desprod. " Lote: " . $numlote ;
                    if (strlen($vencim)>0)
                    {
                        $producto = $producto. " (".$vencim.")";
                    }
                } 
                else 
                {
                   $producto = $desprod;
                }
            ?>
            
             
     
            <TR>
                <TD width="40px"><pre><?php echo $cantemp;?></PRE>
                <TD width="50"><?php echo $marca;?>
                <TD width="350"><?php echo $producto2;?>
                <TD width="60"><?php echo $numlote;?>
                <TD width="60"><?php echo $vencim;?>
                <TD width="60"><?php echo number_format($prisal, 2, '.', '');?>
                <TD width="60"><?php echo number_format($prisal*$Cantidad, 2, '.', '');?>
            
            </TR>
           
           

        
  
            
            
            
            
            
            
       
        <?php
            $i++;
            }
        }
        mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
        ?>
</table>
            <table   >
        <div class="div_end">
            <div class="f1">
                <p class="letra">Son: <?php echo valorEnLetras($invtot);?></p>
                <p class="letra">NETO: <?php echo number_format($SumGrabado, 2, '.', '');?></p>
            </div>
            <div class="f2">
                <br>
                <p class="letra">INFACTO: <?php echo number_format($SumInafectos, 2, '.', '');?></p>
            </div>
            <div class="f3">
                <br>
                <p class="letra">IGV:<?php echo ($igv);?></p>
            </div>
            <div class="f4">
                <br>
                <p class="letra">TOTAL: S/ <?php echo $invtot;?></p>
            </div>
        </div>
        </table>
        <table >
            <div class="money">
            <p class="letra2">PAG&Oacute; con S/. <?php echo $pagacon;?></p>
            <p class="letra2">VUELTO S/. <?php echo $vuelto;?> </p>
        </div>
        </table>
      
         </section>
        <?php }else{
        
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
           ?>
    <table class="table_T" style="width: 100%; border: 1px ;">
            <tr>
                <td style="text-align: left; width:30%;"><img src="logo.jpg"></td>
                <td style="width:30%;">                       
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
        
             </td>
            </tr>
          </table>
            <table class="table_T" style="width: 100%">
            <tr >
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="5">FECHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $invfec;?></td>
            </tr>
            <tr>
                <td colspan="5"> HORA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo substr($hora,0,5);?></td>
            </tr>
            <tr>
                <td colspan="5">VENDEDOR&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $nomusu;?></td>
            </tr>
            <tr>
                <td colspan="5">CLIENTE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $descli;?></td>
            </tr>
            <?php 
            if (($ruccli <> "") and ($tipdoc == 1))
            {
            ?>
            <tr>
                <td colspan="5">RUC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $ruccli;?></td>
            </tr>
            <?php 
            }
            if (strlen($dircli)>0)
            {
            ?>
            <tr>
                <td colspan="5">DIRECCI&Oacute;N&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $dircli;?></td>
            </tr>
         
         
            <?php 
            }
            if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL"))
            {
            ?>
            <tr>
                <td>PUNTOS ACUMULADOS HASTA LA FECHA : <?php echo $pstcli;?></td>
            </tr>
            <?php 
         
            }
            ?>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td style="font-size: 12px;"><center><b><?php echo $TextDoc;?> - <?php echo $serie.'-'.zero_fill($correlativo,8);?></b></center></td>
            </tr>
            </table>
        <hr>
        <table class="table_T" style="width: 100%">
        <?php
        $i  = 1;
        $sqlDet="SELECT * FROM detalle_venta where invnum = '$venta'";
        $resultDet = mysqli_query($conexion,$sqlDet);
        if (mysqli_num_rows($resultDet))
        {
        ?>
            <tr>
                <td style="text-align: left; width:4%;">Cant</td>
                <td style="width:70%;">Descripcion</td>
                <td style="width:7%;">Marca</td>
                <td style="text-align: right; width:9.5%;">P.UNit</td>
                <td style="text-align: right; width:9.5%;">S.Total</td>
                <!--<td style="width:10%;">LOTE</td>
                <td style="text-align: right; width:7.5%;">P. unit</td>
                <td style="text-align: right; width:7.5%;">SUB TOTAL</td>-->
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
                $numlote = "......";
                $vencim  = "";
                $sqlLote="SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                $resulLote = mysqli_query($conexion,$sqlLote);
                if (mysqli_num_rows($resulLote))
                {
                    while ($row1 = mysqli_fetch_array($resulLote))
                    {
                        $numlote    = $row1['numlote'];
                        $vencim     = $row1['vencim'];
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
                $producto=$desprod ;
                if (strlen($numlote) > 0) 
                {
                    $producto = $desprod. " Lote: " . $numlote ;
                    if (strlen($vencim)>0)
                    {
                        $producto = $producto. " (".$vencim.")";
                    }
                } 
                else 
                {
                   $producto = $desprod;
                }
            ?>
            <tr>
                <td style="text-align: left; width:4%;"><?php echo $cantemp;?></td>
                <td style="width:70%;"><?php echo $producto;?></td>
                <td style="width:7%;"><?php echo $marca;?></td>
                <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal, 2, '.', '');?></td>
                <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal*$Cantidad, 2, '.', '');?></td>
                <!--<td><?php echo $numlote;?></td>-->
            </tr>
            <tr><td colspan="5"></td></tr>
        </table>
        
        <table class="table_T" style="width: 100%">
        <?php
            $i++;
            }
        }
        mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
        ?>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>GRAVADA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo number_format($SumGrabado, 2, '.', '');?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>INAFECTO: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<?php echo number_format($SumInafectos, 2, '.', '');?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>IGV:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo ($igv);?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;font-size: 12px;"><b>TOTAL:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;S/ <?php echo $invtot;?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left;font-size: 10px;">SON: <?php echo valorEnLetras($invtot);?></td>
            </tr>
            <tr>
                <td colspan="5"><b>PAG&Oacute; con:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $pagacon;?></b></td>
            </tr>
            <tr>
                <td colspan="5"><b>VUELTO:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $vuelto;?></b></td>
            </tr>
        </table>
        <table class="table_T" style="width: 100%">
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
        <?PHP }?>
    </form>
    
    
    
</body>
</html>