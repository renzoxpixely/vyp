<?php 
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$ct = 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<style>
#boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
#boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
a:link,
a:visited {
color: #0066CC;
border: 0px solid #e7e7e7;
}
a:hover {
background: #fff;
border: 0px solid #ccc;
}
a:focus {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
}
a:active {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
} 
</style>
<?php $cr = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
?>
<script>
function validar_grid()
{
document.form1.method = "post";
document.form1.submit();
}
function validar_prodd()
{
var f = document.form1;
f.method = "post";
f.action="grabar_datos.php";
f.submit();
}
function sf()
{
document.form1.p1.focus();
}
var nav4 = window.Event ? true : false;

function ent(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		    var f = document.form1;
			f.method = "post";
			f.action="grabar_datos.php";
			f.submit();
	}
	else
	{
	return (key <= 13 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57));
	}
}

</script>
</head>
<?php 
function tablaslocal($nomloc)
{
	if ($nomloc == "LOCAL0")
	{
		$tabla = 's000';
	}
	if ($nomloc == "LOCAL1")
	{
		$tabla = 's001';
	}
	if ($nomloc == "LOCAL2")
	{
		$tabla = 's002';
	}
	if ($nomloc == "LOCAL3")
	{
		$tabla = 's003';
	}
	if ($nomloc == "LOCAL4")
	{
		$tabla = 's004';
	}
	if ($nomloc == "LOCAL5")
	{
		$tabla = 's005';
	}
	if ($nomloc == "LOCAL6")
	{
		$tabla = 's006';
	}
	if ($nomloc == "LOCAL7")
	{
		$tabla = 's007';
	}
	if ($nomloc == "LOCAL8")
	{
		$tabla = 's008';
	}
	if ($nomloc == "LOCAL9")
	{
		$tabla = 's009';
	}
	if ($nomloc == "LOCAL10")
	{
		$tabla = 's010';
	}
	if ($nomloc == "LOCAL11")
	{
		$tabla = 's011';
	}
	if ($nomloc == "LOCAL12")
	{
		$tabla = 's012';
	}
	if ($nomloc == "LOCAL13")
	{
		$tabla = 's013';
	}
	if ($nomloc == "LOCAL14")
	{
		$tabla = 's014';
	}
	if ($nomloc == "LOCAL15")
	{
		$tabla = 's015';
	}
	if ($nomloc == "LOCAL16")
	{
		$tabla = 's016';
	}
	return $tabla;
}
$sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}
$Tabla = tablaslocal($nomloc);
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");	//LOCAL DEL USUARIO
require_once("../../local.php");	//LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";

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
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";	
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
?>
<body <?php if ($valform==1){ ?>onload="sf();"<?php }else{?> onload="getfocus();"<?php }?> id="body">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table width="932" border="0" class="tabla2">
  <tr>
    <td width="951"><table width="99%" border="0" align="center">
      <tr>
	  <td width="9"></td>
	  <td width="116">&nbsp;</td>
	  <td width="10">	  </td>
	  <td width="191">&nbsp;</td>
        <td width="300"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local?></span></div></td>
        <td width="263"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
      </tr>
    </table>
	<img src="../../../images/line2.png" width="920" height="4" />
      <table width="915" border="0" align="center">
      <tr>
        <td width="305"><strong>PRODUCTO</strong></td>
        <td width="60"><strong>STOCK UNID</strong></td>
        <td width="130"><div align="center"><strong>MARCA</strong></div></td>
        <td width="67"><div align="center"><strong>DIGEMID </strong></div></td>
        <td width="65"><div align="center"><strong>MODIFICAR</strong></div></td>
    </tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php if ($val <> "")
	  {
	  if ($val == 1)
	  {
	  $sql="SELECT codpro,desprod,digemid,stopro,codmar,$Tabla FROM producto where desprod like '$search%' order by desprod ";
	  }
	   
	  
	  if ($val == 2)
	  {
	  $sql="SELECT codpro,desprod,digemid,stopro,codmar,$Tabla FROM producto where codmar = '$search' order by desprod ";
	
	  }
	  
	   if ($val == 3)
	  {
	  $sql="SELECT codpro,desprod,digemid,codmar,$Tabla FROM producto order by codmar ";
	
	  }

	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="915" border="0" align="center" id="myTab">
          <?php $cr = 1;
		  	$cont = 1;
			while ($row = mysqli_fetch_array($result)){
				
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];	
				$digemid         = $row['digemid'];
				$codmar         = $row['codmar'];
				$stopro         = $row['stopro'];
                                
				$sql1="SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$destab    = $row1['destab'];
				}
				}
				if ($ct == 1)
				{
					$color = "#99CCFF";	
				}
				else
				{
					$color = "#FFFFFF";
				}
				$t = $cont % 2;
				if ($t == 1) {
					$color = "#D2E0EC";
				} else {
					$color = "#ffffff";
				}
				$cont++;
		  ?>
		  <tr bgcolor="<?php echo $color;?>" onmouseover=this.style.backgroundColor='#FFFF99';this.style.cursor='hand'; onmouseout=this.style.backgroundColor="<?php echo $color;?>";>
                      
                        <td  width="315">
                            <a tabindex="1" id="l<?php echo $cr;?>" href="digemid2.php?val=<?php echo $val?>&search=<?php echo $search?>&valform=1&codpros=<?php echo $codpro?>"><?php echo $desprod?></a>
                        </td>
                        
                                          <td width="60">
			<div align="center"><?php echo $stopro?></div>
			</td>   
                        
                        <td width="160">
			<div align="center"><?php echo $destab?></div>
			</td>
              
                      
                        
			<td width="67">
			<div align="center">
			<?php if (($valform == 1) and ($codpros == $codpro)){
                            ?>
                            
			<input name="p1" type="text" id="p1" size="8" value="<?php echo $digemid?>"  onkeypress="return ent(event);" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $digemid;
			}
			?>
			</div>
                        </td>
                        
                       
                        <td width="65">
                            <div align="center">
                        <?php if (($valform == 1) and ($codpros == $codpro)){?>

                        <input name="val" type="hidden" id="val" value="<?php echo $val?>" />

                        <input name="search" type="hidden" id="search" value="<?php echo $search?>" />
                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
                        <input name="button" type="button" id="boton" onclick="validar_prodd()" alt="GUARDAR"/>
                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
                        <?php }
                                    else
                                    {
                                    ?>
                        <a href="digemid2.php?val=<?php echo $val?>&search=<?php echo $search?>&valform=1&codpros=<?php echo $codpro?>">
                          <img src="../../../images/add1.gif" width="14" height="15" border="0"/>			  </a>
                        <?php }
                                    ?>
                        </div>
                        </td>
                </tr>
		  <?php }
		  ?>
        </table>
      <?php $cr++;
	  }
	  }
	  ?>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
