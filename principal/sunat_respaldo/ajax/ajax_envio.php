<?php 
	include_once('../../../conexion.php');
	include_once('funciones.php');
	if(isset($_POST['action'])){
		switch ($_POST['action']){
			case 'consultar':
				$date = addslashes($_POST['date']);
				$sucursal = addslashes($_POST['sucursal']);
				$data = '';
				$totalcpe = $sent = $pending = 0;
				$sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
				while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
					$id = $key['invnum'];
					$type = ($key['tipdoc'] == 1)? 'Factura' : 'Boleta'; 
					$typef = ($key['tipdoc'] == 1)? "'F'" : "'B'";
					$doc = explode('-', $key['nrofactura']);
					$serie = $doc[0];
					$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
					$date = date('d/m/Y', strtotime($key['invfec']));
					$rucdni = ($key['tipdoc'] == 1)? $key['ruccli'] : $key['dnicli'];  
					$customer = utf8_encode($key['descli']);
					$total = number_format($key['invtot'], 2);
					$enviado = ($key['sunat_enviado'] > 0)? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado'; 
					$respuestacod = $key['sunat_respuesta_codigo'];
					$respuestadesc = $key['sunat_respuesta_descripcion'];
					$option = ($key['sunat_enviado'] > 0)? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat('.$id.', '.$typef.');">';
					$data .= '<tr id="row-'.$id.'">
								<td>'.$type.'</td>
								<td>'.$serie.'</td>
								<td>'.$correlativo.'</td>
								<td>'.$date.'</td>
								<td>'.$rucdni.'</td>
								<td>'.$customer.'</td>
								<td align="right">'.$total.'</td>
								<td>'.$enviado.'</td>
								<td>'.$respuestacod.'</td>
								<td>'.$respuestadesc.'</td>
								<td align="center">'.$option.'</td>
							  </tr>';
					$totalcpe++;
					if($key['sunat_enviado'] > 0){$sent++;}
				}
				$pending = $totalcpe-$sent;
				$response = array('data' => $data, 'total' => $totalcpe, 'sent' => $sent, 'pending' => $pending);
				exit(json_encode($response, JSON_UNESCAPED_UNICODE));
			break;

			case 'limpiar_enviados':
				$now = date('Y-m-d H:i:s');
				$date = addslashes($_POST['date']);
				$sucursal = addslashes($_POST['sucursal']);
				$data = '';
				$update = mysqli_query($conexion, "UPDATE venta SET sunat_enviado = 1, sunat_fenvio = '$now', sunat_respuesta_descripcion = IF(SUBSTRING(nrofactura, 1, 1)='F', CONCAT('La Factura numero ', nrofactura, ', ha sido aceptada'), CONCAT('La Boleta numero ', nrofactura, ', ha sido aceptada')) WHERE invfec = '$date' AND (nrofactura LIKE 'F%' OR nrofactura LIKE 'B%') AND LENGTH(nrofactura) > 0 AND sucursal = '$sucursal' AND sunat_respuesta_descripcion LIKE 'El comprobante fue registrado previamente con otros datos%'");
				$sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec BETWEEN '$from' AND '$to' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
				while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
					$id = $key['invnum'];
					$type = ($key['tipdoc'] == 1)? 'Factura' : 'Boleta'; 
					$typef = ($key['tipdoc'] == 1)? "'F'" : "'B'";
					$doc = explode('-', $key['nrofactura']);
					$serie = $doc[0];
					$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
					$date = date('d/m/Y', strtotime($key['invfec']));
					$rucdni = ($key['tipdoc'] == 1)? $key['ruccli'] : $key['dnicli'];  
					$customer = utf8_encode($key['descli']);
					$total = number_format($key['invtot'], 2);
					$enviado = ($key['sunat_enviado'] > 0)? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado'; 
					$respuestacod = $key['sunat_respuesta_codigo'];
					$respuestadesc = $key['sunat_respuesta_descripcion'];
					$option = ($key['sunat_enviado'] > 0)? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat('.$id.', '.$typef.');">';
					$data .= '<tr id="row-'.$id.'">
								<td>'.$type.'</td>
								<td>'.$serie.'</td>
								<td>'.$correlativo.'</td>
								<td>'.$date.'</td>
								<td>'.$rucdni.'</td>
								<td>'.$customer.'</td>
								<td align="right">'.$total.'</td>
								<td>'.$enviado.'</td>
								<td>'.$respuestacod.'</td>
								<td>'.$respuestadesc.'</td>
								<td align="center">'.$option.'</td>
							  </tr>';
				}
				$response = array('data' => $data);
				exit(json_encode($response, JSON_UNESCAPED_UNICODE));
			break;

			case 'consultar-masa':
				$date = addslashes($_POST['date']);
				$sucursal = addslashes($_POST['sucursal']);
				$data = '';
				$sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sunat_enviado = 0 AND v.sucursal = '$sucursal' ORDER BY v.nrofactura ASC");
				$items = array();
				while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
					$type = ($key['tipdoc'] == 1)? 'F' : 'B';
					$items[] = array(
						'id' => $key['invnum'],
						'type' => $type
					);	
				}
				exit(json_encode($items, JSON_UNESCAPED_UNICODE));
			break;

			case 'crear_json':
				$id = addslashes($_POST['id']);
				$header = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli, t.sucursal_usuario_secundario, t.sucursal_usuario_password, t.sucursal_ruc, t.sucursal_nombre_comercial, t.sucursal_nombre, t.sucursal_ubigueo, t.sucursal_distrito, t.sucursal_provincia, t.sucursal_departamento, t.sucursal_urbanizacion, t.sucursal_codigo, t.sucursal_direccion FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli LEFT JOIN ticket AS t ON v.sucursal = t.sucursal WHERE v.invnum = '$id' LIMIT 1");
				$header_key = mysqli_fetch_array($header, MYSQLI_ASSOC);
				$doc = explode('-', $header_key['nrofactura']);
				$serie = $doc[0];
				$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$femision = $header_key['invfec'];
				$clirucdni = ($header_key['tipdoc'] == 1)? $header_key['ruccli'] : $header_key['dnicli'];  
				$clirznsocial = utf8_encode($header_key['descli']);
				$clidireccion = utf8_encode($header_key['dircli']);
				$montogravado = $header_key['gravado'];
				$montoxonerado = $header_key['inafecto'];
				$montoigv = $header_key['igv'];
				$totalimpuesto = $header_key['igv'];
				$valorventa = $header_key['valven'];
				$montoventa = $header_key['invtot'];
				$son = convertNumberToWord($montoventa, 'PEN');
				$comuser = $header_key['sucursal_usuario_secundario']; 
				$compass = $header_key['sucursal_usuario_password'];
				$compruc = $header_key['sucursal_ruc'];
				$compnomcomercial = $header_key['sucursal_nombre_comercial'];
				$comprznsocial = $header_key['sucursal_nombre'];
				$compubigueo = $header_key['sucursal_ubigueo'];
				$compdistrito = $header_key['sucursal_distrito'];
				$compprovincia = $header_key['sucursal_provincia'];
				$compdepartamento = $header_key['sucursal_departamento'];
				$compurbanizacion = $header_key['sucursal_urbanizacion'];
				$compcodlocal = $header_key['sucursal_codigo'];
				$compdireccion = $header_key['sucursal_direccion'];
				$response = array(
					'serie' => trim($serie),
					'correlativo' => trim($correlativo),
					'femision' => trim($femision),
					'moneda' => 'PEN',
					'clirucdni' => trim($clirucdni),
					'clirznsocial' => mb_strtoupper(trim($clirznsocial), 'UTF-8'),
					'clidireccion' => mb_strtoupper(trim($clidireccion), 'UTF-8'),
					'montogravado' => number_format($montogravado, 2, '.', ''),
					'montoexonerado' => number_format($montoxonerado, 2, '.', ''),
					'montoigv' => number_format($montoigv, 2, '.', ''),
					'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
					'valorventa' => number_format($valorventa, 2, '.', ''),
					'montoventa' => number_format($montoventa, 2, '.', ''),
					'compruc' => trim($compruc),
					'compnomcomercial' => mb_strtoupper(trim($compnomcomercial), 'UTF-8'),
					'comprznsocial' => mb_strtoupper(trim($comprznsocial), 'UTF-8'),
					'compubigueo' => trim($compubigueo),
					'compdistrito' => mb_strtoupper(trim($compdistrito), 'UTF-8'),
					'compprovincia' => mb_strtoupper(trim($compprovincia), 'UTF-8'),
					'compdepartamento' => mb_strtoupper(trim($compdepartamento), 'UTF-8'),
					'compurbanizacion' => mb_strtoupper(trim($compurbanizacion), 'UTF-8'),
					'compcodlocal' => mb_strtoupper(trim($compcodlocal), 'UTF-8'),
					'compdireccion' => mb_strtoupper(trim($compdireccion), 'UTF-8'),
					'son' => trim($son),
					'comuser' => trim($comuser),
					'compass' => trim($compass),
					'items' => array()
				);  
				$items = array();
				$porcentajeigv = 0;
				$igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
				while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)){
					$porcentajeigv = (float)$rowigvtabla['porcent'];
					$porcentajeigv = $porcentajeigv/100;
				}
				$detail = mysqli_query($conexion, "SELECT d.*, p.desprod, p.igv AS igvpro FROM detalle_venta AS d LEFT JOIN producto AS p ON d.codpro = p.codpro WHERE d.invnum = '$id'");
				while ($detail_key = mysqli_fetch_array($detail, MYSQLI_ASSOC)){
					$porcentaje = $porcentajeigv;
					if($detail_key['igvpro'] > 0){ 
						$afectaigv = '10'; //GRAVADO - OPERACION ONEROSA
					}else{ 
						$porcentaje = 0;
						$afectaigv = '20'; //EXONERADO - OPERACION ONEROSA
					}
					$codproducto = $detail_key['codpro'];
					$unidad = 'NIU';
					$descripcion = mb_strtoupper($detail_key['desprod'], 'UTF-8');
					$cantidad = $detail_key['canpro'];
					$valunitario = ($detail_key['prisal']/(1+$porcentaje));
					$valventa = ($detail_key['pripro']/(1+$porcentaje));
					$baseigv = $valventa;
					$pcntjeigv = $porcentaje*100;
					$valigv = $baseigv*$porcentaje;
					$totalimpuesto = $valigv;
					$preciounitario = $detail_key['prisal'];
					$items[] = array(
						'codproducto' => trim($codproducto),
						'unidad' => trim($unidad),
						'descripcion' => trim($descripcion),
						'cantidad' => number_format($cantidad, 2, '.', ''),
						'valunitario' => number_format($valunitario, 2, '.', ''),
						'valventa' => number_format($valventa, 2, '.', ''),
						'baseigv' => number_format($baseigv, 2, '.', ''),
						'pcntjeigv' => number_format($pcntjeigv, 2, '.', ''),
						'valigv' => number_format($valigv, 2, '.', ''),
						'afectaigv' => $afectaigv,
						'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
						'preciounitario' => number_format($preciounitario, 2, '.', '')
					);
				}
				$response['items'] = $items;
				exit(json_encode($response, JSON_UNESCAPED_UNICODE));
			break;

			case 'actualizar':
				$id = addslashes($_POST['id']);
				$enviado = addslashes($_POST['enviado']);
				$code = addslashes($_POST['code']);
				$description = addslashes($_POST['description']);
				$hash = addslashes($_POST['hash']);
				$data = '';
				if($enviado > 0 AND $code == '0'){
					$fenvio = date('Y-m-d H:i:s');
					$enviado = 1;
				}else{
					$fenvio = '0000-00-00 00:00:00';
					$enviado = 0;	
				}
				$update = mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$id'");
				$sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invnum = '$id' LIMIT 1");
				while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
					$id = $key['invnum'];
					$type = ($key['tipdoc'] == 1)? 'Factura' : 'Boleta'; 
					$typef = ($key['tipdoc'] == 1)? "'F'" : "'B'"; 
					$doc = explode('-', $key['nrofactura']);
					$serie = $doc[0];
					$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
					$date = date('d/m/Y', strtotime($key['invfec']));
					$rucdni = ($key['tipdoc'] == 1)? $key['ruccli'] : $key['dnicli'];  
					$customer = utf8_encode($key['descli']);
					$total = number_format($key['invtot'], 2);
					$enviado = ($key['sunat_enviado'] > 0)? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado'; 
					$respuestacod = $key['sunat_respuesta_codigo'];
					$respuestadesc = $key['sunat_respuesta_descripcion'];
					$option = ($key['sunat_enviado'] > 0)? '<input type="button" class="btn-envio enviado" value="Enviar" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat('.$id.', '.$typef.');">';
					$data = '<tr id="row-'.$id.'">
								<td>'.$type.'</td>
								<td>'.$serie.'</td>
								<td>'.$correlativo.'</td>
								<td>'.$date.'</td>
								<td>'.$rucdni.'</td>
								<td>'.$customer.'</td>
								<td align="right">'.$total.'</td>
								<td>'.$enviado.'</td>
								<td>'.$respuestacod.'</td>
								<td>'.$respuestadesc.'</td>
								<td align="center">'.$option.'</td>
							 </tr>';
				}
				$response = array('data' => $data);
				exit(json_encode($response, JSON_UNESCAPED_UNICODE));
			break;
		}

	}
?>