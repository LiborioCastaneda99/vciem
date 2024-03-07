<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion
require_once('../vendors/tcpdf/tcpdf.php'); // Se carga la libreria tcpdf
require_once('php-qrcode-master/lib/full/qrlib.php'); // Incluir la biblioteca PHP QR Code

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Función para generar el código QR
function generateQRCode($data, $filename)
{
    QRcode::png($data, $filename, 'H', 4, 2); // Generar el código QR y guardar en el archivo
}

$id = null;

// Verificar si se proporciona el parámetro "id" en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $encrypted = $_GET['id'];
    $key = 'clave_secreta'; // Reemplazar con la clave real o recuperarla de manera segura

    // Función para desencriptar el ID
    function decryptID($encrypted, $key)
    {
        $decrypted = openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, 0, substr($key, 0, 16));
        return $decrypted !== false ? $decrypted : null; // Manejar errores de desencriptación
    }

    // Desencriptar el ID
    $id = decryptID($encrypted, $key);

    if ($id !== null) {
        // El ID se desencriptó correctamente, ahora puedes usarlo
        // echo "ID desencriptado: $id";
    } else {
        // Error al desencriptar el ID
        echo "Error: No se pudo desencriptar el ID";
    }
} else {
    // El parámetro "id" no está presente en la URL
    echo "Error: Falta el parámetro 'id' en la URL";
}


// Crear una instancia de TCPDF
$dbconec = new Conexion();
$conn = $dbconec->Conectar();
$conn->exec("SET CHARACTER SET utf8");

$query = "SELECT V.id, Tc.nombre As cliente, Tc.codigo As documento, Tc.direc As direccion, Tf.nombre As tipo_factura, 
A.nombre As atiende, C.nombre As caja, V.created_at, V.total, V.subtotal, V.descuentos, (V.total - V.subtotal) As impuesto
FROM ventas As V
INNER JOIN tbclientes As Tc ON Tc.id = V.cliente
INNER JOIN tipo_facturas As Tf ON Tf.id = V.factura
INNER JOIN tbvendedores As A ON A.id = V.`atiende`
INNER JOIN tbnombod As C ON C.id = V.`caja`
WHERE V.id = :id";  // Usamos el marcador de posición :id
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$resp_venta = $stmt->fetch(PDO::FETCH_ASSOC);


// if (!$resp_venta) {
//     echo "<script>window.close();</script>";
//     exit; // Salir del script
// }

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

// Crear una instancia de la clase TCPDF
$pdf = new TCPDF('P', 'mm', array(90, 300), true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5, true); // Establece los márgenes izquierdo, derecho y superior en 10 mm

// Establecer el título del documento
$pdf->SetTitle('Tirilla de Facturación POS');

// Agregar una página
$pdf->AddPage();

// Establecer el formato de fuente
$pdf->SetFont('helvetica', '', 9);

// Definir la información de la tirilla de facturación
$contenido = '
<div>
    <p style="text-align:center !important;">
        <b>ANA BEATRIZ MENDIVIL HENRIQUEZ</b>
        <br>NIT. 31275776-1 <br>
        CALLE 73 # 41D - 19 <br>
        TELEFONO: 3456696 - 3453161 <br>
        BARRANQUILLA-COLOMBIA <br>
        e.d.s.texaco4@hotmail.com <br>
        2024.03.05 01:43:06 PM <br>
        FACTURA DE VENTA No. 001223 <br>
        AUTORIZACION POS DIAN 18764060787003 <br>
        DEL PAM 8002 AL 9000 DEL 28 NOVIEMBRE 2023 <br>
    </p>
    <hr>
    <table>
        <tr>
            <td><b>Nombre:</b></td>
            <td colspan="2">' . $resp_venta['cliente'] . '</td>
        </tr>
        <tr>
            <td><b>Dirección:</b></td>
            <td colspan="2">' . $resp_venta['direccion'] . '</td>
        </tr>
        <tr>
            <td><b>Nit:</b></td>
            <td colspan="2">' . $resp_venta['documento'] . '</td>
        </tr>
        <tr>
            <td><b>Almacen:</b></td>
            <td colspan="2">' . $resp_venta['caja'] . '</td>
        </tr>
        <tr>
            <th><b>Fecha</b></th>
            <th><b>Plazo</b></th>
            <th><b>Vendedor</b></th>
        </tr>
        <tr>
            <td>' . $resp_venta['created_at'] . '</td>
            <td>4 días</td>
            <td>' . $resp_venta['atiende'] . '</td>
        </tr>
        <tr>
        <td>
        </td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <th>
                <b>Cod</b>
            </th>
            <th colspan="3">
                <b>Descripción</b>
            </th>
        </tr>
        <tr>
            <th>
                <b>Cant.</b>
            </th>
            <th>
                <b>P. Unit.</b>
            </th>
            <th>
                <b>Iva %</b>
            </th>
            <th>
                <b>Total</b>
            </th>
        </tr>
    </table>
    <hr>
