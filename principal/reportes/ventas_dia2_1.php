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
        font-size:18px;
    }
    .letras1{
        font-size:20px;
    }
    .letras22{
    font-weight: 700;
       background: black;
       color: white;
       font-size:19px;
    }
    .letras22x{
        font-size:19px;
    }
    .letras12{
        font-size:20px;
        
        font-weight: 700px;
       
    }
    
    .letras121{
        font-size:25px;
        
        font-weight: 800px;
       
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

    $date1 = $_REQUEST['date1'];
    $date2 = $_REQUEST['date2'];
    $local = $_REQUEST['local'];
    $ck = $_REQUEST['ck'];
    $val = $_REQUEST['val'];
    $vals = $_REQUEST['vals'];
    $ckloc = $_REQUEST['ckloc'];
    $ckprod = $_REQUEST['ckprod'];


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

       
     <table width="100%"  height="50" border="0">
      <tr class="letras12">
        <td class="letras12" width="300" align="left" height="20"><strong><pre><?php echo $desemp?></pre></strong></td>
        
        <td class="letras12" width="260">
            <div class="letras12" align="right">
                <strong><pre>FECHA </pre></strong>
                
               <strong><pre> <?php echo date('d/m/Y');?></pre></strong>
                
            </div>
        </td>
      </tr>
      <tr >
        
        <td align="left" colspan="2" class="letras121"  height="26">
            <div align="left" class="letras121" align="left">
                <strong><pre>REPORTE DE CIERRE DEL DIA - <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $locals;}?></pre></strong>
            </div>
        </td>
        
      </tr>
      <tr>
         
          <td class="letras121" colspan="2" width="633"><div class="letras121" align="center"><b><?php if ($val == 1){?>NRO DE VENTA ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?></b></div></td>
     
         
          
        </tr>
      <tr>
         
         <td class="letras121" height="23" colspan="2" width="633"><div class="letras121" align="center"><b> FECHAS ENTRE EL </b></div></td> 
         
          
        </tr>
        <br>
      <tr>
         
         
          <td class="letras121" colspan="2" width="633"><div class="letras121" align="center"><b><?php echo $dat1; ?> Y EL <?php echo $dat2; } if ($valTipoDoc == 1){?> No DE DOCUMENTO ENTRE EL <?php echo $from; ?> Y EL <?php echo $until; } ?></b></div></td>
          
        </tr>
    </table>
   
        

