<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../archivo/css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
<style>
#boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
#boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
</style>
<style type="text/css">
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
        font-size: 18px;
}
.Estilo2 {
	color: #282727;
	font-weight: bold;
        font-size: 18px;
}
</style>
<script>
function validar_grid()
{
document.form1.method = "post";
document.form1.submit();
}


function validar_prod()
{
var f = document.form1;

  var v3 = parseFloat(document.form1.puntos.value);	
  var v1 = parseFloat(document.form1.p1.value);	
  
  
if ((f.p1.value == "") || (f.p1.value == "0"))
    { alert("Ingrese una Cantidadww" + v1); f.p1.focus(); return; }
    if (f.p3.value == "")
  { alert("Ingrese una descripcion"); f.p3.focus(); return; }
    if (v3 < v1)
  { alert("La cantidad ingresada excede a los puntos acomulados"); f.p1.focus(); return; }

f.method="post";
f.action="grabar_datos1.php";
f.submit();
}
function validar_prod2(){
var f = document.form1;
var mensaje=confirm("DESEA GRABAR ESTA INFORMACION");
if(mensaje){
f.method="post";
f.action="grabar_datos.php";
f.submit();
			
}else{
f.method="post";
f.action="grabar_datos2.php";
f.submit();
                }
                }



function sf()
{
document.form1.p1.focus();
}

</script>
</head>
    
    
    
<?php
$date = date('Y-m-d');


$sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");	//LOCAL DEL USUARIO
require_once("../../local.php");	//LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
  $sql1="SELECT COUNT(codtempun) as count  from temp_puntos";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$count   = $row1['count'];
				}
				}
function formato($c) {
printf("%08d",$c);
} 
$codclis = isset($_REQUEST['codclis']) ? ($_REQUEST['codclis']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
?>
<body <?php if ($valform==1){ ?>onload="sf();"<?php }?>>
<form id="form1" name="form1"  onKeyUp="highlight(event)" onClick="highlight(event)">
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
        <td width="180"><strong>CLIENTE</strong></td>
        <td width="100" align="center"><strong>DNI</strong></td>
<!--        <td width="89"><div align="right"><strong>P. COSTO</strong></div></td>
	<td width="71"><div align="right"><strong>MARGEN % </strong></div></td>
        <td width="77"><div align="right"><strong>P. VENTA </strong></div></td>
        <td width="90"><div align="right"><strong>P. VENTA UNIT </strong></div></td>-->
        <td width="40"><div align="left"><strong>PUNTOS ACOMULADOS. </strong></div></td>
        <td width="40"><div align="left"><strong>PUNTOS A DESCONTAR. </strong></div></td>
        <td width="80"><div align="right"><strong>DESCRIPCION</strong></div></td>
        <?php IF ($count == 0){?>
        <td width="68"><div align="center"><strong> DESCONTAR</strong></div></td>
        <?php }else{?>
        <td width="68"><div align="center"><strong> GRABAR</strong></div></td>
        <?php }?>
      </tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php if ($val <> "")
	  {
//	  $sql="SELECT codcli,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,blister,preblister FROM producto where codcli = '$search'";
	  $sql="SELECT codcli,descli,dnicli,puntos FROM cliente where codcli = '$search'  " ;
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="915" border="0" align="center">
          <?php while ($row = mysqli_fetch_array($result)){
				$codcli         = $row['codcli'];
				$descli        = $row['descli'];
				$puntos        = $row['puntos'];
				$dnicli        = $row['dnicli'];
			
                                
                                
//                                $sql1="SELECT despunto FROM puntos where codclic ='$search' ";
//				$result1 = mysqli_query($conexion,$sql1);
//				if (mysqli_num_rows($result1)){
//				while ($row1 = mysqli_fetch_array($result1)){
//					$despunto    = $row1['despunto'];
//				}
//				}
                                
                                $sql1="SELECT pdescuento,despunto FROM temp_puntos where codclic ='$search' ";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$despunto    = $row1['despunto'];
					$pdescuento    = $row1['pdescuento'];
				}
				}
                                $sql1="SELECT COUNT(codtempun) as count  from temp_puntos";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$count   = $row1['count'];
				}
				}
                                
                                
		  ?>
		  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                    <td width="150"><?php echo "<p class='Estilo2'>$descli</p>";?></td>
                    <td width="90"><?php echo "<p class='Estilo2'>$dnicli</p>";?></td>

                    
                    <td width="40" align="center">
                       <?php IF($puntos <= 0){ echo "<p class='Estilo1'>$puntos</p>";} else { echo "<H2> $puntos </H2>"; }?>
                    </td>
                    <td width="40">
                        <div align="center">
                        <?php if (($valform == 1) and ($codclis == $codcli)){?>
                            <input name="p1" type="text" id="p1" size="8" value=""   onkeypress="return acceptNum(event)" <?php if ($puntos > 0){  } else {?>disabled="disabled"<?php }?> />
                            <input name="puntos3" type="hidden" id="puntos4" value="<?php echo $pdescuento?>" />
                            <input name="puntos" type="hidden" id="puntos" value="<?php echo $puntos?>" />
			<?php }
                        else
			{
			echo $pdescuento;
			}
			?>
			</div>
                    </td>
                    <td width="80">
			<div style="width: 75px; height: 75px;" align="center">
			<?php if (($valform == 1) and ($codclis == $codcli)){?>
			    <!--<input name="p3" type="text" id="p3" size="20" value=""/>-->
                  <textarea name="p3" id="p3" cols="20" rows="4" class="Estilodany" <?php echo $despunto?>  <?php if ($puntos > 0){  } else {?>disabled="disabled"<?php }?>></textarea>
			<?php }
			else
			{
			echo $despunto;
			}
			?>
			</div>			
                    </td>
                    <td width="68">
                        <div align="center">
                    <?php if (($valform == 1) and ($codclis == $codcli)){?>
                    <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
                    <input name="date" type="hidden" id="date" value="<?php echo $date?>" />
                    <input name="search" type="hidden" id="search" value="<?php echo $search?>" />
                    <input name="codcli" type="hidden" id="codcli" value="<?php echo $codcli?>" />
                    <!--<input name="button" type="button" id="boton" onclick="validar_prod()" alt="ACEPTAR"/>-->
                    <!--<input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>-->
                    <input name="button2" type="button" id="boton1" onclick="validar_prod()" alt="ACEPTAR"/>
                    <?php }
			  else
			  {
                              if($count == 0){
			  ?>
                    <a href="puntos2.php?val=<?php echo $val?>&&search=<?php echo $search?>&&valform=1&&codclis=<?php echo $codcli?>">
                    <img src="../../../images/add1.gif" width="14" height="15"  border="0"   />			  
                    
                    </a>
                          <?php } else{?>
                              
                    <!--<input name="button2" type="button" id="boton2" onclick="validar_prod2()" value="GUARDAR"/>-->
                       <input name="button" type="button" id="boton" onclick="validar_prod2()" alt="GUARDAR"/>
                    <input name="codcli" type="hidden" id="codcli" value="<?php echo $codcli?>" />
                        <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
                    <input name="search" type="hidden" id="search" value="<?php echo $search?>" />
                         <?php }
                          
                              }
                    ?>
                        </div>
                    </td>
                </tr>
		  <?php }
		  ?>
        </table>
      <?php }
	  }
	  ?>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
