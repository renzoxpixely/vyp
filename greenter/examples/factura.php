<?php

use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

include_once('ws.php');

$json = json_decode($_POST['json'], true);
$file_xml = $json['compruc'].'-01-'.$json['serie'].'-'.$json['correlativo'].'.xml';

$util = Util::getInstance();
$util->company_ruc = $json['compruc']; //'20603564783';
$util->company_user = $json['comuser']; //'ANGELA13';
$util->company_pass = $json['compass']; //'Avalentina14';
$util->company_folder = $json['compruc']; //'20603564783';
//REVISAR SI EXISTE LA CARPETA PARA ALMACENAR LOS DOCUMENTOS
if(!is_dir('../files/'.$json['compruc'])){
    mkdir('../files/'.$json['compruc'], 0777);
}

$invoice = new Invoice();
$invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento('')
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie($json['serie'])
    ->setCorrelativo($json['correlativo'])
    ->setFechaEmision(new \DateTime($json['femision']))
    ->setTipoMoneda($json['moneda'])
    ->setClient($util->getClient('6', $json['clirucdni'], $json['clirznsocial'], $json['clidireccion']))
    ->setMtoOperGravadas($json['montogravado'])
    ->setMtoOperExoneradas($json['montoexonerado'])
    ->setMtoIGV($json['montoigv'])
    ->setTotalImpuestos($json['totalimpuesto'])
    ->setValorVenta($json['valorventa'])
    ->setMtoImpVenta($json['montoventa'])
    ->setCompany($util->getCompany($json['compruc'], $json['compnomcomercial'], $json['comprznsocial'], $json['compubigueo'], $json['compdistrito'], $json['compprovincia'], $json['compdepartamento'], $json['compurbanizacion'], $json['compcodlocal'], $json['compdireccion']));
$items = array();
foreach ($json['items'] as $key){
    $item = new SaleDetail();
    $item->setCodProducto($key['codproducto'])
        ->setUnidad($key['unidad'])
        ->setDescripcion($key['descripcion'])
        ->setCantidad($key['cantidad'])
        ->setMtoValorUnitario($key['valunitario'])
        ->setMtoValorVenta($key['valventa'])
        ->setMtoBaseIgv($key['baseigv'])
        ->setPorcentajeIgv($key['pcntjeigv'])
        ->setIgv($key['valigv'])
        ->setTipAfeIgv($key['afectaigv'])
        ->setTotalImpuestos($key['totalimpuesto'])
        ->setMtoPrecioUnitario($key['preciounitario']);  
    $items[] = $item; 
}
$invoice->setDetails($items)
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue($json['son'])
    ]);

// Envio a SUNAT.
//$see = $util->getSee(SunatEndpoints::FE_BETA);
$see = $util->getSee(WS_SUNAT);

/** Si solo desea enviar un XML ya generado utilice esta función**/
//$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));
$res = $see->send($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());

if($res->isSuccess()){
    $cdr = (array) $res->getCdrResponse();
    $util->writeCdr($invoice, $res->getCdrZip());

    $xml = new DOMDocument;
    $xml->load('../files/'.$json['compruc'].'/'.$file_xml);
    $hash = $xml->getElementsByTagName('DigestValue')->item(0)->nodeValue;

    //$util->showResponse($invoice, $cdr);
    $response = (array) $res->getCdrResponse();
    $response['status'] = 'OK';
    $response['hash'] = $hash;
    $response = json_encode($response, JSON_UNESCAPED_UNICODE);
    $response = str_replace('\u0000*\u0000', '', $response);
    exit($response);
}else{
    //echo $util->getErrorResponse($res->getError());
    $error = (array) $util->getErrorResponse($res->getError());
    exit(json_encode(array(
        'status' => 'ERROR',
        'error' => $error['code'],
        'description' => $error['description'],
        'hash' => ''
    )));
}