<?php 
require_once('../../session_user.php');
require_once('../../../conexion.php');

$sql1="SELECT priceditable FROM datagen_det";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1))
{
    while ($row1 = mysqli_fetch_array($result1))
    {
        $priceditable   = $row1['priceditable'];
    }
}
$venta      = $_SESSION['venta'];
$date       = date("Y-m-d");
$text1	 	= $_REQUEST['text1']; //CANTIDAD
$text3	 	= $_REQUEST['text3'];
$factor	 	= $_REQUEST['factor'];
$numero	 	= $_REQUEST['numero'];
$cant_prod	= $_REQUEST['cant_prod'];
$codpro   	= $_REQUEST['codpro'];
$pcostouni	= $_REQUEST['pcostouni'];

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

//SI NUMERO = 0 ES NUMERO SI NO ES LETRA O CAJA
require_once('funciones/datos_generales.php'); 

$cantventaparabonificar = "";
$codprobonif            = "";
$cantbonificable        = "";

$sqlPRODT       = "SELECT $tabla FROM producto where codpro = '$codpro'";
$resultPRODT    = mysqli_query($conexion,$sqlPRODT);
if (mysqli_num_rows($resultPRODT))
{
    while ($row = mysqli_fetch_array($resultPRODT))
    {
        $cant_prod  = $row[0];
    }
}

    $repetido = 0;  ////// NO ESTA EN LA BASE DE DATOS

$popupMostrado = 0;
$sqlCLI="SELECT cuscod,invfec,sucursal FROM venta where invnum = '$venta'";
$resultCLI = mysqli_query($conexion,$sqlCLI);
if (mysqli_num_rows($resultCLI))
{
    while ($row1 = mysqli_fetch_array($resultCLI))
    {
        $cuscod             = $row1['cuscod'];
        $invfec             = $row1['invfec'];
        $sucursal           = $row1['sucursal'];
    }
}
            
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars,"",$str);
}

