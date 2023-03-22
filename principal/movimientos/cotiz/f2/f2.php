<?php include('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../../funciones/funct_principal.php");
require_once("../../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../../funciones/botones.php");	//COLORES DE LOS BOTONES
$close = $_REQUEST['close'];
?>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
<script type="text/javascript">
function fc(){
document.form1.country.focus();
}
function asigna()
{
  var f = document.form1;
  if (f.country_ID.value == "")
  { alert("Ingrese el nombre del Cliente"); f.country.focus(); return; }
  var codcli = f.country_ID.value;
  document.form1.target = "venta_principal";
  window.opener.location.href="salir.php?codcli="+codcli;
  self.close();
}
function save_cliente(){
  var f = document.form2;
  if (f.nom.value == "")
  { alert("Ingrese el nombre del Cliente"); f.nom.focus(); return; }
  ventana=confirm("Desea Grabar este Cliente");
  if (ventana) {
  f.method = "post";
  f.action ="cliente_reg.php";
  f.submit();
  }
}
function cerrar_popup()
{
//ventana=confirm("Desea Grabar este Cliente");
document.form1.target = "venta_principal";
window.opener.location.href="salir.php";
self.close();
}
function cerrar_popup1()
{
//ventana=confirm("Desea Grabar este Cliente");
document.form1.target = "venta_principal";
window.opener.location.href="salir1.php";
self.close();
}
var nav4 = window.Event ? true : false;
function ent(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		  var f = document.form1;
		  if (f.country_ID.value == "")
		  { alert("Ingrese el nombre del Cliente"); f.country.focus(); return; }
		  var codcli = f.country_ID.value;
		  document.form1.target = "venta_principal";
		  window.opener.location.href="salir.php?codcli="+codcli;
		  self.close();
	}
}
function escapes(e) {
tecla=e.keyCode
  if (tecla == 27)
  {
    //document.form1.val.value = "";
	//document.form1.tipo.value = "";
	//document.form1.submit();
	window.close();
  }
}
</script>

<style type="text/css">
<!--
body {
	background-color: #FFFFCC;
}
-->
</style>
</head>
<?php $val = $_REQUEST['val'];
if ($val == 1)
{
	$codcli = $_REQUEST['country_ID'];
	$sql="SELECT codcli,descli,dnicli FROM cliente where codcli = '$codcli'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codcli         = $row["codcli"];
		$descli         = $row["descli"];
		$dnicli         = $row["dnicli"];
		mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
		mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
	}
	}
}
$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
}
}
$sql="SELECT codcli,descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codcli         = $row["codcli"];
	$descli         = $row["descli"];
}
}
function formato($c) {
printf("%08d",  $c);
} 
?>
</head>
<body onload="<?php if ($close == 1){?>cerrar_popup()<?php }else{ if ($close == 2){?> cerrar_popup1()<?php } else{?>fc()<?php }}?>" onkeyup="escapes(event)">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
<div align="center">
  <table width="565" border="0">
    <tr>
      <td width="74" valign="top">NRO DE VENTA </td>
      <td width="481" valign="top">
	  <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($invnum)?>"/>      </td>
    </tr>
    <tr>
      <td valign="top">BUSCAR</td>
      <td valign="top">
	      <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="52" onclick="this.value=''" onkeypress="return ent(event);"/>
          <input type="hidden" id="country_hidden" name="country_ID" />
          <input name="val" type="hidden" id="val" value="1" />
          <input name="button" type="button" value="ASIGNAR" onclick="asigna()"/>
          <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()"/>      </td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="570" height="4" />
  <table width="399" border="0">
    <tr>
      <td><strong>NUEVO CLIENTE </strong></td>
    </tr>
  </table>
  </div>
</form>
<form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
  <div align="center">
  <table width="565" border="0">
    <tr>
      <td width="74">NOMBRE</td>
      <td width="481"><input name="nom" type="text" id="nom" size="60" onkeyup="this.value = this.value.toUpperCase();"/>      </td>
    </tr>
    <tr>
      <td>DNI</td>
      <td><input name="dni" type="text" id="dni" onkeypress="return acceptNum(event)" maxlength="8"/>      </td>
    </tr>
    <tr>
      <td>RUC</td>
      <td><input name="ruc" type="text" id="ruc" onkeypress="return acceptNum(event)" maxlength="14"/>      </td>
    </tr>
    <tr>
      <td>TELEFONO 1 </td>
      <td><input name="fono" type="text" id="fono" onkeypress="return acceptNum(event)" maxlength="10"/>      </td>
    </tr>
    <tr>
      <td>TELEFONO 2 </td>
      <td><input name="fono1" type="text" id="fono1" onkeypress="return acceptNum(event)" maxlength="10"/>      </td>
    </tr>
    <tr>
      <td>EMAIL</td>
      <td><input name="mail" type="text" id="mail" size="45" />
          <input type="button" name="Submit" value="GRABAR" onclick="save_cliente()"/>      </td>
    </tr>
  </table>
</div>
<div align="center"><img src="../../../../images/line2.png" width="580" height="4" />
<br>
</div>
</form>
</body>
</html>
