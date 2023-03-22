<?php include('../session_user.php');
require_once ('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">


<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS?>
</head>
<body>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>
<script type="text/javascript">
    window.addEvent('domready', function() 
	{ 
	myCal = new Calendar({ date1: 'd/m/Y' });
	myCal = new Calendar({ date2: 'd/m/Y' }); 
	
myCal3 = new Calendar({ date3: 'd/m/Y' }, { classes: ['i-heart-ny'], direction: 1 }); 
	}
	)
	;
</script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<link href="../select2/css/select2.min.css" rel="stylesheet" />
<script src="../select2/js/select2.min.js"></script>

<?php require_once('../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../funciones/calendar.php");?>
<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL?>
<script language="JavaScript">
function validar()
{
	  var f = document.form1;
	  if (f.desc.value == "")
	  { alert("Ingrese el Numero del Documento"); f.desc.focus(); return; }
	  document.form1.vals.value = "";
	  document.form1.valTipoDoc.value = "";
	  document.form1.ck1.value = "";
	  document.form1.ck2.value = "";
	  var tip = document.form1.report.value;
	  if (tip ==1)
	  {
	  f.action = "ventas_dia1.php";
	  }
	  else
	  {
	  f.action = "ventas_prog.php";
	  }
	  f.submit();
}
function desab()
{
	 var f = document.form1;
	  if (f.ckprod.checked == true)
	  { 
	  //alert("hola1");
	  f.ck.disabled = true;
	  f.ck1.disabled = true;
	  f.ck2.disabled = true;
	  }
	  else
	  {
		  //alert("hola2");
	  f.ck.disabled = false;
	  f.ck1.disabled = false;
	  f.ck2.disabled = false;
	  }
}
function validar1()
{
	  var f = document.form1;
	  if (f.date1.value == "")
	  { alert("Ingrese una Fecha"); f.date1.focus(); return; }
	  if (f.date2.value == "")
	  { alert("Ingrese una Fecha"); f.date2.focus(); return; }
	  document.form1.val.value = "";
	  document.form1.valTipoDoc.value = "";
	  document.form1.ck.value = "";
	  document.form1.ck2.value = "";
	  var tip = document.form1.report.value;
	  if (tip ==1)
	  {
	  f.action = "ventas_dia1.php";
	  }
	  else
	  {
	  f.method = 'get';
	  f.action = "ventas_prog.php";
	  }
	  f.submit();
}
function validarTipoDoc()
{
	  var f = document.form1;
	  if (f.from.value == "")
	  { alert("Ingrese un número inicial"); f.from.focus(); return; }
	  if (f.until.value == "")
	  { alert("Ingrese un número final"); f.until.focus(); return; }
	  document.form1.val.value = "";
	  document.form1.vals.value = "";
	  document.form1.ck.value = "";
	  document.form1.ck1.value = "";
	  var tip = document.form1.report.value;
	  if (tip ==1)
	  {
		f.action = "ventas_dia1.php";
	  }
	  else
	  {
		  f.method = 'get';
		  f.action = "ventas_prog.php";
	  }
	  f.submit();
}
function sf(){
var f = document.form1;
document.form1.desc.focus();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../index.php";
	 f.submit();
}
function printer()
{
	window.print();
}
function printerTipoDoc()
{
	window.print();
}
</script>
<?php 
$date  = date('d/m/Y');
$val   = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$vals  = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
$valTipoDoc  = isset($_REQUEST['valTipoDoc']) ? ($_REQUEST['valTipoDoc']) : "";
$desc  = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
$desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$tipoDoc = isset($_REQUEST['tipoDoc']) ? ($_REQUEST['tipoDoc']) : "";
$from = isset($_REQUEST['from']) ? ($_REQUEST['from']) : "";
$until = isset($_REQUEST['until']) ? ($_REQUEST['until']) : "";
$report= isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$ck    = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";
$ck1   = isset($_REQUEST['ck1']) ? ($_REQUEST['ck1']) : "";
$ck2   = isset($_REQUEST['ck2']) ? ($_REQUEST['ck2']) : "";
$ckloc = isset($_REQUEST['ckloc']) ? ($_REQUEST['ckloc']) : "";
$ckprod = isset($_REQUEST['ckprod']) ? ($_REQUEST['ckprod']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$sql="SELECT export,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$export    = $row['export'];
	$user    = $row['nomusu'];
}
}
////////////////////////////
$registros = 20;
$pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
if ($local <> 'all')
{
require_once("datos_generales.php");	//COGE LA TABLA DE UN LOCAL
}
////////////////////////////
if ($ckprod == 1)
{
		if ($val == 1){ ///	PRIMER BOTON
			if ($local == 'all')////TODOS LOS LOCALES
			{ 
			$sql="SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";
			}
			else ///UN SOLO LOCAL
			{
			$sql="SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local'";
			}
		}
		elseif ($vals == 2)///	SEGUNDO BOTON
		{
			if ($local == 'all')////TODOS LOS LOCALES
			{ 
					$sql="SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and invtot <> '0' and estado = '0'";
			}
			else ///UN SOLO LOCAL
			{
				$sql="SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
			}
		} else // TERCER BOTON
		{
			if ($local == 'all')////TODOS LOS LOCALES
			{ 
					$sql="SELECT venta.invnum FROM venta inner join detalle_venta where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0'";
			}
			else ///UN SOLO LOCAL
			{
				$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' group by usecod order by nrovent";
			}
		}
		$sql			 = mysqli_query($conexion,$sql);
		$total_registros = mysqli_num_rows($sql);
		$total_paginas   = ceil($total_registros/$registros); 
		//echo $sql;
}
else
{
	if (($ck == '') && ($ck1 == '') && ($ck2 == ''))
	{
		if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1))
		{
			if ($val == 1)
			{
				if ($local == 'all')
				{
					$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' group by usecod";
				}
				else
				{
					$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' group by usecod";
				}
			}
			if ($vals == 2)
			{
				if ($local == 'all')
				{
					$sql="SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
				}
				else
				{
					$sql="SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' group by usecod order by nrovent";
				}
			}
			if ($valTipoDoc == 1)
			{
				if ($local == 'all')
				{
					$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' group by usecod order by nrovent";
				}
				else
				{
					$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' group by usecod order by nrovent";
				}
			}
			$sql			 = mysqli_query($conexion,$sql);
			$total_registros = mysqli_num_rows($sql);
			$total_paginas   = ceil($total_registros/$registros); 
		}
	}
	if (($ck == 1) || ($ck1 == 1) || ($ck2 == 1))
	{
		if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1))
		{
			if ($val == 1)
			{
				if ($local == 'all')
				{
					$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where nrovent between '$desc' and '$desc1'";
				}
				else
				{
					$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local'";
				}
			}
			if ($vals == 2)
			{
				if ($local == 'all')
				{	
					$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' order by nrovent";
				}
				else
				{
					$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' order by nrovent";
				}
			}
			if ($valTipoDoc == 1)
			{
				if ($local == 'all')
				{	
				$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' order by nrovent";
				}
				else
				{
				$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' order by nrovent";
				}
			}
			$sql			 = mysqli_query($conexion,$sql);
			$total_registros = mysqli_num_rows($sql);
			$total_paginas   = ceil($total_registros/$registros); 
		}
	}
}
?>
 <table width="954" border="0">
    <tr>
      <td><b><u>REPORTE DE VENTAS DIARIAS</u></b>
	  <form id="form1" name="form1" method = "post" action="">
        <table width="927" border="0">
          <tr>
            <td width="119">SALIDA</td>
            <td width="172">
              <select name="report" id="report">
                <option value="1">POR PANTALLA</option>
                <?php if ($export == 1){?>
                <option value="2">EN ARCHIVO XLS</option>
				<?php }?>
              </select>            </td>
			<td width="58"><div align="right">LOCAL</div></td>
			<td width="504">
			<select name="local" id="local">
              <?php if ($nombre_local == 'LOCAL0'){?>
			  <option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>ALL PREMISES</option>
			  <?php }?>
              <?php 
			    if ($nombre_local == 'LOCAL0')
				{
				$sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc"; 
				}
				else
				{
				$sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local'"; 
				}
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				$loc	= $row["codloc"];
				$nloc	= $row["nomloc"];
				$nombre	= $row["nombre"];
				if ($nombre == '')
				{
				$locals = $nloc;
				}
				else
				{
				$locals = $nombre;
				}
				?>
              <option value="<?php echo $row["codloc"]?>" <?php if ($loc == $local){?> selected="selected"<?php }?>><?php echo $locals; ?></option>
              <?php } ?>
            </select>
			<input name="ckloc" type="checkbox" id="ckloc" value="1" <?php if ($ckloc == 1){?>checked="checked"<?php }?>/>