';


// Incluir el contenido del PDF con el bucle foreach
$contenido .= '
    <table>';
foreach ($resp_detalle_venta as $key => $value) {
    $contenido .= '
    <tr>
    <td>
    ' . $value['codigo'] . '
    </td>
    <td colspan="3">
    ' . $value['nombre_producto'] . '    </td>
    </tr>
    <tr>
        <td>
        ' . $value['cantidad'] . '
        </td>
        <td>
        ' . $value['vlr_unit_final'] . '        </td>
        <td>
        ' . $value['impuesto'] . '
        </td>
        <td>
        ' . $value['vlr_parcial'] . '        </td>
    </tr>';
}

$contenido .= '
</table>
<hr>
<table>
    <tr>
        <td colspan="3">
            Subtotal
        </td>
        <td>
            ' . $resp_venta['subtotal'] . '
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Descuento
        </td>
        <td>
            ' . floatval($resp_venta['descuento']) . '
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Valor Iva
        </td>
        <td>
            ' . $resp_venta['impuesto'] . '
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Total a pagar
        </td>
        <td>
            ' . $resp_venta['total'] . '
        </td>
    </tr>
</table>';

// Incluir el contenido del PDF con el bucle foreach
$contenido .= '
    <table>
        <tr>
            <td colspan="4" style="text-align:center;"><b>FORMA DE PAGO</b></td>
        </tr>';
foreach ($resp_medio_pago as $key => $value) {
    $contenido .= '
        <tr>
            <td colspan="3">' . $value['columna'] . '</td>
            <td>' . $value['valor'] . '</td>
        </tr>';
}

$contenido .= '
        <tr>
            <td colspan="4" cellpadding="2" style="text-align:justify;">
                <br><br>RÉGIMEN COMÚN. No somos autorretenedores, ni grandes
                contribuyentes. Declaro haber recibido a entera satisfacción
                esta mercancía.
                <br>Para efectos legales, esta Factura de Venta se asimila a la
                letra
                de Cambio, según Art. 774 Cod Comercio. Después de vencida esta
                factura cobraremos Intereses de Mora a la tasa máxima legal
                permitida.
                <br>Impreso por ANA BEATRIZ MENDIVIL HENRIQUEZ Software: Visual
                Ciem Autor: Luis Cienfuegos Combustibles y Lubricantes de la
                mejor calidad, baterías hasta con el 40% de descuento. Llantas,
                accesorios y cambios de aceites.
            </td>
        </tr>
    </table>
    ************* <b>GRACIAS POR SU COMPRA</b> *************
    </div>';
// Continuar con el resto del contenido del PDF...

// Generar el código QR
$qrData = 'Información que deseas codificar en el código QR';
$qrFilename = 'codigo_qr.png';
generateQRCode($qrData, $qrFilename);

// Agregar el código QR al PDF
$pdf->Image($qrFilename, 25, 235, 40, 40, 'PNG', '', '', true, 300, '', false, false, 0, false, false, false);

// Escribir el contenido en el PDF
$pdf->writeHTML($contenido, true, false, true, false, '');

// Salida del PDF
$pdf->Output('tirilla_facturacion_POS.pdf', 'I');
