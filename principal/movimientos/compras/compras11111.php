<?php include('../../session_user.php');
$ok       	= $_REQUEST['ok'];
$msg       	= $_REQUEST['msg'];
$busca_num  = $_REQUEST['busca_num'];
$busca_prov = $_REQUEST['busca_prov'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../funciones/compras.php");	//FUNCIONES DE ESTA PANTALLA
require_once("ajax_compras.php");	//FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
require_once("../../local.php");	//LOCAL DEL USUARIO
////////////////////////////////////////////////////////////////////////////////////////////////
$sql="SELECT invnum,nro_compra FROM movmae where usecod = '$usuario' and proceso = '1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$invnum          = $row["invnum"];		//codigo
		$ncompra         = $row["nro_compra"];		//codigo
}
}
$_SESSION[compras]	= $invnum; 
/////////////////////////////////////////////////////////////////////////////////////////////////
$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$user    = $row1['nomusu'];
}
}
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$porcent    = $row1['porcent'];
}
}
////////////////////////////////////////////////////////////////////////////////////////////////
$sql="SELECT * FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nro_compra   = $row['nro_compra'];		//codgio
		$fecha        = $row['invfec'];
		$fecdoc       = $row['fecdoc'];
		$fecven       = $row['fecven'];
		$numdoc       = $row['numdoc'];
		$ndoc         = $row['numero_documento'];
		$ndoc1        = $row['numero_documento1'];
		$plazo        = $row['plazo'];
		$moneda       = $row['moneda'];
		$forpag       = $row['forpag'];
		if ($fecdoc == "0000-00-00")
		{
                    $fecdoc = date('Y-m-d');
                    //$hour       = date(G);
                    //$fecdoc	= CalculaFechaHora($hour);
		}
}
}
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
function redondear_dos_decimal($valor) {
$float_redondeado=round($valor * 100) / 100;
return $float_redondeado;
}
?>
<link rel="STYLESHEET" type="text/css" href="../../../funciones/codebase/dhtmlxcalendar.css">
<link rel="STYLESHEET" type="text/css" href="../../../funciones/codebase/dhtmlxcombo.css">
<script>
window.dhx_globalImgPath="../../../funciones/codebase/imgs/";
$(document).ready(function() { 
 
  $('form').keypress(function(e){    
    if(e == 13){ 
      return false; 
    } 
  }); 
 
  $('input').keypress(function(e){ 
    if(e.which == 13){ 
      return false; 
    } 
  }); 
 
}); 
var nav4 = window.Event ? true : false;
function nums(evt) {
var key = nav4 ? evt.which : evt.keyCode;
if (key == 13)
{
  var f = document.form1;
  if (f.alfa1.value == "")
  { alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
  if (f.alfa1.value == 0)
  { alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
  if (f.nrocompra.value == "")
  { alert("Ingrese el Numero de la Orden de Compra"); f.nrocompra.focus(); return; }
  f.method = "post";
  f.action = "compras_busca.php";
  f.submit();
}
return (key <= 13 || key == 115 || key == 83 || (key >= 48 && key <= 57));
}
var nav4 = window.Event ? true : false;
function forma_pago(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
return (key == 102 || key == 103 || key == 111 || key == 70 || key == 71 || key == 79 || key == 8);
}
</script>
<script  src="../../../funciones/codebase/dhtmlxcommon.js"></script>
<script  src="../../../funciones/codebase/dhtmlxcalendar.js"></script>
<script  src="../../../funciones/codebase/dhtmlxcombo.js"></script>
<?php require_once("../../../funciones/calendar.php");?>
<?php ///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA
	$sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$count        = $row[0];	////CANTIDAD DE REGISTROS EN EL GRID
	}	
	}
	else
	{
	$count = 0;	////CUANDO NO HAY NADA EN EL GRID
	}
	///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
	$sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro = '0' and qtyprf = ''";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$count1        = $row[0];	////CUANDO HAY UN GRID PERO CON DATOS VACIOS
	}	
	}
	else
	{
	$count1 = 0;	////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
	}
	///////CONTADOR PARA CONTROLAR LOS TOTALES
	$sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum' and costre <> '0'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$count2        = $row[0];	
	}	
	}
	else
	{
	$count2 = 0;
	}
	$sql1="SELECT * FROM tempmovmov where invnum = '$invnum'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	    $codpro    = $row1['codpro'];
		$qtypro    = $row1['qtypro'];	
		$qtyprf    = $row1['qtyprf'];
		$prisal    = $row1['prisal'];
		$pripro    = $row1['pripro'];
		$costre    = $row1['costre'];
		$d1        = $row1['desc1'];
		$d2        = $row1['desc2'];
		$d3        = $row1['desc3'];
		//////////////VERIFICO SI TIENE IGV
		$sql2="SELECT igv,factor FROM producto where codpro = '$codpro'";
		$result2 = mysqli_query($conexion,$sql2);
		if (mysqli_num_rows($result2)){
		while ($row2 = mysqli_fetch_array($result2)){
				$igv        = $row2['igv'];
				$factor     = $row2['factor'];
		}
		}
		////CANTIDADES///////////
		if ($qtyprf =="")
		{
			$cantidad_comp = $qtypro;
		}
		else
		{
			$cantidad_comp = $qtyprf/$factor;
		}
		//////////CALCULO DEL MONTO BRUTO - SIN DESCUENTO CON IGV
		$sum_mont1 = $prisal * $cantidad_comp;
		$mont_bruto= $mont_bruto + $sum_mont1;
		//////////CALCULO DEL VALOR VENTA
		if ($igv == 1)
		{
		$valor_vent		= ($pripro/(($porcent/100)+1))*$cantidad_comp;
		//$valor_vent		= number_format($valor_vent,2,',','.');
		$valor_vent1	= $valor_vent1 + $valor_vent;
		}
		else
		{
		$valor_vent     = ($pripro * $cantidad_comp);
		$valor_vent1	= $valor_vent1 + $valor_vent;
		}
		$monto_total	= $monto_total + $costre;
	}	
		//////////CALCULO DEL IGV
		$total_des		= $mont_bruto - $valor_vent1;
		$sum_igv		= ($monto_total - $valor_vent1);
		$sum1 			=  $numero_formato_frances = number_format($mont_bruto, 2, '.', ',');
		$sum2 			=  $numero_formato_frances = number_format($total_des, 2, '.', ',');
		$sum3			=  $numero_formato_frances = number_format($valor_vent1, 2, '.', ',');
		$sum4			=  $numero_formato_frances = number_format($sum_igv, 2, '.', ',');
		$sum5			=  $numero_formato_frances = number_format($monto_total, 2, '.', ',');
	}
