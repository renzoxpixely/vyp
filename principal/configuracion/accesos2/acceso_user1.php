<?php

require_once("../../../conexion.php");

include('../../session_user.php');

$nombre = $_REQUEST['nombre'];

$login  = $_REQUEST['login'];

$clave  = $_REQUEST['codigo'];

$grup   = $_REQUEST['grup'];

$local  = $_REQUEST['local'];

$claveventa  = "c".$_REQUEST['claveventa'];

//$hour   = date(G);

$date	= date('Y-m-d');

//$date	= mysqli_aFechaHora($hour);

$trozos = explode(" ", $nombre);

$nom    = $trozos[0]; 

$ape    = $trozos[1]; 

$ape1   = $trozos[2]; 

$nom	= substr($nom, 0, 1);

$ape	= substr($ape, 0, 1);

$ape1	= substr($ape1, 0, 1);

$abrev  = $nom.$ape.$ape1;

$sql = "SELECT logusu,nomusu FROM usuario WHERE (logusu = '$login' and nomusu = '$nombre') or (abrev = '$abrev')";

$result = mysqli_query($conexion,$sql);

if($row = mysqli_fetch_array($result))

{	

	header("Location: acceso_user.php?error=1&val=1&codgrup=$grup");

}

else

{

mysqli_query($conexion, "INSERT INTO usuario(nomusu,logusu,pasusu,estado,codgrup,fecha_reg,abrev,codloc,claveventa) values ('$nombre','$login','$clave','1','$grup','$date','$abrev','$local','$claveventa')");

header("Location: acceso_user.php?ok=1&val=1&codgrup=$grup");

}

?>