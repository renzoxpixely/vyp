<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$codtemp = $_POST['codtemp'];
if ($cod <> ""){
mysqli_query($conexion,"DELETE from tempmovmov where codtemp = '$cod'");
}
if ($codtemp <> ""){
$text1 = $_POST['text1'];	///cantidad ingresada
$text2 = $_POST['text2'];	///precio promedio
$text3 = $_POST['text3'];	///total
$number = $_POST['number']; ///factor
if ($costpr == 0)
{
$costpr = 1;
}
if ($number == 0)
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', pripro = '$text2', costre = '$text3',costpr= '$text2' where codtemp = '$codtemp'");
}
else
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', pripro = '$text2', costre = '$text3',costpr= '$text2' where codtemp = '$codtemp'");
}
}
header("Location: ingresos_varios1.php"); 
?>