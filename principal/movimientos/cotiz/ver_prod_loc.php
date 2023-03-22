<?php include('../../session_user.php');
$venta   = $_SESSION['cotiz'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<?php $sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codloc    = $row['codloc'];
}
}
$sql="SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$nomloc    = $row['nomloc'];
}
}
$cod	 = $_REQUEST['cod'];
$sql="SELECT desprod,codmar,codfam,factor,margene,costre,prevta,preuni,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$codfam         = $row['codfam'];
			$factor         = $row['factor'];
			$margene        = $row['margene'];
			$costre         = $row['costre'];
			$prevta         = $row['prevta'];
			$preuni         = $row['preuni'];
			$s000	        = $row['s000'];
			$s001	        = $row['s001'];
			$s002           = $row['s002'];
			$s003           = $row['s003'];
			$s004           = $row['s004'];
			$s005           = $row['s005'];
			$s006           = $row['s006'];
			$s007           = $row['s007'];
			$s008           = $row['s008'];
			$s009           = $row['s009'];
			$s010           = $row['s010'];
			$s011           = $row['s011'];
			$s012           = $row['s012'];
			$s013           = $row['s013'];
			$s014           = $row['s014'];
			$s015           = $row['s015'];
			$s016           = $row['s016'];
			$sql1="SELECT * FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			$marca        = $row1['destab'];
			}
			}
			$sql1="SELECT * FROM titultabladet where tiptab = 'F' and codtab = '$codfam'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			$familia      = $row1['destab'];
			}
			}
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL0'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre1      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL1'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre2      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL2'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre3      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL3'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre4     = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL4'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre5      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL5'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre6      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL6'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre7      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL7'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre8      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL8'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre9      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL9'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre10      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL10'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre11      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL11'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre12      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL12'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre13      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL13'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre14      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL14'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre15      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL15'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre16      = $row1['nombre'];
}
}
$sql1="SELECT nombre FROM xcompa where nomloc = 'LOCAL16'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nombre17      = $row1['nombre'];
}
}
?>
<script>
function getfocus1(){
document.getElementById('l1').focus();
}
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
</script>
<title><?php echo $desprod?></title>
<script>
function cerrar_popup(valor)
{
//ventana=confirm("Desea Grabar este Cliente");
var prod = valor;
document.form1.target = "venta_principal";
window.opener.location.href="salir.php?prod="+prod;
self.close();
}
</script>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF; font-weight: bold; }
.Estilo3 {color: #FFFFFF}
-->
</style>
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
<table class="tabla2" width="991" border="0">
  <tr>
    <td width="988"><table width="982" border="0">
      <tr>
        <td width="79" bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>DESCRIPCION</strong></td>
        <td width="893" bgcolor="#FFFF99"><?php echo $desprod?></td>
      </tr>
      <tr>
        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>MARCA</strong></td>
        <td bgcolor="#FFFF99"><?php echo $marca?></td>
      </tr>
      <tr>
        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>LINEA</strong></td>
        <td bgcolor="#FFFF99"><?php echo $familia?></td>
      </tr>
      <tr>
        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>FACTOR</strong></td>
        <td bgcolor="#FFFF99"><?php echo $factor?></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="991" border="0" class="tabla2">
  <tr>
    <td width="987"><table width="982" border="0" bgcolor="#CCFFCC">
      <tr>
        <td width="47" class="text_combo_select"><div align="right"><strong><?php if($nombre1 == ""){?>LOCAL0<?php }else{ echo $nombre1; }?></strong></div></td>
        <td width="49" class="text_combo_select"><div align="right"><strong><?php if($nombre2 == ""){?>LOCAL1<?php }else{ echo $nombre2; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre3 == ""){?>LOCAL2<?php }else{ echo $nombre3; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre4 == ""){?>LOCAL3<?php }else{ echo $nombre4; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre5 == ""){?>LOCAL4<?php }else{ echo $nombre5; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre6 == ""){?>LOCAL5<?php }else{ echo $nombre6; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre7 == ""){?>LOCAL6<?php }else{ echo $nombre7; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre8 == ""){?>LOCAL7<?php }else{ echo $nombre8; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre9 == ""){?>LOCAL8<?php }else{ echo $nombre9; }?></strong></div></td>
        <td width="48" class="text_combo_select"><div align="right"><strong><?php if($nombre10 == ""){?>LOCAL9<?php }else{ echo $nombre10; }?></strong></div></td>
        <td width="58" class="text_combo_select"><div align="right"><strong><?php if($nombre11 == ""){?>LOCAL10<?php }else{ echo $nombre11; }?></strong></div></td>
        <td width="54" class="text_combo_select"><div align="right"><strong><?php if($nombre12 == ""){?>LOCAL11<?php }else{ echo $nombre12; }?></strong></div></td>
        <td width="59" class="text_combo_select"><div align="right"><strong><?php if($nombre13 == ""){?>LOCAL12<?php }else{ echo $nombre13; }?></strong></div></td>
        <td width="57" class="text_combo_select"><div align="right"><strong><?php if($nombre14 == ""){?>LOCAL13<?php }else{ echo $nombre14; }?></strong></div></td>
        <td width="61" class="text_combo_select"><div align="right"><strong><?php if($nombre15 == ""){?>LOCAL14<?php }else{ echo $nombre15; }?></strong></div></td>
        <td width="69" class="text_combo_select"><div align="right"><strong><?php if($nombre16 == ""){?>LOCAL15<?php }else{ echo $nombre16; }?></strong></div></td>
        <td width="74" class="text_combo_select"><div align="right"><strong><?php if($nombre17 == ""){?>LOCAL16<?php }else{ echo $nombre17; }?></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="991" border="0" class="tabla2">
  <tr>
    <td width="987"><table width="982" border="0">
      <tr>
        <td width="47" class="text_combo_select"><div align="right"><?php echo $s000?></div></td>
        <td width="49" class="text_combo_select"><div align="right"><?php echo $s001?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s002?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s003?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s004?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s005?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s006?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s007?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s008?></div></td>
        <td width="48" class="text_combo_select"><div align="right"><?php echo $s009?></div></td>
        <td width="58" class="text_combo_select"><div align="right"><?php echo $s010?></div></td>
        <td width="54" class="text_combo_select"><div align="right"><?php echo $s011?></div></td>
        <td width="59" class="text_combo_select"><div align="right"><?php echo $s012?></div></td>
        <td width="57" class="text_combo_select"><div align="right"><?php echo $s013?></div></td>
        <td width="61" class="text_combo_select"><div align="right"><?php echo $s014?></div></td>
        <td width="69" class="text_combo_select"><div align="right"><?php echo $s015?></div></td>
        <td width="74" class="text_combo_select"><div align="right"><?php echo $s016?></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<form name="form1" id="form1">
<table width="991" border="0" class="tabla2">
  <tr>
    <td>
	<?php /*?><iframe src="ver_prod_loc1.php?cod=<?php echo $cod?>&codfam=<?php echo $codfam?>" name="iFrame1" width="<?php if ($resolucion == 1){?>710<?php }else{?>970<?php }?>" height="200" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
    </iframe>
	<?php */
	?>
    <table width="983" border="0" bgcolor="#50ADEA">
      <tr>
        <td width="33"><div align="center" class="Estilo2">
            <div align="left">N�</div>
        </div></td>
		<td width="425"><div align="center" class="Estilo2">
            <div align="left">PRODUCTO</div>
        </div></td>
		<td width="105"><div align="center" class="Estilo2">
            <div align="left">MARCA</div>
        </div></td>
		<td width="80"><div align="center" class="Estilo2">
            <div align="right">PRECIO REF</div>
		</div></td>
		<td width="66"><div align="center" class="Estilo2">
            <div align="right">DCTOS</div>
		</div></td>
		<td width="81"><div align="center" class="Estilo2">
            <div align="right">PRECIO Caja</div>
		</div></td>
		<td width="86"><div align="center" class="Estilo2">
            <div align="right">PRECIO Unid</div>
		</div></td>
		<td width="73"><div align="center" class="Estilo2">
            <div align="right">STOCK U.</div>
		</div></td>
      </tr>
    </table>
    <?php $i = 1;
$sql="SELECT codpro,desprod,codmar,codfam,factor,margene,costre,preuni,prelis,prevta,factor,incentivado,pcostouni,$tabla,margene FROM producto where codfam = '$codfam'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
    <table width="983" border="0">
      <?php while ($row = mysqli_fetch_array($result)){
			$codigo         = $row['codpro'];
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$codfam         = $row['codfam'];
			$factor         = $row['factor'];
			$margene        = $row['margene'];
			$costre         = $row['costre'];
			$preuni     	= $row['preuni'];
			$referencial  	= $row['prelis'];
			$prevta		  	= $row['prevta'];
			$factor     	= $row['factor'];
			$incentivado    = $row['incentivado'];
			$pcostouni      = $row['pcostouni'];
			$margene        = $row['margene'];
			$cant_loc  		= $row[13];
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
			$sql1="SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];
				$marca1    = $row1['abrev'];	
			}
			}
			if (($incentivado == 1) and ($cant_loc > 0))
			{
			$color = "prodincent";
			$text  = "text_prodincent";
			}
			else
			{
				if ($cant_loc > 0)
				{
				$color = "prodnormal";
				$text  = "text_prodnormal";
				}
				else
				{
				$color = "prodstock";
				$text  = "text_prodstock";
				}
			}
