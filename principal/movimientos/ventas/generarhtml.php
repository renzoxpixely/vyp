<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('../montos_text.php');
$venta     = $_SESSION['venta'];
require_once('session_ventas.php');
require_once('venta_reg1.php');	//GRABO EL DETALLE DE VENTA
/////////////////////////////////////////////
$_SESSION['codigo_user'] = $_SESSION['UsuarioPrincipal'];
$rd	= $_REQUEST['tt'];
$numCopias   = isset($_REQUEST['numCopias'])? $_REQUEST['numCopias'] : 1;

error_log("rd: ".$rd);
$facturacionElect = 0;
$sql="SELECT facturacionElect FROM datagen";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $facturacionElect    = $row['facturacionElect'];
}
}

$linea5RUC = "";
$sqlTicket="SELECT linea5 "
        . "FROM ticket where sucursal = '$sucursal'";
$resultTicket = mysqli_query($conexion,$sqlTicket);
if (mysqli_num_rows($resultTicket))
{
    while ($row = mysqli_fetch_array($resultTicket))
    {
        $linea5RUC      = $row['linea5'];
    }
}
else
{
    $sqlTicket="SELECT linea5 "
        . "FROM ticket where sucursal = '1'";
    $resultTicket = mysqli_query($conexion,$sqlTicket);
    if (mysqli_num_rows($resultTicket))
    {
        while ($row = mysqli_fetch_array($resultTicket))
        {
            $linea5RUC       = $row['linea5'];
        }
    }
}
//OBTENGO LOS DATOS DE LA VENTA
$sqlV = "SELECT tipdoc FROM venta where invnum = '$venta'";
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row1 = mysqli_fetch_array($resultV))
    {
        $tipdoc             = $row1['tipdoc'];          //4=TICKET, 2=BOLETA, 1=FACTURA
    }
}


error_log("facturacionElect: ".$facturacionElect);
error_log("linea5RUC: ".$linea5RUC);
error_log("tipdoc: ".$tipdoc);
//($facturacionElect == 1) and 
if (($facturacionElect == 1) and (strlen($linea5RUC)>0) and ($tipdoc == 2 || $tipdoc == 1))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generando Venta...</title>
<script>
function impresionSunat()
{
    var f = document.form1;
    window.open('generaSunat.php?rd=<?php echo $rd;?>&vt=<?php echo $venta;?>','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=260,left=120,width=885,height=330');
    f.action = "venta_index.php";
    f.method = "post";
    f.submit();
    
}
</script>
</head>

<body onload="impresionSunat();">
    <form name="form1" id="form1"></form>
</body>
</html>
<?php 
}
else
{
    header("Location: generaTicket.php?rd=$rd&vt=$venta&numCopias=$numCopias");
    //echo "TICKWET";
}
?>
