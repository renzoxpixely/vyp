<?php 
require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title><?php echo $desemp?></title>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="../../../archivo/css/select_cli.css" rel="stylesheet" type="text/css">
<?php 
require_once('../../../../funciones/funct_principal.php');
require_once('../../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../../funciones/botones.php');	//COLORES DE LOS BOTONES
require_once("funciones/call_combo.php");	//LLAMA A generaSelect
$close = isset($_REQUEST['close'])? $_REQUEST['close'] : "";
?>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
<script type="text/javascript" src="funciones/select_3_niveles.js"></script>
<script type="text/javascript">
function fc()
{
    document.form1.country.focus();
}

function asigna()
{
    var f = document.form1;
    if (f.country_ID.value == "")
    { 
        alert("Ingrese el nombre del Medico"); f.country.focus(); return;
    }
    var codmed = f.country_ID.value;
    document.form1.target = "venta_principal";
    window.opener.location.href="salir.php?codmed="+codmed;
    self.close();
}
var nav4 = window.Event ? true : false;
function enteres1(evt){
	var f   = document.form1;
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	    if (f.country_ID.value !== '')
	    {
		document.form1.submit();
	    }
	    else
	    {
	        alert("Ingrese una descripciÃ³n");
	        return false;
	    }
	}
	else
	{
		return false; 
	}
}



function cerrar_popup()
{
    document.form1.target = "venta_principal";
    window.opener.location.href="salir.php";
    self.close();
}

function cerrar_popup1()
{
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
        { 
            alert("Ingrese el nombre del Cliente"); f.country.focus(); return;
        }
        
        var codmed = f.country_ID.value;
        document.form1.target = "venta_principal";
        window.opener.location.href="salir.php?codmed="+codmed;
        self.close();
    }
}

function escapes(e)
{
    tecla=e.keyCode
    if (tecla == 27)
    {
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
<?php 
$val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
if ($val == 4)
{
	$codmed = $_REQUEST['country_ID'];
	$sql="SELECT codmed,nommedico,codcolegiatura FROM medico where codmed = '$codmed'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codmed           = $row["codmed"];
		$nommedico        = $row["nommedico"];
		$codcolegiatura   = $row["codcolegiatura"];
		mysqli_query($conexion, "UPDATE venta set codmed = '$codmed' where invnum = '$venta'");
		mysqli_query($conexion, "UPDATE temp_venta set codmed = '$codmed' where invnum = '$venta'");
	}
	}
}
$sql="SELECT invnum,nrovent,invfec,cuscod,codmed,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$codmedd       = $row['codmed'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
                $correlativo  = $row['correlativo'];
}
}
$sql="SELECT codmed,nommedico,codcolegiatura FROM medico where codmed = '$codmedd'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)>0){
while ($row = mysqli_fetch_array($result)){
	$codmed           = $row["codmed"];
	$nommedico        = $row["nommedico"];
	$codcolegiatura   = $row["codcolegiatura"];
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
      <td width="74" valign="top">NRO DE OPERACION </td>
      <td width="481" valign="top">
	  <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo)?>"/>      </td>
    </tr>
    <tr>
      <td valign="top">BUSCAR</td>
      <td valign="top">
	      <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="52" onclick="this.value=''" onkeypress="return ent(event);"/>
          <input type="hidden" id="country_hidden" name="country_ID" onkeypress="enteres1(event)" />
          <input name="val" type="hidden" id="val" value="2" />
          <input name="button" type="button" value="ASIGNAR" onclick="asigna()"/>
          <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()"/>      
      </td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="570" height="4" />
  
  
  
  
</div>

</form>
</body>
</html>
