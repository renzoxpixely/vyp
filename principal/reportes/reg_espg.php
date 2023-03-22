<?php 
//ini_set('max_execution_time', 900);
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<?php 
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>
<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$date   = date('d/m/Y');
$hour  = date(G);  
//$hour   = CalculaHora($hour);
$min	= date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$val    = $_REQUEST['val'];
$vals   = $_REQUEST['vals'];
$desc   = $_REQUEST['desc'];
$desc1  = $_REQUEST['desc1'];
$date1  = $_REQUEST['date1'];
$date2  = $_REQUEST['date2'];
$doc  = $_REQUEST['doc'];
$ck     = $_REQUEST['ck'];
$ck1    = $_REQUEST['ck1'];
$ckloc  = $_REQUEST['ckloc'];
$ckprod = $_REQUEST['ckprod'];
$local  = $_REQUEST['local'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];

$dat1	 = $date1;
$dat2	 = $date2;
$date1	 = fecha1($dat1);
$date2   = fecha1($dat2);
$registros  = $_REQUEST['registros'];
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
if ($local <> 'all')
{
	$sql="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql); 
	while ($row = mysqli_fetch_array($result)){ 
	$nloc	= $row["nomloc"];
	$nombre	= $row["nombre"];
		if ($nombre == '')
		{
		$locals = $nloc;
		}
		else
		{
		$locals = $nombre;
		}
	}
}
?>
<body>
<table width="930" border="0" align="center">
  <tr>
    <td>
     <table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td width="380">
            <div align="center">
                <strong>REPORTE ESPECIAL - 
                    <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $locals;}?>
                </strong>
            </div>
        </td>
        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>

    </table>
      <table width="914" border="0">
        <tr>
          <td width="134"><strong>PAGINA <?php echo $pagina;?> de <?php echo $tot_pag?></strong></td>
          <td width="633"><div align="center"><b><?php if ($val == 1){?>NRO DE VENTA ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?> FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php echo $dat2; }?></b></div></td>
          <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
        </tr>
      </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<?php 
