<?php include('../../session_user.php');
require_once('../../../conexion.php');
$p3       = $_REQUEST['p3'];
$p1  = $_REQUEST['p1'];
$codcli   = $_REQUEST['codcli'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];
$puntos   = $_REQUEST['puntos'];
$date   = $_REQUEST['date'];
$n=$puntos - $p1;
 
// mysqli_query($conexion,"UPDATE cliente set puntos = '$n' where codcli = '$codcli'");

  

//mysqli_query($conexion,"INSERT INTO puntos (fecha,usecod,codclic,despunto,pdescuento,estado) values ('$date','$usuario','$codcli','$p3','$p1','$val')");
mysqli_query($conexion,"INSERT INTO temp_puntos (fecha,usecod,codclic,despunto,pdescuento,estado,descontado) values ('$date','$usuario','$codcli','$p3','$p1','$val','$n')");


header("Location:puntos2.php?search=$search&val=1");
?>