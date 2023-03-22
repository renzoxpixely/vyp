<?php 
  include('../session_user.php');
  include('ajax/funciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

<title>Documento sin t&iacute;tulo</title>
<link href="../reportes/css/style.css" rel="stylesheet" type="text/css" />
<link href="../reportes/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>
<script type="text/javascript">
    window.addEvent('domready', function() { myCal = new Calendar({ date1: 'Y-m-d' }); myCal = new Calendar({ date2: 'Y-m-d' }); });
</script>
<?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
<?php require_once("../../funciones/calendar.php");?>
<?php require_once("../../funciones/functions.php");  //DESHABILITA TECLAS?>
<?php require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES?>
<script type="text/javascript" src="../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../funciones/ajax-dynamic-list1.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script language="JavaScript">
function salir()
{
   var f = document.form1;
   f.method = "POST";
   f.target = "_top";
   f.action ="../index.php";
   f.submit();
}
</script>
</head>
<?php 
//$hour   = date(G);
//$date = CalculaFechaHora($hour);
$date = date("Y-m-d");
$val        = $_REQUEST['val'];
$country    = $_REQUEST['country'];
$report     = $_REQUEST['report'];
$sql="SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
  $export    = $row['export'];
}
}
////////////////////////////
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
?>
<script language="javascript" type="text/javascript">  
function st()
{
    var f = document.form1;
    f.country.focus();
}
</script>
<body onload="st();">
<link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
 <table width="954" border="0">
    <tr>
      <td>
        <b><u>COMUNICACION DE BAJA DE BOLETAS Y FACTURAS</u></b>
        <br>
        <form id="form1" name="form1" method = "post">
        <br>
        <table cellpadding="3px" border="0px">
          <tr>
            <td>Consulta Comunicaciones de Baja desde</td>
            <td><input type="date" id="from" value="<?=date('Y-m-d');?>"></td>
            <td>hasta</td>
            <td><input type="date" id="to" value="<?=date('Y-m-d');?>"></td>
            <td>Sucursal</td>
            <td>
              <select id="sucursal" style="padding:3px;">
                <?php 
                  $sql = mysqli_query($conexion, "SELECT linea1, linea7, sucursal, sucursal_codigo, sucursal_ruc FROM ticket ORDER BY sucursal_ruc, sucursal_codigo");
                  while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
                    echo '<option value="'.$key['sucursal'].'">'.$key['sucursal_ruc'].'-'.$key['linea7'].'-'.$key['linea1'].'</option>';
                  }
                ?>
              </select>
            </td>
            <td><input type="button" value="Consultar" id="sunat-consultar"></td>
            <td><input type="button" value="Salir" onclick="salir()"></td>
          </tr>  
        </table>
        <br>
        <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div><br>
        <table width="99%" cellpadding="3px" border="1px" style="border-collapse:collapse;" id="sunat-table">
          <thead bgcolor="#E6E6E6">
            <tr>
              <th>Sucursal</th>
              <th width="45px">Generacion</th>
              <th width="35px">Fecha</th>
              <th width="95px">Resumen</th>
              <!--<th width="80px">Documentos</th>-->
              <th width="45px">Codigo</th>
              <th>Respuesta</th>
              <th>Ticket</th>
              <th width="55px">CDR</th>
              <th width="55px">XML</th>
            </tr>
          </thead>  
          <tbody></tbody>
        </table>
        <br>
        </form>
        <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div>
      </td>
    </tr>
  </table>
  <br>
  <?php if ($val == 1)
  {
  ?>
  <iframe src="stock_loc2.php?val=<?php echo $val?>&country=<?php echo $country?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>" name="marco" id="marco" width="958" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
  <?php }
  ?>
</body>
</html>

<style type="text/css">
  .enviado{
    color: #A4A4A4;
  }
  .text-small{
    font-size: 11px;
  }
</style>

<script type="text/javascript">
  $('#sunat-consultar').on('click', function(){
    var from = $('#from').val(); 
    var to = $('#to').val();
    var sucursal = $('#sucursal').val();
    if(from.length > 0 && to.length > 0 && sucursal.length > 0){
      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_generar.php',
        data: {action:'consultar', from:from, to:to, sucursal:sucursal},
        dataType: 'JSON',
        success: function(response){
          $('#sunat-table tbody').html(response.data);
        }
      }).fail(function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
      });
    }else{
      alert('Seleccione los rangos de fecha y la sucursal.');
    }
  });

  function download_file(id, type){
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_generar.php',
      data: {action:'download', id:id, type:type},
      dataType: 'JSON',
      success: function(response){
        force_download(response.path, response.name);
      }
    }).fail(function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
    });
  }

  function force_download(fileURL, fileName) {
    if(!window.ActiveXObject){
      var save = document.createElement('a');
      save.href = fileURL;
      save.target = '_blank';
      var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
      save.download = fileName || filename;
      if(navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0){
        document.location = save.href; 
      }else{
        var evt = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': false
        });
        save.dispatchEvent(evt);
        (window.URL || window.webkitURL).revokeObjectURL(save.href);
      } 
    }else if(!!window.ActiveXObject && document.execCommand){
      var _window = window.open(fileURL, '_blank');
      _window.document.close();
      _window.document.execCommand('SaveAs', true, fileName || fileURL)
      _window.close();
    }
  }
</script>