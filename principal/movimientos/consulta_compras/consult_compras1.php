<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once ('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../funciones/consulta_compras.php");	//FUNCIONES DE ESTA PANTALLA
require_once("ajax_consult_compras.php");	//FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
require_once("../../local.php");	//LOCAL DEL USUARIO

function convertir_a_numero($str)
{
  $legalChars = "%[^0-9\-\. ]%";
  return preg_replace($legalChars,"",$str);
}

$pag             = $_REQUEST['pageno'];
$ultimo          = $_REQUEST['ultimo'];
$sql="SELECT count(invnum) FROM movmae where tipmov = '1' and tipdoc = '1' and proceso = '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$numrows             = $row[0];
}
}
if (isset($_REQUEST['pageno'])) {
   $pageno = $_REQUEST['pageno'];
} else {
   $pageno = $numrows;
} 

	$numero	= $_POST['num'];
	if ($numero == "")
	{
		$numero = $_REQUEST['numero'];
		
		if($numero <> "")
		{
		$numero = $_REQUEST['numero'];
		//echo "holaa";
		}
		else
		{
		$numero = "";
		}
	//$numero = isset($_REQUEST['num'])? $_REQUEST['num'] : '';
	}
	//}
//}
$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";	////NOMBRE DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		$user    = $row1['nomusu'];
}
}
$sql1="SELECT * FROM datagen";								////PORCENTAJE
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		$porcent    = $row1['porcent'];
		$porcentaje = (1+($porcent/100));
}
}
/////////////////////////////////
$rows_per_page = 1;
$lastpage      = ceil($numrows/$rows_per_page);
$pageno = (int)$pageno;
if ($ultimo==1)
{
$pageno = $lastpage;
}
if ($pageno > $lastpage) {
   $pageno = $lastpage;
} // if
if ($pageno < 1) {
   $pageno = 1;
} // if
$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
//echo $limit;
//////////////////////////////////
if (($numero == "") && ($pag == ""))
{
$sql="SELECT numdoc FROM movmae where tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc desc limit 1";
//echo "1";
}
else
{	
	if (($numero == "") && ($pag <> ""))
	{
	$sql="SELECT numdoc FROM movmae where tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc asc $limit";
	//echo "2";
	}
	else
	{
	$sql="SELECT numdoc FROM movmae where numdoc = '$numero' and tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc desc";
	//echo "3";
	}
}
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$numdoc       = $row['numdoc'];	
		$impresion	  = 1;
}
}
else
{
		$numdoc		  = $numero;
		$impresion	  = 0;
}
?>
</head>
<body onload="<?php if ($upd == 1){?>update();<?php } else {?> inic();<?php }?>">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="968" border="0">
    <tr>
      <td width="958">
	  <table width="954" border="0">
        <tr>
          <td width="129">NUMERO DE MOVIMIENTO </td>
          <td width="497">
		    <input name="num" type="text" id="num" size="15" value="<?php echo $numdoc?>"/>
		    <input type="button" name="Submit" value="BUSCAR" class="buscar" onclick="consult_validar()"/>
			<input type="button" name="Submit" value="TODOS" class="buscar" onclick="consult_todos()"/>
		  </td>
          <td width="314"><div align="right" class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></div></td>
        </tr>
      </table>
