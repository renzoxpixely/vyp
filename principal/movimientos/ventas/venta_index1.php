<?php 
require_once('../../session_user.php');
$venta   	  = $_SESSION['venta'];
$forpag           = "";
$cotizacion	  = isset($_REQUEST['cotizacion'])? $_REQUEST['cotizacion'] : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />

<style>
    
.inpu{
    padding:0 5px;
    border-radius: 5px;
    background-color: #fff;
}    
</style>
<?php
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('../../../funciones/highlight.php');
require_once('../../../funciones/functions.php');
require_once('../../../funciones/botones.php');
require_once('funciones/ventas_index1/funct_principal.php');
require_once('../../local.php');
require_once('ajax_forma_pago.php');
//require_once('funciones/datos_generales.php');
require_once('funciones/ventas_index1.php');
require_once('calcula_monto.php');

function numberOfWeek ($dia,$mes,$ano) 
{
    $Hora = date("H");
    $Min  = date("i");
    $Sec  = date("s");
    $fecha = mktime ($Hora, $Min, $Sec, $mes, 1, $ano);
    $numberOfWeek = ceil(($dia + (date ("w", $fecha)-1))/7);
    return $numberOfWeek;
}


// Lee los datos de la nueva venta del usuario
error_log("CONTROL------------");
if (isset($_SESSION['venta'])) {
	error_log("CONTROL IF------------");
	$sessionVenta = $_SESSION['venta']; 
	$sql="SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias FROM venta where invnum = '$sessionVenta' and usecod = '$usuario' and estado ='1'";
} else {
	error_log("CONTROL ELSE------------");
		// Tomar datos para la venta (local, cliente, numero de venta, correlativo)
		$sql="SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
			if ($row = mysqli_fetch_array($result))
			{
				$codloc    = $row['codloc'];
				$nomusu    = $row['nomusu'];
			}
		}
		$sql="SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
			if ($row = mysqli_fetch_array($result)){
				$codcli    = $row['codcli'];
			}
		}
		$date       = date("Y-m-d");
		
		$fecha      = explode("-",$date);
		$daysem     = $fecha[2];
		$messem     = $fecha[1];
		$yearsem    = $fecha[0];
		$correlativo = 1;
		$sql="SELECT max(correlativo) correlativo FROM venta where sucursal = '$codloc'";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
			if ($row = mysqli_fetch_array($result)){
				$correlativo    = $row['correlativo'] + 1;
			}
		}
		$semana = numberOfWeek($daysem,$messem,$yearsem);
		mysqli_query($conexion,"INSERT INTO venta (nrovent,invfec,usecod,cuscod,forpag,estado,sucursal,tipdoc,correlativo,semana,nrofactura) values ('$correlativo','$date','$usuario','$codcli','E','1','$codloc','2','$correlativo','$semana','')");
		$lastVentaId = mysqli_insert_id($conexion);
		
		$_SESSION['venta'] = $lastVentaId;
		error_log('================== Creando la venta '.$lastVentaId);
		$sql="SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias FROM venta where invnum = '$lastVentaId' and usecod = '$usuario' and estado ='1'";
}

error_log("Obteniendo datos de venta");
error_log($sql);

$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		$cuscod    = $row['cuscod'];
		$invfec    = $row['invfec'];
		$nrovent   = $row['nrovent'];
		$correlativo   = $row['correlativo'];
		$ndias   = $row['ndias'];
	}
}
error_log($invnum);
error_log($cuscod);
$tt     = "";
$vt     = "";
$sql="SELECT focuscotiz, mensaje FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$focuscotiz    = $row['focuscotiz'];
		$msj    = $row['mensaje'];
	}
}
// Determinar cantidad de filas en temp venta
$contador = 0;

if (isset($_SESSION['arr_detalle_venta'])) {
	$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
		$arr_detalle_venta = array();
}
if (!empty($arr_detalle_venta)){
	$contador = sizeof($arr_detalle_venta);
}

