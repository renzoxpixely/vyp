<?php

use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

include_once('ws.php');

$json = json_decode($_POST['json'], true);
$file_xml = $json['compruc'].'-'.$json['resumen_factura'].'.xml';

$util = Util::getInstance();
$util->company_ruc = $json['compruc']; //'20603564783';
$util->company_user = $json['comuser']; //'ANGELA13';
$util->company_pass = $json['compass']; //'Avalentina14';
$util->company_folder = $json['compruc']; //'20603564783';
//REVISAR SI EXISTE LA CARPETA PARA ALMACENAR LOS DOCUMENTOS
if(!is_dir('../files/'.$json['compruc'])){
    mkdir('../files/'.$json['compruc'], 0777);
}

$voided = $util->getVoided($json);

// Envio a SUNAT.
//$see = $util->getSee(SunatEndpoints::FE_BETA);
$see = $util->getSee(WS_SUNAT);

$res = $see->send($voided);
$util->writeXml($voided, $see->getFactory()->getLastXml());

if($res->isSuccess()){
    $ticket = $res->getTicket();
    sleep(4);
    $result = $see->getStatus($ticket);
    if ($result->isSuccess()) {
        $util->writeCdr($voided, $result->getCdrZip());
        $xml = new DOMDocument;
        $xml->load('../files/'.$json['compruc'].'/'.$file_xml);
        $hash = $xml->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        //$util->showResponse($invoice, $cdr);
        $response = (array) $result->getCdrResponse();
        $response['status'] = 'OK';
        $response['hash'] = $hash;
        $response['ticket'] = $ticket;
        $response['sucursal'] = $json['sucursal'];
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);
        $response = str_replace('\u0000*\u0000', '', $response);
        exit($response);
    }else{
        $error = $util->getErrorResponse($result->getError());
        exit(json_encode(array(
            'status' => 'ERROR',
            'error' => $error['code'],
            'description' => $error['description'],
            'hash' => '',
            'ticket' => '',
            'sucursal' => $json['sucursal']
        )));
    }
}else{
    $error = (array) $util->getErrorResponse($res->getError());
    exit(json_encode(array(
        'status' => 'ERROR',
        'error' => $error['code'],
        'description' => $error['description'],
        'hash' => '',
        'ticket' => '',
        'sucursal' => $json['sucursal']
    )));
}