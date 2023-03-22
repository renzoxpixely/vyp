<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])){
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql="SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
		 $limit             = $row["limite"];
    }
	}
	if ($limit == 0)
	{
	$limit = 50;
	}
	$t = is_numeric($letters);
	if($t == 0)
	{
            $res = mysqli_query($conexion,"select codpro,desprod,codmar,stopro,codbar from producto where activo1 = '1' and desprod like '".$letters."%' or codbar like '".$letters."%' limit $limit") or die(mysqli_error());
	}
	else
	{
            $res = mysqli_query($conexion,"select codpro,desprod,codmar,stopro,codbar from producto where activo1 = '1' and codpro like '".$letters."%' or codbar like '".$letters."%' limit $limit") or die(mysqli_error());
	}
	while($inf = mysqli_fetch_array($res)){
            $codpro   = $inf['codpro'];
            $desprod  = $inf['desprod'];
            $marca    = $inf['codmar'];
            $stopro   = $inf['stopro'];
            $codbar   = $inf['codbar'];
            $sql1="SELECT destab FROM titultabladet where codtab = '$marca'";
            $result1 = mysqli_query($conexion,$sql1);
            if (mysqli_num_rows($result1)){
            while ($row1 = mysqli_fetch_array($result1)){
                $destab = substr($row1['destab'],0,35);
            }
            }
            $cad = $desprod." <u><b> MARCA = </b>".$destab." <b>STOCK =</b> ".$stopro."...</u>"."|";
            echo $inf["codpro"]."###".$cad;
	}	
}
?>