<?php if (($numero == "") && ($pag == ""))
{
$sql="SELECT * FROM movmae where tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc desc limit 1";
$dis = 0;
}
else
{	
	if (($numero == "") && ($pag <> ""))
	{
	$sql="SELECT * FROM movmae where tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc asc $limit";
	$dis = 0;
	}
	else
	{
	$sql="SELECT * FROM movmae where numdoc = '$numero' and tipmov = '1' and tipdoc = '1' and proceso = '0' order by numdoc desc";
	$dis = 1;
	}
}
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codigo
		$fecha        = $row['invfec'];
		$fecdoc       = $row['fecdoc'];
		$fecven       = $row['fecven'];
		$numdoc       = $row['numdoc'];
		$ndoc         = $row['numero_documento'];
		$ndoc1        = $row['numero_documento1'];
		$plazo        = $row['plazo'];
		$val_habil    = $row['val_habil'];
		$invtot       = $row['invtot'];
		$destot       = $row['destot'];
		$valven       = $row['valven'];
		$costo        = $row['costo'];
		$igv          = $row['igv'];
		$sucursal = $row['sucursal'];
}
$find = 1;
$_SESSION['consulta_comp']	= $invnum; 
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c){
printf("%06d",  $c);
} 
	///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA
	$sql="SELECT count(*) FROM movmov where invnum = '$invnum'";
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
	$sql="SELECT count(*) FROM movmov where invnum = '$invnum' and qtypro = '0' and qtyprf = ''";
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
	$sql="SELECT count(*) FROM movmov where invnum = '$invnum' and costre <> '0'";
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
	$sql1="SELECT * FROM movmov where invnum = '$invnum'";
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
		$numlote    = $row1['numlote'];	
 //local donde se compra
		$col_stock = "s".sprintf('%03d', $sucursal-1);
		$est_habil_stock = 1;
		$msg_habil_stock = "";
		$sqlSto="SELECT stopro, $col_stock stock_loc FROM producto where codpro = '$codpro'";
		error_log($sqlSto);
		$resultSto = mysqli_query($conexion,$sqlSto);
		if (mysqli_num_rows($resultSto)){
			while ($rowSto = mysqli_fetch_array($resultSto)){
					$stopro    = $rowSto['stopro'];		
					$stock_loc    = $rowSto['stock_loc'];		
					if ($qtyprf != "")
					{
							//ES FRACCION
							$text_char  = convertir_a_numero($qtyprf);
					}
					if ($qtyprf <> ""){ $cantidad_compra =  $text_char; } else { $cantidad_compra = $qtypro;}
					error_log("Cantidad de compra: ".$cantidad_compra);
					error_log("Stock actual: ".$stopro." ".$stock_loc);
					if (($cantidad_compra>$stock_loc) || ($cantidad_compra>$stopro)) {
						$est_habil_stock = 0;
						$msg_habil_stock = "No existe suficiente stock del producto para habilitar la salida";
					} else if ($numlote!='') {						
						$sqlLot="SELECT stock  FROM movlote where codpro = '$codpro' and codloc='$sucursal' and numlote='$numlote'";
						error_log($sqlLot);
						$resultLot = mysqli_query($conexion,$sqlLot);
						if (mysqli_num_rows($resultLot)){
							while ($rowLot = mysqli_fetch_array($resultLot)){
								$stockLote    = $rowSto['stock'];		
								if ($cantidad_compra>$stockLote) {
									$est_habil_stock = 0;
									$msg_habil_stock = "No existe suficiente stock en el lote ".$numlote." para habilitar la salida";

								}
							}
						}
					}
			}
		}
	}	
	}
