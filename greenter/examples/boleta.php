<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

include_once('ws.php');

$json = json_decode($_POST['json'], true);
$file_xml = $json['compruc'].'-03-'.$json['serie'].'-'.$json['correlativo'].'.xml';

$util = Util::getInstance();
$util->company_ruc = $json['compruc']; //'20603564783';
$util->company_user = $json['comuser']; //'ANGELA13';
$util->company_pass = $json['compass']; //'Avalentina14';
$util->company_folder = $json['compruc']; //'20603564783';
//REVISAR SI EXISTE LA CARPETA PARA ALMACENAR LOS DOCUMENTOS
if(!is_dir('../files/'.$json['compruc'])){
    mkdir('../files/'.$json['compruc'], 0777);
}

$client = new Client();
$client->setTipoDoc('1')
    ->setNumDoc($json['clirucdni'])
    ->setRznSocial($json['clirznsocial']);

$invoice = new Invoice();
$invoice
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('03')
    ->setSerie($json['serie'])
    ->setCorrelativo($json['correlativo'])
    ->setFechaEmision(new \DateTime($json['femision']))
    ->setTipoMoneda('PEN')
    ->setClient($client)
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
        ->setCantidad($key['cantidad'])
        ->setDescripcion($key['descripcion'])
        ->setMtoBaseIgv($key['baseigv'])
        ->setPorcentajeIgv($key['pcntjeigv'])
        ->setIgv($key['valigv'])
        ->setTipAfeIgv($key['afectaigv'])
        ->setTotalImpuestos($key['totalimpuesto'])
        ->setMtoValorVenta($key['valventa'])
        ->setMtoValorUnitario($key['valunitario'])
        ->setMtoPrecioUnitario($key['preciounitario']);
    $items[] = $item; 
}
$legend = new Legend();
$legend->setCode('1000')
    ->setValue($json['son']);

$invoice->setDetails($items)
    ->setLegends([$legend]);

// Envio a SUNAT.
//$see = $util->getSee(SunatEndpoints::FE_BETA);
$see = $util->getSee(WS_SUNAT);
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