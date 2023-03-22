<?php 
require_once('../../session_user.php');
//echo $usuario;exit;
require_once('session_ventas.php');
//echo "hola";exit;
$venta        = isset($_SESSION['venta']) ? $_SESSION['venta'] : '';
$cotizacion   = isset($_SESSION['cotizacion']) ? $_SESSION['cotizacion'] : '';
$search       = isset($_SESSION['search']) ? $_SESSION['search'] : '';
$sum33	      = "";
$st			  = "";
$codigo_busk  = "";
$z			  = "";
$add		  = "";
$typpe		  = "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Documento sin t&iacute;tulo</title>
<link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
<link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js">


</script>

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
    font-size:
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
<?php 
require_once('../../../conexion.php');
require_once('../../../funciones/highlight.php');
require_once('calcula_monto.php');
require_once('funciones/ventas_index1.php');
require_once('funciones/ventas_index2.php');
require_once('../funciones/functions.php');
require_once('../../../funciones/botones.php');
//require_once('funciones/datos_generales.php');

$val  = isset($_REQUEST['val'])? ($_REQUEST['val']) : "";
$tipo =	isset($_REQUEST['tipo'])? ($_REQUEST['tipo']) : "";

$sql="SELECT limite, priceditable FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
    if ($row = mysqli_fetch_array($result)){
        $limite_busk = $row['limite'];
        $priceditable    = $row1['priceditable'];
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


$sqlVenta    = "SELECT sucursal FROM venta where invnum = '$venta'";
$resultVenta = mysqli_query($conexion,$sqlVenta);
if (mysqli_num_rows($resultVenta)){
while ($rowVenta = mysqli_fetch_array($resultVenta))
{
    $sucursal    = $rowVenta['sucursal'];
}
}

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

if (($val == 1) and ($tipo == 2))
{
    $campo          = "codpro";
    $operador_sql   = "=";
    $limite_sql     = "";
    if ($limite_busk > 0)
    {
        if ($search == "")
        {	
            $producto =	$_REQUEST['country_ID'];
            $sql="SELECT codpro FROM producto where codpro = '$producto' and activo = '1'";
        }
        else
        {
            $producto = $_REQUEST['codigo_busk'];
            switch ($search)
            {
                case 2:
                    $campo = "codfam";
                    break;
                case 3:
                    $campo = "coduso";
                    break;
                case 4:
                    $campo = "codmar";
                    break;
                case 6:
                    $campo = "codpres";
                    break;
            }
        }
    }
    else
    {
        //$acc =	$_REQUEST['acc'];
        $CampoAdic  = "";
        $acc = isset($_REQUEST['acc'])? ($_REQUEST['acc']) : "";
        if ($acc == 1)
        {
            $producto       = $_REQUEST['country_ID'];	
            $sql="SELECT codpro FROM producto where codpro = '$producto' and activo = '1'";
        }
        else
        {
            $producto       = $_REQUEST['country'] . "%";
            $campo          = "desprod";
            $operador_sql   = "like";
            $CampoAdic      = "%";
            $limite_sql     = "limit 15";
        }
    }

    $add = 0;
    $sql="SELECT codpro FROM producto where " . $campo . " " . $operador_sql . " '$producto' and activo = '1' " . $limite_sql;
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result))
    {
        $add = 3;
    }   
}
else
{
    $add  = isset($_REQUEST['add']) ? ($_REQUEST['add']) : ""; 
}

$sql="SELECT cuscod,codmed FROM venta where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$cuscod    = $row['cuscod'];
		$codmed    = $row['codmed'];
}
}

$sql="SELECT descli,ruccli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nombre_cliente     = $row['descli'];
        $ruc_cliente        = $row['ruccli'];
}
}

$sql="SELECT nommedico,codcolegiatura FROM medico  WHERE codmed = '$codmed'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$nommedico2     = $row['nommedico'];
        $codcolegiatura2   = $row['codcolegiatura'];
}
}


$sql1="SELECT codloc,codgrup FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
	$codgrupve   = $row1['codgrup'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}