if ($msj <> "")
{
?>
	<link href="css/scroll.css" rel="stylesheet" type="text/css" />
<?php
}
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	if ($row = mysqli_fetch_array($result)){
		$descli    = $row['descli'];
	}
}
$_SESSION['venta'] = $invnum; 
$msn         = isset($_REQUEST['msn'])? $_REQUEST['msn'] : "";
$cotizacions = isset($_REQUEST['cotizacions'])? $_REQUEST['cotizacions'] : "";
function formato($c) {
	printf("%08d",$c);
} 
function formato1($c) {
	printf("%04d",$c);
} 
?>
<script>
// Valida valor de cotizacion
function cotiz(){
	var f = document.form1;
	if ((f.cotizacion.value == "") || (f.cotizacion.value == 0))
	{
		alert("Ingrese un Valor Valido"); f.cotizacion.focus(); return;
	}
	f.method = "post";
	f.action = "asigna_cotiz.php";
	f.submit();
}
// Valida cuando usuario presiona ENTER
function nums(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	/////F4/////
	if (key == 13)
	{
		cotiz();
	}
	return (key <= 13 || key == 37 || key == 39 || (key >= 48 && key <= 57));
}
// Abre ventana cuando presiona F11
function abrir_index1(e)
{
	tecla=e.keyCode;
	/////F11/////
	if (tecla == 122) 
	{
		var popUpWin=0;
		var left  = 90;
		var top   = 120;
		var width = 895;
		var height= 420;
		if(popUpWin)
		{
			if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
	}
}
function cc()
{
	var f = document.form1;
	f.cotizacion.focus();
}
function cp()
{
	var f = document.form1;
	alert("LA COTIZACION INGRESADA YA SE ENCUENTRA REGISTRADA");
	f.cotizacion.focus();
}
// Mostrar ventana de pendientes
var popUpWin=0;
function cotizacion1()
{
	////boton///
	var left  = 90;
	var top   = 120;
	var width = 460;
	var height= 300;
	if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
</script>
</head>
<body onkeyup="abrir_index1(event)" <?php if ($msn == 1){?>onload="cp()"<?php } else{if ($focuscotiz == 1){ if (($contador == 0) || ($contador == '')){?>onload="cc()"<?php }}}?>>
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="968" border="0">
    <tr>
      <td width="958">
				<?php
				if ($msj <> "")
				{
				?>
					<table width="<?php if ($resolucion == 1){?>700<?php } else { ?> 954<?php }?>" border="0">
							<tr>
								<td>
									<marquee direction=left height=15 onMouseOut=this.scrollAmount=4 onMouseOver=this.scrollAmount=0 scrollamount=4 width=618>
										<span class="scroll_text1"><?php echo $msj?></span> 
									</marquee>		
								</td>
							</tr>
					</table>
				<?php 
				}
				?>
				<table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>"  style="margin-top:-20px;margin-bottom:-10px;" border="0">
					<tr>
							<td width="40"><strong>NUMERO</strong></td>
							<td width="<?php if ($resolucion == 1){?>50<?php }else{?>80<?php }?>">
								<input class="inpu" name="textfield" type="text" size="<?php if ($resolucion == 1){?>5<?php } else { ?> 10<?php }?>" disabled="disabled" value="<?php echo formato($correlativo);?>"/>
							</td>
							&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;
								<td width="<?php if ($resolucion == 1){?>37<?php }else{?>40<?php }?>"><strong>FECHA</strong></td>
								<td width="<?php if ($resolucion == 1){?>60<?php }else{?>94<?php }?>">
								<input class="inpu" name="textfield2" type="text" size="<?php if ($resolucion == 1){?>10<?php } else { ?> 12<?php }?>" disabled="disabled" value="<?php echo fecha($invfec)?>"/></td>
								&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;
								<td width="<?php if ($resolucion == 1){?>90<?php }else{?>93<?php }?>"><strong>FORMA DE PAGO</strong></td>
								<td width="<?php if ($resolucion == 1){?>270<?php }else{?>340<?php }?>">
								<input  class="inpu" name="fpago" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="<?php if ($resolucion == 1){?>1<?php } else { ?> 1<?php }?>" maxlength="1" value="<?php echo $forpag?>"/>
								(E, C, T)	&nbsp;&nbsp;&nbsp;
								<strong>N&ordm; DIAS</strong>
								<input class="inpu" name="ndias" type="text" id="ndias" onkeyup="cargarContenido()" value="<?php echo $ndias?>" size="<?php if ($resolucion == 1){?>1<?php } else { ?> 2<?php }?>" maxlength="3"/>
							</td>
							<td width="<?php if ($resolucion == 1){?>120<?php }else{?>189<?php }?>"  align="left"><span class="blues"><h1><strong></strong>&nbsp; &nbsp; &nbsp; &nbsp;       <?php echo $nombre_local?></span></h1></td>
					</tr>
        </table>
          
				<table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>" border="0">
					<tr>
					   <!-- <td width="750"></td>-->
						<!--<td width="56">VENDEDOR</td>
						<td width="<?php if ($resolucion == 1){?>150<?php }else{?>200<?php }?>">
							<input name="textfield232" type="text" size="<?php if ($resolucion == 1){?>30<?php } else { ?> 50<?php }?>" disabled="disabled" value="<?php echo $user?>"/>
					    </td>-->
					    
							<!--<td width="<?php if ($resolucion == 1){?>50<?php }else{?>120<?php }?>"><div align="left"><span class="blues"><b>FECHA:</b> <?php echo date('d/m/Y');?></span></div></td>-->
						<!--<td width="<?php if ($resolucion == 1){?>50<?php }else{?>300<?php }?>">
							<strong><font color="#FF0000">Cotizacion</font></strong>
							<?php $cotiza = isset($_REQUEST['cotizacion'])? $_REQUEST['cotizacion'] : "";            
							?>
							<input name="cotizacion" type="text" onkeypress="return nums(event);" size="10" maxlength="6" value="<?php if ($cotizacions <> '') { echo $cotizacions;} else {echo $cotiza;}?>"/>
							<input type="button" name="Submit" value="Asignar" onclick="cotiz();"/>
							<input type="button" name="Submit2" value="Mostrar Cotizaciones" onclick="cotizacion1();"/>			 
						</td>-->
						<td width="<?php if ($resolucion == 1){?>319<?php }else{?>200<?php }?>">
							<!--<div align="right"><span class="blues"><b>USUARIO:</b> <?php echo formato1($usuario)?></span></div>-->
							<div align="right"><span class="blues"><b>&nbsp;USUARIO:</b> <?php echo $nomusu?></span></div>
						</td>
					</tr>
				</table>
		  
				<input name="tt" type="hidden" id="tt" value=""/>
				<input name="vt" type="hidden" id="vt" value=""/>
				<div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
				<table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>" border="0">
					<tr>
						<td width="<?php if ($resolucion == 1){?>715<?php }else{?>948<?php }?>">
							<iframe src="venta_index2.php" name="index1" width="<?php if ($resolucion == 1){?>720<?php } else{?>954<?php }?>" height="495" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
							</iframe>			  
						</td>
					</tr>
        </table>      
			</td>
    </tr>
  </table>
</form>
<?php
	mysqli_free_result($result);
	mysqli_close($conexion); 
?>
</body>
</html>
