<?php include('../../session_user.php');
include('../../../convertfecha.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$sql="SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$invnum          = $row["invnum"];		//codigo
}
}
$_SESSION[transferencia_sal]	= $invnum; 
//echo $invnum."<br>";
$sql="SELECT numdoc FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
}
}

//echo $numdoc;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/select.css" rel="stylesheet" type="text/css" />
<script>
function combo()
{
	alert('Submit');
var f = document.form1;
f.action = "transferencia_sal_val.php";
f.method = "post";
f.submit();
}
function prepedido1()
{
	if (document.getElementById("prepedido").value)
	{
		var f = document.form1;
		f.action = "transferencia1_sal_preped.php";
		f.method = "post";
		f.submit();
	} else {
		alert('Ingrese un número de prepedido');
	}

}

function cancelarTransf()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="transferencia1_sal_del.php";
	 f.submit();
}
function compras1(e)
{
	tecla=e.keyCode;
	var f = document.form1;
	var a = f.carcount.value;
	var b = f.carcount1.value;
	 if(tecla==119)
  	 {
		  if ((a == 0)||(b>0))
		  {
		  alert('No se puede grabar este Documento');
		  }
		  else
		  {
			  var f = document.form1;
			 
			  if (f.local.value == 0)
			  {
			  alert("Seleccione un Local"); f.local.focus(); return; 
			  }
			  if (f.mont2.value == "")
			  { alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont2.focus(); return; }
			  if (confirm("�Desea Grabar esta informacion?")) {
					<?php if (isset($numdoc)) {
						?>
						alert("EL NUMERO REGISTRADO ES "+<?php echo $numdoc?>);
					<?php
					}?>
			  f.method = "POST";
			  f.target = "_top";
			  f.action ="transferencia1_sal_reg.php";
			  f.submit();
			  }
		  }
	 }
	 if(tecla==120)
  	 {
		 if ((a == 0)||(b>0))
		 {
		 alert('No se puede realizar la impresi�n de este Documento');
		 }
		 else
		 {
		 	 var f = document.form1;
			  if (f.referencia.value == "")
			  { alert("Ingrese una referencia"); f.referencia.focus(); return; }
			  if (f.vendedor.value == 0)
			  {
			  alert("Seleccione un Vendedor"); f.vendedor.focus(); return; 
			  }
			  if (f.local.value == 0)
			  {
			  alert("Seleccione un Local"); f.local.focus(); return; 
			  }
			  if (f.mont2.value == "")
			  { alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont2.focus(); return; }
			  f.method = "POST";
			  f.target = "_top";
			  f.action ="transferencia1_sal_op_reg.php";
			  f.submit();
		 }
	 }
}
function imprimirdoc()
{
	var f = document.form1;
	var a = f.carcount.value;
	var b = f.carcount1.value;
	if ((a == 0)||(b>0))
		 {
		 alert('No se puede realizar la impresi�n de este Documento');
		 }
		 else
		 {
		 	 var f = document.form1;
			  /*if (f.referencia.value == "")
			 // { alert("Ingrese una referencia"); f.referencia.focus(); return; }
			  if (f.vendedor.value == 0)
			  {
			  //alert("Seleccione un Vendedor"); f.vendedor.focus(); return; 
			  }*/
			  if (f.local.value == 0)
			  {
			  alert("Seleccione un Local"); f.local.focus(); return; 
			  }
			  if (f.mont2.value == "")
			  { alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont2.focus(); return; }
			  f.method = "POST";
			  f.target = "_top";
			  f.action ="transferencia1_sal_op_reg.php";
			  f.submit();
		 }
}

function grabardoc()
{
	var f = document.form1;
	var a = f.carcount.value;
	var b = f.carcount1.value;
		  if ((a == 0)||(b>0))
		  {
		  alert('No se puede grabar este Documento');
		  }
		  else
		  {
			  var f = document.form1;
			  
			  if (f.local.value == 0)
			  {
			  alert("Seleccione un Local"); f.local.focus(); return; 
			  }
			  if (f.mont2.value == "")
			  { alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont2.focus(); return; }
			  if (confirm("�Desea Grabar esta informacion?")) {
					<?php if (isset($numdoc)) {
						?>
						alert("EL NUMERO REGISTRADO ES "+<?php echo $numdoc?>);
					<?php
					}?>
			  f.method = "POST";
			  f.target = "_top";
			  f.action ="transferencia1_sal_reg.php";
			  f.submit();
			  }
		  }
}
</script>
<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../funciones/transferencia.php");	//FUNCIONES DE ESTA PANTALLA
require_once("ajax_transferencia.php");	//FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
require_once("../../local.php");	//LOCAL DEL USUARIO
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
$sql="SELECT invnum,invfec,numdoc,refere,codusu,sucursal1 FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$cod          = $row['invnum'];		//codgio
		$fecha        = $row['invfec'];
		$numdoc       = $row['numdoc'];
		$refere       = $row['refere'];
		$codusu       = $row['codusu'];
		$sucursal1    = $row['sucursal1'];
}
}
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
?>
<?php $sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
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
	$sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro <> '0' or qtyprf <> ''";
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
	$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$user    = $row1['nomusu'];
	}
	}
	$sql1="SELECT codpro,pripro,costre FROM tempmovmov where invnum = '$invnum'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	    $codpro    = $row1['codpro'];
		$pripro    = $row1['pripro'];
		$costre    = $row1['costre'];
		$sum1	   = $sum1 + $pripro;
		$sum2	   = $sum2 + $costre;
	}	
		$sum1 			=  $numero_formato_frances = number_format($sum1, 2, '.', ',');
		$sum2 			=  $numero_formato_frances = number_format($sum2, 2, '.', ',');
	}
	else
	{
	
	}
