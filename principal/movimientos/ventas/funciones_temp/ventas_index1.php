<?php
require_once('../../../conexion.php');
$sql = "SELECT vendedorventa FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $vendedorventa = $row['vendedorventa'];
    }
}
?>
<script language="JavaScript">
    function salir1()
    {
        var f = document.form1;
        f.method = "POST";
        f.target = "_top";
        f.action = "ventas_salir_temp.php";
        f.submit();
    }
    function buscar()
    {
        var f = document.form1;
        //ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
        //if (ventana) {
        f.method = "POST";
        f.target = "_top";
        f.action = "ventas_buscar.php";
        f.submit();
        //}
    }
    function cancelar()
    {
        var f = document.form1;
        ventana = confirm("Desea cancelar esta venta");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "ventas_cancel_temp.php";
            f.submit();
        }
    }
    function grabar1()
    {
        var f = document.form1;
    <?php
        if ($vendedorventa == 1) {
    ?>
            var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
            if (claveVendedor !== null)
            {
                $.ajax({
                    type: "GET",
                    url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                    async: true,
                    success: function(datos) {
                        var dataJson = eval(datos);
                        var contad = 0;
                        for (var i in dataJson) 
                        {
                            contad++;
                            //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                        }
                        if (contad > 0)
                        {
                            window.open('preimprimir_temp.php?CodClaveVendedor=c'+ claveVendedor,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
                            
                        }
                        else
                        {
                            alert("No existe el Usuario");return;
                        }
                    },
                    error: function(obj, error, objError) {
                        //avisar que ocurri� un error
                    }
                });
            }
    <?php
        } 
        else 
        {
    ?>
            window.open('preimprimir_temp.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
    <?php
        }
    ?>
    }
</script>