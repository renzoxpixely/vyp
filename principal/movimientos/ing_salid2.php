<?php 
require_once ('../../conexion.php');
include('../session_user.php');
$date	 = isset($_REQUEST['date']) ? ($_REQUEST['date']) : "";
$tipo	 = isset($_REQUEST['type']) ? ($_REQUEST['type']) : "";	//INGRESO O UNA SALIDA	1= INGRESO 2= SALIDA
$reg	 = isset($_REQUEST['reg']) ? ($_REQUEST['reg']) : "";	/// SI ES REGISTRO O CINSULTA 1 - REGISTRO, 2 - CONSULTA
$rd      = isset($_REQUEST['rd']) ? ($_REQUEST['rd']) : "";	//COMPRAS, ETC..
$DatosProveedor      = isset($_REQUEST['DatosProveedor']) ? ($_REQUEST['DatosProveedor']) : "";
////////////////////////////////////////////////////////////
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
				$codloc    = $row['codloc'];
	}
}
//echo $tipo;
//echo $rd;
//echo $reg;
$_SESSION['sesIGV'] = 0; 
/////CALCULOS DE NUMERO DE DOCUMENTOS
if ($tipo == 1)		/////INGRESOS
{
	if($rd == 1)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			//$pagina	 = 'compras/compras.php?DatosProveedor='.$DatosProveedor;
			$pagina	 = 'compras/compras_busca_copy.php?DatosProveedor='.$DatosProveedor;
		}
		if ($reg == 2)
		{
			$pagina	 = 'consulta_compras/consult_compras.php';
		}
	}
	if($rd == 2)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'transferencia_ing/transferencia_ing.php';
		}
		if ($reg == 2)
		{
			$pagina	 = 'consulta_transferencia_ing/cons_transferencia_ing.php';
		}
	}
	if($rd == 3)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'devolucion/devolucion.php';
		}
		if ($reg == 2)
		{
			$pagina	 = 'cons_devolucion/devolucion.php';
		}
	}
	if($rd == 4)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'compras.php';
		}
		if ($reg == 2)
		{
		
		}
	}
	if($rd == 5)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'ingresos_varios/ingresos_varios.php';
		}
		if ($reg == 2)
		{
			$pagina	 = 'consultas_ingresos_varios/ingresos_varios.php';
		}
	}
	if($rd == 6)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'preingreso/compras.php?DatosProveedor='.$DatosProveedor;
		}
		if ($reg == 2)
		{
			$pagina	 = 'consultas_preingresos/consultas_preingresos.php';
		}
	}
}
else				/////SALIDAS
{
	if($rd == 1)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'salidas_varias/salidas_varias.php';
		}
		if ($reg == 2)
		{
			$pagina	 = 'consulta_salidas_varias/consulta_salidas_varias.php';
		}
	}
	if($rd == 2)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'compras.php';
		}
		if ($reg == 2)
		{
		
		}
	}
	if($rd == 3)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'transferencia_sal/transferencia_sal.php';
		}
		if ($reg == 2)
		{
			$pagina	 = 'consulta_transferencia_sal/cons_transferencia_sal.php';
		}
	}
	if($rd == 4)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'compras.php';
		}
		if ($reg == 2)
		{
		
		}
	}
	if($rd == 5)
	{
		$num_doc = 1;
		if ($reg == 1)
		{
			$pagina	 = 'compras.php';
		}
		if ($reg == 2)
		{
		
		}
	}
}

//if (!isset($_SESSION["usuario"]))
//{
	
	if ($rd <> "")
	{
		// Recuperar el nÃÂºmero de documento siguiente (secuencia)
		//$sql="SELECT numdoc FROM movmae where tipmov = '$tipo' and tipdoc = '$rd' order by numdoc desc limit 1";
		$sql="SELECT numdoc FROM movmae order by numdoc desc limit 1";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
				$numdoc = $row[0];		//codigo
			}
			$numdoc	= $numdoc + 1;
		}
		else // Si no hay datos, usar el primer nÃÂºmero (1)
		{
			$numdoc = $num_doc;
		}
		// Solamente insertar para las opciones de "registro" (no de consulta)
		if ($reg == 1)
		{
		mysqli_query($conexion,"INSERT INTO movmae (invfec,usecod,numdoc,tipmov,tipdoc,proceso,val_habil,sucursal) values ('$date','$usuario','$numdoc','$tipo','$rd','1','0','$codloc')");
		/////SESIONES
		}
		header("Location: $pagina"); 
	}
	else
	{
		header("Location: ing_salid.php"); 
	}
/*}
else
{
//header("Location: ing_salid.php");
}*/
?>