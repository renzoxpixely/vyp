<script language="JavaScript">
function salir1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_salir.php";
	 f.submit();
}
function buscar()
{
	 var f = document.form1;
	 //ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
	 //if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_buscar.php";
	 f.submit();
	 //}
}
function cancelar()
{
	 var f = document.form1;
	 ventana=confirm("Desea cancelar esta Cotizacion");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_cancel.php";
	 f.submit();
	 }
}
function grabar1()
{
	 var cod = parseFloat(document.form1.cod.value);		
	 var f = document.form1;
	 ventana=confirm("Desea Grabar esta Cotizacion" );
	 if (ventana) {
             
	 ventana2=confirm("EL NUMERO DE COTIZACION ES "+ cod );
	 if (ventana2) {
             
             
	 f.method = "post";
	 f.target = "_top";
	 f.action ="venta_reg.php";
	 f.submit();
	 }
         }
}
</script>