require_once("../funciones/call_combo.php");	//LLAMA A generaSelect
?>
<script type="text/javascript" src="../funciones/select_2_niveles.js"></script>
</head>
<body onkeyup="compras1(event)">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="968" border="0">
    <tr>
      <td width="958"><table width="932" border="0">
        <tr>
          <td width="302"><div align="center">
              <input name="first" type="button" id="first" value="Primero" class="primero" disabled="disabled"/>
              <input name="prev" type="button" id="prev" value="Anterior" class="anterior" disabled="disabled"/>
              <input name="next" type="button" id="next" value="Siguiente" class="siguiente" disabled="disabled"/>
              <input name="fin" type="button" id="fin" value="Ultimo" class="ultimo" disabled="disabled"/>
          </div></td>
          <td width="10">&nbsp;</td>
          <td width="606"><div align="right">
              
              <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
              <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
              <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
              <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33?>" />
              <input name="carcount" type="hidden" id="carcount" value="<?php echo $count?>" />
              <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1?>" />
              
              <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelarTransf()" class="cancelar"/>
			  <input name="save" type="button" id="save" value="Grabar" onclick="grabardoc()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
			  <input name="printer" type="button" id="printer" value="Grabar e Imprimir" class="imprimir" onclick="imprimirdoc()" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
          </div></td>
        </tr>
      </table>
        <div align="center"><img src="../../../images/line2.png" width="950" height="4" /> </div>
        <table width="954" border="0">
          <tr>
            <td width="76">NUMERO</td>
            <td width="201"><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($numdoc)?>"/></td>
            <td width="61"><div align="right">FECHA</div></td>
            <td width="129"><input name="textfield2" type="text" size="22" disabled="disabled" value="<?php echo fecha($fecha)?>"/></td>
            <td width="10">&nbsp;</td>
            <td width="11">&nbsp;</td>
            <td width="436"><div align="right" class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></div></td>
          </tr>
        </table>
          
          <table width="954" border="0">
            <tr>
              <td width="76">LOCAL</td>
              <td width="201">
			  <select name="local" id="local" onchange="cargarContenido()">
			  <option value="0">Elegir</option>
                <?php $sql = "SELECT * FROM xcompa where codloc <> '$codigo_local' and habil = '1' order by nombre, nomloc"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				?>
                <option value="<?php echo $row["codloc"]?>" <?php if ($sucursal1 == $row["codloc"]){?> selected="selected"<?php }?>>
                  <?php if ($row["nombre"]<>""){ echo $row["nombre"];} else { echo $row["nomloc"];} ?>
                </option>
                <?php } ?>
              </select></td>
              <td width="61">
			  <div align="right">VENDEDOR</div>
			  </td>
			  <td width="460">
			  <select name="vendedor" id="vendedor" onchange="cargarContenido()">
			  <option value="0">Elegir</option>
                <?php $sql = "SELECT * FROM usuario where estado = '1' and usecod <> '$usuario' order by nomusu"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				?>
                <option value="<?php echo $row["usecod"]?>" <?php if ($codusu == $row["usecod"]){?> selected="selected"<?php }?>> <?php echo $row["nomusu"] ?> </option>
                <?php 
				}
				?>
              </select>
		      <input type="submit" name="Submit" value="Actualizar" onclick="combo()"/></td>
              <td width="134"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local?></span> </div></td>
            </tr>
          </table>
          <table width="954" border="0">
            <tr>
              <td width="76">REFERENCIA</td>
              <td width="868">
			  <input name="referencia" type="text" id="referencia" size="140" onkeyup="cargarContenido()" value="<?php echo $refere;?>"/></td>
            </tr>
          </table>
          <table width="954" border="0">
            <tr>
              <td width="76">CARGAR PREPEDIDO</td>
              <td width="30">
			  				<input name="prepedido" type="text" id="prepedido" size="20" value="<?php echo $idpreped;?>"/></td>
							<td>
								<input type="submit" name="Prepedido" value="Buscar" onclick="prepedido1()"/>
							</td>
            </tr>
          </table>
          <table width="954" border="0">
            <tr>
              <td width="67">&nbsp;</td>
              <td width="109"><label></label></td>
              <td width="39">&nbsp;</td>
              <td width="100"><label></label></td>
              <td width="74">&nbsp;</td>
              <td width="445" class="login"><div align="right">F8 = GRABAR </div></td>
              <td width="90" class="login"><div align="right">F9 = IMPRIMIR </div></td>
            </tr>
          </table>
          <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="954" border="0">
            <tr>
              <td width="948">
			  <iframe src="transferencia2_sal.php" name="iFrame1" width="954" height="178" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
			</iframe>
			  </td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="962" border="0">
            <tr>
              <td width="955">
			  <iframe src="transferencia3_sal.php" name="iFrame2" width="954" height="208" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe></td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" />          </div>
		  <table width="955" border="0" align="center">
            <tr>
              <td width="72"><div align="right"></div></td>
              <td width="130">&nbsp;</td>
              <td width="49"><div align="right"></div></td>
              <td width="130">&nbsp;</td>
              <td width="49"><div align="right"></div></td>
              <td width="80">&nbsp;</td>
              <td width="125"><div align="right">PRECIO PROMEDIO </div></td>
              <td width="113">
			    <div align="right">
			      <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="10" value="<?php if ($count > 0){?> <?php echo $sum1?> <?php }else{?>0.00<?php }?>"/>
	          </div></td>
              <td width="57"><div align="right">TOTAL</div></td>
              <td width="108">
			    <div align="right">
			      <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="10" value="<?php if ($count > 0){?> <?php echo $sum2?> <?php }else{?>0.00<?php }?>"/>
	          </div></td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /> </div>
		  <br></td>
    </tr>
  </table>
</form>
</body>
</html>
