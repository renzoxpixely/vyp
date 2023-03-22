<?php include('../../session_user.php');
$venta   = $_SESSION['cotiz'];
$search  = $_SESSION['searchcot'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
<style>

#efecto1{
     position:relative;
    background:#f3efed;
    width:400px;
    height:30px;
    border:none;
    outline:none;
    
    padding: 0 12px ;
    border-radius:25px 0 0 25px;
    /*border: 1px solid #6ec0f5;*/
}
#efecto2{
    position:relative;
    left:-4px;
    margin-top:8px;
    border-radius:0 25px 25px 0;
    width :90px;
    height:30px;
    border:none;
    outline:none;
   font-weight:bolder;
    cursor:pointer;
    background:#6ec0f5;
    color:#fff;
}
#efecto2:hover{
    background:#fcc154;
}

</style>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("funciones/ventas_index2.php");	//FUNCIONES DE ESTA PANTALLA
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once ('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
/////////////////////////////////////////////////////////////////////////////////////
$val  = $_REQUEST['val'];	//// SI HE PRESIONADO EL TEXTO DE BUSQUEDA
$tipo =	$_REQUEST['tipo'];	//// SI LE INDICADO POR CODIGO O POR DESCRIPCION
//$_SESSION[cotiz]			= $invnum; 
////////////LIMITE DE LA BARRA DE BUSQUEDA
$sql="SELECT limite FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
	 $limite_busk = $row['limite'];
}
}
if ($resolucion == 1)
{
$charact = 40;
$charactbonif = 10;
}
else
{
$charact = 40;
$charactbonif = 14;
}
$sql1="SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$localp    = $row1['codloc'];
}
}
//////////////////////////////////////////
if (($val == 1) and ($tipo == 2))			////SI INGRESO UN TEXTO DE BUSQUEDA QUE PARPADEE EL MISMO TEXTO DE BUSQUEDA
{
		if ($limite_busk > 0)
		{
			if ($search == "")
			{	
			$producto =	$_REQUEST['country_ID'];
			$sql="SELECT codpro FROM producto where codpro = '$producto'";
			}
			else
			{
				$producto = $_REQUEST['codigo_busk'];
				if (($search == 1) || ($search == 5))
				{	
				$sql="SELECT codpro FROM producto where codpro = '$producto'";
				}
				else
				{
					if ($search == 2)
					{
					$sql="SELECT codpro FROM producto where codfam = '$producto'";
					$tipo = 2;
					}
					else
					{
						if ($search == 3)
						{
						$sql="SELECT codpro FROM producto where coduso = '$producto'";
						$tipo = 2;
						}
						else
						{
							if ($search == 4)
							{
							$sql="SELECT codpro FROM producto where codmar = '$producto'";
							$tipo = 2;
							}
							else
							{
								if ($search == 6)
								{
								$sql="SELECT codpro FROM producto where codpres = '$producto'";
								$tipo = 2;
								}
							}
						}
					}
				}
			}
		}
		else
		{
			$acc =	$_REQUEST['acc'];	
			if ($acc == 1)
			{
			$producto =	$_REQUEST['country_ID'];	
			$sql="SELECT codpro FROM producto where codpro = '$producto'";
			}
			else
			{
			$producto =	$_REQUEST['country'];	
			$sql="SELECT codpro FROM producto where desprod like '$producto%' limit 15";
			}
		}
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
		$add = 3;
		}
		else
		{
		$add = 0;
		}
}
else
{
	$add  = $_REQUEST['add'];				////SI SELECCIONO EL PRODUCTO QUE PARPADEE LA CAJA DE CANTIDAD
}
?>
<script language="javascript" type="text/javascript">  
    
