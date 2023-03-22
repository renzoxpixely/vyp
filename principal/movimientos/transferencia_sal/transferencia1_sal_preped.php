<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$prepedido = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['Prepedido'])) {
			$prepedido = $_POST['prepedido'];
	} 
}
$alertMensaje = 'No se encontró prepedido';
if ($prepedido>0) {
    $invnum  = $_SESSION['transferencia_sal'];
    error_log("se llama nuevamente al prepedido: ");
    error_log($invnum);

    $sql="SELECT DISTINCT idprod, solicitado, P.costpr, PR.codloc FROM detalle_prepedido DP, producto P, prepedido PR 
        WHERE numpagina= '$prepedido' and DP.idprod=P.codpro and PR.idpreped = DP.idprepedido order by iddetalle asc";
        error_log($sql);
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result)){
        while ($row = mysqli_fetch_array($result)){
            $idprod       = $row['idprod'];	
            $solicitado       = $row['solicitado'];	
            $costpr       = $row['costpr'];	
            $codloc       = $row['codloc'];	
            $costre =  round($solicitado * $costpr, 2);
            if ($solicitado>0) {
                $sqlVer="SELECT * FROM tempmovmov 
                    WHERE invnum='$invnum' AND codpro='$idprod'";
                error_log($sqlVer);
                $resultVer = mysqli_query($conexion,$sqlVer);
                if (!mysqli_num_rows($resultVer)){
                        $sqlInsert = "INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr) values ('$invnum','$idprod','$solicitado',$costpr,$costre,'$costpr')";
                        error_log($sqlInsert);
                        mysqli_query($conexion,$sqlInsert);
                }
            }
            $sqlUpdate="UPDATE movmae SET sucursal1='$codloc' WHERE invnum='$invnum'";
            mysqli_query($conexion,$sqlUpdate);
            $alertMensaje = 'Prepedido cargado';
            
        }	
    }

    
}

echo'<script type="text/javascript">
alert("'.$alertMensaje.'");
window.location.href="transferencia1_sal.php";
</script>';
?>