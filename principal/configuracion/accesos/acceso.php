<?php include('../../session_user.php');
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/body.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/functions.php");?>
<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
</head>
<body>
<div class="tabla1">
	<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>
	<table width="666" border="0" align="center">
	  <tr>
		<td>
		<center>
		<iframe src="acceso1.php" name="iFrame1" width="740" height="680" scrolling="No" frameborder="No" id="iFrame1" allowtransparency="True"></iframe>
		</center>
		</td>
	  </tr>
	</table>
</div>
</body>
</html>
