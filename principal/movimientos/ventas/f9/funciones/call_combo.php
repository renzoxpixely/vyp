<?php function generaSelect()
{
	//include '../../../../conexion.php';
	$sql	= "SELECT codtab, destab FROM titultabladet where tiptab = 'D'";
	$result = mysqli_query($conexion,$sql); 
	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='departamento' id='departamento' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Seleccione un Departamento</option>";
	while($row=mysqli_fetch_array($result))
	{
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	}
	echo "</select>";
}
?>