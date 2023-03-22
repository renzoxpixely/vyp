<?php require_once('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('venta_reg1.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../montos_text.php');
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$venta   = $_SESSION['cotiz'];
$rd 	 = $_REQUEST['rd'];
$sql="SELECT * FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
		$sucursal     = $row['sucursal'];
		if ($forpag == 'E')
		{
		$forma_pago = 'EFECTIVO';
		}
		if ($forpag == 'T')
		{
		$forma_pago = 'TARJETA';
		}
		if ($forpag == 'C')
		{
		$forma_pago = 'CREDITO';
		}
		$var[nrovent] = $nrovent;
		$var[invfec]  = $invfec;
		$var[cuscod]  = $cuscod;
		$var[usecod]  = $usecod;
		$var[forpag]  = $forma_pago;
		$var[mont_bruto]   = $mont_bruto;
		$var[total_es]     = $total_es;
		$var[valor_vent1]  = $valor_vent1;
		$var[sum_igv]      = $sum_igv;
		$var[monto_total]  = $monto_total;
}
}
$sql="SELECT nomusu FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$nomusu       = $row['nomusu'];
		$var[nomusu]  = $nomusu;
}
}
$sql="SELECT descli,dircli,ruccli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$descli       = $row['descli'];
		$dircli       = $row['dircli'];
		$ruccli       = $row['ruccli'];
		$var[descli]  = $descli;
		$var[dircli]  = $dircli;
		$var[ruccli]  = $ruccli;
		
}
}
$sql="SELECT linea FROM formato where tipodoc = '$rd' and titulo = 'CB' order by linea desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$llinea1       = $row['linea'];
}
}
$sql="SELECT columna FROM formato where tipodoc = '$rd' and titulo = 'CB' order by columna desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$ccolumna1     = $row['columna'];
}
}
$sql="SELECT linea FROM formato where tipodoc = '$rd' and titulo = 'PIE' order by linea desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$llinea2       = $row['linea'];
}
}
$sql="SELECT columna FROM formato where tipodoc = '$rd' and titulo = 'PIE' order by columna desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$ccolumna2     = $row['columna'];
}
}
$sql="SELECT fdisp,flinpag,fini,fcanti,fcodpro,fmarca,fpreuni,fmonto,fdescuento,fnom,fref FROM xcompa where codloc = '$sucursal'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$fdisp         = $row['fdisp'];
		$flinpag       = $row['flinpag'];
		$fini          = $row['fini'];
		$fcanti        = $row['fcanti'];
		$fmarca        = $row['fmarca'];
		$fcodpro       = $row['fcodpro'];
		$fpreuni       = $row['fpreuni'];
		$fmonto        = $row['fmonto'];
		$fdescuento    = $row['fdescuento'];
		$fnom          = $row['fnom'];
		$fref          = $row['fref'];
		$fuente        = $row['fuente'];
		if ($fuente == 0)
		{
		$fuente = 12;
		}
}
}
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
function orden($g)
{
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	if ($fcanti == $g)
	{
	echo "<span class='Letras'>CANTIDAD</span>";
	}
	if ($fmarca == $g)
	{
	echo "<span class='Letras'>MARCA</span>";
	}
	if ($fcodpro == $g)
	{
	echo "<span class='Letras'>CODIGO</span>";
	}
	if ($fpreuni == $g)
	{
	echo "<span class='Letras'>PRECIO</span>";
	}
	if ($fmonto == $g)
	{
	echo "<span class='Letras'>SUB TOTAL</span>";
	}
	if ($fdescuento == $g)
	{
	echo "<span class='Letras'>DCTOS</span>";
	}
	if ($fnom == $g)
	{
	echo "<span class='Letras'>DESCRIPCION</span>";
	}
	if ($fref == $g)
	{
	echo "<span class='Letras'>PRECIO REF</span>";
	}
}
function ancho($u)
{
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	if ($fcanti == $u)
	{
	echo 74;
	}
	if ($fmarca == $u)
	{
	echo 157;
	}
	if ($fcodpro == $u)
	{
	echo 40;
	}
	if ($fpreuni == $u)
	{
	echo 67;
	}
	if ($fmonto == $u)
	{
	echo 68;
	}
	if ($fdescuento == $u)
	{
	echo 68;
	}
	if ($fnom == $u)
	{
	echo 264;
	}
	if ($fref == $u)
	{
	echo 87;
	}
}
function muestra($y)
{
	global $codpro;
	global $desprod;
	global $marca;
	global $precio_ref;
	global $descuento;
	global $fraccion;
	global $canpro;
	global $prisal;
	global $pripro;
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	if ($fcanti == $y)
	{
	echo '<div align="right"><span class="Letras">';if ($fraccion == "T"){echo $canpro; } if ($fraccion == "F") { $canpro = "c".$canpro; echo $canpro;} echo '</span></div>';
	}
	if ($fmarca == $y)
	{
	echo '<span class="Letras">'; echo $marca; echo '</span>';
	}
	if ($fcodpro == $y)
	{
	echo '<span class="Letras">'; echo $codpro; echo '</span>';
	}
	if ($fpreuni == $y)
	{
	echo '<div align="right"><span class="Letras">'; echo $prisal; echo '</span></div>';
	}
	if ($fmonto == $y)
	{
	echo '<div align="right"><span class="Letras">'; echo $pripro; echo '</span></div>';
	}
	if ($fdescuento == $y)
	{
	echo '<div align="right"><span class="Letras">'; echo $numero_formato_frances = number_format($descuento, 0, '.', ' '); echo '</span> %</div>';
	}
	if ($fnom == $y)
	{
	echo '<span class="Letras">'; echo $desprod; echo '</span>';
	}
	if ($fref == $y)
	{
	echo '<div align="right"><span class="Letras">'; echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' '); echo '</span></div>';
	}
}
if ($rd == 1)
{
$descm = "FACTURA";
}
if ($rd == 2)
{
$descm = "BOLETA DE VENTA";
}
if ($rd == 3)
{
$descm = "TICKET INTERNO";
}
//require_once('calcula_monto.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IMPRESION DE VENTA</title>
<style type="text/css">
<!--
a:link {
	color: #666666;
}
a:visited {
	color: #666666;
}
a:hover {
	color: #666666;
}
a:active {
	color: #666666;
}
.Letras {font-size: <?php echo $fuente;?>px;}
-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
function imprimir()
{
    window.print();
}
// -->
</SCRIPT>
<?php ?>
<script>
function escapes(e) {
tecla=e.keyCode
  if (tecla == 27)
  {
	//document.form1.target = "venta_principal";
	//window.opener.location.href="nada.php";
	self.close();
    parent.opener.location='hola.php';
  }
}
</script>
</head>
<body onkeyup="escapes(event)" onload="imprimir();">
<form name="form1" id="form1">
<table width="869" border="0" bordercolor="#666666">
  <tr>
    <td><div align="center"><a href="javascript:imprimir()"><b><span class="Letras"><?php echo $descm?></span></b></a></div>
      <table width="857" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td>
		    <?php $ii = 1;
			$ic = 1;
			while($ii <= $llinea1)
			{
			?>
			<table width="847" border="0" align="center">
              <tr>
                <td>
				<?php $ic = 1;
					$sql="SELECT columna,descbrev,campo,cuanto FROM formato inner join titultabladet on formato.descripcion = titultabladet.codtab where sucursal = '$sucursal' and tipodoc = '$rd' and titulo = 'CB' and state = '1' and linea = '$ii' order by linea, columna";
					$result = mysqli_query($conexion,$sql);
					if (mysqli_num_rows($result)){
					while ($row = mysqli_fetch_array($result)){
							$lin           = $row['linea'];
							$col   		   = $row['columna'];
							$desc   	   = $row['descbrev'];
							$cam	       = $row['campo'];
							$long	       = $row['cuanto'];
							if ($ic == $col)
							{
								$sumlet = 0;
								$ddate  = 0;
								if($contit == 1)
								{
								echo '<b><span class="Letras">';echo $desc;echo '</b></b>&nbsp;';
								$sumlet = strlen($desc);
								}
								
								echo "<span class='Letras'>"; if ($cam == 'hora'){ 
								$hour  = date(G);  
//                                                                $hour  = CalculaHora($hour);
                                                                $min   = date(i);
                                                                $hora  = $hour.":".$min;
								$ddate = strlen($hora);
								echo $hora;}else{echo substr($var[$cam],0,$long);} echo "</span>";
								$totlet = $sumlet + $long; + $ddate;
								$ic     = $totlet;
							}
							else
							{
								while($ic <= $col)
								{
							?>
								&nbsp;
							<?php $ic++;
								}
								$sumlet = 0;
								$ddate  = 0;
								if($contit == 1)
								{
								echo '<b><span class="Letras">';echo $desc;echo '</span></b>&nbsp;';
								$sumlet = strlen($desc);
								}	
								
								echo "<span class='Letras'>";if ($cam == 'hora'){ 
								$hour  = date(G);  
//                                                                $hour  = CalculaHora($hour);
                                                                $min   = date(i);
                                                                $hora  = $hour.":".$min;
								$ddate = strlen($hora);
								echo $hora;}else{echo substr($var[$cam],0,$long);}
								$ic++; echo "</span>";
								$totlet = $sumlet + $long; + $ddate;
								$ic     = $totlet;
							}
					}
					}
					else
					{
						while($ic <= $ccolumna1)
						{
					?>
						&nbsp;
					<?php $ic++;
						}
					}
				?>
				</td>
              </tr>
            </table>
			<?php $ii++;
			}
			?></td>
        </tr>
      </table>
      <br>
	  <?php /*
	  ?>
      <table width="857" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td width="<?php ancho(1);?>"><strong><?php orden(1)?></strong></td>
          <td width="<?php ancho(2);?>"><strong><?php orden(2);?></strong></td>
          <td width="<?php ancho(3);?>"><strong><?php orden(3);?></strong></td>
          <td width="<?php ancho(4);?>"><strong><?php orden(4);?></strong></td>
          <td width="<?php ancho(5);?>"><strong><?php orden(5);?></strong></td>
          <td width="<?php ancho(6);?>"><strong><?php orden(6);?></strong></td>
          <td width="<?php ancho(7);?>"><strong><?php orden(7);?></strong></td>
          <td width="<?php ancho(8);?>"><strong><?php orden(8);?> </strong></td>
        </tr>
      </table>
	  <?php */
	  $co = 0;
	  while($co < $fini)
	  {
	  echo '<br>';
	  $co++;
	  }
	  ?>
      <table width="857" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td>
		  <table width="851" border="0" align="center">
          <?php $i = 1;
	        $sql="SELECT * FROM detalle_venta where invnum = '$venta'";
		    $result = mysqli_query($conexion,$sql);
		    if (mysqli_num_rows($result)){
			while ($row = mysqli_fetch_array($result)){
			$codtemp      = $row['codtemp'];	
			$codpro       = $row['codpro'];	
			$canpro       = $row['canpro'];
			$fraccion     = $row['fraccion'];
			$factor       = $row['factor'];
			$prisal       = $row['prisal'];	
			$pripro       = $row['pripro'];	
			$fraccion     = $row['fraccion'];
			if ($fraccion == "F")
			{
			$cantemp = $canpro * $factor;
			}
			else
			{
			$cantemp = $canpro;
			}
			$sql1="SELECT codpro,desprod,codmar,factor,costpr,stopro,incentivado,prelis,prevta,preuni FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$codpro     = $row1['codpro'];
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
				$costpr     = $row1['costpr'];  ///COSTO PROMEDIO
				$stopro     = $row1['stopro'];	///STOCK EN UNIDADES DEL PRODUCTO GENERAL
				$cant       = $row1['cant'];	///STOCK EN UNIDADES DEL PRODUCTO POR LOCAL
				$idlocal    = $row1['idlocal'];	///CODIGO DEL LOCAL
				$inc	    = $row1['incentivado'];	
				$referencial= $row1['prelis'];	
				$prevta		= $row1['prevta'];
				$preuni     = $row1['preuni'];
			}
			}
			if (($referencial <> 0) and ($referencial <> $prevta))
			{
			$margenes       = ($margene/100)+1;
			$precio_ref     = $referencial/$factor;
			$precio_ref		= $precio_ref * $margenes;
			$precio_ref		= number_format($precio_ref,2,'.',',');
			$desc1	        = $precio_ref - $preuni;
				if ($desc1 < 0)
				{
				$descuento = 0;
				}
				else
				{
				$descuento      = (($precio_ref - $preuni)/$precio_ref)*100;
				}
			}
			else
			{
			$precio_ref		= $preuni;
			$descuento		= 0;

			}
			$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}
			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];	
			}
			}
			?>
		    <tr>
              <td width="<?php ancho(1);?>"><span class="Letras"><?php muestra(1);?></span></td>
              <td width="<?php ancho(2);?>"><span class="Letras"><?php muestra(2);?></span></td>
              <td width="<?php ancho(3);?>"><span class="Letras"><?php muestra(3);?></span></td>
              <td width="<?php ancho(4);?>"><span class="Letras"><?php muestra(4);?></span></td>
              <td width="<?php ancho(5);?>"><span class="Letras"><?php muestra(5);?></span></td>
              <td width="<?php ancho(6);?>"><span class="Letras"><?php muestra(6);?></span></td>
              <td width="<?php ancho(7);?>"><span class="Letras"><?php muestra(7);?></span></td>
              <td width="<?php ancho(8);?>"><span class="Letras"><?php muestra(8); ?></span></td>
            </tr>
			<?php $i++;
			}
			}
			if($i<($flinpag+1))
			{
				while($i<=$flinpag)
				{
		    ?>
            <tr>
              <td width="<?php ancho(1);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(2);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(3);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(4);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(5);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(6);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(7);?>" class="main_text">&nbsp;</td>
              <td width="<?php ancho(8);?>" class="main_text">&nbsp;</td>
            </tr>
			<?php $i++;
		   		}
		   }
		  ?>
          </table>
		  
		  </td>
        </tr>
      </table>
	  <br>
	  <table width="857" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td>
		    <?php
			$ii = 1;
			$ic = 1;
			while($ii <= $llinea2)
			{
			?>
			<table width="847" border="0" align="center">
              <tr>
                <td><?php		  
				   $ic = 1;
					$sql="SELECT columna,descbrev,campo,cuanto,linea FROM formato inner join titultabladet on formato.descripcion = titultabladet.codtab where sucursal = '$sucursal' and tipodoc = '$rd' and titulo = 'PIE' and state = '1' and linea = '$ii' and campo <> 'montext' order by linea, columna";
					$result = mysqli_query($conexion,$sql);
					if (mysqli_num_rows($result)){
					while ($row = mysqli_fetch_array($result)){
							$lin           = $row['linea'];
							$col   		   = $row['columna'];
							$desc   	   = $row['descbrev'];
							$cam	       = $row['campo'];
							$long	       = $row['cuanto'];
							if ($ic == $col)
							{
								$sumlet = 0;
								if($contit == 1)
								{
								echo '<b><span class="Letras">';echo $desc;echo '</span></b>&nbsp;';
								$sumlet = strlen($desc);
								}						
								echo '<b><span class="Letras">';echo $numero_formato_frances = number_format($var[$cam], 2, '.', ' ');echo '</span></b>&nbsp;';
								$totlet = $sumlet + $long;
								$ic     = $totlet;
							}
							else
							{
								while($ic <= $col)
								{
							?>
                  &nbsp;
							<?php $ic++;
								}
								$sumlet = 0;
								if($contit == 1)
								{
								echo '<b><span class="Letras">';echo $desc;echo '</span></b>&nbsp;';
								$sumlet = strlen($desc);
								}
								echo '<b><span class="Letras">';echo $numero_formato_frances = number_format($var[$cam], 2, '.', ' ');echo '</span></b>&nbsp;';
								$totlet = $sumlet + $long;
								$ic     = $totlet;
							}
					}
					}
					else
					{
						while($ic <= $ccolumna2)
						{
					?>
						&nbsp;
					<?php $ic++;
						}
					}
				?>				</td>
              </tr>
            </table>
			<?php $ii++;
			}
			?></td>
        </tr>
      </table>
	  <br />	  
	  <table width="857" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td>
		  <?php $ii  = 1;
		  $icc = 1;
		  while($ii <= $llinea2)
		  {
		  ?>
		  <table width="847" border="0" align="center">
            <tr>
              <td><?php $icc = 1;
					$sql="SELECT columna,descbrev,campo,cuanto FROM formato inner join titultabladet on formato.descripcion = titultabladet.codtab where sucursal = '$sucursal' and tipodoc = '$rd' and titulo = 'PIE' and state = '1' and linea = '$ii' and campo = 'montext' order by linea, columna";
					$result = mysqli_query($conexion,$sql);
					if (mysqli_num_rows($result)){
					while ($row = mysqli_fetch_array($result)){
							$lin1          = $row['linea'];
							$col1   	   = $row['columna'];
							$desc1   	   = $row['descbrev'];
							$cam1	       = $row['campo'];
							$long1	       = $row['cuanto'];
							if ($icc == $col1)
							{
								$sumlet = 0;
								//echo '<b>';echo $desc1;echo '</b>&nbsp;';
								$sumlet = strlen($desc1);
								$totlet = $sumlet + $long1;
								$icc     = $totlet;
								if ($cam1 == 'montext'){ echo '<span class="Letras">Son :'; echo $text_letra = strtoupper(letras2($monto_total)); echo ' Nuevos Soles</span>';}else{ echo substr($var[$cam1],0,$long1);}
							}
							else
							{
								while($icc <= $col1)
								{
							?>
                			&nbsp;
                			<?php $icc++;
								}
								$sumlet = 0;
								//echo '<b>';echo $desc1;echo '</b>&nbsp;';
								$sumlet = strlen($desc1);
								$totlet = $sumlet + $long1;
								$icc     = $totlet;
								if ($cam1 == 'montext'){ echo '<span class="Letras">Son :'; echo $text_letra = strtoupper(letras2($monto_total)); echo ' Nuevos Soles</span>';}else{ echo substr($var[$cam1],0,$long1);}
								$icc++;
							}
					}
					}
					else
					{
						while($icc <= $ccolumna2)
						{
					?>
                		&nbsp;
               		<?php $icc++;
						}
					}
				?>
              </td>
            </tr>
          </table>
		    <?php $ii++;
			}
			?>
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
