<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
function formato($c) {
printf("%08d",$c);
} 
?>
<body>
<table width="932" border="0" class="tabla2">
  <tr>
    <td width="951"><table width="99%" border="0" align="center">
      <tr>
        <td width="602"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local?></span></div></td>
        <td width="303"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
      </tr>
    </table>
	<img src="../../../images/line2.png" width="920" height="4" />
      <table width="915" border="0" align="center">
      <tr>
        <td width="80"><strong>N&ordm; DOC </strong></td>
        <td width="91"><strong>FECHA</strong></td>
        <td width="163"><strong>PROVEEDOR</strong></td>
        <td width="243"><strong>USUARIO</strong></td>
		<td width="72"><div align="right"><strong>MONTO</strong></div></td>
		<td width="98"><div align="center"><strong>ESTADO</strong></div></td>
		<td width="83"><div align="center"><strong>CONFIRMAR</strong></div></td>
		<td width="51"><div align="center"><strong>DETALLE</strong></div></td>
      </tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php $sql="SELECT * FROM ordmae where preingreso = '1' and pendiente = '1'";
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="915" border="0" align="center">
          <?php while ($row = mysqli_fetch_array($result)){
				$invnum    = $row['invnum'];
				$nrocomp   = $row['nrocomp'];
				$invfec    = $row['invfec'];
				$provee    = $row['provee'];
				$invtot    = $row['invtot'];
				$codusu    = $row['codusu'];
				$conf      = $row['confirmado'];
				$preingreso    = $row['preingreso'];
				$altpreingreso = $row['altpreingreso'];
				$sql1="SELECT nomusu FROM usuario where usecod = '$codusu'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$nomuser    = $row1['nomusu'];
				}
				}
				$sql1="SELECT despro FROM proveedor where codpro = '$provee'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$proveedor    = $row1['despro'];
				}
				}
		  ?>
		  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
            <td width="80"><?php echo formato($nrocomp)?></td>
            <td width="91"><?php echo fecha($invfec)?></td>
            <td width="163"><?php echo $proveedor?></td>
            <td width="243"><?php echo $user?></td>
            <td width="72"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' ');?></div></td>
			<td width="98"><div align="center">
			<?php if ($altpreingreso == 1)
				{
					if ($conf == 1)
					{
					?>
					<a href="regingreso.php?invnum=<?php echo $invnum?>">
					INGRESAR
					</a>
					<?php }
				}
				else
				{
				echo "NO INGRESADO";
				}
				?>
			</div>
			</td>
            <td width="83">
			<div align="center">
			<?php if (($preingreso == 1) and ($altpreingreso == 0))
			{
				if ($conf == 0)
				{
				?>
				<a href="conf_preingreso.php?invnum=<?php echo $invnum?>&conf=<?php echo $conf?>">
				DESAUTORIZAR</a>
				<?php }
				else
				{
				?>
				<a href="conf_preingreso.php?invnum=<?php echo $invnum?>&conf=<?php echo $conf?>">
				AUTORIZAR</a>
				<?php }
			}
			?>
			</div>			
			</td>
            <td width="51">
			<div align="center">
			<a href="javascript:popUpWindow('ver_compras.php?invnum=<?php echo $invnum?>', 30, 140, 975, 480)">VER</a>			
			</div>
			</td>
          </tr>
		  <?php }
		  ?>
        </table>
      <?php }
	  ?>
    </div></td>
  </tr>
</table>
</body>
</html>
