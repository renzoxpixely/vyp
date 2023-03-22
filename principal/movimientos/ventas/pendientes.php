<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../../titulo_sist.php');
include('../../local.php');
?>
<script>
// Si usuario pulsa tecla ESC, cierra ventana
function cerrar(e){
	tecla=e.keyCode
	if (tecla == 27)
	{
		window.close();
	}
}
function cerrars(e)
{
	var f    = document.form1;
	var cxr  = e;
	document.form1.target = "venta_principal";
	window.opener.location.href="exit1.php?invnum="+cxr;
	self.close();
}
</script>
<?php
	function formato($c) {
		printf("%08d",$c);
	} 
?>
<title><?php echo $desprod?> - INGRESOS PENDIENTES</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<body onkeyup="cerrar(event)">
<form name="form1">
	<table class="tabla2" width="442" border="0">
		<tr>
			<td width="540">
				<table width="438" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
					<tr>
						<td width="99"><strong>NUMERO</strong></td>
						<td width="191"><strong>FECHA</strong></td>
						<td width="134"><strong>MONTO</strong></td>
					</tr>
				</table>
				<div align="center"><img src="../../../images/line2.jpg" width="438" height="4" /></div>
				<?php
				echo $codloc;
				// Lee cotizaciones registradas y vigentes para la sucursal (baja=0)
				$sql="SELECT invfec,invnum,invtot FROM cotizacion where sucursal = '$codigo_local' and baja = '0' order by invnum";
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				?>
					<table width="438" border="0" align="center">
						<?php
						while ($row = mysqli_fetch_array($result)){
							$invfec         = $row['invfec'];
							$invnum         = $row['invnum'];
							$invtot         = $row['invtot'];
						?>
							<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
								<td width="98"><a href="javascript:cerrars(<?php echo $invnum?>)"><?php echo formato($invnum)?></a></td>
								<td width="192"><a href="javascript:cerrars(<?php echo $invnum?>)"><?php echo $invfec?></a></td>
								<td width="134"><a href="javascript:cerrars(<?php echo $invnum?>)"><?php echo $invtot?></a></td>
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
</form>
</body>
</html>