?>
</head>
<body onload="<?php if (($ok == 1) || ($ok == 4) ||($msg == 2)){ ?> carga();<?php }else{?>carga1();<?php }?>">
<link rel='STYLESHEET' type='text/css' href='../../../css/calendar.css'>
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" method = "post">
  <table width="968" border="0">
    <tr>
      <td width="958"><table width="954" border="0">
        <tr>
          <td width="67">NUMERO</td>
          <td width="109"><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($numdoc)?>"/></td>
          <td width="39">FECHA</td>
          <td width="158"><input name="textfield2" type="text" size="22" disabled="disabled" value="<?php echo $fecha?>"/></td>
          <td width="75">PROVEEDOR</td>
		  <td width="260">
		  <select style='width:250px;' id="combo_zone1" name="alfa1">
            <?php $sql = "SELECT codpro,despro FROM proveedor order by despro"; 
			$result = mysqli_query($conexion,$sql); 
			while ($row = mysqli_fetch_array($result)){ 
			$s_prov = $row["codpro"];
			?>
			<option value="<?php echo $row["codpro"]; ?>" <?php if ($busca_prov == $s_prov){?> selected="selected"<?php }?>><?php echo substr($row["despro"],0,55);?></option>
            <?php } ?>
          </select>
		  <script>
			var z=dhtmlXComboFromSelect("combo_zone1");
			z.enableFilteringMode(true);
		  </script>
		  </td>
		  <td width="86">N&ordm; MOVIMIENTO </td>
		  <td width="126"><input name="nrocompra" type="text" id="nrocompra" size="4" value="<?php echo $busca_num?>" onKeyPress="return nums(event)"/>
            <input name="srch" type="button" id="srch" value="Buscar" class="buscar" onclick="searchs()"/></td>
        </tr>
      </table>
        <table width="954" border="0">
          <tr>
            <td width="67">FECHA DOC</td>
            <td width="109">
			<div style="position:relative; border:1px solid navy; width: 94px">
			<input name="date1" type="text" id="calInput1" style="border-width:0px; width: 74px; font-size:12px;"
			 readonly="true" value="<?php echo $fecdoc;?>"><img style="cursor:pointer;" onClick="showCalendar(1)" src="../../../funciones/codebase/imgs/calendar.gif" align="absmiddle"><div id="calendar1" style="position:absolute; left:94px; top:0px; display:none"></div></div>
			</td>
            <td width="39">TIPO</td>
            <td width="158">
			<input name="fpago" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="4" maxlength="1" value="<?php echo $forpag?>"/> 
			F / G / O </td>
            <td width="75">N DOC</td>
            <td width="179"><input name="n1" type="text" id="n1" onkeypress="return acceptNum(event)" size="5" maxlength="3" onkeyup="cargarContenido()" value="<?php echo $ndoc?>"/>
