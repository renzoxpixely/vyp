<?php
include_once('../../../conexion.php');
include_once('funciones.php');
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'consultar':
			$from = addslashes($_POST['from']);
			$to = addslashes($_POST['to']);
			$sucursal = addslashes($_POST['sucursal']);
			$data = '';
			$sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli, t.sucursal_ruc FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli LEFT JOIN ticket AS t ON v.sucursal = t.sucursal WHERE v.invfec BETWEEN '$from' AND '$to' AND v.sunat_enviado > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
			while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
				$id = $key['invnum'];
				$type = ($key['tipdoc'] == 1) ? 'Factura' : 'Boleta';
				$typef = ($key['tipdoc'] == 1) ? "'F'" : "'B'";
				$doc = explode('-', $key['nrofactura']);
				$serie = $doc[0];
				$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$date = date('d/m/Y', strtotime($key['invfec']));
				$rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
				$customer = utf8_encode($key['descli']);
				$total = number_format($key['invtot'], 2);
				$enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
				$cdr = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 1)" title="CDR"><i class="far fa-file-archive"></i> CDR</button>';
				$xml = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 2)" title="XML"><i class="far fa-file-code"></i> XML</button>';
				$pdf = '<button type="button" class="btn-envio text-small" onclick="print_pdf(' . $id . ')" title="XML"><i class="far fa-file-code"></i> PDF</button>';
				$typeDoc = ($key['tipdoc'] == 1) ? '01' : '03';
				$file = $key['sucursal_ruc'] . '-' . $typeDoc . '-' . $serie . '-' . $correlativo;
				$data .= '<tr id="row-' . $id . '">
								<td align="center"><input type="checkbox" class="cpe-item" file="' . $file . '"></td>
								<td>' . $type . '</td>
								<td>' . $serie . '</td>
								<td>' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td align="center">' . $cdr . '</td>
								<td align="center">' . $xml . '</td>
								<td align="center">' . $pdf . '</td>
							  </tr>';
			}
			$response = array('data' => $data);
			exit(json_encode($response));
			break;

		case 'consultar_nc':
			$from = addslashes($_POST['from']);
			$to = addslashes($_POST['to']);
			$sucursal = addslashes($_POST['sucursal']);
			$data = '';
			$sql = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli WHERE n.invfec BETWEEN '$from' AND '$to' AND n.sunat_enviado > 0 AND n.sucursal = '$sucursal' ORDER BY n.correlativo ASC");
			while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
				$id = $key['invnum'];
				$doc = explode('-', $key['nrofactura']);
				$serie = $doc[0];
				$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$date = date('d/m/Y', strtotime($key['invfec']));
				$anotacion = $key['anotacion'];
				$docafectado = explode('-', $key['serie_doc']);
				$afectado = $docafectado[0] . '-' . str_pad($docafectado[1], 8, '0', STR_PAD_LEFT);
				$rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
				$customer = utf8_encode($key['descli']);
				$total = number_format($key['invtot'], 2);
				$enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
				$cdr = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 1)" title="CDR"><i class="far fa-file-archive"></i> CDR</button>';
				$xml = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 2)" title="XML"><i class="far fa-file-code"></i> XML</button>';
				$pdf = '<button type="button" class="btn-envio text-small" onclick="print_pdf(' . $id . ')" title="XML"><i class="far fa-file-code"></i> PDF</button>';
				$data .= '<tr id="row-' . $id . '">
								<td>' . $serie . '-' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $anotacion . '</td>
								<td>' . $afectado . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td align="center">' . $cdr . '</td>
								<td align="center">' . $xml . '</td>
								<td align="center">' . $pdf . '</td>
							  </tr>';
			}
			$response = array('data' => $data);
			exit(json_encode($response));
			break;

		case 'download':
			$id = addslashes($_POST['id']);
			$type = addslashes($_POST['type']);
			$sql = mysqli_query($conexion, "SELECT v.tipdoc, v.nrofactura, t.sucursal_ruc FROM venta AS v LEFT JOIN ticket AS t ON v.sucursal = t.sucursal WHERE v.invnum = '$id' AND v.sunat_enviado > 0  ORDER BY v.nrofactura ASC");
			$key = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$typeDoc = ($key['tipdoc'] == 1) ? '01' : '03';
			$doc = explode('-', $key['nrofactura']);
			$serie = $doc[0];
			$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
			$file = $key['sucursal_ruc'] . '-' . $typeDoc . '-' . $serie . '-' . $correlativo;


			switch ($type) {
				case 1:
					$name = 'R-' . $file . '.ZIP';
					break;
				case 2:
					$name = $file . '.XML';
					break;
				case 3:
					$name = $file . '.pdf';
					break;
				default:
					$name = $file . '.pdf';
					break;
			}

			$nombreCarpeta = ($type == '2') ? 'xml/' : 'cdr/';

			$path = 'ApiFacturacion/' . $key['sucursal_ruc'] . '/' . $nombreCarpeta . $name;



			$response = array(
				'path' => $path,
				'name' => $name
			);
			exit(json_encode($response));
			break;

		case 'download_nc':
			$id = addslashes($_POST['id']);
			$type = addslashes($_POST['type']);
			$sql = mysqli_query($conexion, "SELECT n.nrofactura, t.sucursal_ruc FROM nota AS n LEFT JOIN ticket AS t ON n.sucursal = t.sucursal WHERE n.invnum = '$id' AND n.sunat_enviado > 0  ORDER BY n.nrofactura ASC");
			$key = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$typeDoc = '07';
			$doc = explode('-', $key['nrofactura']);
			$serie = $doc[0];
			$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
			$file = $key['sucursal_ruc'] . '-' . $typeDoc . '-' . $serie . '-' . $correlativo;
			switch ($type) {
				case 1:
					$name = 'R-' . $file . '.zip';
					break;
				case 2:
					$name = $file . '.xml';
					break;
				case 3:
					$name = $file . '.pdf';
					break;
				default:
					$name = $file . '.pdf';
					break;
			}
			$path = '../../greenter/files/' . $key['sucursal_ruc'] . '/' . $name;
			$response = array(
				'path' => $path,
				'name' => $name
			);
			exit(json_encode($response));
			break;

		case 'zip_cpe':
			if ($_POST['type'] == 'CDR') {
				$name_zip = 'cdr_cpe.zip';
			} else {
				$name_zip = 'xml_cpe.zip';
			}
			$items = json_decode($_POST['items'], true);
			$zip = new ZipArchive();
			$zip_path = '../../principal/sunat/ajax/' . $name_zip;
			if (is_file($name_zip)) {
				unlink($name_zip);
			}

			if ($zip->open($name_zip, ZipArchive::CREATE)) {
				foreach ($items as $key => $value) {
					if ($_POST['type'] == 'CDR') {
						$file = 'R-' . $value . '.ZIP';
						$nombreCarpeta = 'cdr/';
					} else {
						$file = $value . '.XML';
						$nombreCarpeta = 'xml/';
					}
					$explode = explode('-', $value);
					$file_cpe = dirname_r(__FILE__, 4) . '/principal/sunat/ApiFacturacion/' . $explode[0] . '/' . $nombreCarpeta . $file;
					if (is_file($file_cpe)) {
						// echo 'ENTRA = ' . "<BR>";
						$zip->addFile($file_cpe, $file);
					}
					// echo '$file_cpe = ' . $file_cpe . "<BR>";;
				}
				$zip->close();
			}
			echo json_encode(array('path' => $zip_path, 'name' => $name_zip));
			break;
	}
}
