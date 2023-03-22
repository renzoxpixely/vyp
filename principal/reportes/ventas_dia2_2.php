<?php 
require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
 //require_once("../../funciones/calendar.php");
 require_once('../../funciones/highlight.php');
 require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
 require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
 require_once("local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS








function pintaDatos($Valor)
{
    if ($Valor<> "")
    {
        return "<tr><td style:'text-align:center'><center>".$Valor."</center></td></tr>";
    }
}
function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp"> 
<script>
function imprimir()
{
   
    window.print();
    window.history.go(-2)
    
    f.submit();
}
</script>
<style type="text/css">
    body, table
    {
         line-height: 80%
      
    }
    
    .letras{
        font-size:22px;
    }
    .letras1{
        font-size:15px;
    }
    .letras12{
        font-size:20px;
        
        font-weight: 700px;
       
    }
</style>
<style>
    body, table
    {   
        font-family:courier;
        font-size:6px;
        font-weight: normal;
    }
</style>


    <style type="text/css" media="print">
    div.page { 
    writing-mode: tb-rl;
    height: 80%;
    margin: 10% 0%;
    }
    </style>


</head>
<body onload="imprimir()">

    
        
   <style type="text/css">
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
</style>

<script>
function printLayer(Layer){
    var generator=window.open(",'name,'");
    var layertext=document.getElementById(Layer) ;
    generator.document.write(layertext.innerHTML.replace("Print Me"));
    generator.document.close();
    generator.print();
    generator.close();



}

</script>
<?php

  
    
$val   = $_REQUEST['val'];
$vals  = $_REQUEST['vals'];
$valTipoDoc  = $_REQUEST['valTipoDoc'];
$desc  = $_REQUEST['desc'];
$desc1 = $_REQUEST['desc1'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$tipoDoc = $_REQUEST['tipoDoc'];
$from = $_REQUEST['from'];
$until = $_REQUEST['until'];
$report= $_REQUEST['report'];
$ck    = $_REQUEST['ck'];
$ck1   = $_REQUEST['ck1'];
$ck2   = $_REQUEST['ck2'];
$ckloc = $_REQUEST['ckloc'];
$ckprod = $_REQUEST['ckprod'];
$local = $_REQUEST['local'];


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
if ($local <> 'all'){
	$sql="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql); 
	while ($row = mysqli_fetch_array($result)){ 
	$nloc	= $row["nomloc"];
	$nombre	= $row["nombre"];
		if ($nombre == ''){
		$locals = $nloc;}
		else{
		$locals = $nombre;}
	}}
$dat1 = $date1;
$dat2 = $date2;
$date1 = fecha1($dat1);
$date2 = fecha1($dat2);




?>


<div class="pagina">
<table width="100%" border="0" align="center">
  <tr>
    <td>
       
     <table width="100%"  height="50" border="0">
      <tr class="letras12">
        <td class="letras12" width="300" height="20"><strong><pre><?php echo $desemp?></pre></strong></td>
        <td class="letras12" width="300" height="20">
            <div align="center" class="letras12">
                <strong><pre>REPORTE DE CIERRE DEL DIA - <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $locals;}?></pre></strong>
            </div>
        </td>
        <td class="letras12" width="260">
            <div class="letras12" align="right">
                <strong><pre>FECHA </pre></strong>
                
               <strong><pre> <?php echo date('d/m/Y');?></pre></strong>
                
            </div>
        </td>
      </tr>
    </table>
    </td>
        
  </tr>
</table>


<?php
if ($ckprod == 1)
{
?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    	<table width="926" border="0" align="center">
      		<tr>
            <td width="57"><div align="left"><strong>TIENDA   </strong></div></td>
            <td width="74"><div align="left"><strong>RESPONSABLE  </strong></div></td>
            <td width="24"><div align="left"><strong>NUMERO</strong></div></td>
            <td width="24"><div align="left"><strong>NUM FISICO</strong></div></td>
            <td width="50"><div align="left"><strong>FECHA</strong></div></td>
            <td width="54"><div align="left"><strong>CLIENTE</strong></div></td>
            <td width="308"><div align="left"><strong>PRODUCTO</strong></div></td>
            <td width="61"><div align="left"><strong>MARCA</strong></div></td>
            <td width="61"><div align="left"><strong>CANTIDAD</strong></div></td>
             <td width="61"><div align="center"><strong>IGV</strong></div></td>
              <td width="61"><div align="left"><strong>GRAVADO</strong></div></td>
            <td width="60"><div align="right"><strong>PRECIO UNI.</strong></div></td>
            <td width="60"><div align="right"><strong>SUB. TOTAL</strong></div></td>
                        <td width="60"><div align="right"><strong>TOTAL</strong></div></td>
      		
            </tr>
      	</table>
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
               <td>
               <?php 
				$zz = 0;
				if ($val == 1){ ///	PRIMER BOTON
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
					$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' order by nrovent group by = nrovent";
					}
					else ///UN SOLO LOCAL
					{
					$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local' order by nrovent";
					}
				} elseif ($vals == 2){ ///	SEGUNDO BOTON 
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
						//echo $date1; echo "<br>";
						//echo $date2;
						$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and invtot <> '0' and estado = '0' order by nrovent";
					}
					else ///UN SOLO LOCAL
					{
						$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' order by nrovent";
					}
				} else { //TERCER BOTON
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
						//echo $date1; echo "<br>";
						//echo $date2;
						$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0' order by sucursal, nrovent";
					}
					else ///UN SOLO LOCAL
					{
						$sql="SELECT venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0' order by sucursal, nrovent";
					}
				}
				error_log("SQL 4: ".$sql);
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				?>
                <table width="926" border="0" align="center">
                    <?php 
					while ($row = mysqli_fetch_array($result)){
						$usecod    = $row['usecod'];
						$invnum    = $row['invnum'];
						$igv        = $row['igv'];
						$gravado    = $row['gravado'];
						$invtot    = $row['invtot'];
						$sucursal  = $row['sucursal'];
						$nrovent   = $row['nrovent'];
						$nrofactura   = $row['nrofactura'];
						$invfec    = fecha($row['invfec']);
						$cuscod    = $row['cuscod'];
						$codpro    = $row['codpro'];
						$codmar    = $row['codmar'];
						$prisal    = $row['prisal'];
						$factor    = $row['factor'];////
						$canpro    = $row['canpro'];////
						$cospro    = $row['costpr'];////
						$fraccion  = $row['fraccion'];/////
						$costpr    = $row['costpr']; //costo del producto x unidad
						
						if ($fraccion == "T")
						{
							$cospro = $costpr;
						}
						else
						{
							$cospro = $costpr;
						}
                                                
						$plista	   = 0;
						$dif = 0;
						//USUARIO
						$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
						$result1 = mysqli_query($conexion,$sql1);
						if (mysqli_num_rows($result1)){
							while ($row1 = mysqli_fetch_array($result1)){
								$nomusu    = $row1['nomusu'];
							}
						}
						//CLIENTE
						$sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
						$result1 = mysqli_query($conexion,$sql1);
						if (mysqli_num_rows($result1)){
							while ($row1 = mysqli_fetch_array($result1)){
								$descli     = $row1['descli'];
							}
						}
						$sql1="SELECT desprod,destab,pdistribuidor,abrev FROM producto inner join titultabladet on codmar = codtab where codpro = '$codpro'";
						$result1 = mysqli_query($conexion,$sql1);
						if (mysqli_num_rows($result1)){
							while ($row1 = mysqli_fetch_array($result1)){
								$desprod    = $row1['desprod'];
								$destab     = $row1['destab'];
								$abrev      = $row1['abrev'];
							if ($abrev <> '')
							{
								$destab = $abrev;
							}
								$pdistribuidor     = $row1['pdistribuidor'];
							}
						}
						$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
						$result3 = mysqli_query($conexion,$sql3); 
						if (mysqli_num_rows($result3)){
							while ($row3 = mysqli_fetch_array($result3)){
								$nloc	= $row3["nomloc"];
								$nombre	= $row3["nombre"];
							}
						}
						$plista	   = $prisal - $costpr;
						$dif 	   = $prisal - $costpr;
						if ($nombre == "")
						{
							$nombre = $nloc;
						}
						if ($prisal < $costpr){
							$color = "#ffffff";
						}
						else
						{
							if ($prisal < $costpr){ 
								$color ="#ffffff";	
							}
							else
							{
								$color ="";	
							}
						}
										
						$sqlDet="SELECT * FROM detalle_venta where invnum = '$invnum'";
						$resultDet = mysqli_query($conexion,$sqlDet);
						if (mysqli_num_rows($resultDet))
						{
						   while ($row = mysqli_fetch_array($resultDet))
							{
								$codpro       = $row['codpro'];	
								$canpro       = $row['canpro'];
								$factor       = $row['factor'];
								$prisal       = $row['prisal'];	
								$pripro       = $row['pripro'];	
								$fraccion     = $row['fraccion'];
								$idlote       = $row['idlote'];
								$factorP = 1;                                     
							}
						}               
						$sqlProd="SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
						$resultProd = mysqli_query($conexion,$sqlProd);
						if (mysqli_num_rows($resultProd))
						{
							while ($row1 = mysqli_fetch_array($resultProd))
							{
								$desprod    = $row1['desprod'];
								$codmar     = $row1['codmar'];
								$factorP    = $row1['factor'];
							}
						}
						if ($fraccion == "F")
						{
							$cantemp = "C".$canpro;
						}
						else
						{
							if ($factorP == 1)
							{
								$cantemp = $canpro;
							}
							else
							{
								$cantemp = "F".$canpro;
							}
						}
						$Cantidad= $canpro;
					?>
                    <tr <?php if ($prisal < $costpr){?>bgcolor="#FF0000"<?php } else { if ($prisal < $costpr){ ?> bgcolor="#006600"<?php }}?>>
                        <td width="57"><div align="left"><font color="<?php echo $color?>"><?php echo $nombre;?></font>   </div></td>
						<td width="74"><div align="left"><font color="<?php echo $color?>"><?php echo $nomusu;?></font></div></td>
						<td width="24"><div align="left"><font color="<?php echo $color?>"><?php echo $nrovent?></font></div></td>
                        <td width="24"><div align="left"><font color="<?php echo $color?>"><?php echo $nrofactura?></font></div></td>
						<td width="50"><div align="left"><font color="<?php echo $color?>"><?php echo $invfec;?></font></div></td>
						<td width="54"><div align="left"><font color="<?php echo $color?>"><?php echo $descli;?></font></div></td>
						<td width="308"><div align="left"><font color="<?php echo $color?>"><?php echo $desprod?></font></div></td>
						<td width="61"><div align="left"><font color="<?php echo $color?>"><?php echo $destab?></font></div></td>
						<td width="61"><div align="CENTER"><font color="<?php echo $color?>"><?php echo $cantemp?></font></div></td>
						<td width="61"><div align="center"> <strong><font color="<?php echo $color?>"><?php echo $igv?></font></strong></div></td>
                        <td width="61"><div align="left"> <strong><font color="<?php echo $color?>"><?php echo $gravado?></font></strong></div></td>
						<td width="60"><div align="CENTER"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($prisal, 2, '.', ' ');?></font></div></td>
                        <td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($prisal*$Cantidad, 2, '.', ' ');?></font></div></td> 
                        <td width="60"><div align="right"><strong><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' ');?></font></strong></div></td>   

                    </tr>
                    <?php 
					}
					?>
                </table>
                <?php 
				}
				?>
               </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<?php	
}
else
{
error_log("Check :".$ck2);
error_log("valTipoDoc :".$valTipoDoc);
if (($ck == '') && ($ck1 == '') && ($ck2 == '')){
if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1))
{
?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <table width="100%" border="0" align="center">
      <tr>
        <?php if ($ckloc == 1){?>
		<td width="102"><strong><h1>LOCAL</h1></strong></td>
		<?php }?>
		<td width="<?php if ($ckloc == 1){?>200<?php } else{?>300<?php }?>" class="letras"><strong><h1>VENDEDOR</h1></strong></td>
        <!--<td width="87"><div align="right"><strong><h1># VENTAS</h1> </strong></div></td>-->
        <td width="61" class="letras"><div align="right"><strong><h1>TOTAL</h1></strong></div></td>
<!--    <td width="90"><div align="right"><strong>UTILIDAD</strong></div></td>-->
      </tr>
    </table>
    </td>
  </tr>
</table>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php 
	$zz = 0;
	if ($val == 1){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' group by usecod,sucursal";}
			else{
			$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' group by usecod";}}
		else{
		$sql="SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod";}}
	if ($vals == 2){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where invfec between '$date1' and '$date2' and invtot <> '0' and estado = '0' group by usecod,sucursal order by nrovent";}
			else{
			$sql="SELECT usecod FROM venta where invfec between '$date1' and '$date2' and estado = '0' and invtot <> '0' group by usecod order by nrovent";}}
		else{
		
		$sql="SELECT usecod FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod order by nrovent";}}
	if ($valTipoDoc == 1){
		if ($local == 'all'){
			if ($ckloc == 1){
			$sql="SELECT usecod,sucursal FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0' group by usecod,sucursal order by sucursal, nrovent";}
			else{
			$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' and invtot <> '0' group by usecod order by sucursal, nrovent";}}
		else{
		
		$sql="SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0' group by usecod order by sucursal, nrovent";}}
	
				error_log("SQL: ".$sql);
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$usecod    = $row['usecod'];
		if ($ckloc == 1){
			$sucurs    = $row['sucursal'];}
		///////USUARIO QUE REALIZA LA VENTA
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];}}
		$e = 0;
		$t = 0;
		$c = 0;
		$e_tot = 0;
		$t_tot = 0;
		$c_tot = 0;
		$deshabil 	  = 0;
		$deshabil_tot = 0;
		$habil_tot    = 0;
		$count = 0;
		$sumpripro = 0;
		$sumpcosto = 0;
		$porcentaje= 0;
		$Rentabilidad = 0;
		if ($valTipoDoc == 1){
			if ($local == 'all'){
				if ($ckloc == 1){
					$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
					$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0' order by sucursal";}}
			else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and estado = '0' order by sucursal";}}
		if ($vals == 2){
			if ($local == 'all'){
				if ($ckloc == 1){
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and estado = '0' order by sucursal";}}
			else{
			$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invfec between '$date1' and '$date2' and sucursal = '$local' and estado = '0'";}}
		if ($val == 1){
			if ($local == 'all'){
				if ($ckloc == 1){
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and estado = '0' and sucursal = '$sucurs' order by sucursal";}
				else{
				$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and estado = '0' order by sucursal";}}
			else{
			$sql1="SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and nrovent between '$desc' and '$desc1' and sucursal = '$local' and estado = '0'";}}
		
				error_log("SQL 1 : ".$sql1);
                        $result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$invnum    = $row1["invnum"];
				$forpag    = $row1["forpag"];
				$val_habil = $row1["val_habil"];
				$total     = $row1["invtot"];
				$sucursal  = $row1["sucursal"];
				$hora  = $row1["hora"];
				if ($ckloc == 1){
					if ($sucursal <> $suc[$zz]){
						$zz++;
						$suc[$zz] = $sucursal;
					}
				}
				else{
					if ($usecod <> $suc[$zz]){
						$zz++;
						$suc[$zz] = $usecod;
					}
				}
				$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
					$nloc	= $row3["nomloc"];
					$nombre	= $row3["nombre"];
					if ($nombre == ''){
						$sucur = $nloc;}
					else{
						$sucur = $nombre;
					}
				}
				if ($val_habil == 0){
					if ($forpag == "E"){
						$e = $e + 1;
						$e_tot = $e_tot + $total;
						$e_tot1[$zz] = $e_tot1[$zz] + $total;
					}
					if ($forpag == "T"){
						$t = $t + 1;
						$t_tot = $t_tot + $total;
						$t_tot1[$zz] = $t_tot1[$zz] + $total;
					}
					if ($forpag == "C"){
						$c = $c + 1;
						$c_tot = $c_tot + $total;
						$c_tot1[$zz] = $c_tot1[$zz] + $total;
					}
                                        
					$sql2="SELECT cospro,pripro,canpro,fraccion,factor,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
					$result2 = mysqli_query($conexion,$sql2);
					if (mysqli_num_rows($result2)){
						while ($row2 = mysqli_fetch_array($result2)){
							$pcostouni    = $row2["cospro"]; //costo del producto x caja
							$pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
							$canpro       = $row2['canpro'];
							$fraccion     = $row2['fraccion'];
							$factor       = $row2['factor'];
							$prisal       = $row2['prisal']; //precio de venta x unidad
							$costpr       = $row2['costpr']; //costo del producto x unidad
	
							if ($fraccion == "T")
							{
								$RentPorcent  = (($prisal-$costpr) * $canpro);
								$Rentabilidad = $Rentabilidad + $RentPorcent;
								
								//$precio_costo = $pcostouni;
							}
							else
							{
								$RentPorcent  = (($prisal-$costpr) * $canpro);
								$Rentabilidad = $Rentabilidad + $RentPorcent;
							}                                                
						 }
					}
				}
				if ($val_habil == 1)
				{
					$deshabil++;
					$deshabil_tot = $deshabil_tot + $total;
					$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
				}
				else
				{
					$habil_tot = $habil_tot + $total;
					$habil_tot1[$zz] = $habil_tot1[$zz] + $total;
                                }
					$count++;    
				 }
			 }
			 $rentabilidad       = $Rentabilidad;			 
			 $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
             
		  if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		  ?>
            <tr bgcolor="#CCCCCC">
                <?php if ($ckloc == 1){?><td width="25"></td><?php }?>
                <td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>"></td>
                <td class="letras1" width="5"><div align="right" class="letras1"><strong><h2>efc</h2></strong></div></div></td>
                <td class="letras1" width="200"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></h2></div></td>
                <td class="letras1" width="1000"><div align="center" class="letras1"><strong><h2>tar/otros</h2></strong></div></div></td>
                <td class="letras1" width="220"><div align="left" class="letras1"><h2><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ') + number_format($t_tot1[$zz-1], 2, '.', ' ')+ number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></h2></div></td>
                <td class="letras1" width="57"><div align="right" class="letras1"><strong><h2>TOTAL</h2></strong></div></div></td>
                <td class="letras1" width="71"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></h2></div></td>

            </tr>
	  <?php }?>
	   <tr>
        <?php if ($ckloc == 1){?><td width="102"><?php echo $sucur?></td><?php }?>
		 <td colspan="7"  class="letras" width="<?php if ($ckloc == 1){?>700<?php } else{?>00<?php }?>" height="46px" ><h1><?php echo $user?></h1></td>
         </tr>
	  <?php }?>
    </table>
		<?php if ($zz == 1){?>
		  <table width="100%" border="0" align="center">
			 <tr bgcolor="#CCCCCC" >
			      
              <td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>"></td>
              <td class="letras1" width="5"><div align="right"class="letras1"><strong><h2>efc</h2></strong></div></td>
              <td class="letras1" width="200"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></h2></div></td>
              <td class="letras1" width="1000"><div align="center"class="letras1"><strong><h2>tar/otros</h3></strong></div></td>
              <td class="letras1" width="220"><div align="left" class="letras1"><h2><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></h2></div></td>
              <td class="letras1" width="57"><div align="right"class="letras1"><strong><h2>TOTAL</h2></strong></div></td>
              <td class="letras1" width="71"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></h2></div></td>

			  </tr>
		  </table>
		<?php }else{
		?>
		  <table width="100%" border="0" align="center">
            <tr bgcolor="#CCCCCC">
              <td width="<?php if ($ckloc == 1){?>240<?php } else{?>342<?php }?>"></td>
              <td class="letras1" width="5"><div align="right"class="letras1"><strong><h2>efc</h2></strong></div></td>
              <td class="letras1" width="200"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></h2></div></td>
              <td class="letras1" width="1000"><div align="center"class="letras1"><strong><h2>tar/otros</h2></strong></div></td>
              <td class="letras1" width="220"><div align="left" class="letras1"><h2><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></h2></div></td>
              <td class="letras1" width="57"><div align="right"class="letras1"><strong><h2>TOTAL</h2></strong></div></td>
              <td class="letras1" width="71"><div align="right" class="letras1"><h2><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></h2></div></td>

            </tr>
          </table>
		  <?php }?>
	<?php }else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
</table>
<?php }}?>
<?php if (($ck == 1) || ($ck1 == 1) || ($ck2 == 1)){
if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)){?>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <?php if ($ckloc == 1){?><td width="82"><strong>LOCAL</strong></td><?php }?>
	    <td width="<?php if ($ckloc == 1){?>180<?php }else{?>250<?php }?>"><strong>VENDEDOR</strong></td>
        <td width="60"><div align="left"><strong>HORA </strong></div></td>
	    <td width="20"><div align="left"><strong>FECHA </strong></div></td>
	    <td width="30"><div align="right"><strong>N&ordm; C. INTERNO </strong></div></td>
<!--	<td width="30"><div align="right"><strong>N&ordm; DE. VENTE </strong></div></td>-->
        <td width="29"><div align="right"><strong>N&ordm; FISICO </strong></div></td>
        <td width="60"><div align="right"><strong>CONTADO</strong></div></td>
        <td width="60"><div align="right"><strong>CREDITO</strong></div></td>
        <td width="80"><div align="right"><strong>TARJETAS</strong></div></td>
        <td width="44"><div align="right"><strong>OTROS</strong></div></td>
        <td width="50"><div align="right" class="Estilo1">ANULADAS</div></td>
        <td width="55"><div align="right"><strong>TOTAL VENTAS</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php 
	if ($val == 1){
		if ($local == 'all'){
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";
		}
		else{
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' and estado = '0' and invtot <> '0'";
		}
	}
	if ($vals == 2){
		if ($local == 'all'){
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where invfec between '$date1' and '$date2' and estado = '0' and invtot <> '0' order by nrovent  ";}
		else{
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0'  order by nrovent";
		}
	}
	if ($valTipoDoc == 1){
		if ($local == 'all'){
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where correlativo between '$from' and '$until'  and tipdoc='$tipoDoc' and estado = '0' and invtot <> '0' order by sucursal, nrovent  ";}
		else{
			$sql="SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0' and estado = '0'  order by sucursal, nrovent";
		}
	}		
	$zz = 0;
	$i  = 0;

	error_log("SQL 2: ".$sql);
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		$usecod    = $row['usecod'];
		$nrovent   = $row['nrovent'];
		$forpag    = $row["forpag"];
		$val_habil = $row["val_habil"];
		$total     = $row["invtot"];
		$sucursal  = $row["sucursal"];
		$nrofactura  = $row["nrofactura"];
		$hora	   = $row["hora"];
		$i++;
		$ssss[$i]  = $sucursal;
		if ($sucursal <> $suc[$zz]){
			$zz++;
			$suc[$zz] = $sucursal;
		}
		$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
		$result3 = mysqli_query($conexion,$sql3); 
		while ($row3 = mysqli_fetch_array($result3)){ 
			$nloc	= $row3["nomloc"];
			$nombre	= $row3["nombre"];
			if ($nombre == ''){
				$sucur = $nloc;}
			else{
				$sucur = $nombre;
			}
		}
		$e_tot = 0;
		$t_tot = 0;
		$c_tot = 0;
		$deshabil_tot = 0;
		$habil_tot = 0;
		$count = 0;
		$tot	   = 0;
		$Rentabilidad = 0;
		$sumpripro = 0;
		$sumpcosto = 0;
		$porcentaje= 0;
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$user    = $row1['nomusu'];
			}
		}
		if ($val_habil == 0){
			if ($forpag == "E"){
				$e_tot = $total;
				$e_tot1[$zz] = $e_tot1[$zz] + $total;
			}
			if ($forpag == "T"){
				$t_tot = $total;
				$t_tot1[$zz] = $t_tot1[$zz] + $total;
			}
			if ($forpag == "C"){
				$c_tot = $total;
				$c_tot1[$zz] = $c_tot1[$zz] + $total;
			}
			$sql2="SELECT costpr,pripro,canpro,fraccion,factor,invfec,prisal,costpr, cospro FROM detalle_venta where invnum = '$invnum' order by invfec";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
				while ($row2 = mysqli_fetch_array($result2)){
					$pcostouni    = $row2["cospro"]; //costo del producto x caja
					$pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
					$canpro       = $row2['canpro'];
					$fraccion     = $row2['fraccion'];
					$factor       = $row2['factor'];
					$prisal       = $row2['prisal']; //precio de venta x unidad
					$costpr       = $row2['costpr']; //costo del producto x unidad
					$invfec       = $row2['invfec'];
					
					//FRACCIONADO
					if ($fraccion == "T")
					{
						$RentPorcent  = (($prisal-$costpr) * $canpro);
						$Rentabilidad = $Rentabilidad                               +$RentPorcent;
						//$precio_costo = $pcostouni;
					}
					else
					{
						//NO FRACCIONADO
						$RentPorcent  = (($prisal-$pcostouni) * $canpro);
						$Rentabilidad = $Rentabilidad 
						+ $RentPorcent;
					}					
				}
			}
		}
				
		if ($val_habil == 1)
		{
			$deshabil_tot = $total;
			$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
		}
		else
		{
			$habil_tot = $total;
			$habil_tot1[$zz] = $habil_tot1[$zz] + $total;
		}
                        
		$rentabilidad       = $Rentabilidad;
		$rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
			/*if ($sumpcosto > 0){
			$rentabilidad   = $sumpripro - $sumpcosto;
			$rentabilidad1[$zz] = $rentabilidad1[$zz] + $rentabilidad;}*/
		if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		if ($sucursal <> $ssss[$i-1]){
		  ?>
			<tr bgcolor="#CCCCCC">
			    <?php if ($ckloc == 1){?><td width="102"><?php ?></td><?php }?>
				<td width="<?php if ($ckloc == 1){?>180<?php } else {?>282<?php }?>" bgcolor="#CCCCCC"></td>
			
				<td  colspan="4"width="67"><div align="right"><strong>TOTAL1</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
				<td colspan="2" width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				
				<td bgcolor="#92c1e5" width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				
	
                        </tr>
		  <?php }}?>
                        <tr>
                            <?php if ($ckloc == 1){?><td width="82"><?php echo $sucur?></td><?php }?>
                            <td width="<?php if ($ckloc == 1){?>180<?php } else {?>282<?php }?>">
                            <a href="javascript:popUpWindow('ver_venta_usu.php?invnum=<?php echo $invnum?>', 30, 140, 975, 280)"><?php echo $user?></a></td>
                            <td width="40"><div align="right"><?php echo $hora?></div></td>
                            <td width="40"><div align="right"><?php echo fecha($invfec)?></div></td>
                            
<!--                   <td width="25"><div align="right"><?php echo $nrovent?></div></td>-->
                        <td width="25"><div align="right"><?php echo $invnum?></div></td>
                        
                            <td width="25"><div align="right"><?php echo $nrofactura?></div></td>
                            <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></div></td>
                            <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ');?></div></td>
                            <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot, 2, '.', ' ');?></div></td>
                            <td width="54">&nbsp;</td>
                            <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' ');?></div></td>
                            <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></div></td>
    
                        </tr>
                  <?php }?>
    </table>
	<?php if ($zz == 1){
		?>
		  <table width="926" border="0" align="center">
			  <tr bgcolor="#CCCCCC">
				<td width="497"><div align="right"><strong>TOTAL2</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
				<td colspan="2" width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td bgcolor="#92c1e5" width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
				  </tr>
	  </table>
		<?php }else{?>
		  <table width="926" border="0" align="center">
            <tr bgcolor="#CCCCCC">
              <td width="497"><div align="right"><strong>TOTAL3</strong></div></td>
              <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
               <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
              <td colspan="2" width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td bgcolor="#92c1e5" width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
            </tr>
          </table>
		  <?php }}else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
</table>
<?php }}}?>

    </DIV>
</body>
</html>