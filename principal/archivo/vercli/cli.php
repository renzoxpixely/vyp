<?php include('../../session_user.php');
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="css2/tablas.css" rel="stylesheet" type="text/css" />
<link href="css2/body.css" rel="stylesheet" type="text/css" />
<link href="css2/style.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<!--<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>-->
</head>
<body>
<div class="tabla1">
<!--<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>-->
<div class="title1">
<span class="titulos">LISTA DE CLIENTES
</span></div>
<div class="mask1111">
	<div class="mask2222">
		<div class="mask3333">
			<iframe src="cli1.php" name="principal" width="1400" height="600" scrolling="Automatic" frameborder="0" id="principal" allowtransparency="0">
			</iframe>
  	  </div>
	</div>
   </div>
  </div>
</body>
</html>