if ($ckprod == 1)
{
?>




<!--nooo-->
<?php	
}
else
{
if (($ck == '') && ($ck1 == '')){
if (($val == 1) || ($vals == 2) )
{
?>
<table width="555" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <table width="926" border="0" align="center">
            <TR>
            <center> <h2>VENTAS ESPECIALES</h2></center>
           
        
        </TR>
    </table></td>
  </tr>
</table>

<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        
        
	<?php if ($val == 1){
		    if ($local == 'all'){
                    if($doc==1){
                        $sql="SELECT venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'    and estado = '0'  and medico.codcolegiatura<>0 and medico.codmed >0  order by venta.nrovent";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'    and estado = '0'   and detalle_venta.prisal <'0'  order by venta.nrovent";  
                        }
                        
       
                        }
		else{
                    if($doc==1){
                        $sql="SELECT venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'  and venta.sucursal = '$local'  and estado = '0' and medico.codcolegiatura<>0 and medico.codmed >0 and medico.codcolegiatura<>0  order by venta.nrovent";   
                        
                        }
                    if($doc==2){
                        $sql="select venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'  and venta.sucursal = '$local'  and estado = '0'  and detalle_venta.prisal <'0'  order by venta.nrovent";  
                        }
                        
                            }

                       }
                
                
                if ($vals == 2){
                   if ($local == 'all'){
                    if($doc==1){
//                        $sql="SELECT  detalle_venta.cuscod,venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.invfec between  '$date1' and '$date2'    and estado = '0'    and venta.codmed <>''  order by venta.nrovent";   
                        $sql="SELECT V.invnum,V.nrovent,V.sucursal,V.invfec,V.cuscod,V.usecod,V.codmed FROM venta as V WHERE V.invfec between '$date1' and '$date2' and codmed <> '' GROUP BY V.invnum ORDER BY V.nrovent ";   
                        }
                    if($doc==2){
                        $sql="SELECT detalle_venta.cuscod,venta.sucursal,venta.codmed,venta.invfec,medico.nommedico,medico.codcolegiatura FROM medico INNER JOIN venta on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and estado = '0' and producto.codprobonif <>'0' order by venta.nrovent ";  
                        }
                        }
		else{
                    if($doc==1){
//                        $sql="SELECT  detalle_venta.cuscod,venta.sucursal,venta.invfec,cliente.descli,cliente.telcli,medico.nommedico,medico.codcolegiatura   FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.invfec between  '$date1' and '$date2'  and venta.sucursal = '$local'  and estado = '0'  and medico.codcolegiatura<>0 and medico.codmed >0  and medico.codcolegiatura<>0 order by venta.nrovent";   
                        $sql="SELECT V.invnum,V.nrovent,V.sucursal,V.invfec,V.cuscod,V.usecod,V.codmed FROM venta as V WHERE V.invfec between '$date1' and '$date2' and V.sucursal = '$local' and codmed <> '' GROUP BY V.invnum ORDER BY V.nrovent ";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT detalle_venta.cuscod,venta.sucursal,venta.codmed,venta.invfec,medico.nommedico,medico.codcolegiatura FROM medico INNER JOIN venta on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and venta.sucursal = '$local' and estado = '0' and producto.codprobonif <>'0' order by venta.nrovent ";  
                        }
                    }
                        }
	$zz = 0;
	$i  = 0;
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
            <tr bgcolor="#77b9f7" height="30">
                <?php if ($ckloc == 1){?>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;" width="30"><strong>LOCAL</strong></th><?php }?>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>FECHA DE EMISION </strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong> NOMBRE DEL CLIENTE </strong></div></th>
           	<th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>TELEFONO CLIENTE</strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>NOM. DE MEDICO</strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>N&ordm; COLEGIATURA </strong></div></th>
				  
            </tr>
      <?php while ($row = mysqli_fetch_array($result)){
		$invnum   = $row['invnum'];
		$nrovent  = $row['nrovent'];
		$sucursal = $row['sucursal'];
		$invfec   = $row['invfec'];
		$cuscod   = $row['cuscod']; //CLIENTE
		$usecod   = $row['usecod']; //USUARIO
		$codmed   = $row['codmed']; //MEDICO

		
		$i++;
		$ssss[$i]  = $sucursal;
		if ($sucursal <> $suc[$zz]){
		$zz++;
		$suc[$zz] = $sucursal;}
		$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                $result3 = mysqli_query($conexion,$sql3); 
                while ($row3 = mysqli_fetch_array($result3)){ 
                $nloc	= $row3["nomloc"];
                $nombre	= $row3["nombre"];
                        if ($nombre == ''){
                        $sucur = $nloc;}
                        else{
                        $sucur = $nombre;}}
                
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];}}
			
			
               $sql1="SELECT descli,telcli,dnicli,ruccli FROM cliente where codcli = '$cuscod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row = mysqli_fetch_array($result1)){
			$descli   = $row['descli'];
		        $telcli = $row["telcli"];
		        $dnicli	   = $row["dnicli"];
                        $ruccli   = $row["ruccli"];
		    
		}}  
                
               $sql1="SELECT codmed,codcolegiatura,nommedico FROM medico where codmed = '$codmed'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row = mysqli_fetch_array($result1)){
			$codcolegiatura   = $row['codcolegiatura'];
		        $nommedico = $row["nommedico"];
		    
		}}         
                      
		  ?>
			
                        <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                             <?php if ($ckloc == 1){?><td width="30"><?php echo $sucur?></td><?php }?>
                            <!--<td width="300"><div align="center"><?php // echo $invnum;?></div></td>-->
                            <td width="80"><div align="center"><?php echo fecha($invfec)?></div></td>
                             <td width="235"><div align="left"><?php echo $descli ?></div></td>
                             <td width="155">
                             
                             <div align="CENTER">
                                <?php   if($telcli==""){
                             $reso="--------";
                             echo "<p class='Estilo1'><strong>$reso</strong></p>";
                            }else{
                             echo "$telcli";
                            }?>
                            </div>
                             </td>  
                             
                             <td width="235"><div align="left"><?php echo $nommedico ?></div></td>
                             <td width="105"><div align="CENTER"><?php echo $codcolegiatura?></div></td>
                        </tr>
                        
                        
                        
                  <?php }?>
    </table>
	<?php if ($zz == 1){
		?>
<!--		  <table width="926" border="0" align="center">
			   <tr bgcolor="#CCCCCC">
				<td width="280"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($gravado1, 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($inafecto1, 2, '.', ' ');?></div></td>
              			<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($igv1, 2, '.', ' ');?></div></td>
              			<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($TOT1, 2, '.', ' ');?></div></td>
            		</tr>
                                
			  </tr>
	  </table>-->
		<?php }else{?>
<!--		  <table width="926" border="0" align="center">
            <tr bgcolor="#CCCCCC">
			 
				<td width="450"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($gravado1, 2, '.', ' ');?></div></td>
                                <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($habil_inafecto12[$zz], 2, '.', ' ');?></div></td>

              			<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($igv1, 2, '.', ' ');?></div></td>
              			<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($TOT1, 2, '.', ' ');?></div></td>
            		</tr>
          </table>-->
		  <?php }}
                  
                  
                  else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
  
  

  
