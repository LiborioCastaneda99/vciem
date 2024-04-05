<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion
require_once('../vendors/tcpdf/tcpdf.php'); // Se carga la libreria tcpdf
require_once('php-qrcode-master/lib/full/qrlib.php'); // Incluir la biblioteca PHP QR Code

$encrypted = $_GET['id'];
$key = 'clave_secreta';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Función para generar el código QR
function generateQRCode($data, $filename)
{
    QRcode::png($data, $filename, 'H', 4, 2); // Generar el código QR y guardar en el archivo
}

// Función para desencriptar el ID
function decryptID($encrypted, $key)
{
    $decrypted = openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    return $decrypted;
}

$id = decryptID($encrypted, $key);

// Crear una instancia de TCPDF
$dbconec = new Conexion();
$conn = $dbconec->Conectar();
$conn->exec("SET CHARACTER SET utf8");

$query = "SELECT V.id, Tc.nombre As cliente, Tc.codigo As documento, Tc.direc As direccion, Tc.tel1 As telefono, Tf.nombre As tipo_factura, 
A.nombre As atiende, C.nombre As caja, V.created_at, V.total, V.subtotal, V.descuentos, (V.total - V.subtotal) As impuesto, V.nota
FROM ventas As V
INNER JOIN tbclientes As Tc ON Tc.id = V.cliente
INNER JOIN tipo_facturas As Tf ON Tf.id = V.factura
INNER JOIN tbvendedores As A ON A.id = V.`atiende`
INNER JOIN tbnombod As C ON C.id = V.`caja`
WHERE V.id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$resp_venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resp_venta) {
    echo "<script>window.close();</script>";
    exit; // Salir del script
}

$query = "SELECT 'Efectivo' AS columna, fac_efecti AS valor FROM pagos_ventas WHERE id_ventas = :id
UNION ALL
SELECT 'Tarjeta debito' AS columna, fac_tdebit AS valor FROM pagos_ventas WHERE id_ventas = :id
UNION ALL
SELECT 'Tarjeta credito' AS columna, fac_tcredi AS valor FROM pagos_ventas WHERE id_ventas = :id
UNION ALL
SELECT 'Cheque' AS columna, fac_tchequ AS valor FROM pagos_ventas WHERE id_ventas = :id
UNION ALL
SELECT 'Vales' AS columna, fac_tvales AS valor FROM pagos_ventas WHERE id_ventas = :id
UNION ALL
SELECT 'Cambio' AS columna, fac_tcambi AS valor FROM pagos_ventas WHERE id_ventas = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$resp_medio_pago = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT Dv.*, Ta.nombre As nombre_producto
FROM `detalle_ventas` As Dv 
INNER JOIN tbarticulos As Ta ON Ta.codigo = Dv.codigo 
WHERE Dv.venta_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$resp_detalle_venta = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener la fecha actual
$fechaGeneracion = date('Y-m-d H:i:s');

// Crear una instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// $pdf->SetMargins(0, 0, 0);

// Establecer el título del documento
$pdf->SetTitle('Factura');

// Agregar una página
$pdf->AddPage();

$pdf->SetFont('courier', '', 9);
// $pdf->SetTopMargin(0);
// Agregar la imagen
// $image_file = 'https://img.freepik.com/free-vector/bird-colorful-logo-gradient-vector_343694-1365.jpg';
$image_file = '';
$pdf->Image($image_file, 10, 10, 40, '', 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);

// $pdf->SetXY(70, 10); // Establecer la posición X e Y para el texto

// Agregar el texto
// Contenido HTML
$html = '

    <div>
        <p style="text-align:center;"><b>ESTIBAS Y MADERAS DEL ATLÁNTICO SAS</b> <br> CR 15 SUR CL 8 120 BRR LA BONGA MALAMBO <br> Telefax: 3003358320 <br> MALAMBO - ATLÁNTICO-COLOMBIA <br> N.I.T. : 901100712-3</p>
        <h2 style="text-align:right;">Factura electronica de venta No. EST ' . $resp_venta['id'] . '</h2>
        <p></p>
        <p style="font-size:7.5px;">AUTORIZACION DIAN 18764052240291 DESDE EST 121 AL 1000 DEL 7 JULIO DE 2023. VIGENCIA 12 MESES. AUTORIZA</p>
        
        <table style="border-radius: 7px; border: 1px solid #000; width:100%;">
            <tr>
                <td width="15%">CLIENTE</td>
                <td width="30%">: ' . $resp_venta['cliente'] . '</td>
                <td width="10%"></td>
                <td width="23%"></td>
                <td width="22%">MONEDA: COP</td>
            </tr>
            <tr>
                <td>N.I.T.</td>
                <td>: ' . $resp_venta['documento'] . '</td>
                <td></td>
                <td colspan="2">TIPO MOVIMIENTO : 001 FACTURA CONTADO</td>
                <!-- <td>MONEDA: COP</td> -->
            </tr>
            <tr>
                <td>DIRECCION</td>
                <td>: ' . $resp_venta['direccion'] . '</td>
                <td></td>
                <td>FECHA: ' . $resp_venta['created_at'] . '</td>
                <td>PLAZO: 0 días</td>
            </tr>
            <tr>
                <td>TELEFONO</td>
                <td>: ' . $resp_venta['telefono'] . '</td>
                <td></td>
                <td>VENCE: 2024.03.05</td>
                <td>No ORDEN: ' . $resp_venta['id'] . '</td>
            </tr>
            <tr>
                <td>CIUDAD</td>
                <td>: MEDELLIN</td>
                <td></td>
                <td>VENDEDOR: ' . $resp_venta['atiende'] . '</td>
                <td>CAJA: ' . $resp_venta['caja'] . '</td>
            </tr>
        </table>
        ';