if ($nomloc == "LOCAL0")
{
	$tabla = 's000';
}
if ($nomloc == "LOCAL1")
{
	$tabla = 's001';
}
if ($nomloc == "LOCAL2")
{
	$tabla = 's002';
}
if ($nomloc == "LOCAL3")
{
	$tabla = 's003';
}
if ($nomloc == "LOCAL4")
{
	$tabla = 's004';
}
if ($nomloc == "LOCAL5")
{
	$tabla = 's005';
}
if ($nomloc == "LOCAL6")
{
	$tabla = 's006';
}
if ($nomloc == "LOCAL7")
{
	$tabla = 's007';
}
if ($nomloc == "LOCAL8")
{
	$tabla = 's008';
}
if ($nomloc == "LOCAL9")
{
	$tabla = 's009';
}
if ($nomloc == "LOCAL10")
{
	$tabla = 's010';
}
if ($nomloc == "LOCAL11")
{
	$tabla = 's011';
}
if ($nomloc == "LOCAL12")
{
	$tabla = 's012';
}
if ($nomloc == "LOCAL13")
{
	$tabla = 's013';
}
if ($nomloc == "LOCAL14")
{
	$tabla = 's014';
}
if ($nomloc == "LOCAL15")
{
	$tabla = 's015';
}
if ($nomloc == "LOCAL16")
{
	$tabla = 's016';
}
if ($nomloc == "LOCAL17")
{
	$tabla = 's017';
}
if ($nomloc == "LOCAL18")
{
	$tabla = 's018';
}
if ($nomloc == "LOCAL19")
{
	$tabla = 's019';
}
if ($nomloc == "LOCAL20")
{
	$tabla = 's020';
}
?>
<!--<script type="text/javascript" src="funciones/js/jquery.js"></script>--> 
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

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