?>
      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="33"><span class="<?php echo $text?>"><?php echo $i++?>-</span></td>
		<td width="425">
		<a id="l1" href="javascript:cerrar_popup(<?php echo $codigo?>)">
		  <?php if ($codigo == $cod){ ?>
          <b><?php echo $desprod?></b>
          <?php } else {echo $desprod;}?>
		</a>		
		</td>
		<td width="105"><span class="<?php echo $text?>"><b><?php if ($marca1 == ""){echo substr($marca,0,5);echo "...";} else { echo substr($marca1,0,5);echo "...";}?></b></span></td>
		<td width="80"><div align="right"><span class="<?php echo $text?>"><b><?php echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' ');?></span></div></td>
		<td width="66"><div align="right"><span class="<?php echo $text?>"><b><?php echo $numero_formato_frances = number_format($descuento, 0, '.', ' ');?>%</b></span></div></td>
		<td width="81"><div align="right"><span class="<?php echo $text?>"><b><?php echo $prevta?></b></span></div></td>
		<td width="86"><div align="right"><span class="<?php echo $text?>"><b><?php echo $preuni?></b></span></div></td>
        <td width="73">
		<div align="right">
		<span class="<?php echo $text?>">
            <?php if ($codigo == $cod){ ?>
            <b><?php echo $cant_loc?></b>
            <?php } else {echo $cant_loc;}?>
		</span>        </div>		</td>
      </tr>
      <?php }
?>
    </table>
    <?php }
?></td>
  </tr>
</table>
</form>
</body>
</html>
