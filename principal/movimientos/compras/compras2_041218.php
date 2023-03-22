<?php include('../../session_user.php');
$invnum     = $_SESSION['compras'];
$ckigv      = $_REQUEST['ckigv'];
$busca_prov = $_REQUEST['busca_prov'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	document.form1.submit();
	}
}
var nav4 = window.Event ? true : false;
function ent(evt){
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	var f = document.form1;
	var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
	var valor = isNaN(v1);
	if (valor == true)
	{
	document.form1.number.value=1;		////avisa que no es numero
	}
	else
	{
	document.form1.number.value=0;		////avisa que es numero
	}
	if ((f.text1.value == "") || (f.text1.value == "0"))
    { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
    if ((f.text2.value == "") || (f.text2.value == "0.00"))
    { alert("Ingrese el Precio"); f.text2.focus(); return; }
	f.method = "post";
	f.action = "compras2_reg.php";
	f.target = "comp_principal";
	f.submit();
	}
return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
}
var nav4 = window.Event ? true : false;
function ent1(evt){
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	var f = document.form1;
	var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
	var valor = isNaN(v1);
	if (valor == true)
	{
	document.form1.number.value=1;		////avisa que no es numero
	}
	else
	{
	document.form1.number.value=0;		////avisa que es numero
	}
	if ((f.text1.value == "") || (f.text1.value == "0"))
    { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
    if ((f.text2.value == "") || (f.text2.value == "0.00"))
    { alert("Ingrese el Precio"); f.text2.focus(); return; }
	f.method = "post";
	f.action = "compras2_reg.php";
	f.target = "comp_principal";
	f.submit();
	}
return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
}
function caj1(){
	//document.form1.text1.focus();
}
var popUpWin=0;
function popUpWindows(URLStr, left, top, width, height)
{
  pcosto = document.form1.text2.value;
  pdesc1 = document.form1.text3.value;
  pdesc2 = document.form1.text4.value;
  pdesc3 = document.form1.text5.value;
  ptext1 = document.form1.text1.value;
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  URLStr = URLStr+'&costo='+pcosto+'&desc1='+pdesc1+'&desc2='+pdesc2+'&desc3='+pdesc3+ '&text1='+ptext1 ;
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
function compras2(e)
{
	tecla=e.keyCode;
	var f = document.form1;
	var a = f.carcount.value;
	var b = f.carcount1.value;
	 if(tecla==120)
  	 {
		 if ((a == 0)||(b>0))
		 {
		 alert('No se puede realizar la impresiÃÂ¯ÃÂ¿ÃÂ½n de este Documento');
		 }
		 else
		 {
		 	//alert("hola");	 
			  //f.method = "POST";
			  //f.target = "_top";
			  //f.action ="comprasop_reg.php";
			  //f.submit();
			//if (window.print)
  			  //window.print()
  			//else
   			 //alert("Disculpe, su navegador no soporta esta opciÃÂ¯ÃÂ¿ÃÂ½n.");
		 }
	 }
	 if (tecla == 27)
	{
	document.form1.submit();
	}
}
</script>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../funciones/compras.php");	//FUNCIONES DE ESTA PANTALLA
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codloc    = $row['codloc'];
}
}
//echo $sql;
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$porcent    = $row1['porcent'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}