<?php 
if ($ckprod == 1)
{
?>

<table width="50%" border="1" align="center" cellpadding="0" cellspacing="0">
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
            <td width="60"><div align="right"><strong>PRECIO VTA.</strong></div></td>
      		<td width="60"><div align="right"><strong>PRECIO LTA.</strong></div></td>
            <td width="60"><div align="right"><strong>DIFERENCIA</strong></div></td>
            <td width="60"><div align="right"><strong>PRECIO LTA.</strong></div></td>
            <td width="60"><div align="right"><strong>DIFERENCIA</strong></div></td>
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
					$sql="SELECT detalle_venta.usecod,costpr,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' order by nrovent group by = nrovent";
					}
					else ///UN SOLO LOCAL
					{
					$sql="SELECT detalle_venta.usecod,costpr,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local' order by nrovent";
					}
				}
				else///	SEGUNDO BOTON
				{
					if ($local == 'all')////TODOS LOS LOCALES
					{ 
						//echo $date1; echo "<br>";
						//echo $date2;
						$sql="SELECT detalle_venta.usecod,costpr,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and invtot <> '0' and estado = '0' order by nrovent";
					}
					else ///UN SOLO LOCAL
					{
						$sql="SELECT detalle_venta.usecod,costpr,sucursal,nrovent,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0' order by nrovent";
					}
				}
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				?>
                <table width="926" border="0" align="center">
                    <?php 
					while ($row = mysqli_fetch_array($result)){
						$usecod    = $row['usecod'];
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
						}}
						$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
						$result3 = mysqli_query($conexion,$sql3); 
						if (mysqli_num_rows($result3)){
						while ($row3 = mysqli_fetch_array($result3)){ 
						$nloc	= $row3["nomloc"];
						$nombre	= $row3["nombre"];}}
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
						<td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($prisal, 2, '.', ' ');?></font></div></td>
						<td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($cospro, 2, '.', ' ');?></font></div></td>
						<td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($plista, 2, '.', ' ');?></font></div></td>
						<td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($pdistribuidor, 2, '.', ' ');?></font></div></td>
						<td width="60"><div align="right"><font color="<?php echo $color?>"><?php echo $numero_formato_frances = number_format($dif, 2, '.', ' ');?></font></div></td>
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
    
    
if (($ck == '') && ($ck1 == '')){
if (($val == 1) || ($vals == 2))
{
?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <table width="100%" border="0" align="center">
      <tr>
        <?php if ($ckloc == 1){?>
		<td width="102" class="letras"><strong><h1>LOC</h1></strong></td>
		<?php }?>
		<td width="<?php if ($ckloc == 1){?>200<?php } else{?>300<?php }?>" align="center" class="letras"><strong><h1>VENDEDOR</h1></strong></td>
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
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="100%" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$usecod    = $row['usecod'];
		$sucurs    = $row['sucursal'];
		
		if ($ckloc == 1){
			$sucurs    = $row['sucursal'];}
		///////USUARIO QUE REALIZA LA VENTA
		$sql1="SELECT nomusu,abrev FROM usuario where  usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];
		    $abrev    = $row1['abrev'];
		     if ($ckloc == 1){
		    $user2 = substr($user, 0, 16);
		     }ELSE{
		          $user2 = substr($user, 0, 22);
		     }
		   
		    
		}}
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
					$suc[$zz] = $sucursal;}}
				else{
					if ($usecod <> $suc[$zz]){
					$zz++;
					$suc[$zz] = $usecod;}}
				$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
				$nloc	= $row3["nomloc"];
				$nombre	= $row3["nombre"];
					if ($nombre == ''){
					$sucur = $nloc;}
					else{
					$sucur = $nombre;}}
                                    if ($val_habil == 0){
					if ($forpag == "E"){
					$e = $e + 1;
					$e_tot = $e_tot + $total;
					$e_tot1[$zz] = $e_tot1[$zz] + $total;}
					if ($forpag == "T"){
					$t = $t + 1;
					$t_tot = $t_tot + $total;
					$t_tot1[$zz] = $t_tot1[$zz] + $total;}
					if ($forpag == "C"){
					$c = $c + 1;
					$c_tot = $c_tot + $total;
					$c_tot1[$zz] = $c_tot1[$zz] + $total;}
                                        
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
                                                    //$precio_costo = $pcostouni/$factor;
                                                    //$canpros   = $canpro * $factor;
                                                    //$tot	   = $tot + $canpros;
                                                    $RentPorcent  = (($prisal-$costpr) * $canpro);
                                                    $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                }
                                                /*$tot   	      = 0;
						$precio_costo = $pcostouni;
						if ($fraccion == "T")
                                                {
                                                    $tot	   = $tot + $canpro;
                                                    //$precio_costo = $pcostouni;
						}
						else
                                                {
                                                    //$precio_costo = $pcostouni/$factor;
                                                    $canpros   = $canpro * $factor;
                                                    $tot	   = $tot + $canpros;
                                                }
						$sumpripro = $sumpripro + $pripro;
						$pcosto    = $tot * $precio_costo;
						$sumpcosto = $sumpcosto + $pcosto;*/
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
                         //if ($sumpcosto > 0)
                         //{
                         $rentabilidad       = $Rentabilidad;
			 //$rentabilidad       = $sumpripro - $sumpcosto;
			 $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
                         //}
		  if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		  ?>
                        <tr bgcolor="#CCCCCC">
                           
                                
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="5"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><strong><h3>efc</h3></strong></div></div></td>
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><h3><pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></pre></h3></div></td>
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="500"><div align="center" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><strong><h3>tar/otros</h3></strong></div></div></td>
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="240"><div align="left" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><h3><pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ') + number_format($t_tot1[$zz-1], 2, '.', ' ')+ number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></pre></h3></div></td>
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="57"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><strong><h3>TOT</h3></strong></div></div></td>
                                <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> " width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?> "><h3><pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></pre></h3></div></td>

                        </tr>
	  <?php }?>
	  <tr >
        <?php if ($ckloc == 1){?><td  width="30" class="letras"><h1><?php echo $sucur?></h1></td><?php }?>
        <td colspan="6" align="center" class="letras" height="46px" ><h1><?php echo $abrev?></h1></td>
        
    
      </tr>
       <?php if ($ckloc == 1){?>
      <tr >
         
      
      
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="12"><div align="right"class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><strong><h3>efc</h3></strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="3100"><div align="right" class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="450"><div align="center"class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><strong><h3>tar/otros</h3></strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="320"><div align="left" class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ') + number_format($t_tot, 2, '.', ' ') + number_format($deshabil_tot, 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="67"><div align="right"class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><strong><h3>TOT</strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  " width="90"><div align="right" class="<?php if ($ckloc == 1){?>letras22x<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></pre></h3></div></td>

      
      
      
      </tr>
      <?}?>
      
	  <?php }?>
    </table>
		<?php if ($zz == 1){?>
		  <table width="100%" border="0" align="center">
			  <tr bgcolor="#CCCCCC" >
			      
             
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="5"><div align="right"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><strong><h3>efc</h3></strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="500"><div align="center"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><strong><h3>tar/otros</h3></strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="240"><div align="left" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="57"><div align="right"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><strong><h3>TOT</strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  " width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>  "><h3><pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>

			  </tr>
		  </table>
		<?php }else{
		?>
		  <table width="100%" border="0" align="center">
            <tr bgcolor="#CCCCCC" >
             
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>   " width="5"><div align="right"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><strong>efc</strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>" width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><h3><pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?> font-size:7px<?php } else{?>letras1<?php }?>" width="500"><div align="center"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><strong><h3>tar/otros</h3></strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>" width="240"><div align="left" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><h3><pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>" width="57"><div align="right"class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><strong><h3>TOT</strong></div></td>
              <td class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>" width="220"><div align="right" class="<?php if ($ckloc == 1){?>letras22<?php } else{?>letras1<?php }?>"><h3><pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></pre></h3></div></td>

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
    
    
<?php if (($ck == 1) || ($ck1 == 1)){
if (($val == 1) || ($vals == 2)){?>
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
<!--       <td width="29"><div align="right"><strong>N&ordm; FISICO </strong></div></td>-->
        <td width="60"><div align="right"><strong>CONTADO</strong></div></td>
        <td width="60"><div align="right"><strong>CREDITO</strong></div></td>
        <td width="80"><div align="right"><strong>TARJETAS</strong></div></td>
        <td width="44"><div align="right"><strong>OTROS</strong></div></td>
        <td width="50"><div align="right" class="Estilo1">ANULADAS</div></td>
        <td width="55"><div align="right"><strong>TOTAL</strong></div></td>
        <td width="90"><div align="right"><strong>UTILIDAD</strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php if ($val == 1){
		if ($local == 'all'){
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora,nrofactura FROM venta where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";}
		else{
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora,nrofactura FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' and estado = '0' and invtot <> '0'";}}
	if ($vals == 2){
		if ($local == 'all'){
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora,nrofactura FROM venta where invfec between '$date1' and '$date2' and estado = '0' and invtot <> '0' order by nrovent  ";}
		else{
		$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot,sucursal,hora,nrofactura FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> '0' and estado = '0'  order by nrovent";}}
	$zz = 0;
	$i  = 0;
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
			$user    = $row1['nomusu'];}}
			if ($val_habil == 0){
				if ($forpag == "E"){
				$e_tot = $total;
				$e_tot1[$zz] = $e_tot1[$zz] + $total;}
				if ($forpag == "T"){
				$t_tot = $total;
				$t_tot1[$zz] = $t_tot1[$zz] + $total;}
				if ($forpag == "C"){
				$c_tot = $total;
				$c_tot1[$zz] = $c_tot1[$zz] + $total;}
				$sql2="SELECT costpr,pripro,canpro,fraccion,factor,invfec,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
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
                                            //$precio_costo = $pcostouni/$factor;
                                            //$canpros   = $canpro * $factor;
                                            //$tot	   = $tot + $canpros;
                                            $RentPorcent  = (($prisal-$pcostouni) * $canpro);
                                            $Rentabilidad = $Rentabilidad 
                                            + $RentPorcent;
                                        }
                                    
                                    
                                        /*$pcostouni    = $row2["cospro"];
					$pripro       = $row2['pripro'];
					$canpro    	  = $row2['canpro'];
					$fraccion     = $row2['fraccion'];
					$factor       = $row2['factor'];
					$invfec       = $row2['invfec'];
					$tot   	      = 0;
					$precio_costo = $costpr;
					if ($fraccion == "T"){
					$tot	   = $tot + $canpro;}
					else{
					//$precio_costo = $pcostouni/$factor;
					$canpros   = $canpro * $factor;
					$tot	   = $tot + $canpros;}
					$sumpripro = $sumpripro + $pripro;
					$pcosto    = $tot * $precio_costo;
					$sumpcosto = $sumpcosto + $pcosto;*/
                                        
                                        }}}
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
				<td width="20"><div align="right"></div></td>
				<td width="30"><div align="right"></div></td>
                                <td width="25"><div align="right"></div></td>
				<td width="67"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="54">&nbsp;</td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz-1], 2, '.', ' '); ?></div></td>
                        </tr>
		  <?php }}
                  ?>
                        <tr>
                            
                            <?php if ($ckloc == 1){?><td width="82"><?php echo $sucur?></td><?php }?>
                            <td width="<?php if ($ckloc == 1){?>180<?php } else {?>282<?php }?>">
                            <a href="javascript:popUpWindow('ver_venta_usu.php?invnum=<?php echo $invnum?>', 30, 140, 975, 280)"><?php echo $user?></a></td>
                            <td width="40"><div align="right"><?php echo $hora?></div></td>
                            <td width="40"><div align="right"><?php echo fecha($invfec)?></div></td>
                            