$html .= '
        <table style="border-radius: 7px; border: 1px solid #000; width:100%; text-align:left">
            <tr>
                <td width="8%"><b>CODIGO</b></td>
                <td width="36%"><b>DESCRIPCIÓN</b></td>
                <td width="8%"><b>UMED</b></td>
                <td width="10%"><b>CANTIDAD</b></td>
                <td width="15%"><b>P.VENTA UNIT.</b></td>
                <td width="8%"><b>IVA %</b></td>
                <td width="15%"><b>VALOR</b></td>
            </tr>
        </table>
        ';

$html .= '
<table style="border-radius: 7px; border: 1px solid #fff; width:100%; text-align:left">';        
// Incluir el contenido del PDF con el bucle foreach
foreach ($resp_detalle_venta as $key => $value) {
    $html .= '
    <tr>
    <td width="8%">' . $value['codigo'] . '</td>
    <td width="36%">' . $value['nombre_producto'] . '</td>
    <td width="8%">' . $value['um'] . '</td>
    <td width="10%">' . $value['cantidad'] . '</td>
    <td width="15%">' . $value['vlr_unit_final'] . '</td>
    <td width="8%">' . $value['impuesto'] . '</td>
    <td width="15%">' . $value['vlr_parcial'] . '</td>
    </tr>';
}


$html .='
</table>
        <p></p>

        <table style="border: 1px solid #000;   width:100%;">
            <tr>
                <td><b>Vlr. Gravado</b></td>
                <td>$' . $resp_venta['total'] . '</td>
                <td><b>Vlr. Excluido</b></td>
                <td>$' . $resp_venta['descuentos'] . '</td>
                <td><b>Subtotal</b></td>
                <td>$' . $resp_venta['subtotal'] . '</td>
            </tr>
            <tr>
                <td><b>Vlr. IVA</b></td>
                <td colspan="5">$' . $resp_venta['impuesto'] . '</td>
            </tr>
            <tr>
                <td colspan="5"><b>Total factura en pesos</b></td>
                <td>$' . $resp_venta['total'] . '</td>
            </tr>
            <tr>
                <td colspan="6"><b>Son:</b> ' . numeroALetras($resp_venta['total']) . '
                </td>
            </tr>
            <tr>
                <td colspan="6"><b>Nota:</b> ' . $resp_venta['nota'] . '
                </td>
            </tr>
        </table>
        <p style="margin-top:40px !important; text-align:justify;">RÉGIMEN COMÚN. Para efectos legales, esta Factura de 
        Venta se asimila a la letra de Cambio, según Art. 774 Cod Comercio. Después de vencida esta Factura cobraremos 
        intereses de Mora a la tasa máxima legal permitida. Se hace constar que la firma de una persona distinta al comprador 
        indica que dicha persona se entiende autorizada expresamente por el comprador para firmar, reconocer la deuda y obligar 
        al comprador. Impreso por ESTIBAS Y MADERAS DEL ATLÁNTICO SAS - Software: Visual Ciem Autor: Luis Cienfuegos Noble 
        CEDULA-NIT-SELLO Actividad ICA 204 tarifa 9.6 x 1000</p>

';


// Generar el código QR
$qrData = 'El numero de tu factura es: '.$resp_venta['id'];
$qrFilename = 'codigo_qr_id_'.$resp_venta['id'].'_'.$fechaGeneracion.'.png';
generateQRCode($qrData, $qrFilename);

// Agregar el código QR al PDF
// $pdf->Image($qrFilename, 25, 170, 40, 40, 'PNG', '', '', true, 300, '', false, false, 0, false, false, false);