function Submit_seguro(formulario)
{  
  for (i=1; i < formulario.elements.length; i++) {  
  if (formulario.elements[i].type == 'submit') {  
      formulario.elements[i].disabled = true  
  }  
  }  
  formulario.submit()  
  Submit_seguro = Submit_off  
  return false  
}  
function Submit_off(formulario) {  
  return false  
}  
<!--
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
function incentiv()
{
////boton///
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
</script>
<script language="javascript" src="funciones/jquery.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script language="javascript"> 
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
function enteres(evt){
	var f   = document.form1;
	var key = nav4 ? evt.which : evt.keyCode;
	
	if (key == 13)
	{
		var cod = document.form1.country_ID.value;
		window.location.href="venta_index2.php?cod="+cod+"&add=1&typpe=1";
	}
	else
	{
	return false; 
	}
}
function enteres1(evt){
	var f   = document.form1;
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		document.form1.submit();
	}
	else
	{
	return false; 
	}
}
  function buscarb()
{
  var f = document.form1;
   if (f.country.value !== '')
	    {
		document.form1.submit();
	    }
	    else
	    {
	        alert("Ingrese una descripcion");f.country.focus();
	        return false;
	    }
//  if (f.country.value == "")
//  { alert("Ingrese el Producto para iniciar la Busqueda"); f.country.focus(); return; }


  f.submit();
}
</script> 
<style>
a:link,
a:visited {
color: #0066CC;
border: 0px solid #e7e7e7;
}
a:hover {
background: #fff;
border: 0px solid #ccc;
}
a:focus {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
}
a:active {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
} 
.Estilo1 {
	color: #006699;
	font-weight: bold;
}
.Estilo2 {
	color: #0066CC;
	font-weight: bold;
}
.Estilo3 {color: #003300}
</style>
</head>
<body onkeyup="abrir_index2(event)" onload="<?php if (($add == 1) || ($add == 2)){?>st();<?php } else { if ($add ==3){?>getfocus()<?php } else {?>sf();<?php }}?>">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
<!--</font><font color="#FF0000"><u>F2 = LISTADO DE CLIENTES</u></font></b> -->
<!--<font color="#00CC00"><u><b>F5 - TIPO DE BUSQUEDA</b></u></font> -->
 <span class="Estilo2"><u>F11 = LISTADO DE PRODUCTOS INCENTIVADOS</u></span>
  <br />
  <!--<u><b>Tipo de Bï¿½squeda: <?php echo $st;?></b></u>-->
<table width="<?php if ($resolucion == 1){?>705<?php }else{?>908<?php }?>" border="0">
  <tr>
   
      <!--<td width="<?php if ($resolucion == 1){?>50<?php }else{?>59<?php }?>" valign="bottom"> PRODUCTO </td>-->
    <td width="<?php if ($resolucion == 1){?>405<?php }else{?>574<?php }?>"><?php if ($limite_busk > 0){
	?>
     <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" value="" size="<?php if ($resolucion == 1){?>50<?php }else{?>90<?php }?>" class="busk" onkeypress="enteres(event)"/>
     <input type="hidden" id="country_hidden" name="country_ID" />
    <?php }
	else
	{
	?>
        <!--<input name="country" type="text" id="country" size="90" class="busk" onkeypress="enteres1(event)"/>-->
        <input  id="efecto1" type="text" placeholder="Buscar Producto . . . . ."   name="country"  id="country" size="65" class="busk" onkeypress="enteres1(event)"/>
    <?php }
	?>
              <input  id="efecto2" type="button"  name="Submit" value="BUSCAR" class="busk" onclick="buscarb()"/>

    </td>
    <td width="<?php if ($resolucion == 1){?>255<?php }else{?>261<?php }?>">
        <div align="right">
          <input name="tipo" type="hidden" id="tipo" value="2" />
          <input name="val" type="hidden" id="val" value="1" />
          <input name="activado" type="hidden" id="activado" value="<?php echo $count?>" />
          <input name="activado1" type="hidden" id="activado1" value="<?php echo $count1?>" />
          <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
          
        </div>
      <div align="right"><span class="blues"><b>CLIENTE:</b> <?php echo $nombre_cliente?></span></div>
	</td>
  </tr>
</table>
<br />
  <?php $val = $_REQUEST['val'];
  if ($val == 1)
  {
  if ($tipo == 2)
  {
	  $add 		= 0;
	  $cod		= 0;
	  $i		= 1;
	  if ($limite_busk > 0)
	  {
	  if ($search == "")
		{	
		$producto =	$_REQUEST['country_ID'];	
	  	$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpro = '$producto' order by $tabla desc, desprod";
		}
		else
		{
			$producto = $_REQUEST['codigo_busk'];
			if (($search == 1) || ($search == 5))
			{	
			$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpro = '$producto' order by $tabla desc,desprod";
			}
			else
			{
				if ($search == 2)
				{
				$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codfam = '$producto' order by $tabla desc,desprod";
				}
				else
				{
					if ($search == 3)
					{
					$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where coduso = '$producto' order by $tabla desc,desprod";
					}
					else
					{
						if ($search == 4)
						{
						$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codmar = '$producto' order by $tabla desc,desprod";
						}
						else
						{
							if ($search == 6)
							{
							$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpres = '$producto' order by $tabla desc,desprod";
							}
						}
					}
				}
			}
		}
	  }
	  else
	  {
	  	$acc =	$_REQUEST['acc'];	
		$productop = $_REQUEST['codigo_busk'];
		if ($productop <> "")
		{
			if (($search == 1) || ($search == 5))
			{	
			$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpro = '$productop' order by $tabla desc,desprod";
			}
			else
			{
				if ($search == 2)
				{
				$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codfam = '$productop' order by $tabla desc,desprod";
				}
				else
				{
					if ($search == 3)
					{
					$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where coduso = '$productop' order by $tabla desc,desprod";
					}
					else
					{
						if ($search == 4)
						{
						$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codmar = '$productop' order by $tabla desc,desprod";
						}
						else
						{
							if ($search == 6)
							{
							$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpres = '$productop' order by $tabla desc,desprod";
							}
						}
					}
				}
			}
		}
		else
		{
			if ($acc == 1)
			{
			$producto =	$_REQUEST['country_ID'];	
			$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codpro = '$producto' order by $tabla desc,desprod";
			}
			else
			{
			$producto =	$_REQUEST['country'];
			$sql="SELECT codpro,desprod,codmar,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where (desprod LIKE '$producto%') order by $tabla desc limit 15";
			}
		}
	  }
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
  ?>

  <table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>">
       <tr>
      <th width="<?php if ($resolucion == 1){?>30<?php }else{?>31<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</th>
      <th width="<?php if ($resolucion == 1){?>343<?php }else{?>431<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</th>
      <th width="<?php if ($resolucion == 1){?>39<?php }else{?>80<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></th>
      <th width="<?php if ($resolucion == 1){?>48<?php }else{?>68<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. REF<?php }else{?>PRECIO REF<?php }?></div></th>
      <th width="41" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">DCTOS</div></th>
      <th width="<?php if ($resolucion == 1){?>53<?php }else{?>73<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. Caja<?php }else{?>PRECIO Caja<?php }?></div></th>
      <th width="<?php if ($resolucion == 1){?>54<?php }else{?>74<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. Unid<?php }else{?>PRECIO Unid<?php }?></div></th>
      <th width="<?php if ($resolucion == 1){?>39<?php }else{?>65<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>S. Und<?php }else{?>STOCK U.<?php }?>  </div></th>
      <th width="<?php if ($resolucion == 1){?>48<?php }else{?>41<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</th>
    </tr>
    <?php while ($row = mysqli_fetch_array($result)){
			$codpro         = $row['codpro'];		//codgio
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$preuni     	= $row['preuni'];
			$referencial  	= $row['prelis'];
			$prevta		  	= $row['prevta'];
			$factor     	= $row['factor'];
			$incentivado    = $row['incentivado'];
			$pcostouni      = $row['pcostouni'];
			$cant_loc  		= $row[9];
			$margene     	= $row['margene'];
			if (($referencial <> 0) and ($referencial <> $prevta))
			{
			$margenes       = ($margene/100)+1;
			$precio_ref     = $referencial/$factor;
			$precio_ref		= $precio_ref * $margenes;
			$precio_ref		= number_format($precio_ref,2,'.',',');
			$desc1	        = $precio_ref - $preuni;
				if ($desc1 < 0)
				{
				$descuento = 0;
				}
				else
				{
				$descuento      = (($precio_ref - $preuni)/$precio_ref)*100;
				}
			}
			else
			{
			$precio_ref		= $preuni;
			$descuento		= 0;
			}
			$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}
			$sql1="SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];
				$marca1    = $row1['abrev'];	
			}
			}
			$sql1="SELECT sum(codpro) FROM incentivadodet where codpro = '$codpro' and estado = '1' and ((codloc = '$codloc') or (codloc = '$localp'))";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			$sumcodes    = $row1[0];
			}
			}
			else
			{
			$sumcodes    = 0;
			}
			if ($sumcodes <> 0)
			{
			$incentivado = 1;
			}
			else
			{
			$incentivado = 0;
			}
			$sql1="SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod_bonif  	= $row1['desprod'];
			}
				$bonifi = 1;
			}
			else
			{
			$bonifi = 0;
			}
			$sql1="SELECT codpro FROM cotizacion_det where codpro = '$codpro' and invnum = '$venta'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
				$control = 1;
			}
			else
			{
				$control = 0;
			}
			if (($incentivado == 1) and ($cant_loc > 0))
			{
			$color = "prodincent";
			$text  = "text_prodincent";
			}
			else
			{
				if ($cant_loc > 0)
				{
				$color = "prodnormal";
				$text  = "text_prodnormal";
				}
				else
				{
				$color = "prodstock";
				$text  = "text_prodstock";
				}
			}
			$z++;
			$convert1    = $cant_loc/$factor;
			$div1    	= floor($convert1);			////PARTE ENTERA DEL STOCK GENERAL
			$mult1		= $factor * $div1;
			$tot1		= $cant_loc - $mult1;	/////OBTENGO EL RESIDUO DEL STOCK GENERAL
	?>
	 <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
      <td width="<?php if ($resolucion == 1){?>30<?php }else{?>28<?php }?>"><b><span class="<?php echo $text?>"><?php echo $i?>-</span></b></td>
      <td width="<?php if ($resolucion == 1){?>343<?php }else{?>431<?php }?>">
	  <?php if ($control == 0){?>
	  <a id="l<?php echo $z?>" href="venta_index2.php?cod=<?php echo $codpro?>&add=1&typpe=1" class="<?php echo $color?>"><b><?php if ($bonifi == 1){echo substr($desprod,0,$charact);echo " "; echo " + (B) x CAJA "; echo substr($desprod_bonif,0,$charactbonif);} else {echo substr($desprod,0,$charact);echo "";}?></b></a>
	  <?php } else {?>
	  <span class="<?php echo $text?>"><font><b><?php if ($bonifi == 1){echo substr($desprod,0,$charact);echo " "; echo " + (B) x CAJA "; echo substr($desprod_bonif,0,$charactbonif);} else {echo substr($desprod,0,$charact);echo " ";}?></b></font></span><?php }?></td>
	  <td width="<?php if ($resolucion == 1){?>39<?php }else{?>80<?php }?>"><div class="<?php echo $text?>"><b><?php if ($marca1 == ""){echo substr($marca,0,15);echo " ";} else { echo substr($marca1,0,15);echo " ";}?></b></div></td>
      <td width="<?php if ($resolucion == 1){?>48<?php }else{?>67<?php }?>"><div align="right" class="<?php echo $text?>"><b><?php echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' ');?></b></div></td>
	  <td width="<?php if ($resolucion == 1){?>41<?php }else{?>40<?php }?>"><div align="right" class="<?php echo $text?>"><b><?php echo $numero_formato_frances = number_format($descuento, 0, '.', ' ');?>%</b></div></td>
	  <td width="<?php if ($resolucion == 1){?>53<?php }else{?>73<?php }?>"><div align="right" class="<?php echo $text?>"><b><?php echo $prevta?></b></div></td>
	  <td width="<?php if ($resolucion == 1){?>54<?php }else{?>72<?php }?>"><div align="right" class="<?php echo $text?>"><b><?php echo $preuni?></b></div></td>
	  <td width="<?php if ($resolucion == 1){?>39<?php }else{?>65<?php }?>"><div align="right" class="<?php echo $text?>"><b><?php echo $div1?> F <?php echo $tot1?></b></div></td>
	  <td width="<?php if ($resolucion == 1){?>48<?php }else{?>44<?php }?>">
	  <div align="center">
	  <a href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro?>', 2, 50, 1100, 350)">
	  <input name="codigo_producto" type="hidden" id="codigo_producto" value="<?php echo $codpro?>" />
	  <img src="../../../images/lens.gif" width="14" height="15" border="0"/></a>
	  <?php /*if (($control == 0) and ($cant_loc > 0)){?>
	  <a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $codpro?>', 285, 90, 650, 200)">
	  <img src="../../../images/add.gif" width="14" height="15" border="0"/></a>
	  <?php }else{?>
	  <img src="../../../images/del_16.png" width="16" height="16" border="0"/>
	  <?php }*/?>
	  </div>
	  </td>
    </tr>
	<?php $i++;
	}
	?>
  </table>
  <?php }
  else
  {
  ?> 
  <center><u><br><br>
    <span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
  </center>
  <?php }
  }
  }
  ?>
  <?php $add    = $_REQUEST['add'];
  $typpe  = $_REQUEST['typpe'];
  $i = 1;
  if ($typpe==1)
  {
    $val = 0;
	$cod = $_REQUEST['cod'];///CODIGO DEL PRODUCTO
	$sql="SELECT codpro,desprod,codmar,factor,costpr,stopro,preuni,prevta,$tabla,pcostouni,margene FROM producto where codpro = '$cod'";  
	$result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result)){
  ?>
  <span class="Estilo1"><u>F4 = LINEA DE PRODUCTOS</u></span>
  <table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>">
    <tr>
      <td width="<?php if ($resolucion == 1){?>15<?php }else{?>27<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</td>
      <td width="<?php if ($resolucion == 1){?>384<?php }else{?>446<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
      <td width="<?php if ($resolucion == 1){?>42<?php }else{?>73<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">
	  <?php if ($resolucion == 1){?>
	  S. UN
	  <?php }else{?>
	  STOCK UNID
	  <?php }?>
	  </div></td>
	  <td width="<?php if ($resolucion == 1){?>67<?php }else{?>93<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">
	  <?php if ($resolucion == 1){?>
	  P. CAJA
	  <?php }else{?>
	  PRECIO Caja
	  <?php }?>
	  </div></td>
	  <td width="<?php if ($resolucion == 1){?>80<?php }else{?>90<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">
	  <?php if ($resolucion == 1){?>
	  P. UN
	  <?php }else{?>
	  PRECIO Unid
	  <?php }?>
	  </div></td>
	  <td width="<?php if ($resolucion == 1){?>62<?php }else{?>91<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">
	  <?php if ($resolucion == 1){?>
	  CANT
	  <?php }else{?>
	  CANTIDAD
	  <?php }?>
	  </div></td>
	  <td width="<?php if ($resolucion == 1){?>66<?php }else{?>82<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">
	  <?php if ($resolucion == 1){?>
	  TOT
	  <?php }else{?>
	  TOTAL
	  <?php }?>
	  </div></td>
    </tr>
  </table>
  <table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>">
    <?php while ($row = mysqli_fetch_array($result)){
			$codpro         = $row['codpro'];	 ///CODIGO PRODUCTO
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$factor     	= $row['factor'];	
			$costpr     	= $row['costpr'];   ///COSTO PROMEDIO
			$stopro     	= $row['stopro'];	///STOCK EN UNIDADES DEL PRODUCTO GENERAL
			$preuni     	= $row['preuni'];	///PRECIO EN UNIDADES DEL PRODUCTO GENERAL
			$prevta		  	= $row['prevta'];
			$pcostouni  	= $row['pcostouni'];
			$margene     	= $row['margene'];
			$cant_loc_add	= $row[8];
			$sql1="SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod_bonif  	= $row1['desprod'];
			}
				$bonif = 1;
			}
			else
			{
			$bonif = 0;
			}
			$sql1="SELECT codpro FROM cotizacion_det where codpro = '$codpro' and invnum = '$venta'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
				$control = 1;
			}
			else
			{
				$control = 0;
			}
			$convert    = $cant_loc_add/$factor;
			$div    	= floor($convert);			////PARTE ENTERA DEL STOCK GENERAL
			$mult		= $factor * $div;
			$tot		= $cant_loc_add - $mult;	/////OBTENGO EL RESIDUO DEL STOCK GENERAL
	?>
    <tr bgcolor="#FFFF99">
      <td width="<?php if ($resolucion == 1){?>15<?php }else{?>27<?php }?>"><font color="#006699" size="4"><?php echo $i?></font></td>
      <td width="<?php if ($resolucion == 1){?>438<?php }else{?>447<?php }?>"><font color="#006699" size="3"><?php if ($bonif == 1){echo substr($desprod,0,$charact);echo " "; echo " + (B) x CAJA "; echo substr($desprod_bonif,0,$charactbonif);} else {echo substr($desprod,0,$charact);echo " ";}?></font></td>
	  <td width="<?php if ($resolucion == 1){?>50<?php }else{?>72<?php }?>"><div align="right"><b><font color="<?php if ($cant_loc_add == 0){?>#FF0000<?php } else {?>#006699<?php }?>" size="4"><?php echo $div?> F <?php echo $tot?></font></b></div></td>
	  <td width="<?php if ($resolucion == 1){?>54<?php }else{?>92<?php }?>"><b><font color="#006699" size="4">
      <div align="right"><?php echo $prevta;?></div></font></b></td>
	  <td width="<?php if ($resolucion == 1){?>54<?php }else{?>90<?php }?>">
	  <label>
	    
		<div align="right">
		<?php if ($control == 0){?>
		<input name="text2" type="hidden" id="text2" value="<?php echo $preuni?>" />
		<input name="text222" type="text" class="cant" id="text222" onclick="blur()" value="<?php echo $preuni?>" size="4" disabled="disabled"/>
	    <?php }
		else
		{
			?>
			<font color="#006699" size="4"><?php echo '<b>';echo $preuni; echo '</b>';?></font>
			<?php }
		?>
	      </label>	  
      </div></td>
      <td width="<?php if ($resolucion == 1){?>54<?php }else{?>92<?php }?>">
      <div align="right">
	      <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni?>" />
	      <input type="hidden" name="numero" id="numero" />
	      <input type="hidden" name="codpro" id="codpro" value="<?php echo $codpro;?>" />
	      <input type="hidden" name="factor" id="factor" value="<?php echo $factor;?>" />
	      <input type="hidden" name="cant_prod" id="cant_prod" value="<?php echo $cant_loc_add;?>" />
              <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
	      <?php if ($control == 0){?>
		  <input name="text1" type="text" class="cant" id="text1" onkeypress="return letraccc(event);" onkeyup ="precio();" size="4"/>
	      <?php }?>
      </div>	  </td>
      <td width="<?php if ($resolucion == 1){?>50<?php }else{?>82<?php }?>" bgcolor="#FFFF99">
      <div align="right">
		  <?php if ($control == 0){?>
		  <input name="text333" type="text" class="cant1" id="text333" onclick="blur()" size="4" disabled="disabled"/>
		  <input type="hidden" name="text3" id="text3" value=""/>
	      <?php }?>
      </div></td>
    </tr>
    <?php $i++;
	}
	?>
  </table>
  <?php }
  else
  {
  ?> 
  <center><u><br><br>
    <span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
  </center>
  <?php }
  }
  ?>
  <iframe src="venta_index3.php" name="iFrame1" width="<?php if ($resolucion == 1){?>710<?php }else{?>935<?php }?>" height="200" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
  </iframe>
</form>
</body>
</html>