//function PRINCIPIOACTIVO(URLStr, left, top, width, height, limpiacadena)
//{
//  if(popUpWin)
//  {
//    if(!popUpWin.closed) popUpWin.close();
//  }
//  popUpWin = open('prinactivo.php?lim=' + limpiacadena , 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=455,height=350,left=540,top=100,screenX='+left+',screenY='+top+'');
//    alert(limpiacadena)
//}
function PRINCIPIOACTIVO(limpiacadena)
    {
        window.open('prinactivo.php?lim='+ limpiacadena,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=70,left=540,width=455,height=350');
    }
function ACCIONTERAPEUTICA(limpiacadena)
    {
        window.open('accionte.php?lim='+ limpiacadena,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=70,left=540,width=455,height=350');
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

function f6()
{
	var popUpWin=0;
		var left = 300;
            var top = 120;
            var width = 480;
            var height = 280;
		if(popUpWin)
		{
		if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('tip_venta.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
 }
 
 function f2()
{
window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=320,width=905,height=380');
 }
 
  function f1()
{
window.open('f3/f3.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=350');
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
<script language="javascript" src="funciones/jquery.js"></script> 
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
function enteres(evt)
{
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
	    if (f.country.value !== '')
	    {
		document.form1.submit();
	    }
	    else
	    {
	        alert("Ingrese una descripcion");
	        return false;
	    }
	}
	else
	{
		return false; 
	}
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
	
	       
          .f{
    text-decoration: none;
    padding: 2px;
    font-weight: 200;
    font-size: 10px;
    color: #ffffff;
    background-color: #1883ba;
    	font-weight: bold;
    border-radius: 6px;
    
  }
</style>
</head>
<body onkeyup="abrir_index2(event)" onload="<?php if (($add == 1) || ($add == 2)){?>st();<?php } else { if ($add ==3){?>getfocus()<?php } else {?>sf();<?php }}?>">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
	<table width="<?php if ($resolucion == 1){?>715<?php }else{?>920<?php }?>" height="30" border="0" align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>" class="tabla2">
            <tr>
                <td width="<?php if ($resolucion == 1){?>20<?php }else{?>188<?php }?>">
                    <?php 
                    if (strlen($ruc_cliente)>0)
                    {
                        echo "<h2 style='color: #2a4f8c;'>FACTURA</h2>";
                    }
                    ?>
                    <div align="left"><span class="blues"><b>MEDICO:</b> <?php echo $nommedico2?> 
                            <?php
                            if($codcolegiatura2<>""){ ?>
                                 <b>CODIGO:</b><?php echo $codcolegiatura2;?></span></div>
                          <?php  }?>

                            

                </td>
                <td width="<?php if ($resolucion == 1){?>690<?php }else{?>170<?php }?>" valign="middle"><div align="right">
                    <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()" disabled="disabled"/>
                    &nbsp;
                    <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                    &nbsp;
                    <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
                    
                    <input name="documento" type="hidden" id="documento" value="<?php echo $nrovent?>" />
                    <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
                    <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33?>" />
                    <input name="CodClaveVendedor" type="hidden" id="CodClaveVendedor" value="" />
                    <input name="save" type="hidden" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
                    &nbsp;
                    <input name="ext" type="button" id="ext" value="Buscar" onclick="buscar()" class="buscar" <?php if (($count == 1)||($count1<0)){?>disabled="disabled" title="Tiene una Venta Pendiente Cancelar o Eliminar para Poder Buscar,Gracias"<?php }?> />
                    &nbsp;
                    <input name="ext3" type="button" id="ext3" value="Cancelar(F4)" onclick="cancelar()" class="cancelar"/>
                    &nbsp;
                    <input name="ext2" type="button" id="ext2" value="Salir" onclick="salir1()" class="salir" <?php if (($count == 1)||($count1<0)){?>disabled="disabled" title="Cancelar la Venta Antes de Salir"<?php }?> />
                </div>
                </td>
            </tr>
	</table>
        
	<!--<b><font color="#FF9900"><u>F1 = LISTADO DE MEDICOS</u></font> - <font color="#FF0000"><u>F2 = LISTADO DE CLIENTES</u></font> - <font color="#00CC00"><u>F5 - TIPO DE BUSQUEDA</u></font></b> - <span class="Estilo3"><u><strong><font color="#CC6600">F6 = TIPO DE PAGO</font></strong></u></span> - <span class="Estilo2"><u>F11 = LISTADO DE PRODUCTOS INCENTIVADOS</u></span> <br />-->
	 
	  <b><b title="Anteponer el * para Realizar la Busqueda Ejmplo: *NAPROXENO "><font color="#FF9900">* &nbsp; PRINCIPIO ACTIVO </font> </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B title="Anteponer el / para Realizar la Busqueda Ejmplo: *ANTIBIOTICO "> <font color="#FF0000">/ &nbsp; ACCION TERAPEUTICA</font></B></b> <br />
	<input type="button" class="f" name="Submit" value="LISTADO DE MEDICOS (F1)" onclick="f1();"/></td>
		<input type="button" class="f" name="Submit" value="LISTADO DE CLIENTES (F2)" onclick="f2();"/></td>
	<input type="button" class="f" name="Submit" value="FORMA DE PAGO (F6)" onclick="f6();"/></td>
	 <input type="button" class="f" name="Submit" value="LISTADO DE INCENTIVOS (F11)" onclick="incentiv();"/></td>
	<!--<u><b>Tipo de Busqueda: <?php echo $st;?></b></u>-->
	<table width="<?php if ($resolucion == 1){?>705<?php }else{?>920<?php }?>" border="0">
            <tr>
               <!-- <td width="59" valign="bottom"> PRODUCTOww </td>-->
                <td width="685">
                <?php
                if ($limite_busk > 0){
                ?>
                    <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" value="" size="<?php if ($resolucion == 1){?>50<?php }else{?>65<?php }?>" class="busk" onkeypress="enteres(event)" />
                    <input type="hidden" id="country_hidden" name="country_ID" />
                <?php
                }
                else
                {
                ?>
                    <input  id="efecto1" type="text" placeholder="Buscar Producto . . . . ."   name="country"  id="country" size="65" class="busk" onkeypress="enteres1(event)"/>
                <?php
                }
                ?>
                   <!--<input type="button" name="Submit" value="Incentivos (F11)" onclick="incentiv();"/></td>-->
                <input  id="efecto2" type="button"  name="Submit" value="BUSCAR" class="busk" onclick="buscarb()"/>
               
                <td width="220">
                    <div align="right">
                        <input name="tt" type="hidden" id="tt" value=""/>
                        <input name="vt" type="hidden" id="vt" value=""/>
                        <input name="tipo" type="hidden" id="tipo" value="2" />
                        <input name="val" type="hidden" id="val" value="1" />
                        <input name="activado" type="hidden" id="activado" value="<?php echo $count?>" />
                        <input name="activado1" type="hidden" id="activado1" value="<?php echo $count1?>" />
                        <input name="medico" type="hidden" id="medico" value="<?php echo $nommedico2?>" />
                        <input name="t33" type="hidden" id="t33" value="<?php echo $pripro?>" />
                    </div>
                <div align="right"><span class="blues"><b>CLIENTE:</b> <?php echo $nombre_cliente?></span></div>
                </td>
            </tr>
<?php 
	if (strlen($nommedico)>0)
	{
?>
            <tr>
                <td colspan="3">
                    <div align="right"><span class="blues"><b>MEDICO:</b> <?php echo $nommedico?> <b>COLEGIATURA:</b><?php echo $codcolegiatura;?></span></div>
                </td>
            </tr>
<?php 
	}
?>
	</table>
	<br />
<?php 
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
if ($val == 1)
{
	if ($tipo == 2)
	{
		$add 		= 0;
		$cod		= 0;
		$i		= 1;

		$campo          = "codpro";
		if ($limite_busk > 0)
		{
                    if ($search == '')
                    {
                        $producto = $_REQUEST['country_ID'];	
                    }
                    else
                    {
                        $producto = $_REQUEST['codigo_busk'];

                        switch ($search)
                        {
                            case 2:
                                    $campo = "codfam";
                                    break;
                            case 3:
                                    $campo = "coduso";
                                    break;
                            case 4:
                                    $campo = "codmar";
                                    break;
                            case 6:
                                    $campo = "codpres";
                                    break;
                        }
                    }
                    $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ".$campo." = '$producto' and activo = '1' order by $tabla desc";
		}
		else
		{
                    $acc 		= isset($_REQUEST['acc']) ? ($_REQUEST['acc']) : ""; 
                    $productop 	= isset($_REQUEST['codigo_busk']) ? ($_REQUEST['codigo_busk']) : ""; 
                    if ($productop <> "")
                    {
                        switch ($search)
                        {
                                case 2:
                                        $campo = "codfam";
                                        break;
                                case 3:
                                        $campo = "coduso";
                                        break;
                                case 4:
                                        $campo = "codmar";
                                        break;
                                case 6:
                                        $campo = "codpres";
                                        break;
                        }
                        $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ".$campo." = '$productop' and activo = '1' order by $tabla desc ,desprod desc";
                    }
                    else
                    {
                        if ($acc == 1)
                        {
                            $producto =	$_REQUEST['country_ID'];	
                            $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where codpro = '$producto' and activo = '1' order by $tabla desc,desprod desc";
                        }
                        /*else
                        {
                            $producto 	= $_REQUEST['country'];
                            $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ((desprod LIKE '$producto%') or (codbar = '$producto') or (codpro = '$producto%'))  and activo = '1' order by $tabla desc,desprod desc";
                        }*/
                        
                         else
                      {
                            $producto 	= $_REQUEST['country'];
                            $codfamm =	$_REQUEST['codfam'];	
                            $codusoo =	$_REQUEST['coduso'];	
                            $limpiacadena ="";
                            $DetectaAsterics1    = substr($producto, 0,1);
                            $DetectaAsterics2    = substr($producto, 0,1);
                              if ($DetectaAsterics2 == "*") 
                            {
                                $limpiacadena = str_replace('*', '', $producto);
                                    echo "<script language='javascript'> PRINCIPIOACTIVO('". $limpiacadena."'); </script>";
                            }
                            elseif ($DetectaAsterics1 == "/")
                            {

//                                    ACCION TERAPEUTICA
                                $limpiacadena = str_replace('/', '', $producto);
                           echo "<script language='javascript'> ACCIONTERAPEUTICA('". $limpiacadena."'); </script>";
                             
                                }else{
                                    
                                    if($codfamm <>""){
                                        $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where codfam='$codfamm'  and activo = '1' order by $tabla desc,desprod desc";
                                    }elseif($codusoo <>""){
                                        $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where coduso='$codusoo'  and activo = '1' order by $tabla desc,desprod desc";
                                    }
                                    else{
                                $limpiacadena =  $producto;
                                $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ((desprod LIKE '$limpiacadena%') or (codbar = '$limpiacadena') or (codpro = '$limpiacadena%') or(codfam='$codfamm') )  and activo = '1' order by $tabla desc,desprod desc";
                                }
                                }
                        }
                    }
		}
		$result= mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
?>
		
			<table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>" border="0">
			    
			    <tr>
					<th width="<?php if ($resolucion == 1){?>30<?php }else{?>31<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</th>
					<th width="<?php if ($resolucion == 1){?>378<?php }else{?>466<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</th>
					<th width="<?php if ($resolucion == 1){?>39<?php }else{?>80<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></th>
                                        <th width="<?php if ($resolucion == 1){?>20<?php }else{?>75<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos"><div align="CENTER">FeVen</div></th>
					<th width="<?php if ($resolucion == 1){?>53<?php }else{?>73<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. Caja<?php }else{?>PRECIO Caja<?php }?></div></th>
					<th width="<?php if ($resolucion == 1){?>54<?php }else{?>74<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. Unid<?php }else{?>PRECIO Unid<?php }?></div></th>
					<th width="<?php if ($resolucion == 1){?>54<?php }else{?>74<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>P. Blis<?php }else{?>P. Blister<?php }?></div></th>
					<th width="<?php if ($resolucion == 1){?>39<?php }else{?>65<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1){?>S. Und<?php }else{?>STOCK U.<?php }?>  </div></th>
					<th width="<?php if ($resolucion == 1){?>48<?php }else{?>41<?php }?>" bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</td>
			</tr>
			<?php
				while ($row = mysqli_fetch_array($result)){
					$codpro         = $row['codpro'];
					$desprod        = $row['desprod'];
					$codmar         = $row['codmar'];
					$pblister     	= $row['blister'];
					$preblister     = $row['preblister'];
					$referencial  	= $row['prelis'];
					$factor     	= $row['factor'];
					$incentivado    = $row['incentivado'];
					$pcostouni      = $row['pcostouni'];
                    $margene     	= $row['margene'];
					$cant_loc       = $row[10];
                    $prevtaMain     = $row['PrevtaMain'];
                    $preuniMain     = $row['PreuniMain'];
                    $prevta         = $row[13];
                    $preuni         = $row[14];
					
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
                        
					if (($referencial > 0) and ($referencial <> $prevta))
					{
						$margenes       = ($margene/100)+1;
						$precio_ref     = $referencial;
						//$precio_ref     = $referencial/$factor;
						//$precio_ref     = $referencial* $factor;
						$precio_ref	= $precio_ref * $margenes;
						$desc1	        = $precio_ref - $preuni;
						if ($desc1 < 0)
						{
							$descuento = 0;
						}
						else
						{
							if (!(($precio_ref < 1) and ($precio_ref > 0)))
							{
								$precio_ref		= number_format($precio_ref,2,'.',',');
							}
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
					$sql1="SELECT vencim FROM movlote where codpro = '$codpro'";
					$result1 = mysqli_query($conexion,$sql1);
					if (mysqli_num_rows($result1)){
						while ($row1 = mysqli_fetch_array($result1)){
							$vencim    = $row1['vencim'];	
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
					//echo $marca1;
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
					$sql1="SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$venta'";
					$result1 = mysqli_query($conexion,$sql1);
					if (mysqli_num_rows($result1)){
						$control = 1;
					}
					else
					{
						$control = 0;
					}

					$control = 0;
					if (($incentivado == 1) and ($cant_loc > 0))
					{
						$color = 'prodincent';
						$text  = 'text_prodincent';
					}
					else
					{
						if ($cant_loc > 0)
						{
							$color = 'prodnormal';
							$text  = 'text_prodnormal';
						}
						else
						{
							$color = 'prodstock';
							$text  = 'text_prodstock';
						}
					}
					if ($factor == 0)
					{
						$factor = 1;
					}
					++$z;
					$convert1       = $cant_loc/$factor;
					$div1    	= floor($convert1);
					$mult1		= $factor * $div1;
					$tot1		= $cant_loc - $mult1;
					if($preuni>0)
					{
						
					}
					else
					{
						if ($factor <>0)
						{
							$preuni = $prevta/$factor;
						}
					}
					$preunit = number_format($preuni, 3, '.', ' ');
				?>
				<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
				<td width="<?php if ($resolucion == 1){?>30<?php }else{?>28<?php }?>">
				    	<?php if ($control == 0) {?>
				    <b><span class="<?php echo $text?>"><?php echo $codpro?>-</span></b>
				    <?php 	} ?>
				 </td>
				 
				<td width="<?php if ($resolucion == 1){?>300<?php }else{?>350<?php }?>">
        			<?php if ($control == 0) {?>
        				<a id="l<?php echo $z?>" style="text-decoration:none"  href="venta_index2.php?cod=<?php echo $codpro?>&add=1&typpe=1" class="<?php echo $color?>"><b><?php if ($bonifi == 1){echo substr($desprod,0,$charact);echo " "; echo " + (B) x CAJA "; echo substr($desprod_bonif,0,$charactbonif);} else {echo substr($desprod,0,$charact);echo " ";}?></b></a>
        			<?php 	} ?>
		    	</td>
		    	
				<td width="<?php if ($resolucion == 1){?>25<?php }else{?>45<?php }?>" title=" <?PHP ECHO $marca;?>  ">
				    	<?php if ($control == 0) {?>
				    <div class="<?php echo $text?>"><pre><b><?php if ($marca1 == ""){echo substr($marca,0,5);echo " ";} else { echo substr($marca1,0,5);echo " ";}?></b></pre>
				    </div>
				    	<?php 	} ?>
				</td>
				
					<td width="<?php if ($resolucion == 1){?>10<?php }else{?>50<?php }?>">
					    <?php if ($control == 0) {?>
					    <div   align="CENTER" class="<?php echo $text?>"><pre><?php echo $vencim?></pre></div>
					    	<?php 	} ?>
					    </td>
					    
					
					
				<td width="<?php if ($resolucion == 1){?>53<?php }else{?>73<?php }?>">
				     <?php if ($control == 0) {?>
				    <div align="CENTER" class="<?php echo $text?>"><pre><?php echo $prevta?></pre></div>
				    	<?php 	} ?>
				    </td>
				    <td width="<?php if ($resolucion == 1){?>20<?php }else{?>70<?php }?>" title=" A partir de &nbsp;<?PHP ECHO $pblister;?>&nbsp;und &nbsp;el precio es <?PHP ECHO $preblister;?>  ">
					    <?php if ($control == 0) {?>
					    <div   align="CENTER" class="<?php echo $text?>"><pre><?php echo $pblister.">&nbsp;". $preblister;?></pre> </div>
					    	<?php 	} ?>
				    </td>
				<td width="<?php if ($resolucion == 1){?>54<?php }else{?>72<?php }?>">
				    <?php if ($control == 0) {?>
				    <div align="right" class="<?php echo $text?>"><b><?php echo $preunit?></b></div>
				    <?php 	} ?>
				    </td>
				<!--<td width="<?php if ($resolucion == 1){?>54<?php }else{?>72<?php }?>">
				    <?php if ($control == 0) {?>
				    <div align="right" class="<?php echo $text?>"><b><?php echo $preblister?></b></div>
				    <?php 	} ?>
				</td>-->
				<td width="<?php if ($resolucion == 1){?>39<?php }else{?>65<?php }?>">
				    <?php if ($control == 0) {?>
				    <div align="right" class="<?php echo $text?>"><b><?php echo $div1?> F <?php echo $tot1?></b></div>
				    <?php 	} ?>
				    </td>
				<td width="<?php if ($resolucion == 1){?>48<?php }else{?>44<?php }?>">
				    <?php if ($control == 0) {?>
				<div align="center">
				<a style="text-decoration:none"  href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro?>', 2, 50, 1100, 350)">
				<input name="codigo_producto" type="hidden" id="codigo_producto" value="<?php echo $codpro?>" />
				<img src="../../../images/lens.gif" width="14" height="15" border="0"/></a>
				</div>
				<?php 	} ?>
				</td>
				</tr>
			<?php 
				++$i;
			}
			?>
			</table>
		<?php
		}
		else
		{
		?> 
		<center><u><br><br>
			<span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
		</center>
<?php
		}
	}
}
?>
<?php 
$add    = isset($_REQUEST['add']) ? ($_REQUEST['add']) : "";
$typpe  = isset($_REQUEST['typpe']) ? ($_REQUEST['typpe']) : "";
$i = 1;
if ($typpe==1)
{
      //echo "holaaaa";exit;
    $val = 0;
	$cod = $_REQUEST['cod'];
	$sql="SELECT costre,codpro,desprod,costre,codmar,factor,costpr,stopro,pcostouni,margene,codfam,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni "
				. "FROM producto where codpro = '$cod' and activo = '1' order by desprod"; 
	// error_log($sql); 
	$result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result)) {
?>
		<span class="Estilo1"><u>F4 = LINEA DE PRODUCTOS</u></span>
		<table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>">
			<tr>
			<td width="<?php if ($resolucion == 1){?>15<?php }else{?>27<?php }?>" bgcolor="#6ec0f5"  style="border-top-left-radius: 10px;padding:0 5px;" class="titulos_movimientos">N&ordm;</td>
			<td width="<?php if ($resolucion == 1){?>384<?php }else{?>400<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos">DESCRIPCION</td>
			<td width="<?php if ($resolucion == 1){?>42<?php }else{?>73<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos"><div align="right">
				<?php if ($resolucion == 1){?>
				S. UN
				<?php }else{?>
				STOCK UNID
				<?php }?>
			</div></td>
			<td width="<?php if ($resolucion == 1){?>67<?php }else{?>93<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos"><div align="right">
				<?php if ($resolucion == 1){?>
				P. CAJA
				<?php }else{?>
				PRECIO Caja
				<?php }?>
			</div>
			</td>
			<td width="<?php if ($resolucion == 1){?>67<?php }else{?>85<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos">
                            <div align="CENTER">
				<?php if ($resolucion == 1){?>
				BLISTER
				<?php }else{?>
			    BLISTER
				<?php }?>
			</div>
			
                        </td>
			<td width="<?php if ($resolucion == 1){?>80<?php }else{?>90<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos"><div align="right">
				<?php if ($resolucion == 1){?>
				P. UN
				<?php }else{?>
				PRECIO Unid
				<?php }?>
			</div></td>
			<td width="<?php if ($resolucion == 1){?>62<?php }else{?>91<?php }?>" bgcolor="#6ec0f5" class="titulos_movimientos"><div align="right">
				<?php if ($resolucion == 1){?>
				CANT
				<?php }else{?>
				CANTIDAD
				<?php }?>
			</div></td>
			<td width="<?php if ($resolucion == 1){?>66<?php }else{?>82<?php }?>" bgcolor="#6ec0f5" style="border-top-right-radius: 10px;" class="titulos_movimientos"><div align="center">
				<?php if ($resolucion == 1){?>
				TOT
				<?php }else{?>
				TOTAL
				<?php }?>
			</div></td>
			</tr>
		</table>
		<table class="celda2" width="<?php if ($resolucion == 1){?>715<?php }else{?>934<?php }?>">
		<?php
			while ($row = mysqli_fetch_array($result)){
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];
				$codmar         = $row['codmar'];
				$factor     	= $row['factor'];	
				$costre    	= $row['costre'];	
				$costpr     	= $row['costpr'];
				$stopro     	= $row['stopro'];
				$pcostouni  	= $row['pcostouni'];
				$margene     	= $row['margene'];
				$codfam     	= $row['codfam'];
				$pblister     	= $row['blister'];
				$preblister     = $row['preblister'];
				$cant_loc_add	= $row[13];
				$prevtaMain     = $row['PrevtaMain'];
				$preuniMain     = $row['PreuniMain'];
				$prevta         = $row[16];
				$preuni         = $row[17];
				
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
                                
				if (strlen($pblister) == 0)
				{
                                    $pblister = 0;
				}
				if (strlen($preblister) == 0)
				{
                                    $preblister = 0;
				}
				
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

				$sql1="SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$venta'";
					$result1 = mysqli_query($conexion,$sql1);
					if (mysqli_num_rows($result1)){
						$control = 1;
					}
					else
					{
						$control = 0;
					}
				$convert    = $cant_loc_add/$factor;
				$div    	= floor($convert);
				$mult		= $factor * $div;
				$tot		= $cant_loc_add - $mult;
				if($preuni>0)
					{
						
					}
					else
					{
						if ($factor <>0)
						{
							$preuni = ($prevta/$factor)<$costre;
						}
					}
					$preunit = number_format($preuni, 3, '.', ' ');
		?>
			<tr bgcolor="#FFFF99">
				<td width="<?php if ($resolucion == 1){?>15<?php }else{?>27<?php }?>"><font color="#006699" size="4"><?php echo $i?></font></td>
				<td width="<?php if ($resolucion == 1){?>438<?php }else{?>447<?php }?>"><font color="#006699" size="3"><?php if ($bonif == 1){echo substr($desprod,0,$charact);echo " "; echo " + (B) x CAJA "; echo substr($desprod_bonif,0,$charactbonif);} else {echo substr($desprod,0,$charact);echo "...";}?></font>
				</td>
				<td width="<?php if ($resolucion == 1){?>50<?php }else{?>72<?php }?>"><div align="right"><b><font color="<?php if ($cant_loc_add == 0){?>#FF0000<?php } else {?>#006699<?php }?>" size="4"><pre><?php echo $div?> F <?php echo $tot?></pre></font></b></div></td>
				<td width="<?php if ($resolucion == 1){?>54<?php }else{?>92<?php }?>">
				<b><font color="#006699" size="4"><div align="center"><pre><?php echo $prevta;?></pre></div></font></b>
				</td>
				
				<td align="center" width="<?php if ($resolucion == 1){?>54<?php }else{?>92<?php }?>">
				<b><font color="#006699" size="4"><pre><?php echo $pblister.">&nbsp;". $preblister;?></pre></font></b>
				</td>
				
				<!--AQUI SE INGRESA EL PRECIO-->
				<td width="<?php if ($resolucion == 1){?>54<?php }else{?>80<?php }?>">
					<label>
						<div align="right">
						<?php
						if ($control == 0) { ?>
							<input name="text2" type="hidden" id="text2" value="<?php echo $preuni ?>" />
							<input name="textprevta" type="hidden" id="textprevta" value="<?php echo $prevta?>" />
							<!--<input name="text222" type="text" class="cant" id="text222" value="<?php echo $preuni?>" size="4"  onkeypress="return letraent(event);" onkeyup="precio1();"/>-->
							<input name="text222" type="text" class="cant" id="text222" value="<?php echo $preuni?>" size="4" <?php if (($codgrupve <> 2) ) {?>disabled="disabled" onclick="blur()"<?php }?> onkeyup="precio1();" onkeypress="return letraent(event);"/>
						<?php 
						}
						else
						{
						?>
							<font color="#006699" size="4"><?php echo '<b>';echo $preuni; echo '</b>';?></font>
						<?php 
						}
						?>
						</div>
					</label>
				</td>
				<!--AQUI SE INGRESA LA CANTIDAD-->
				<td width="<?php if ($resolucion == 1){?>54<?php }else{?>80<?php }?>">
					<div align="right">
						<input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni?>" />
						<input type="hidden" name="numero" id="numero" />
						<input type="hidden" name="codpro" id="codpro" value="<?php echo $codpro;?>" />
						<input type="hidden" name="factor" id="factor" value="<?php echo $factor;?>" />
						<input type="hidden" name="cant_prod" id="cant_prod" value="<?php echo $cant_loc_add;?>" />
						<input name="pblister" type="hidden" id="pblister" value="<?php echo $pblister?>" />
						<input name="preblister" type="hidden" id="preblister" value="<?php echo $preblister?>" />
						<?php
						if ($control == 0) { ?>
                                                <input name="text1" type="text" class="cant" id="text1" onkeypress="return letracc(event);" onkeyup="precio();" size="4"/>
						<?php
						}
						?>
					</div>	  
				</td>
				<td width="<?php if ($resolucion == 1){?>50<?php }else{?>82<?php }?>" bgcolor="#FFFF99">
					<div align="right">
						<?php
						if ($control == 0) { ?>
							<input name="text333" type="text" class="cant1" id="text333" onclick="blur()" size="4" disabled="disabled"/>
							<input type="hidden" name="text3" id="text3" value=""/>
							<input name="medico" type="hidden" id="medico" value="<?php echo $nommedico2?>"/>
						<?php
						} ?>
					</div>
				</td>
			</tr>
		<?php ++$i;
			}
		?>
		</table>
<?php
	}
  	else
	{
?> 
		<center><u><br><br>
			<span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PODUCTO CON LA DESCRIPCION INGRESADA</span></u>
		</center>
<?php 
	}
}
?>
		<iframe src="venta_index3.php" name="index2" width="<?php if ($resolucion == 1){?>710<?php }else{?>935<?php }?>" height="260" scrolling="Automatic" frameborder="0" id="index2" allowtransparency="0">
		</iframe>
		<div align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>">
			<img src="../../../images/line2.png" width="<?php if ($resolucion == 1){?>715<?php }else{?>907<?php }?>" height="4" /> 
		</div>
		<table width="<?php if ($resolucion == 1){?>715<?php }else{?>892<?php }?>" border="0" align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>">
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
		<div align="<?php if ($resolucion == 1){?>left<?php }else{?>center<?php }?>">
			<img src="../../../images/line2.png" width="<?php if ($resolucion == 1){?>715<?php }else{?>907<?php }?>" height="4" /> 
		</div>
		<br />
	</form>
<?php 

/*mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); */
mysqli_close($conexion);
?>
</body>
</html>
