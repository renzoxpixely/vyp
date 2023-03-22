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
$close      = $_REQUEST['close'];
$CVendedor  = $_REQUEST['CodClaveVendedor'];
?>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
<script type="text/javascript" src="funciones/select_3_niveles.js"></script>
<script type="text/javascript">
function fc()
{
    document.form1.country.focus();
}

function cerrar_popup()
{
    window.close();
}

function escapes(e) 
{
    tecla=e.keyCode
    if (tecla == 27)
    {
          window.close();
    }
}

function GeneraVenta_popup()
{
    //window.opener.location.href="../preimprimir.php";
    var f = document.formulario;
    f.action = "sendmail.php";
    f.method = "post";
    f.submit();
}
</script>
<style type="text/css">

</style>
</head>
<?php 

$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
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
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
        $codcli         = $row["codcli"];
        $descli         = $row["descli"];
    }
}

function formato($c) 
{
    printf("%08d",  $c);
} 
?>
</head>
<body onload="<?php if ($close == 1){?>cerrar_popup()<?php }else{ if ($close == 2){?> cerrar_popup1()<?php } else{?>fc()<?php }}?>" onkeyup="escapes(event)">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<input type="hidden" name="CVendedor" value="<?php echo $CVendedor;?>"/>
<div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
<div align="center">
    <table width="565" border="0">
        <tr>
          <td width="74" valign="top">NRO DE VENTA </td>
          <td width="481" valign="top">
              <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo)?>"/>      </td>
        </tr>
        <tr>
            <td valign="top">BUSCAR</td>
            <td valign="top">
                <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="52" onclick="this.value=''" onkeypress="return ent(event);"/>
                <input type="hidden" id="country_hidden" name="country_ID" />
                <input name="val" type="hidden" id="val" value="1" />
            </td>
        </tr>
        <tr>
            <td valign="top">RUC</td>
            <td>
                <input name="ruc" type="text" id="ruc" onkeypress="return acceptNum(event)" maxlength="12"/>
            </td>
        </tr>
        <tr>
            <td valign="top">MAIL</td>
            <td>
                <input name="correo" style="width: 80%" type="text" id="correo"/>
            </td>
        </tr>
        <tr>
            <td valign="top"></td>
            <td>
                <input type="button" name="Submit2" value="GENERAR VENTANA" onclick="GeneraVenta_popup()"/>
                <input type="button" name="Submit2" value="CERRAR" onclick="cerrar_popup()"/>
            </td>
        </tr>
    </table>
    <img src="../../../../images/line2.png" width="570" height="4" />
</div>
</form>
</body>
</html>
