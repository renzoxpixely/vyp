<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
include('../../local.php');
/*
include('../../session_user.php');
require_once ('../../../conexion.php');
$valor = $_REQUEST['valor'];
$sql1="SELECT idpreing FROM preing";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $idpreing        = $row1['idpreing'];
}
mysqli_query($conexion,"update preing set valor  = '$valor'");
}
else
{
mysqli_query($conexion,"INSERT INTO preing(valor) values ('$valor')");
}
header("Location: index1.php");
*/
$nombre = 'config_file.php'; // Nombre del archivo
$contenido = $nombre_local; // Contenido del archivo
header( "Content-Type: application/octet-stream");
header( "Content-Disposition: attachment; filename=".$nombre."");
print($contenido);
?>