</table>
<?php }}?>

<?php if (($ck == 1) || ($ck1 == 1))
    {
    
if (($val == 1) || ($vals == 2)){?>

<table width="950" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr style="border: solid 1px #000000;">
    <td>
        
        
	<?php if ($val == 1){
		     if ($local == 'all'){
                          if($doc==1){
                        $sql="SELECT venta.usecod,venta.invfec,medico.codcolegiatura,medico.nommedico,venta.invnum,cliente.descli,cliente.telcli,detalle_venta.codpro, detalle_venta.codmar,venta.invtot,venta.sucursal  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'      and estado = '0'  and medico.codcolegiatura<>0 and medico.codmed >0  order by venta.nrovent";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT venta.usecod,venta.invfec,medico.codcolegiatura,medico.nommedico,venta.invnum,cliente.descli,cliente.telcli,detalle_venta.codpro, detalle_venta.codmar,venta.invtot,venta.sucursal   FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'     and estado = '0'  and detalle_venta.prisal <'0'  order by venta.nrovent";  
                        }
                        }
		else{
                      if($doc==1){
                        $sql="SELECT venta.usecod,venta.invfec,medico.codcolegiatura,medico.nommedico,venta.invnum,cliente.descli,cliente.telcli,detalle_venta.codpro, detalle_venta.codmar,venta.invtot,venta.sucursal   FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'  and venta.sucursal = '$local'  and estado = '0'  and medico.codcolegiatura<>0 and medico.codmed >0  order by venta.nrovent";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT venta.usecod,venta.invfec,medico.codcolegiatura,medico.nommedico,venta.invnum,cliente.descli,cliente.telcli,detalle_venta.codpro, detalle_venta.codmar,venta.invtot,venta.sucursal  FROM medico  INNER JOIN venta  on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN cliente on detalle_venta.cuscod=cliente.codcli where venta.nrovent between  '$desc' and '$desc1'  and venta.sucursal = '$local'  and estado = '0'   and detalle_venta.prisal <'0'  order by venta.nrovent";  
                        }
                            
                            } }
                
                
                if ($vals == 2){
                   if ($local == 'all'){
                          if($doc==1){
//                        $sql="(SELECT DV.invnum, DV.invfec,DV.codpro,DV.codmar FROM detalle_venta AS DV WHERE DV.invfec between '$date1' and '$date2') UNION ALL (SELECT DNV.invnum, DNV.invfec,DNV.codpro,DNV.codmar FROM venta_nosave_detalle AS DNV WHERE DNV.invfec between '$date1' and '$date2')  ";   
//                        $sql="(SELECT DV.invnum, DV.invfec FROM detalle_venta AS DV WHERE DV.invfec between '$date1' and '$date2') UNION ALL (SELECT DNV.invnum, DNV.invfec FROM venta_nosave_detalle AS DNV WHERE DNV.invfec between '$date1' and '$date2') UNION ALL (SELECT V.invnum, V.invfec FROM venta AS V WHERE V.invfec between '$date1' and '$date2' and  V.codmed > 0) ORDER BY invnum";   
//                        $sql="SELECT * FROM `detalle_venta` AS DV INNER JOIN venta AS V ON V.invnum=DV.invnum WHERE V.invfec between '$date1' and '$date2' and V.codmed > 0 ORDER BY V.invnum ";   
                        $sql="(SELECT DV.invnum,DV.invfec,V.codmed,DV.codpro,DV.codmar,V.invtot,V.cuscod,V.usecod FROM `detalle_venta` AS DV INNER JOIN venta AS V ON V.invnum=DV.invnum WHERE V.invfec between '$date1' and '$date2' and V.codmed > 0 ORDER BY V.invnum ) UNION ALL ( SELECT DNV.invnum,DNV.invfec,V.codmed,DNV.codpro,DNV.codmar,V.invtot,V.cuscod,V.usecod FROM `venta_nosave_detalle` AS DNV INNER JOIN venta_nosave as VN on VN.invnum=DNV.invnum INNER JOIN venta as V ON V.invnum=VN.invnum WHERE V.invfec between '$date1' and '$date2' AND V.codmed <> '' )";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT venta.invnum,venta.usecod,detalle_venta.cuscod,venta.sucursal,venta.invfec,medico.nommedico,medico.codcolegiatura,detalle_venta.codpro,detalle_venta.codmar,venta.invtot FROM medico INNER JOIN venta on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and estado = '0' and producto.codprobonif <>'0' order by venta.nrovent ";  
                        }
                        }
		else{
                      if($doc==1){
                        $sql="(SELECT V.sucursal,DV.invnum,DV.invfec,V.codmed,DV.codpro,DV.codmar,V.invtot,V.cuscod,V.usecod FROM `detalle_venta` AS DV INNER JOIN venta AS V ON V.invnum=DV.invnum WHERE V.sucursal='$local' AND V.invfec between '$date1' and '$date2' and V.codmed > 0 ORDER BY V.invnum ) UNION ALL ( SELECT V.sucursal,DNV.invnum,DNV.invfec,V.codmed,DNV.codpro,DNV.codmar,V.invtot,V.cuscod,V.usecod FROM `venta_nosave_detalle` AS DNV INNER JOIN venta_nosave as VN on VN.invnum=DNV.invnum INNER JOIN venta as V ON V.invnum=VN.invnum WHERE V.sucursal='$local' AND V.invfec between '$date1' and '$date2' AND V.codmed <> '' )";   
                        
                        }
                    if($doc==2){
                        $sql="SELECT venta.invnum,venta.usecod,detalle_venta.cuscod,venta.sucursal,venta.invfec,medico.nommedico,medico.codcolegiatura,detalle_venta.codpro,detalle_venta.codmar,venta.invtot FROM medico INNER JOIN venta on medico.codmed=venta.codmed INNER JOIN detalle_venta AS detalle_venta ON venta.invnum=detalle_venta.invnum INNER JOIN producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2'  and venta.sucursal = '$local' and estado = '0' and producto.codprobonif <>'0' order by venta.nrovent ";  
                        }
                            
                            }

                        }
               
                                       
	$zz = 0;
	$i  = 0;
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="950" border="0" align="center">
            
            
            <tr bgcolor="#77b9f7" height="30">
                <?php if ($ckloc == 1){?><th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;" width="30"><strong>LOCAL</strong></th><?php }?>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="left"><strong>F. DE EMISION </strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="left"><strong>  N&ordm; VENTA </strong></div></th>
           	<th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>PRODUCTO</strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>LABORATORIO</strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>VENDEDOR </strong></div></th>
                <th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>NOM. MEDICO </strong></div></th>
		<th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align="center"><strong>  N&ordm; COLEGIA </strong></div></th>
		<th style="border: solid 1px #2c70af ;color:#fff;font-size: 13px;"><div align=""><strong>CAN. VEN</strong></div></th>
				  
            </tr>
      <?php while ($row = mysqli_fetch_array($result)){
		$nommedico      = $row['nommedico'];
		$invfec         = $row['invfec'];
		$descli         = $row['descli'];
		$telcli         = $row["telcli"];
		$invnumX         = $row["invnum"];
		$usecod         = $row["usecod"];
		$sucursal	= $row["sucursal"];
		$nrofactura	= $row["nrofactura"];
		$dnicli         = $row["dnicli"];
                $ruccli         = $row["ruccli"];
		$codmed         = $row["codmed"];
		$codcolegiatura = $row["codcolegiatura"];
		$codpro         = $row["codpro"];
		$codmar         = $row["codmar"];
		$invtot        = $row["invtot"];
		$invtot2        += $row["invtot"];
                
                
              
              $sql1="SELECT sucursal,cuscod,usecod,codmed,invtot FROM venta where invnum = '$invnumXGD'  ";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$sucursal    = $row1['sucursal'];
                        $cuscod      = $row1['cuscod']; //CLIENTE
                        $usecod      = $row1['usecod']; //USUARIO
                        $codmed      = $row1['codmed']; //MEDICO
                        $invtot      = $row1["invtot"];
                        $invtot2     += $row1["invtot"];
                
                        
                }}
              
                
                
              $sql1="SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$destab    = $row1['destab'];
			$abrev    = $row1['abrev'];
                        
                }}
                
                $sql1="SELECT desprod FROM producto where codpro =  '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$desprod    = $row1['desprod'];}}

                $sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$userxx    = $row1['nomusu'];}}
                        
