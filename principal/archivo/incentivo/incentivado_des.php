<?php include('../../session_user.php');
require_once('../../../conexion.php');
$val     = $_REQUEST['val'];
$p1      = $_REQUEST['p1'];
$ord     = $_REQUEST['ord'];
$invnum  = $_REQUEST['invnum'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
$date	= date('Y-m-d');
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
mysqli_query($conexion,"UPDATE incentivado set datefin = '$date' where estado = '1'");
mysqli_query($conexion,"UPDATE incentivado set estado = '0' where invnum = '$invnum'");
header("Location: incentivo2.php?p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros");
?>