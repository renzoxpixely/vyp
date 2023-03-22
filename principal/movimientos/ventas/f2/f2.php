<?php 
require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
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
        alert("Ingrese el nombre del Cliente"); f.country.focus(); return;
    }
    var codcli = f.country_ID.value;
    document.form1.target = "venta_principal";
    window.opener.location.href="salir.php?codcli="+codcli;
    self.close();
}

function save_cliente()
{
    var f = document.form2;
    if (f.nom.value == "")
    { 
        alert("Ingrese el nombre del Cliente"); f.nom.focus(); return; 
    }
    var ruc = f.ruc.value;
    if (ruc.length > 0)
    {
        if (ruc.length < 11)
        {
            alert("Debe ingresar 11 caracteres en el RUC"); 
            f.ruc.focus();
            return false;
        }
    }
    ventana=confirm("Desea Grabar este Cliente");
    if (ventana) 
    {
        f.method = "post";
        f.action ="cliente_reg.php";
        f.submit();
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
        
        var codcli = f.country_ID.value;
        document.form1.target = "venta_principal";
        window.opener.location.href="salir.php?codcli="+codcli;
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

</head>
<?php 
$val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
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
      
      if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
      } else {
        $arr_detalle_venta = array();
      }
      $arrAux = array();
      foreach ($arr_detalle_venta as $detalle) {
        $detalle['cuscod'] = $codcli;
        $arrAux[] = $detalle;
      }
      $_SESSION['arr_detalle_venta'] = $arrAux;
    }
	}
}
$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
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
                $correlativo  = $row['correlativo'];
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
<style>
    .COLOR { color: #FF0000; } /* CSS link color */
  </style>
</head>
<body onload="<?php if ($close == 1){?>cerrar_popup()<?php }else{ if ($close == 2){?> cerrar_popup1()<?php } else{?>fc()<?php }}?>" onkeyup="escapes(event)">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<div align="center"><img src="../../../../images/line2.png" width="100%" height="4" /></div>
<div align="LEFT">
  <table width="100%" border="0">
    <tr>
      <td width="74" valign="top">NRO DE VENTA </td>
      <td width="481" valign="top">
	  <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo)?>"/>      </td>
    </tr>
    <tr>
      <td valign="top">BUSCAR</td>
      <td valign="top">
	      <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="100" onclick="this.value=''" onkeypress="return ent(event);"/>
          <input type="hidden" id="country_hidden" name="country_ID" />
          <input name="val" type="hidden" id="val" value="1" />
          <input name="button" type="button" value="ASIGNAR" onclick="asigna()"/>
          <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()"/>      </td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="100%" height="4" />
  <table width="600" border="0">
    <tr>
      <td align="LEFT" ><strong>CREAR CLIENTE </strong></td>
    </tr>
  </table>
  </div>
</form>
<form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
  <div align="LEFT">
  <table width="565" border="0">
    <tr>
      <td class="COLOR" width="103">NOMBRE / RAZON SOCIAL </td>
      <td width="452"><input name="nom" type="text" id="nom" size="60" onkeyup="this.value = this.value.toUpperCase();"/>      </td>
    </tr>
    <tr>
      <td>DNI</td>
      <td><input name="dni" type="text" id="dni" onkeypress="return acceptNum(event)" maxlength="8"/>      </td>
    </tr>
    <tr>
      <td class="COLOR">RUC</td>
      <td><input name="ruc" type="text" id="ruc" onkeypress="return acceptNum(event)" maxlength="11" minlength="11"/>      </td>
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
      <td>DEPARTAMENTO</td>
      <td><div id="demoIzq">
        <?php generaSelect($conexion); ?>
      </div></td>
    </tr>
    <tr>
      <td>PROVINCIA</td>
      <td><div id="demoMed">
        <select disabled="disabled" name="provincia" id="provincia">
          <option value="0">Seleccione una Provincia</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td>DISTRITO</td>
      <td><div id="demoDer">
        <select disabled="disabled" name="distrito" id="distrito">
          <option value="0">Seleccione un Distrito</option>
        </select>
      </div></td>
    </tr>
	<tr>
      <td>DIRECCIÓN </td>
      <td><input name="direc" type="text" id="direc" size="60"/>      </td>
    </tr>
    <tr>
      <td>EMAIL</td>
      <td><input name="mail" type="text" id="mail" size="45" />
          <input type="button" name="Submit" value="GRABAR" onclick="save_cliente()"/>      </td>
    </tr>
  </table>
</div>
<div align="center"><img src="../../../../images/line2.png" width="100%" height="4" />
<br>
</div>

<td><H4 class="COLOR">PARA FACTURA LLENAR LOS CAMPOS EN COLOR ROJO</H4></td>



</form>
</body>
</html>