$val = $_REQUEST['val'];
$ok  = $_REQUEST['ok'];
///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA
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
if ($val == 1)
{
	$producto =	$_REQUEST['country_ID'];
	if ($producto <> "")
	{
		$sql1="SELECT codtemp FROM tempmovmov where codpro = '$producto' and invnum = '$invnum'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
			$search = 0;
		}
		else
		{
			$search = 1;
		}
	}
	else
	{
	$search = 0;
	}
}
else
{
$search = 0;
}
require_once('../tabla_local.php');
$valform = $_REQUEST['valform'];
?>
</head>
<body onkeyup="compras2(event)" onload="<?php if ($valform == 1){ ?> caj1();<?php } else { if ($search==1){?>links()<?php } else{?>sssf()<?php }}?>">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
    <input type="hidden" id="busca_prov" name="busca_prov" value="<?php echo $busca_prov;?>"/>
    <table width="910" border="0">
    <tr>
      <td width="90">DESCRIPCION</td>
      <td width="614">
        <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" value="" size="120"/>
        <input type="hidden" id="country_hidden" name="country_ID" />
        <input type="hidden" id="ckigv" name="ckigv" value="<?php echo $ckigv;?>"/>
	<input type="hidden" id="ok" name="ok" value="<?php echo $ok?>"/>
        <input name="carcount" type="hidden" id="carcount" value="<?php echo $count?>" />
        <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1?>" /></td>
      <td width="192">
        <input name="val" type="hidden" id="val" value="1" />
      </td>
    </tr>
  </table>
  <?php $val = $_REQUEST['val'];
  if ($val == 1)
  {
  $producto =	$_REQUEST['country_ID'];
  if ($producto <> "")
  {
  $sql="SELECT codpro,desprod,codmar,stopro,factor,$tabla,igv,pcostouni,costod FROM producto where activo1 = '1' and codpro = '$producto'  order by desprod";
  //echo $sql;
  $result = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($result)){
  ?>
  <table class="celda2" width="910">
    <tr>
		  <td width="18" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</td>
		  <td width="219" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
		  <td width="96" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">CANT</div></td>
		  <td width="33" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">BONIF</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">P. UNIT</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">DESC1</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">DESC2</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">DESC3</div></td>
		  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">P. VTA</div></td>
		  <td width="54" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">SUB TOT</div></td>
		  <td width="64" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">MI LOCAL</div></td>
		  <td width="55" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">S. UNID </div></td>
		  <td width="32" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">PREC</div></td>
		  <td width="17" bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</td>
    </tr>
  </table>
  <table class="celda2" width="910">
    <?php while ($row = mysqli_fetch_array($result)){
			$codpro         = $row['codpro'];		//codgio
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$stopro         = $row['stopro'];
			$factor         = $row['factor'];
			$igv            = $row['igv'];
			$costpr         = $row['pcostouni'];  ///COSTO PROMEDIO
			$cant_loc       = $row[5];
            $costod         = $row['costod'];
			$convert        = $cant_loc/$factor;
			$div    	    = floor($convert);
			$mult		    = $factor * $div;
			$tot		    = $stopro - $mult;
			/*if ($igv == 1)
			{
			    $ckigv = 1;
			}*/
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
			$sql1="SELECT qtypro,qtyprf,prisal FROM tempmovmov where invnum = '$invnum' and codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$qtypro1         = $row1['qtypro'];	
				$qtyprf1         = $row1['qtyprf'];
				$prisal1         = $row1['prisal'];	
			}
			}
			$sql1="SELECT codtemp FROM tempmovmov where codpro = '$codpro' and invnum = '$invnum'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
				$control = 1;
			}
			else
			{
				$control = 0;
			}
	?>
	<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
            <td width="18"><?php echo $i?></td>
            <td width="219">
                <?php if ($control == 0){?>
                <a id="l1" href="compras2.php?country_ID=<?php echo $producto?>&ok=<?php echo $ok?>&val=1&valform=1&cprod=<?php echo $codpro?>&ckigv=<?php echo $ckigv;?>&busca_prov=<?php echo $busca_prov;?>"><?php echo substr($desprod,0,45);?></a>
                <?php }
                else
                {
                echo substr($desprod,0,45);
                }
                ?>	  
            </td>
            <?php 
            $cprod   = $_REQUEST['cprod'];
            ?>
            <td width="96"><?php echo substr($marca,0,25)?></td>
            <td width="43">
                <!--AQUI-->
                <div align="right">
                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?> 
                    <input name="text1" type="text" id="text1" size="4" onKeyPress="return ent(event)" value="<?php if ($qtyprf1 <> ""){echo $qtyprf1; } else { echo $qtypro1 ;}?>" onKeyUp ="precio();"/>
                    <input name="number" type="hidden" id="number" value=""/>
                    <input type="hidden" name="factor" value="<?php echo $factor;?>"/>
                    <input type="hidden" name="costpr" value="<?php echo $costpr;?>"/>
                    <input type="hidden" name="stockpro" value="<?php echo $stopro;?>"/>
                    <input type="hidden" name="porcentaje" value="<?php if ($igv == 1){echo $porcent;}?>"/>

                    <input name="cod" type="hidden" id="cod" value="<?php echo $codpro;?>" />
                    <input name="ok" type="hidden" id="ok" value="<?php echo $ok;?>" />
                    <?php }
                    else 
                    {

                    if ($qtyprf1 <> ""){echo $qtyprf1; } else { echo $qtypro1 ;}
                    }
                    ?>
                </div>
            </td>
            <td width="33">
                <div align="center">
                <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                <input name="bonifi" type="checkbox" id="bonifi" value="1" />
                <?php }?>
                </div>
            </td>
            <td width="43">
                <!--AQUI-->
                <div align="right">
                <?php 
                /*if (($prisal1 == 0) || ($prisal1 == ""))
                {
                    $PrecioPrint = $costpr;
                }
                else
                {
                    $PrecioPrint = $prisal1;
                }*/
                $PrecioPrint = $costod;
                if (($valform == 1) && ($cprod == $codpro)) { 
                ?> 
                <input name="text2" type="text" id="text2" value="<?php echo $PrecioPrint?>" size="4" onKeyPress="return ent1(event)" onKeyUp ="precio();"/>
                <?php }
                else 
                {
                echo $PrecioPrint;
                }
                ?>
                </div>
            </td>
            <td width="43">
                <!--AQUI-->
                <div align="right">
                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                    <input name="text3" type="text" class="input_text1" id="text3" value="<?php echo $desc1?>" size="4" maxlength="5" onkeypress="return ent1(event);" onkeyup ="precio();"/>
                    <?php } else { echo $desc1;}?>
                </div>
            </td>
            <td width="43">
                <!--AQUI-->
                <div align="right">
                  <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                  <input name="text4" type="text" class="input_text1" id="text4" value="<?php echo $desc2?>" size="4" maxlength="5" onkeypress="return ent1(event);" onkeyup ="precio();"/>
                <?php } else { echo $desc2;}?>
                </div>
            </td>
            <td width="43">
                <!--AQUI-->
                <div align="right">
                <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                <input name="text5" type="text" class="input_text1" id="text5" value="<?php echo $desc3?>" size="4" maxlength="5" onkeypress="return ent1(event);" onkeyup ="precio();"/>
                <?php } else { echo $desc3;}?>
                </div>
            </td>
            <td width="43">
                <div align="right">
                  <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                  <input name="text6" type="text" id="text6" size="4" class="pvta" value="<?php echo $pripro?>" onclick="blur()"/>
                <?php } else { echo $pripro;}?>
                </div>	  
            </td>
            <td width="54">
                <div align="right">
                  <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                  <input name="text7" type="text" id="text7" size="6" class="pvta" value="<?php echo $costre?>" onclick="blur()"/>
                <?php } else { echo $costre;}?>
                </div>
            </td>
            <td width="64"><div align="right"><?php echo $div?> F <?php echo $tot?></div></td>
            <td width="55"><div align="right"><?php echo $stopro?></div></td>
            <td width="32"><div align="center"> <a href="javascript:popUpWindows('price/price.php?cod=<?php echo $codpro?>&invnum=<?php echo $invnum?>&ncompra=<?php echo $ncompra?>&ok=<?php echo $ok?>', 205, 40, 498, 270)" title="PRECIO DE PRODUCTOS"> <img src="../../../images/tickg.gif" width="19" height="18" border="0"/> </a> </div></td>
            <td width="17"><div align="center"><?php if ($control == 0){?><a href="compras2_reg.php?cod=<?php echo $codpro?>&search=<?php echo $producto?>&val=1&ok=<?php echo $ok?>" target="comp_principal"></a><?php }else{?><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0"/><?php }?></div></td>
        </tr>
	<?php $i++;
	}
	?>
  </table>
  <?php }
  }
  else
  {
  ?> 
  <center><u><br><br>
    <span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
  </center>
  <?php }
  }
  ?>
</form>
</body>
</html>