//		$i++;
		
		$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
				$nloc	= $row3["nomloc"];
				$nombre	= $row3["nombre"];
					if ($nombre == ''){
					$sucur = $nloc;}
					else{
					$sucur = $nombre;}}
		
	
                 $sql1="SELECT codmed,codcolegiatura,nommedico FROM medico where codmed = '$codmed'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row = mysqli_fetch_array($result1)){
			$codcolegiatura   = $row['codcolegiatura'];
		        $nommedico = $row["nommedico"];
		    
		}}           
		
			
		  ?>
			
		  <?php // }}?>
            <?PHP // IF ($invtot > 0){?>
                       <tr height="40" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                            <?php if ($ckloc == 1){?><td width="20"><?php echo $sucur?></td><?php }?>
                            <!--<td width="10"><div align="LEFT"><?php echo $invnumX?></div></td>-->
                            <td width="10"><div align="LEFT"><?php echo fecha($invfec)?></div></td>
                            <td width="30"><div align="CENTER"><?php echo $invnumX?></div></td>
                            <td width="30"><div align=""><?php echo $desprod?></div></td>
                            <td width="20"><div align="left"><?php echo $destab?></div></td>
    			    <td width="60"><div align="LEFT"><?php echo $userxx?></div></td>
			    <td width="70"><div align="LEFT"><?php echo $nommedico?></div></td>
                            <td width="30"><div align="center"><?php echo $codcolegiatura?></div></td>
                            <td width="30"><div align="right"><?php echo $invtot?></div></td>
                        </tr>
      <?PHP // }?>
                  <?php }?>
<!--                        <tr height="40" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                            
                            <td style="font-size: 19px;" colspan="8"  width="30" ><div align="center"><strong>TOTAL</strong>    </div></td>
                            <td  width="30"><div align="right"><?php echo $invtot2?></div></td>
                        </tr>-->
    </table>
	
		  <?php }
                  
                  else{?>
        
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
  
  <!--A-->
  
  
</table>
<?php }                 }       }   ?>



</body>
</html>