$html .= '

<p></p>

    <table style=" width:100%;">
        <tr>
            <td rowspan="7">
                <img style="" src="' . $qrFilename . '" alt="Logo de la empresa">
            </td>
            <td width="12%"><b>RECIBIDO</b></td>
            <td width="31%">_________________________</td>
            <td width="12%"><b>ENTREGADO</b></td>
            <td width="31%">_________________________</td>
        </tr>
        <tr>
            <td colspan="4">
            
            </td>
        </tr>
        <tr>
            <td colspan="4">
            
            </td>
        </tr>

        
        <tr>
            <td><b>NOMBRE</b></td>
            <td colspan="3">_________________________</td>
        </tr>
        <tr>
            <td colspan="4">
            
            </td>
        </tr>
        <tr>
            <td colspan="4">
            
            </td>
        </tr>

        <tr>
            <td><b>CEDULA-NIT-SELLO</b></td>
            <td>_________________________</td>
            <td><b>REVISADO</b></td>
            <td>_________________________</td>
        </tr>
    </table>
    <p style="font-size:7.5px; text-align:right;"><b>Original</b></p>
    </div>

';
// Escribir el contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('factura.pdf', 'I');

function numeroALetras($numero)
{
    $uno = array('', 'UN ', 'DOS ', 'TRES ', 'CUATRO ', 'CINCO ', 'SEIS ', 'SIETE ', 'OCHO ', 'NUEVE ', 'DIEZ ', 'ONCE ', 'DOCE ', 'TRECE ', 'CATORCE ', 'QUINCE ', 'DIECISEIS ', 'DIECISIETE ', 'DIECIOCHO ', 'DIECINUEVE ');
    $diez = array('', '', 'VEINTE ', 'TREINTA ', 'CUARENTA ', 'CINCUENTA ', 'SESENTA ', 'SETENTA ', 'OCHENTA ', 'NOVENTA ');
    $cien = array('', 'CIEN ', 'DOSCIENTOS ', 'TRESCIENTOS ', 'CUATROCIENTOS ', 'QUINIENTOS ', 'SEISCIENTOS ', 'SETECIENTOS ', 'OCHOCIENTOS ', 'NOVECIENTOS ');

    $numero = trim($numero);
    $numero = str_replace(',', '', $numero);
    $enteros = explode('.', $numero);
    $numero = $enteros[0];
    $num_letra = '';
    switch ($numero) {
        case '0':
            $num_letra = 'CERO ';
            break;
        case '1':
            $num_letra = 'UNO ';
            break;
        case '2':
            $num_letra = 'DOS ';
            break;
        case '3':
            $num_letra = 'TRES ';
            break;
        case '4':
            $num_letra = 'CUATRO ';
            break;
        case '5':
            $num_letra = 'CINCO ';
            break;
        case '6':
            $num_letra = 'SEIS ';
            break;
        case '7':
            $num_letra = 'SIETE ';
            break;
        case '8':
            $num_letra = 'OCHO ';
            break;
        case '9':
            $num_letra = 'NUEVE ';
            break;
        default:
            $num_letra = '';
            break;
    }

    if ($numero > 9 && $numero < 20) {
        $num_letra = $uno[$numero];
    } elseif ($numero > 19 && $numero < 100) {
        $num_letra = $diez[substr($numero, 0, 1)];
        $num_letra .= ($numero[1] > 0) ? 'Y ' . $uno[$numero[1]] : '';
    } elseif ($numero > 99 && $numero < 1000) {
        $num_letra = $cien[substr($numero, 0, 1)];
        $num_letra .= ($numero[1] > 0 || $numero[2] > 0) ? numeroALetras((int)substr($numero, 1)) : '';
    } elseif ($numero > 999 && $numero < 2000) {
        $num_letra = 'MIL ' . numeroALetras($numero - 1000);
    } elseif ($numero >= 2000 && $numero < 1000000) {
        $num_letra = numeroALetras(floor($numero / 1000)) . 'MIL ';
        $num_letra .= ($numero % 1000 > 0) ? numeroALetras($numero % 1000) : '';
    } elseif ($numero >= 1000000 && $numero < 2000000) {
        $num_letra = 'UN MILLON ' . numeroALetras($numero - 1000000);
    } elseif ($numero >= 2000000 && $numero < 1000000000000) {
        $num_letra = numeroALetras(floor($numero / 1000000)) . 'MILLONES ';
        $num_letra .= ($numero % 1000000 > 0) ? numeroALetras($numero % 1000000) : '';
    } else {
        $num_letra = '';
    }

    $num_letra = strtoupper($num_letra);
    return $num_letra . 'PESOS';
}