?>
      <table width="954" border="0">
          <tr>
            <td width="67">FECHA DOC </td>
            <td width="143">
			<input name="fecha1" type="text" id="fecha1" size="15" value="<?php echo fecha($fecdoc)?>" disabled="disabled"/></td>
            <td width="39">N DOC </td>
            <td width="178">
			<input name="n1" type="text" id="n1" onKeyPress="return acceptNum(event)" size="5" maxlength="3" value="<?php echo $ndoc?>" disabled="disabled"/>
              -
              <input name="n2" type="text" id="n2" onKeyPress="return acceptNum(event)" size="15" maxlength="8" value="<?php echo $ndoc1?>" disabled="disabled"/>            
			</td>
            <td width="65">MONEDA</td>
            <td width="142">
              <select name="moneda" id="moneda" disabled="disabled">
                <option>SOLES</option>
                <option>DOLARES</option>
              </select>            </td>
            <td width="290"><div align="right" class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local?> </div></td>
          </tr>
          <tr>
            <td>FECHA DIG </td>
            <td>
              <input name="fecha2" type="text" id="fecha2" onfocus="blur()" value="<?php echo fecha($fecha)?>" size="15" disabled="disabled"/>           </td>
            <td>PLAZO</td>
            <td>
              <input name="plazo" type="text" id="plazo" onKeyPress="return acceptNum(event)" size="5" maxlength="3" value="<?php echo $plazo?>" disabled="disabled"/>            </td>
            <td>FECHA VCTO </td>
            <td><input name="fecha3" type="text" id="fecha3" onfocus="blur()" value="<?php echo fecha($fecven)?>" size="15" disabled="disabled"/></td>
            <td>
			  
		      <div align="right"><strong>
		    <?php if ($val_habil == 1)
			{
			?>
		        <span class="login">ANULADO</span>
		    <?php } 
			else
			{
			?>
		        <span class="login">ACTIVADO</span>
		    <?php }
			?>
                </strong></div></td>
          </tr>
        </table>
          
          <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="962" border="0">
            <tr>
              <td width="955">
			  <iframe src="consult_compras2.php?invnum=<?php echo $invnum?>&upd=<?php echo $upd?>&numero=<?php echo $numero?>" name="iFrame2" width="954" height="420" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe></td>
            </tr>
        </table>
		<?php }
		else
		{
		?>
		<div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
          <table width="962" border="0">
            <tr>
              <td width="955">
			  <iframe src="consult_compras3.php" name="iFrame2" width="954" height="468" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe></td>
            </tr>
        </table>
		<?php }
		?>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" />          </div>
		  <table width="955" border="0" align="center">
            <tr>
              <td width="73"><div align="right">V. BRUTO </div></td>
              <td width="132">
              <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $costo?> <?php }else{?>0.00<?php }?>" />              </td>
              <td width="50"><div align="right">DCTOS</div></td>
              <td width="132">
			  <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $destot?> <?php }else{?>0.00<?php }?>">			  </td>
              <td width="50"><div align="right">V. VENTA </div></td>
              <td width="132">
			  <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $valven?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">IGV</div></td>
              <td width="132">
			  <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $igv?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">TOTAL</div></td>
              <td width="112">
			  <input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($count2 > 0){?> <?php echo $invtot?> <?php }else{?>0.00<?php }?>"/></td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /> </div>
		  <br>
		  <div class="botones">
		  <?php $firstpage = 1;
			$prevpage = $pageno-1;
			$nextpage = $pageno+1;
			$lastpage = $lastpage;
		  ?>
            <table width="932" border="0">
              <tr>
                <td width="321"><div align="center">
                  <input name="firstpage" type="hidden" id="firstpage" value="<?php echo $firstpage?>"/>
				  <input name="prevpage" type="hidden" id="prevpage" value="<?php echo $prevpage?>"/>
				  <input name="nextpage" type="hidden" id="nextpage" value="<?php echo $nextpage?>"/>			        
				  <input name="lastpage" type="hidden" id="lastpage" value="<?php echo $lastpage?>"/>
				  <input name="pageno" type="hidden" id="pageno"/>
				  <input name="first" type="button" id="first" value="Primero" <?php if (($pageno == 1)||($search == 1)){ ?> disabled="disabled" <?php } ?> class="primero" onClick="primero()" />
				  <input name="prev" type="button" id="prev" value="Anterior" <?php if (($pageno == 1) ||($search == 1)){ ?> disabled="disabled" <?php } ?> class="anterior" onClick="anterior()"/>
				   <input name="next" type="button" id="next" value="Siguiente" <?php if (($pageno == $lastpage) ||($search == 1) ||($numrows == 0)){ ?> disabled="disabled" <?php } ?> class="siguiente" onClick="siguiente()"/>
				   <input name="fin" type="button" id="fin" value="Ultimo" <?php if (($pageno == $lastpage) ||($search == 1) ||($numrows == 0)){ ?> disabled="disabled" <?php } ?> class="ultimo" onClick="ultimo()"/>
                </div></td>
                <td width="17">&nbsp;</td>
                <td width="580"><label>
                    <div align="right">
                      
                      <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                      <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" onclick="modificar()"/>
                      <?php if ($val_habil == 1){?>
					  <input name="del" type="button" id="del" value="Activar" class="eliminar" <?php if ($find <>1){?>disabled="disabled" <?php }?> onclick="eliminar()"/>
					  <?php } else {?>
						<?php if ($est_habil_stock==1) {
							?>
							<input name="del1" type="button" id="del1" value="Anular" class="eliminar" <?php if ($find <>1){?>disabled="disabled" <?php }?> onclick="eliminar1()"/>
							<?php
						} else {
							?>
							<input name="del1" type="button" id="del1" value="Anular" class="eliminar" <?php 
							$stringAlert = "onclick=\"alert('$msg_habil_stock');\"";
								error_log($stringAlert);
							echo $stringAlert; ?> />
							<?php
						} ?>
					  
					  <?php }?>
                      <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
                      <input name="upd" type="hidden" id="upd" value="<?php echo $find?>" />
                      <input name="numero" type="hidden" id="numero" value="<?php echo $numero?>" />
                      <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33?>" />
                      <input name="save" type="button" id="save" value="Grabar" onclick="grabar()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
                      <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar_consult()" class="cancelar"  <?php if ($find <>1){?>disabled="disabled" <?php }?>/>
					  <input name="exit" type="button" id="exit" value="Salir" onclick="salir_consult()" class="salir"/>
                      <?php 
					  if ($numero == "")
					  {
					  $valnumero = 0;
					  }
					  else
					  {
					  $valnumero = $numero;
					  }
					  ?>
					  <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" <?php if ($impresion == 0){?>disabled="disabled"<?php }?> onclick="prints(<?php echo $invnum;?>,<?php echo $pageno;?>,<?php echo $valnumero;?>)"/>
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
