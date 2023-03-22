<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum  = $_SESSION['ingresos_val'];
$cod	 = $_REQUEST['cod'];			////CODIGO DEL PRODUCTO EN EL LOCAL
$text1   = $_REQUEST['text1'];	///cantidad ingresada
$text2   = $_REQUEST['text2'];	///precio promedio
$text3   = $_REQUEST['text3'];	///total
$textlote= $_REQUEST['textlote'];///lote
$mesL = $_REQUEST['mesL'];///vencimiento
$yearsL = $_REQUEST['yearsL'];///vencimiento
$locall  = $_REQUEST['locall'];	///local
$usu     = $_REQUEST['usu'];	///usuario
$number  = $_REQUEST['number']; ///factor

$textven= $mesL."/".$yearsL;

$sql="SELECT codtemp FROM tempmovmov order by codtemp desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codtemp       = $row[0];	
}	
$codtemp = $codtemp + 1;
}
else
{
$codtemp = 1;
}
if ($number == 0)
{
//mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");
mysqli_query($conexion,"INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr) values ('$invnum','$cod','$text1','$text2','$text3','$text2')");
mysqli_query($conexion,"INSERT INTO templote (invnum,numerolote,codpro,vencim,registrado,codloc) values ('$invnum','$textlote','$cod','$textven','$usu','$locall')");
}
else
{
//mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtyprf,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");

mysqli_query($conexion,"INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr) values ('$invnum','$cod','$text1','$text2','$text3','$text2')");
mysqli_query($conexion,"INSERT INTO templote (invnum,numerolote,codpro,vencim,registrado,codloc) values ('$invnum','$textlote','$cod','$textven','$usu','$locall')");

}
header("Location: ingresos_varios1.php"); 
?>