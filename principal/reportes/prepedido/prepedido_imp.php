<?php 

include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	

$idpreped    = isset($_REQUEST['idpreped']) ? ($_REQUEST['idpreped']) : "";///APLICO EL IGV
$numpagina    = isset($_REQUEST['numpagina']) ? ($_REQUEST['numpagina']) : "";///APLICO EL IGV

$numpagpreped = 60;
$sql1="SELECT numpagpreped FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1))
{
    while ($row1 = mysqli_fetch_array($result1)){
        $numpagpreped    = $row1['numpagpreped'];
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
}
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
#tabDetalle { display: block; }

#tabDetalle {
    /*height: 600px;        Just for the demo          */
    overflow-y: auto;    /* Trigger vertical scroll    */
}
</style>
  <script language="JavaScript">
    function printerFunc()
    {
        window.print(document);
        window.close();
    }

</script>  
<title><?php echo $desemp?></title>

<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/body.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />

<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/style1.css" rel="stylesheet" type="text/css" />

<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>

</head>
<body onload="printerFunc()">
<div style="
    height: 100%;
">
<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>

<div class="title1">
	<span class="titulos">SISTEMA DE VENTAS - PREPEDIDO
	</span>
</div>
<div class="mask1111"  style="height: 100%;">
	<div class="mask2222"  style="height: 100%;">
		<div class="mask3333"  style="height: 100%;">		
        <?php 
        if ($idpreped != "") {
            $sql="SELECT * FROM prepedido P, xcompa X
                where P.codloc=X.codloc AND P.idpreped = '$idpreped'";
            error_log($sql);
            $result = mysqli_query($conexion,$sql);
            if (mysqli_num_rows($result)){
                if ($row = mysqli_fetch_array($result)){
                    $nomloc    = $row['nomloc'];
                    $fecha    = $row['fecha'];
        ?>
        <div id="resultado" name="resultado">
        <b><u>DATOS DEL PREPEDIDO</u></b>
            <div>
                <div>CÓDIGO PRINCIPAL: <?php echo $idpreped; ?></div>
                <div><b>CÓDIGO DEL PREPEDIDO: <?php echo $numpagina; ?></b></div>
                <div>LOCAL: <?php echo $nomloc; ?></div>
                <div>FECHA DEL PREPEDIDO: <?php echo fecha($fecha); ?></div>
                <div></div>
            </div>

            <form id="form1" name="form2" method = "post" action="">
            <table width="930" style="border: solid 1px;margin:10px" id="tabDetalle" name="tabDetalle" cellpadding="0" cellspacing="0">
                <thead>
                    <tr style="border: solid 1px;">
                    <th style="border: solid 1px;width:100px">Id</th>
                    <th style="border: solid 1px;width:300px">Producto</th>
                    <th style="border: solid 1px;width:200px">Laboratorio</th>
                    <th style="border: solid 1px;width:200px">Solicitado</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $sql="SELECT * FROM detalle_prepedido DP, titultabladet TI,
                    producto P where DP.idprod=P.codpro AND TI.codtab=P.codmar
                    AND DP.solicitado>0
                    AND P.factor=1
                    AND TI.tiptab='M' AND DP.numpagina = '$numpagina' order by iddetalle asc";
                error_log($sql);
                $result = mysqli_query($conexion,$sql);
                $cont = 0;
                if (mysqli_num_rows($result)){
                    while ($row = mysqli_fetch_array($result)){
                        $numpagina = $row['numpagina'];
                        $iddetalle    = $row['iddetalle'];
                        $desprod    = $row['desprod'];
						
                        $abrev    = $row['abrev'];
                        $destab    = $row['destab'];
                        $idcantidad = $row['idcantidad'];
                        $solicitado = $row['solicitado'];
                        $stocentpro = $row['s000'];
                        $stopro = $row['stopro'];
                        $factor = $row['factor'];
                        $prevta = $row['prevta'];
                        $cont++;
                ?>
                    <tr>
                    <td style="border: solid 1px;padding:1px"><?php echo $cont;?></td>
                    <td style="border: solid 1px;padding:1px"><?php echo $desprod;?></td>
                    <td style="border: solid 1px;padding:1px"><?php echo $abrev;?></td>
                    <td style="border: solid 1px;padding:1px"><?php echo $solicitado;?></td>
                </tr>
                    
                <?php 
                    }
                }
                ?>
                </tbody>
            </table>
            </form>
        </div>
        <?php 
                }
            }
        }
        ?>
  	  </div>
	</div>
   </div>
  </div>
</body>
</html>