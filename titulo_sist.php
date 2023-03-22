<?php $sql="SELECT desemp FROM datagen";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$desemp = $row['desemp'];
}
}
?>