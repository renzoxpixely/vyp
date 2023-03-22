<?php include('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
$venta   	  = $_SESSION['cotiz'];
$sql="SELECT invnum,cuscod,invfec,ndias FROM cotizacion where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invnum    = $row['invnum'];
	$cuscod    = $row['cuscod'];
	$invfec    = $row['invfec'];
	$venta	   = $invnum;
	$ndias   = $row['ndias'];
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS

require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("funciones/ventas_index1/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
require_once("ajax_forma_pago.php");		//FUNCIONES DE AJAX PARA VENTAS
require_once("funciones/datos_generales.php");	//FUNCIONES DE AJAX PARA VENTAS
require_once("funciones/ventas_index1.php");	//FUNCIONES DE ESTA PANTALLA
require_once('calcula_monto.php'); 			//CALCULO DE LOS MONTOS POR LA VENTA
////////////////////////////////////////////////////////////////////////////////////////////////
$correlativo = 1;
	$sql="SELECT correlativo FROM venta where sucursal = '$codloc' order by correlativo desc limit 1";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
		while ($row = mysqli_fetch_array($result)){
			$correlativo    = $row['correlativo'] + 1;
		}
	}
$sql="SELECT mensaje FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$msj    = $row['mensaje'];
}
}
if ($msj <> "")
{
?>
<link href="css/scroll.css" rel="stylesheet" type="text/css" />
<?php }
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$descli    = $row['descli'];
}
}
$_SESSION[cotiz]			= $invnum; 
function formato($c) {
printf("%08d",$c);
} 
function formato1($c) {
printf("%04d",$c);
} 
?>
<script>
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

