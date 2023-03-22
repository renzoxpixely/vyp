<script language="JavaScript">
function precio()
{
	var v1 		= parseFloat(document.form1.text1.value);		//CANTIDAD
	var v2 		= parseFloat(document.form1.text2.value);		//PRECIO
	var factor  = parseFloat(document.form1.factor.value);		//FACTOR
	var total;
	var valor   = isNaN(v1);
		if (valor == true)			////NO ES NUMERO
		{
		var v1  = document.form1.text1.value.substring(1);	
		v1		= parseFloat(v1 * factor);
		total   = parseFloat(v1 * v2);
		}
		else
		{
		total   = parseFloat(v1 * v2);
		}
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	if(document.form1.text1.value!=''){
			document.form1.text3.value=total;
			document.form1.text333.value=total;
	}else{
			document.form1.text3.value='';
			document.form1.text333.value=total;
	}
}
function letraccc(evt)
{
    var key = nav4 ? evt.which : evt.keyCode;
	/////F4/////
	//alert(key);
	if (key == 115)
	{
	var codigo = document.form1.codpro.value; 
	window.open('ver_prod_loc.php?cod='+codigo+'','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=5,width=1010,height=350');
	}
	////ESC/////
	if (key == 27)
	{
	document.form1.val.value = "";
	document.form1.tipo.value = "";
	document.form1.submit();
	//window.opener.location.href="venta_index2.php";
	}
	////ENTER////
	if (key == 13)
	{
	  var f 	 = document.form1;
	  var v1 	 = parseFloat(document.form1.text1.value);			//CANTIDAD NGRESADA
	  var factor = parseFloat(document.form1.factor.value);			//FACTOR
	  var st 	 = parseFloat(document.form1.cant_prod.value);		//CANTIDAD ACTUAL POR LOCAL
	  if (f.text1.value == "")
	  { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
  		var valor = isNaN(v1);
		if (valor == true)									////NO ES NUMERO
		{
		document.form1.numero.value=1;		////avisa que no es numero
		var v1 = document.form1.text1.value.substring(1);	
		v1	   = parseFloat(v1 * factor);
		}
		else
		{
		document.form1.numero.value=0;		////avisa que es numero
		v1      = v1;						////ES NUMERO
		}
	  if (v1>st)
  	  { 
	  //alert("La cantidad Ingresada excede al Stock Actual del Producto"); 
	  ventana=confirm("La cantidad Ingresada excede al Stock Actual del Producto ¿Desea Grabar esta informacion?");
	     if (ventana) 
		 {
		  f.method = "post";
		  f.target = "venta_principal";
		  f.action ="venta_index2_reg.php";
		  f.submit();
		 }
		 else
		 {
		 f.text1.focus();
		 return; 
		 }
	  }
	  else
	  {
	  	    var v1 		= parseFloat(document.form1.text1.value);		//CANTIDAD
			var v2 		= parseFloat(document.form1.text2.value);		//PRECIO
			var factor  = parseFloat(document.form1.factor.value);		//FACTOR
			var total;
			var valor   = isNaN(v1);
				if (valor == true)			////NO ES NUMERO
				{
				var v1  = document.form1.text1.value.substring(1);	
				v1		= parseFloat(v1 * factor);
				total   = parseFloat(v1 * v2);
				}
				else
				{
				total   = parseFloat(v1 * v2);
				}
			total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
			if(document.form1.text1.value!=''){
					document.form1.text3.value=total;
					document.form1.text333.value=total;
			}else{
					document.form1.text3.value='';
					document.form1.text333.value=total;
			}
		  f.method = "post";
		  f.target = "venta_principal";
		  f.action ="venta_index2_reg.php";
		  f.submit();
	  }
	}
	return (key == 67 || key == 99 || key <= 13 || (key >= 48 && key <= 57));	
}
function abrir_index2(e) {
tecla=e.keyCode;
  if (tecla == 116)
  {
    	var popUpWin=0;
		var left  = 120;
		var top   = 120;
		var width = 880;
		var height= 220;
		if(popUpWin)
		{
		if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('buscaprod/tip_busqueda.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  }
  if (tecla == 115)
  {
    	var popUpWin=0;
		var left  = 120;
		var top   = 120;
		var width = 880;
		var height= 220;
		if(popUpWin)
		{
		if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  }
  if (tecla == 27)
  {
    document.form1.val.value = "";
	document.form1.tipo.value = "";
	document.form1.submit();
  }
   ////F11////
  if (tecla == 122)
  {
		var popUpWin=0;
		var left  = 90;
		var top   = 120;
		var width = 895;
		var height= 420;
		if(popUpWin)
		  {
			if(!popUpWin.closed) popUpWin.close();
		  }
		  popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  }
  ////F2///
 /* if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=240');
  }*/
  ////F4///
  if(tecla==115)
  {
	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
	 }
	 else
	 {
	 	 ventana=confirm("Desea cancelar esta venta");
		 if (ventana) {
		 f.method = "POST";
		 f.target = "_top";
		 f.action ="ventas_cancel.php";
		 f.submit();
		 }
	 }
  }
  ////F8///
  if(tecla==119)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Cotizacion Incompleta. Imposible Grabar"); f.num.focus(); return; 
	 }
	 else
	 {
	 	 ventana=confirm("Desea Grabar esta Cotizacion");
		 if (ventana) {
		 f.method = "post";
		 f.target = "_top";
		 f.action ="venta_reg.php";
		 f.submit();
		 }
	 }
  }
  /////F9/////
if(tecla==120)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Cotizacion Incompleta. Imposible de Imprimir"); f.num.focus(); return; 
	 }
	 else
	 {
//  	  window.open('imprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
                var cod = parseFloat(document.form1.cod.value);		
                 ventana=confirm("Desea Grabar esta Cotizacion");
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
  }


  ////F12/////
  if (tecla == 123)
  {
	var htmled = document.getElementById("index2");
	htmled.contentWindow.document.getElementById("l1").focus();
  }
}
function sf(){
document.form1.country.focus();
}
function st(){
document.form1.text1.focus();
}
function getfocus(){
document.getElementById('l1').focus()
}
</script>