<!--                   <td width="25"><div align="right"><?php echo $nrovent?></div></td>-->
                        <td width="25"><div align="right"><?php echo $invnum?></div></td>
                        
<!--                       <td width="25"><div align="right"><?php   if($val_habil==1){
                             $reso="ANULADO";
                             echo "<p class='Estilo1'>$reso</p>";

                        }else{
                             $reso="NO ";
                             echo "<strong>$reso</strong>";
                        }?></div></td>-->
                        
                            <td width="25"><div align="right"><?php echo $nrofactura?></div></td>
                            <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></div></td>
                            <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ');?></div></td>
                            <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot, 2, '.', ' ');?></div></td>
                            <td width="54">&nbsp;</td>
                            <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' ');?></div></td>
                            <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></div></td>
                            <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' ');?></div></td>
                        </tr>
                  <?php }?>
    </table>
	<?php if ($zz == 1){
		?>
		  <table width="926" border="0" align="center">
			  <tr bgcolor="#CCCCCC">
				<td width="497"><div align="right"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="54">&nbsp;</td>
				<td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
			  </tr>
	  </table>
		<?php }else{?>
		  <table width="926" border="0" align="center">
            <tr bgcolor="#CCCCCC">
              <td width="497"><div align="right"><strong>TOTAL</strong></div></td>
              <td width="64"><div align="right"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="54">&nbsp;</td>
              <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
              <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad1[$zz], 2, '.', ' '); ?></div></td>
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