</script>
</head>
<body onkeyup="abrir_index1(event)">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="968" border="0">
    <tr>
      <td width="958">
	  <?php if ($msj <> "")
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
	  <?php }
	  ?>
	  <table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>" border="0">
	       <div align="center" style="background-color:lightblue;margin-top: -24px;" > <h2 >MODULO DE COTIZACION</h2></div>
        <tr>
          <td width="58">NUMERO</td>
          <td width="<?php if ($resolucion == 1){?>60<?php }else{?>90<?php }?>"><input name="textfield" type="text" size="<?php if ($resolucion == 1){?>7<?php } else { ?> 12<?php }?>" disabled="disabled" value="<?php echo formato($correlativo)?>"/></td>
          <td width="<?php if ($resolucion == 1){?>37<?php }else{?>40<?php }?>">FECHA</td>
          <td width="<?php if ($resolucion == 1){?>80<?php }else{?>114<?php }?>"><input name="textfield2" type="text" size="<?php if ($resolucion == 1){?>10<?php } else { ?> 12<?php }?>" disabled="disabled" value="<?php echo fecha($invfec)?>"/></td>
          <td width="<?php if ($resolucion == 1){?>90<?php }else{?>93<?php }?>">FORMA DE PAGO</td>
          <td width="<?php if ($resolucion == 1){?>270<?php }else{?>340<?php }?>"><input name="fpago" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="<?php if ($resolucion == 1){?>1<?php } else { ?> 1<?php }?>" maxlength="1" value="<?php echo $forpag?>"/>
            (E = EFECTIVO, C = CREDITO, T = TARJETA) <strong>N&ordm; DIAS</strong>
            <input name="ndias" type="text" id="ndias" onkeyup="cargarContenido()" value="<?php echo $ndias?>" size="<?php if ($resolucion == 1){?>1<?php } else { ?> 2<?php }?>" maxlength="3"/>
          </td>
          <td width="<?php if ($resolucion == 1){?>120<?php }else{?>189<?php }?>"><div align="right"><span class="blues"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
        </tr>
      </table>
	  <table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>" border="0">
            <tr>
              <td width="56">VENDEDOR</td>
              <td width="<?php if ($resolucion == 1){?>240<?php }else{?>370<?php }?>">
			  <input name="textfield232" type="text" size="<?php if ($resolucion == 1){?>30<?php } else { ?> 50<?php }?>" disabled="disabled" value="<?php echo $user?>"/></td>
              <td width="<?php if ($resolucion == 1){?>100<?php }else{?>177<?php }?>"><div align="right"><span class="blues"><b>FECHA:</b> <?php echo date('d/m/Y');?></span></div></td>
			  <td width="<?php if ($resolucion == 1){?>319<?php }else{?>329<?php }?>">
			  <div align="right"><span class="blues"><b>USUARIO:</b> <?php echo formato1($usuario)?></span></div>
			  </td>
            </tr>
        </table>
		  
          <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="<?php if ($resolucion == 1){?>715<?php }else{?>954<?php }?>" border="0">
            <tr>
              <td width="<?php if ($resolucion == 1){?>715<?php }else{?>948<?php }?>">
			  <iframe src="venta_index2.php" name="index1" width="<?php if ($resolucion == 1){?>720<?php } else{?>954<?php }?>" height="420" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
			  </iframe>			  </td>
            </tr>
        </table>
		  <div align="<?php if ($resolucion == 1){?>left<?php }else{?>right<?php }?>"><img src="../../../images/line2.png" width="<?php if ($resolucion == 1){?>715<?php }else{?>957<?php }?>" height="4" /> </div>
		  <table width="<?php if ($resolucion == 1){?>715<?php }else{?>912<?php }?>" border="0" align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>">
            <tr>
              <td width="<?php if ($resolucion == 1){?>90<?php }else{?>100<?php }?>"><div align="right">MONTO BRUTO </div></td>
              <td width="<?php if ($resolucion == 1){?>80<?php }else{?>120<?php }?>"><input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="<?php if ($resolucion == 1){?>8<?php }else{?>15<?php }?>" value="<?php if ($count2 > 0){?> <?php echo $numero_formato_frances = number_format($mont_bruto, 2, '.', ' ');?> <?php }else{?>0.00<?php }?>" />
              </td>
              <td width="39"><div align="right">DCTO</div></td>
              <td width="<?php if ($resolucion == 1){?>80<?php }else{?>124<?php }?>"><input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="<?php if ($resolucion == 1){?>8<?php }else{?>15<?php }?>" value="<?php if ($count2 > 0){?> <?php echo $numero_formato_frances = number_format($total_des, 2, '.', ' ');?> <?php }else{?>0.00<?php }?>" />
              </td>
              <td width="<?php if ($resolucion == 1){?>70<?php }else{?>87<?php }?>"><div align="right">V. VENTA </div></td>
              <td width="<?php if ($resolucion == 1){?>80<?php }else{?>134<?php }?>"><input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="<?php if ($resolucion == 1){?>8<?php }else{?>15<?php }?>" value="<?php if ($count2 > 0){?> <?php echo $numero_formato_frances = number_format($valor_vent1, 2, '.', ' ');?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="<?php if ($resolucion == 1){?>70<?php }else{?>53<?php }?>"><div align="right">IGV</div></td>
              <td width="<?php if ($resolucion == 1){?>80<?php }else{?>115<?php }?>"><input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="<?php if ($resolucion == 1){?>8<?php }else{?>15<?php }?>" value="<?php if ($count2 > 0){?> <?php echo $numero_formato_frances = number_format($sum_igv, 2, '.', ' ');?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="39"><div align="left">NETO</div></td>
              <td width="<?php if ($resolucion == 1){?>87<?php }else{?>134<?php }?>"><div align="right">
                  <input name="mont5" class="monto_tot" type="text" id="mont5" onclick="blur()" size="<?php if ($resolucion == 1){?>8<?php }else{?>8<?php }?>" value="<?php if ($count2 > 0){?> <?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' ');?> <?php }else{?>0.00<?php }?>"/>
              </div></td>
            </tr>
          </table>
		  <div align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>"><img src="../../../images/line2.png" width="<?php if ($resolucion == 1){?>715<?php }else{?>957<?php }?>" height="4" /> </div>
		  <br />
		  <table width="<?php if ($resolucion == 1){?>715<?php }else{?>950<?php }?>" height="30" border="0" align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>" class="tabla2">
            <tr>
              <td width="<?php if ($resolucion == 1){?>10<?php }else{?>104<?php }?>">&nbsp;</td>
              <td width="<?php if ($resolucion == 1){?>10<?php }else{?>84<?php }?>">&nbsp;</td>
              <td width="<?php if ($resolucion == 1){?>690<?php }else{?>746<?php }?>" valign="middle"><div align="right">
                  
                  <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                  <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
                  <input name="documento" type="hidden" id="documento" value="<?php echo $nrovent?>" />
                  <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
                  <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33?>" />
                  <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
                  <input name="ext" type="button" id="ext" value="Buscar" onclick="buscar()" class="buscar"/>
                  <input name="ext3" type="button" id="ext3" value="Cancelar" onclick="cancelar()" class="cancelar"/>
                  <input name="ext2" type="button" id="ext2" value="Salir" onclick="salir1()" class="salir"/>
				  <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()"/>
              </div></td>
            </tr>
        </table>
		  <div align="center"></div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
