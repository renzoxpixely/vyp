<?php 
require_once('../../../conexion.php');
$sql= "SELECT vendedorventa FROM datagen_det";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $vendedorventa    = $row['vendedorventa'];
}
}
?>
<script language="JavaScript">
function precio()
{
	var v1 		    = parseFloat(document.form1.text1.value);		//CANTIDAD
    var blister     = parseInt(document.form1.pblister.value);		//BLISTER
    var preblister  = parseFloat(document.form1.preblister.value);		//PRECIO DE BLISTER
	if (document.form1.text222.disabled == true)
	{
	var v22 	= parseFloat(document.form1.text2.value);		//PRECIO UNITARIO
	var v2venta	= parseFloat(document.form1.textprevta.value);	//PRECIO CAJA
	
	console.log(v22);
	console.log(v2venta);
	}
	else
	{
	//var v22 	= parseFloat(document.form1.text222.value);		//PRECIO UNITARIO
	var v22		= parseFloat(document.form1.text2.value);		//PRECIO UNITARIO
	var v2venta	= parseFloat(document.form1.textprevta.value);	//PRECIO CAJA
	}
	//alert(v2);
	var factor  = parseFloat(document.form1.factor.value);		//FACTOR
	var total;
	var valor   = isNaN(v1);
		if (valor == true)			////NO ES NUMERO
		{
		var v1  = document.form1.text1.value.substring(1);	
		//v1		= parseFloat(v1 * factor);
		//total   = parseFloat(v1 * v2);
		document.form1.text222.value=v2venta;
		total   = parseFloat(v1 * v2venta);
		}
		else
		{
                    //SON PRECIOS UNITARIOS
                    //CALCULAR SI EL BLISTER ES 10 Y SI LA CANTIDAD ES MAYOR A 10
                    //COLOCAR EL TEX222 IGUAL AL PRECIO DE BLISTER
                    
                    if ((blister > 1) && (v1 >= blister) && (preblister > 0))
                    {
                        document.form1.text222.value=preblister;
                        total   = parseFloat(v1 * preblister);
                    }
                    else
                    {
                        document.form1.text222.value=v22;
                        total   = parseFloat(v1 * v22);
                    }
		}
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	
	if(document.form1.text1.value!=''){
			document.form1.text3.value=total;
			document.form1.text333.value=total;
	}else{
			document.form1.text3.value='';
			document.form1.text333.value='';
	}
}
function precio1()
{
	var v1 		= parseFloat(document.form1.text1.value);		//CANTIDAD
	if (document.form1.text222.disabled == true)
	{
	//alert("DESHABILITADO");
	var v2 		= parseFloat(document.form1.text2.value);		//PRECIO UNITARIO
	document.form1.text2.value=v2;
	var v2venta	= parseFloat(document.form1.textprevta.value);	//PRECIO CAJA
	}
	else
	{
	//alert("HABILITADO");
	var v2 		= parseFloat(document.form1.text222.value);		//PRECIO UNITARIO
	//var v22		= parseFloat(document.form1.text2.value);	//PRECIO UNITARIO
	var v2venta	= parseFloat(document.form1.textprevta.value);	//PRECIO CAJA
	}
	//alert(v2);
	
	
		
	var factor  = parseFloat(document.form1.factor.value);		//FACTOR
	var total;
	var valor   = isNaN(v1);
        if (valor == true)			////NO ES NUMERO
        {
        var v1  = document.form1.text1.value.substring(1);	
        //v1		= parseFloat(v1 * factor);
        //total   = parseFloat(v1 * v2);
        //document.form1.text222.value=v2venta;
        total   = parseFloat(v1 * v2venta);
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
			document.form1.text333.value='';
	}
}
function letraent(evt)
{
    //key=e.keyCode;
	var key = nav4 ? evt.which : evt.keyCode;
	/////F4/////
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
		var factor = parseFloat(document.form1.factor.value);		//FACTOR
		var st 	 = parseFloat(document.form1.cant_prod.value);		//CANTIDAD ACTUAL POR LOCAL
		if (f.text222.value == "")
		{ 
			alert("Ingrese el Precio del Producto");
			f.text222.focus(); return; 
		}	 
		if (f.text1.value == "")
		{ 
			alert("Ingrese una Cantidad"); 
			f.text1.focus(); return; 
		}
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
	 alert("La cantidad Ingresada excede al Stock Actual del Producto1"); 
	 /* ventana=confirm("La cantidad Ingresada excede al Stock Actual del Producto Desea Grabar esta informacion?");
	     if (ventana) 
		 {
		  f.method = "post";
		  f.action ="venta_index2_reg.php";
		  f.submit();
		 }
		 else
		 {
		 f.text1.focus();
		 return; 
		 }*/
	  }
	  else
	  {
		  f.method = "post";
		  f.action ="venta_index2_reg.php";
		  f.submit();
	  }
	  //alert("hola");
	}
	return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));	
}
function letracc(evt)
{
    //key=e.keyCode;
	var key = nav4 ? evt.which : evt.keyCode;
	/////F4/////
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
	  if (f.text222.value == "")
	  { alert("Ingrese el Precio del Producto"); f.text222.focus(); return; }	 
	  if (f.text1.value == "")
	  { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
//	  if (f.text3.value == 0)
//	  { alert("El total debe ser diferente de 0"); return; }
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
	 alert("La cantidad Ingresada excede al Stock Actual del Producto2"); 
	 // ventana=confirm("La cantidad Ingresada excede al Stock Actual del Producto, Ingrese una Stock  nuevamente ");
//	     if (ventana) 
//		 {
////		  f.method = "post";
////		  f.action ="venta_index.php";
//		  f.submit();
//		 }
//		 else
//		 {
//		 f.text1.focus();
//		 return; 
//		 }
	  }
	  else
	  {
	  	 /*   var v1 		= parseFloat(document.form1.text1.value);		//CANTIDAD
			if (document.form1.text222.disabled == true)
			{
			//alert("DESHABILITADO");
			var v2 		= parseFloat(document.form1.text2.value);		//PRECIO
			}
			else
			{
			//alert("HABILITADO");
			var v2 		= parseFloat(document.form1.text222.value);		//PRECIO
			}
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
					document.form1.text333.value='';
			}*/
		  f.method = "post";
		  f.action ="venta_index2_reg.php";
		  f.submit();
	  }
	  //alert("hola");
	}
	return (key == 67 || key == 99 ||key <= 13 || (key >= 48 && key <= 57));	
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
  //alert(tecla);
  if (tecla == 27)
  {
    document.form1.val.value = "";
	document.form1.tipo.value = "";
	document.form1.submit();
  }
  //////F6/////
  if (tecla == 117)
  {
    	var popUpWin=0;
		var left = 300;
            var top = 120;
            var width = 480;
            var height = 280;
		if(popUpWin)
		{
		if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('tip_venta.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
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
  if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=320,width=905,height=380');
  }
  
  
  
 ///F1////
  if(tecla==112)
  {
  	 window.open('f3/f3.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=250,left=200,width=650,height=250');
  }
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
                if (f.medico.value == "")
                { alert("Asigana a un medico antes de cancelar esta venta");  return; }
	 	 ventana=confirm("Desea cancelar esta venta" );
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
        var t33 = document.form1.t33.value;
        if (f.t33.value == 0)
                { alert("LA CANTIDAD INGRESADA ES SS0, LA VENTA DEBE SER GRABADA CON F4 Y ASIGNANDO A UN MEDICO");  return; }
        
        
        if (t33 > 0)
        {
            
        if ((act == 0) || (act1 > 1))
        {
            alert("Venta Incompleta. Imposible Grabar"); f.num.focus(); return; 
        }
        else
        {
            <?php
            if ($vendedorventa == 1) 
            {
            ?>
                var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
                if (claveVendedor !== null)
                {
                    $.ajax({
                        type: "GET",
                        url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                        async: true,
                        success: function(datos) 
                        {
                            var dataJson = eval(datos);
                            var contad = 0;
                            for (var i in dataJson) {
                                contad++;
                                //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                            }
                            if (contad > 0)
                            {
                                //ENVIO NORMALMENTE
                                f.method = "post";
                                f.target = "_top";
                                f.CodClaveVendedor.value = "c"+claveVendedor;
                                f.action = "venta_reg.php";
                                f.submit();
                            }
                            else
                            {
                                alert("No existe el Usuario");return;
                            }
                        },
                        error: function(obj, error, objError) {
                            //avisar que ocurriï¿½ un error
                        }
                    });
                }
            <?php
            }
            else 
            {
            ?>
//                var f = document.form1;
//                var act = document.form1.text3.value;
                ventana=confirm("Desea Grabar esta Venta"+t33);
                if (ventana) 
                {
                f.method = "post";
                f.target = "_top";
                f.action ="venta_reg.php";
                f.submit();
                }
            <?php
            }
            ?>
        }
    }}
    /////F9/////
	//if((tecla==120) || (tecla ==119))
    if((tecla==120))
    {
        var tecKey= 0;
        if (tecla ==119)
        {
            tecKey = 1;
        }
        if (tecla ==120)
        {
            tecKey = 2;
        }
        var f = document.form1;
        var act = document.form1.activado.value;
        var act1 = document.form1.activado1.value;
        var t33 = document.form1.t33.value;
        /* if (f.t33.value == 0)
                { alert("LA CANTIDAD INGRESADA ES 0DSD, LA VENTA DEBE SER GRABADA CON F4 Y ASIGNANDO A UN MEDICO");  return; }*/
        
        //if (t33 > 0){
        if ((act == 0) || (act1 > 1))
        {
            alert("Venta Incompleta. Imposible de Imprimir"); f.num.focus(); return; 
        }
        else
        {
            <?php
            if ($vendedorventa == 1) 
            {
            ?>
                var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
                if (claveVendedor !== null)
                {
                    $.ajax({
                        type: "GET",
                        url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                        async: true,
                        success: function(datos) 
                        {
                            var dataJson = eval(datos);
                            var contad = 0;
                            for (var i in dataJson) 
                            {
                                contad++;
                                //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                            }
                            if (contad > 0)
                            {
                                //ENVIO NORMALMENTE
                                //--------------------------window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                                window.open('preimprimir.php?CodClaveVendedor=c'+ claveVendedor+'&tecKey='+tecKey,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
                            }
                            else
                            {
                                alert("No existe el Usuario");return;
                            }
                        },
                        error: function(obj, error, objError) 
                        {
                            //avisar que ocurriï¿½ un error
                        }
                    });
                }
            <?php
            } 
            else 
            {
            ?>
                //----------------------------window.open('preimprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                window.open('preimprimir.php?tecKey='+tecKey,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
            <?php 
            }
            ?>
        }
    //}
    
}
  ////F12/////
  if (tecla == 123)
  {
	var htmled = document.getElementById("index2");
	htmled.contentWindow.document.getElementById("ll").focus();
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