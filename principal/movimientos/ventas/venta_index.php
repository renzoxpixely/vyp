<?php 
    require_once('../../session_user.php');
    require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<?php
    $css_file = "css/" . ($resolucion == 1 ? "tablas_pek" : "tablas_med") . ".css";
?>
<link href="<?php echo $css_file ?>" rel="stylesheet" type="text/css" />
<link href="../../css/body.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
    require_once('../../../funciones/functions.php');
    $cancel = isset($_REQUEST['cancel'])? $_REQUEST['cancel'] : "";
    $tt     = isset($_REQUEST['tt'])? $_REQUEST['tt'] : "";
    $vt     = isset($_REQUEST['vt'])? $_REQUEST['vt'] : "";
    $pf     = isset($_REQUEST['pf'])? $_REQUEST['pf'] : "";
    error_log("Borrando la venta");
    if (isset($_SESSION['venta'])) {
        unset($_SESSION['venta']);
    } 
?>
<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
<script>
function sss()
{
    alert("VENTA CANCELADA. PRESIONE ACEPTAR PARA CONTINUAR");
}
var popUpWin=0;
function impresion()
{
    window.frames['iframeOculto'].location='imprimirpdf.php?rd=<?php echo $tt;?>&vt=<?php echo $vt?>';
}
</script>
</head>
<body <?php if($cancel == 1){?>onload="sss();"<?php } else { if(($tt <> '') and ($pf == 1)){ ?>onload="impresion();"<?php }}?>>
    <iframe id="iframeOculto" name="iframeOculto" style="width:0px; height:0px; border:0px"></iframe>
    <div class="tabla1">
        <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>
        <div class="title1" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
        <span class="titulos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SISTEMA DE VENTAS - Movimiento de Mercaderias
        </span>
        </div>
        <div class="mask1111">
            <div class="mask2222">
                <div class="mask3333">
                    <?php 
                    $activado   = isset($_REQUEST['activado'])? $_REQUEST['activado'] : "";
                    $activado1  = isset($_REQUEST['activado1'])? $_REQUEST['activado1'] : "";
                    $tipo       = isset($_REQUEST['tipo'])? $_REQUEST['tipo'] : "";
                    $val        = isset($_REQUEST['val'])? $_REQUEST['val'] : "";
                    $producto   = isset($_REQUEST['producto'])? $_REQUEST['producto'] : "";
                    ?>
                    <iframe src="venta_index1.php?activado=<?php echo $activado?>&activado1=<?php echo $activado1?>&tipo=<?php echo $tipo?>&val=<?php echo $val?>&producto=<?php echo $producto?>" name="venta_principal" width="<?php if ($resolucion == 1){?>738<?php }else{?>978<?php }?>" height="624" scrolling="Automatic" frameborder="0" id="venta_principal" allowtransparency="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