if ($repetido == 0)
{
    if ($numero == 1) ///// NO ES NUMERO ES UNA LETRA C 14 - precio de CAJA
    {
        $text2      = $_REQUEST['textprevta'];
        //TODAS LAS CONSULTAS SERAN EN BASE A CAJAS						
        $text1 		= convertir_a_numero($text1); ////EJEMPLO: C4 = 4 CAJAS
        $caja_bonifi    = $text1;
        $cantreal 	= $text1; //CANTIDAD
        $text1 		= $text1 * $factor;
        $cantidades     = $text1;
        $tt 		= 1;
    }
    else /////ES NUMERO Y SON UNIDADES
    {
        //$text2   	= $_REQUEST['text2'];
        if ($priceditable == 1)
        {
            $text2   	= $_REQUEST['text222'];
            if ($text2 =="") {
                $text2   	= $_REQUEST['text2'];
            }
        }
        else
        {
            $text2	= $_REQUEST['text2'];
        }
        $cantidades     = $text1;
    }
//    if ($cantidades <> 0)
//    {
        if ($cantidades > $cant_prod) ////NO HAY STOCK PARA ESTE PRODUCTO
        {
            $agotado = $cantidades - $cant_prod;
            $agot    = 1;
        }
        else /////HAY STOCK PARA ESTE PRODUCTO
        {
            $agot    = 0;
        }
        
        $sql="SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$codpro'";
        $result = mysqli_query($conexion,$sql);
        if (mysqli_num_rows($result)){
            while ($row = mysqli_fetch_array($result)){
                $codpro                 = $row['codpro'];
                $stopro                 = $row['stopro'];
                $codmar                 = $row['codmar'];
                $costpr                 = $row['costpr'];
                $codfam                 = $row['codfam'];
                $coduso                 = $row['coduso'];
                $factor                 = $row['factor'];
                $cant_loc               = $row[7];
                $cantventaparabonificar = $row['cantventaparabonificar'];
                $codprobonif            = $row['codprobonif'];
                $cantbonificable        = $row['cantbonificable'];
                if (($codprobonif <> 0) || ($codprobonif <> ""))
                {
                    if (!is_numeric($cantventaparabonificar))
                    {
                        $cantventaparabonificar = convertir_a_numero($cantventaparabonificar) * $factor;
                    }
                }
                
            }
        }
        
        if ($numero == 1) ///// NO ES NUMERO ES UNA LETRA = CAJA
        {
        }
        else
        {
            //FRACCION
            if ($factor > 1)
            {
                $costpr = $costpr/$factor;
            }
        }
        
        if ($agot == 0) /////HAY STOCK PARA ESTE PRODUCTO
        {
            if ($numero == 1) ///// NO ES NUMERO ES UNA LETRA 
            {
                $permitido       = $cantreal;
                $strFactor       = "F";
            }
            else
            {
                if ($cantidades <> 0)
    {
                $permitido       = $cantidades;
                $strFactor       = "T";
                $pcostouni       = $pcostouni/($factor * $cantidades);
            }}
            
            $total_local     = $cant_loc - $cantidades;
            $total_general   = $stopro - $cantidades;
        }
        else
        {
            //NO HAY STOCK
            $permitido       = $cant_loc;
            $strFactor       = "T";
            //$pcostouni     = $pcostouni/($factor * $permitido);
            if ($priceditable == 1)
            {
                $text2   	= $_REQUEST['text222'];
                if ($text2 =="") {
                    $text2   	= $_REQUEST['text2'];
                }
            }
            else
            {
                $text2	= $_REQUEST['text2'];
            }
            $cantidades     = $text1; 
			$text3			 = $text2 * $permitido;
            //$pc            = ($text3*$cant_loc)/$factor;
            if ($cant_loc <> 0)
            {
                $pcunit      = $pc/$cant_loc;
            }
            else
            {
                $pcunit      = 0;
            }
            $total_local     = $cant_loc - $cant_loc;
            $total_general   = $stopro - $cant_loc;
            $ppc             = $agotado * $pcunit;
        }
        
        error_log("cantventaparabonificar 1: ". $cantventaparabonificar );
        error_log("cantidades 1: ". $cantidades );
//        if (($cantidades <> "") || ($cantidades <> 0))
//        {
            //ES NUMERO
            if ($numero == 0)
            {
                //ES NUMERO -> T
                if ($cant_prod <> 0)
                {
                    if ($agot == 1)
                    {
                        //AGOTADOS
                        error_log("Log 1: ". $text2 );
                        $detalle_venta['invnum'] = $venta;
                        $detalle_venta['invfec'] = $date;
                        $detalle_venta['cuscod'] = $cuscod;
                        $detalle_venta['usecod'] = $usuario;
                        $detalle_venta['codpro'] = $codpro;
                        $detalle_venta['canpro'] = $permitido;
                        $detalle_venta['fraccion'] = $strFactor;
                        $detalle_venta['factor'] = $factor;
                        $detalle_venta['prisal'] = $text2;
                        $detalle_venta['pripro'] = $text3;
                        $detalle_venta['codmar'] = $codmar;
                        $detalle_venta['cospro'] = $pcostouni;
                        $detalle_venta['costpr'] = $costpr;
                        
                        $arr_detalle_venta[] = $detalle_venta;

                        end($arr_detalle_venta);  
                        $key = key($arr_detalle_venta); 
                        $lastDetVentaId = $key;
                        error_log("Log 1: ". $lastDetVentaId );
                    }
                    else
                    {
                        //HAY STOCK
                        error_log("Log 2: ". $text2 );

                        $detalle_venta['invnum'] = $venta;
                        $detalle_venta['invfec'] = $date;
                        $detalle_venta['cuscod'] = $cuscod;
                        $detalle_venta['usecod'] = $usuario;
                        $detalle_venta['codpro'] = $codpro;
                        $detalle_venta['canpro'] = $permitido;
                        $detalle_venta['fraccion'] = $strFactor;
                        $detalle_venta['factor'] = $factor;
                        $detalle_venta['prisal'] = $text2;
                        $detalle_venta['pripro'] = $text3;
                        $detalle_venta['codmar'] = $codmar;
                        $detalle_venta['cospro'] = $pcostouni;
                        $detalle_venta['costpr'] = $costpr;
                        
                        $arr_detalle_venta[] = $detalle_venta;
                        
                        end($arr_detalle_venta);  
                        $key = key($arr_detalle_venta); 
                        $lastDetVentaId = $key;
                        error_log("Log 2: ". $lastDetVentaId );
                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                    }
                    //BONIFICADO****************************************
                    //PERMITIDO ES LA CANTIDAD
                    if (strlen($codprobonif)>0 && $cantbonificable>0)
                    {
                        //TEXT1 CANTIDAD CAJA O INDIVIDUAL
                        if ($cantidades >= $cantventaparabonificar)
                        {
                            //INSERTA UN DETALLE PARA BONIFICADO
                            $sqlB="SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                            $resultB = mysqli_query($conexion,$sqlB);
                            if (mysqli_num_rows($resultB)){
                                while ($rowB = mysqli_fetch_array($resultB)){
                                    $codproB                = $rowB['codpro'];
                                    $stoproB                = $rowB['stopro'];	
                                    $cant_locB              = $rowB[2];
                                    $factorB                = $rowB['factor'];
                                    $codmarB                = $rowB['codmar'];
                                    error_log("DATOS 1: ". $cantbonificable. " ".$cantventaparabonificar. " ". $text1 );
                                    if (!is_numeric($cantbonificable))
                                    {
                                        $cantbonificable        = convertir_a_numero($cantbonificable);
                                    } 
                                    $factorBonif = floor($text1 / $cantventaparabonificar);
                                    error_log("DATOS 1: ". $factorBonif );
                                    $cantbonificable        = $factorBonif * $cantbonificable;
                                
                                    error_log("DATOS 1: ". $cantbonificable );

                                    //SI HAY STOCK PARA LA BONIFICACION
                                    if ($cantbonificable <= $cant_locB)
                                    {
                                        $cantDescontar = $cant_locB - $cantbonificable;

                                        $detalle_venta['invnum'] = $venta;
                                        $detalle_venta['invfec'] = $date;
                                        $detalle_venta['cuscod'] = $cuscod;
                                        $detalle_venta['usecod'] = $usuario;
                                        $detalle_venta['codpro'] = $codprobonif;
                                        $detalle_venta['canpro'] = $cantbonificable;
                                        $detalle_venta['fraccion'] = 'T';
                                        $detalle_venta['factor'] = $factorB;
                                        $detalle_venta['prisal'] = '0';
                                        $detalle_venta['pripro'] = '0';
                                        $detalle_venta['codmar'] = $codmarB;
                                        $detalle_venta['cospro'] = '0';
                                        $detalle_venta['costpr'] = '0';
                                        $detalle_venta['bonif2'] = '1';
                                        
                                        $arr_detalle_venta[] = $detalle_venta;

                                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;

                                        header("Location: venta_index4_reg.php");
                                    } else {
                                        error_log("NO HAY STOCK PARA BONIF " );
                                        echo("<script LANGUAGE='JavaScript'>
                                            if (confirm('No existe stock suficiente para agregar bonificaciÃ³n. Â¿Desea continuar?') == true) {
                                                document.location='venta_index4_reg.php?numero=$numero&agot=$agot&cuscod=$cuscod&codpro=$codpro&agotado=$agotado&invfec=$invfec&pcunit=$pcunit&factor=$factor&sucursal=$sucursal&usuario=$usuario&codmar=$codmar&codfam=$codfam&coduso=$coduso&ppc=$ppc';
                                            } else {
                                                document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                            }                                
                                            </script>");
                                            $popupMostrado = 1;
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
            else
            {
                //NO ES NUMERO
                //EMPIEZA CON C - F
                if ($cant_prod <> 0)
                {
                    if ($agot == 1)
                    {
                        error_log("Log 3: ". $pcunit );
                        //AGOTADOS
                        
                        $detalle_venta['invnum'] = $venta;
                        $detalle_venta['invfec'] = $date;
                        $detalle_venta['cuscod'] = $cuscod;
                        $detalle_venta['usecod'] = $usuario;
                        $detalle_venta['codpro'] = $codpro;
                        $detalle_venta['canpro'] = $permitido;
                        $detalle_venta['fraccion'] = $strFactor;
                        $detalle_venta['factor'] = $factor;
                        $detalle_venta['prisal'] = $pcunit;
                        $detalle_venta['pripro'] = $pc;
                        $detalle_venta['codmar'] = $codmar;
                        $detalle_venta['cospro'] = $pcostouni;
                        $detalle_venta['costpr'] = $costpr;
                        
                        $arr_detalle_venta[] = $detalle_venta;
                        
                        end($arr_detalle_venta);  
                        $key = key($arr_detalle_venta); 
                        $lastDetVentaId = $key;
                        error_log("Log 3: ". $lastDetVentaId );
                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;

                    }
                    else
                    {
                        error_log("Log 4: ". $text2 );
                        //HAY STOCK
                        $detalle_venta['invnum'] = $venta;
                        $detalle_venta['invfec'] = $date;
                        $detalle_venta['cuscod'] = $cuscod;
                        $detalle_venta['usecod'] = $usuario;
                        $detalle_venta['codpro'] = $codpro;
                        $detalle_venta['canpro'] = $permitido;
                        $detalle_venta['fraccion'] = $strFactor;
                        $detalle_venta['factor'] = $factor;
                        $detalle_venta['prisal'] = $text2;
                        $detalle_venta['pripro'] = $text3;
                        $detalle_venta['codmar'] = $codmar;
                        $detalle_venta['cospro'] = $pcostouni;
                        $detalle_venta['costpr'] = $costpr;
                        
                        $arr_detalle_venta[] = $detalle_venta;
                        
                        end($arr_detalle_venta);  
                        $key = key($arr_detalle_venta); 
                        $lastDetVentaId = $key;
                        error_log("Log 4: ". $lastDetVentaId );
                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;

                    }
                    //BONIFICADO****************************************
                    //PERMITIDO ES LA CANTIDAD
                    if (strlen($codprobonif)>0 && $cantbonificable>0)
                    {
                        if ($permitido >= $cantventaparabonificar)
                        {
                            //INSERTA UN DETALLE PARA BONIFICADO
                            $sqlB="SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                            $resultB = mysqli_query($conexion,$sqlB);
                            if (mysqli_num_rows($resultB)){
                                while ($rowB = mysqli_fetch_array($resultB)){
                                    $codproB                = $rowB['codpro'];
                                    $stoproB                = $rowB['stopro'];	
                                    $cant_locB              = $rowB[2];
                                    $factorB                = $rowB['factor'];
                                    $codmarB                = $rowB['codmar'];
                                    error_log("DATOS 2: ". $cantbonificable. " ".$cantventaparabonificar. " ". $text1 );
                                        if (!is_numeric($cantbonificable))
                                        {
                                            $cantbonificable        = convertir_a_numero($cantbonificable);
                                        } 
                                        $factorBonif = floor($text1 / $cantventaparabonificar);
                                        error_log("DATOS 2: ". $factorBonif );
                                        $cantbonificable        = $factorBonif * $cantbonificable;
                                    
                                        error_log("DATOS 2: ". $cantbonificable );

                                    //SI HAY STOCK PARA LA BONIFICACION
                                    if ($cantbonificable <= $cant_locB)
                                    {
                                        $cantDescontar = $cant_locB - $cantbonificable;
                                        
                                        $detalle_venta['invnum'] = $venta;
                                        $detalle_venta['invfec'] = $date;
                                        $detalle_venta['cuscod'] = $cuscod;
                                        $detalle_venta['usecod'] = $usuario;
                                        $detalle_venta['codpro'] = $codprobonif;
                                        $detalle_venta['canpro'] = $cantbonificable;
                                        $detalle_venta['fraccion'] = 'T';
                                        $detalle_venta['factor'] = $factorB;
                                        $detalle_venta['prisal'] = '0';
                                        $detalle_venta['pripro'] = '0';
                                        $detalle_venta['codmar'] = $codmarB;
                                        $detalle_venta['cospro'] = '0';
                                        $detalle_venta['costpr'] = '0';
                                        $detalle_venta['bonif2'] = '1';
                                        
                                        $arr_detalle_venta[] = $detalle_venta;
                                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;

                                        header("Location: venta_index4_reg.php");
                                    } else {
                                        error_log("NO HAY STOCK PARA BONIF " );
                                        echo("<script LANGUAGE='JavaScript'>
                                            if (confirm('No existe stock suficiente para agregar bonificaciÃ³n. Â¿Desea continuar?') == true) {
                                                document.location='venta_index4_reg.php?numero=$numero&agot=$agot&cuscod=$cuscod&codpro=$codpro&agotado=$agotado&invfec=$invfec&pcunit=$pcunit&factor=$factor&sucursal=$sucursal&usuario=$usuario&codmar=$codmar&codfam=$codfam&coduso=$coduso&ppc=$ppc';
                                            } else {
                                                document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                            }                                
                                            </script>");
                                        $popupMostrado = 1;
                                    }
                                }
                            }
                        } 
                    }
                }
            }
            
//        }
//    }
}

mysqli_close($conexion);
if ($popupMostrado != 1) {
    header("Location: venta_index2.php");
}

?>