-
  <input name="n2" type="text" id="n2" onkeypress="return acceptNum(event)" size="15" maxlength="8" onkeyup="cargarContenido()" value="<?php echo $ndoc1?>"/></td>
            <td width="48">MONEDA</td>
            <td width="89"><select name="moneda" id="moneda" onchange="cargarContenido()">
              <option value="S" <?php if ($moneda == "S"){?> selected="selected"<?php }?>>SOLES</option>
              <option value="D" <?php if ($moneda == "D"){?> selected="selected"<?php }?>>DOLARES</option>
            </select></td>
            <td width="152"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
          </tr>
        </table>
        <table width="954" border="0">
          <tr>
            <td width="67">FECHA DIG </td>
            <td width="109"><label>
              <input name="textfield3" type="text" size="15" onfocus="blur()" value="<?php echo $fecha?>"/>
            </label></td>
            <td width="39">PLAZO</td>
            <td width="158"><label>
            <input name="plazo" type="text" id="plazo" onkeypress="return acceptNum(event)" size="5" maxlength="3" onkeyup="cargarContenido()" value="<?php echo $plazo?>"/>
            </label></td>
            <td width="75">FECHA VCTO </td>
            <td width="147"><input name="date2" type="text" id="date2" onfocus="blur()" size="15" value="<?php echo $fecven?>"/>
            <input name="ok" type="hidden" id="ok" value="<?php echo $ok?>" /></td>
            <td width="329"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
          </tr>
        </table>
          
          <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="962" border="0">
            <tr>
              <td width="955">
			  <?php if ($ok <> 4)
			  {
			  ?>
			  <iframe src="compras3.php?ok=<?php echo $ok?>" name="iFrame2" width="954" height="414" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
			  <?php }
			  else
			  {
			  ?>
			  <iframe src="compras2.php?ok=<?php echo $ok?>" name="iFrame3" width="954" height="214" scrolling="Automatic" frameborder="0" id="iFrame3" allowtransparency="0"> </iframe>
			  <iframe src="compras3.php?ok=<?php echo $ok?>" name="iFrame2" width="954" height="200" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
			  <?php }
			  ?>
			  </td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" />          </div>
		  <table width="955" border="0" align="center">
            <tr>
              <td width="73"><div align="right">V. BRUTO </div></td>
              <td width="132">
              <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $sum1?> <?php }else{?>0.00<?php }?>"/>              </td>
              <td width="50"><div align="right">DCTOS</div></td>
              <td width="132">
			  <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $sum2?> <?php }else{?>0.00<?php }?>">			  </td>
              <td width="50"><div align="right">V. VENTA </div></td>
              <td width="132">
			  <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $sum3?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">IGV</div></td>
              <td width="132">
			  <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $sum4?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">TOTAL</div></td>
              <td width="112">
			  <input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $sum5?> <?php }else{?>0.00<?php }?>"/></td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /> </div>
		  <br>
		  <div class="botones">
            <table width="932" border="0">
              <tr>
                <td width="302">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td width="606"><label>
                    <div align="right">
                      <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()"/>
                      <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                      <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
                      <input name="cant_registros" type="hidden" id="cant_registros" value="<?php echo $count?>" />
                      <input name="ncompra" type="hidden" id="ncompra" value="<?php echo $ncompra?>" />
                      <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
                      <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33?>" />
                      <input name="mont_bruto" type="hidden" id="mont_bruto" value="<?php echo $mont_bruto?>" />
					  <input name="total_des" type="hidden" id="total_des" value="<?php echo $total_des?>" />
					  <input name="valor_vent1" type="hidden" id="valor_vent1" value="<?php echo $valor_vent1?>" />
					  <input name="sum_igv" type="hidden" id="sum_igv" value="<?php echo $sum_igv?>" />
					  <input name="monto_total" type="hidden" id="monto_total" value="<?php echo $monto_total?>" />
                      <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
                      <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar"/>
                    </div>
                </label></td>
              </tr>
            </table>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