Mostrar Local
			<input name="ckprod" type="checkbox" id="ckprod" value="1" <?php if ($ckprod == 1){?>checked="checked"<?php }?> onclick="desab()"/>
Mostrar Detalle de Productos
			</td>
			<td width="24">
			  <?php if(($pagina - 1) > 0) 
			  {
			  ?>
              <a href="ventas_dia.php?val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&ck=<?php echo $ck?>&ck1=<?php echo $ck1?>&ckloc=<?php echo $ckloc?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina-1?>"><img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
              <?php }
			  ?></td>
			<td width="24"><?php if(($pagina + 1)<=$total_paginas) 
			  {
			  ?>
              <a href="ventas_dia.php?val=<?php echo $val?>&vals=<?php echo $vals?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&ck=<?php echo $ck?>&ck1=<?php echo $ck1?>&ckloc=<?php echo $ckloc?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina+1?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
              <?php }
			  ?></td>
          </tr>
        </table>
        <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div>
        <table width="928" border="0">
          <tr>
            <td width="119">NRO DE VENTA INICIAL</td>
            <td width="124"><input name="desc" type="text" id="desc" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc?>"/></td>
            <td width="107"><div align="right">NRO DE VENTA FINAL</div></td>
            <td width="133"><input name="desc1" type="text" id="desc1" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc1?>"/>            </td>
            <td width="199">
              <input name="ck" type="checkbox" id="ck" value="1" <?php if ($ck == 1){?>checked="checked"<?php }?> <?php if ($ckprod == 1){?>disabled="disabled"<?php }?>/>
Mostrar Lista detallada por N&ordm; </td>
            <td width="220"><input name="val" type="hidden" id="val" value="1" />
              <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
              <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
              <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/></td>
          </tr>
        </table>
	    <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div>
	    <table width="928" border="0">
          <tr>
            <td width="119">FECHA INICIO</td>
            <td width="98">
			<input type="text" name="date1" id="date1" size="12" value="<?php if ($date1 == ""){ echo $date;} else{ echo $date1;}?>">
			</td>
            <td width="23">&nbsp;</td>
            <td width="106"><div align="right">FECHA FINAL</div></td>
            <td width="133">
			<input type="text" name="date2" id="date2" size="12" value="<?php if ($date2 == ""){ echo $date;} else {echo $date2;}?>">
			</td>
            <td width="199">
              <input name="ck1" type="checkbox" id="ck1" value="1" <?php if ($ck1 == 1){?>checked="checked"<?php }?> <?php if ($ckprod == 1){?>disabled="disabled"<?php }?>/>
Mostrar Lista detallada por N&ordm; 
			</td>
            <td width="220"><input name="vals" type="hidden" id="vals" value="2" />
              <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar"/>
             <input type="button" name="Submit222" id="im" value="Imprimir"  onClick="self.location.href='ventas_dia2_1.php?ventas_dia2_1.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&ck=<?php echo $ck?>&ck1=<?php echo $ck1?>&val=<?php echo $val?>&vals=<?php echo $vals?>&ckloc=<?php echo $ckloc?>&ckprod=<?php echo $ckprod?>'" class="imprimir"/>
            <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir"/></td>
          </tr>
        </table>
		<div align="left"><img src="../../images/line2.png" width="940" height="4" /></div>
	    <table width="928" border="0">
          <tr>
            <td width="119">TIPO DOC</td>
			<td width="90">
              <select name="tipoDoc" id="tipoDoc">
                <option value="2" <?php if ($tipoDoc == 2){?>selected<?php }?>>BOLETA</option>
                <option value="4" <?php if ($tipoDoc == 4){?>selected<?php }?>>TICKET</option>
                <option value="1" <?php if ($tipoDoc == 1){?>selected<?php }?>>FACTURA</option>
              </select>  
			</td>
            <td width="35"></td>
            <td width="40">DESDE</td>
            <td width="34"><input name="from" type="text" id="from" size="8" onkeypress="return acceptNum(event)" maxlength="10" value="<?php echo $from?>"/></td>
            <td width="5"></td>
            <td width="34"><div align="right">HASTA</div></td>
            <td width="40"><input name="until" type="text" id="until" size="8" onkeypress="return acceptNum(event)" maxlength="10" value="<?php echo $until?>"/>            </td>
            <td width="199">
              <input name="ck2" type="checkbox" id="ck2" value="1" <?php if ($ck2 == 1){?>checked="checked"<?php }?> <?php if ($ckprod == 1){?>disabled="disabled"<?php }?>/>
Mostrar Lista detallada por N&ordm; </td>
            <td width="220"><input name="valTipoDoc" type="hidden" id="valTipoDoc" value="1" />
              <input type="button" name="SubmitTipoDoc" value="Buscar" onclick="validarTipoDoc()" class="buscar"/>
              <input type="button" name="SubmitPrintTipoDoc" value="Imprimir" onClick="self.location.href='ventas_dia2_2.php?ventas_dia2_2.php?val=<?php echo $val?>&vals=<?php echo $vals?>&valTipoDoc=<?php echo $valTipoDoc?>&desc=<?php echo $desc?>&desc1=<?php echo $desc1?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&tipoDoc=<?php echo $tipoDoc?>&from=<?php echo $from?>&until=<?php echo $until?>&report=<?php echo $report?>&ck=<?php echo $ck?>&ck1=<?php echo $ck1?>&ck2=<?php echo $ck2?>&ckloc=<?php echo $ckloc?>&ckprod=<?php echo $ckprod?>&local=<?php echo $local?>'" class="imprimir"/>
              <input type="button" name="SubmitSalirTipoDoc" value="Salir" onclick="salir()" class="salir"/></td>
          </tr>
        </table>
	  </form>
      <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div></td>
    </tr>
  </table>
  <br>
  <?php if (($val == 1) || ($vals == 2) || ($valTipoDoc ==1))
  {
	 require_once("ventas_dia2.php");
  }
  ?>
  </body>
  </html>
  <script>
	$('#tipoDoc').select2();
	$('#local').select2();

</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>
