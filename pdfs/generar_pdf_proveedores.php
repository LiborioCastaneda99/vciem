<?php
require_once('../modelo/Conexion.php');  // Se carga la clase conexion
require_once('../vendors/tcpdf/tcpdf.php'); // Se carga la libreria tcpdf

// Crear una instancia de TCPDF
$pdf = new TCPDF();
$dbconec = new Conexion();
$conn = $dbconec->Conectar();
$conn->exec("SET CHARACTER SET utf8");

// Obtener la fecha actual
$fechaGeneracion = date('Y-m-d H:i:s');

// Agregar una página al PDF
$pdf->AddPage('L', 'OFICIO');

// Estilos CSS para la tabla
$style = '
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
';

// Contenido HTML que deseas incluir en el PDF
$html = $style . '
<h1 style="text-align: center;">Reporte de proveedores</h1>
<p style="text-align: center;">Fecha de Generación: ' . $fechaGeneracion . '</p>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th>Código</th>
        <th>Sucursal</th>
        <th>Zona</th>
        <th>Subzona</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono 1</th>
        <th>Teléfono 2</th>
        <th>Ciudad</th>
        <th>Cupo</th>
        <th>Legal</th>
        <th>Fecha Inicial</th>
        <th>Forma de Pago</th>
        <th>Correo</th>
        <th>Caract. Devolución</th>
        <th>Dígito</th>
        <th>Retención de IVA</th>
        <th>Retención de Fuente</th>
        <th>Retención de ICA</th>
        <th>Estado</th>
    </tr>
';

// Realizar una consulta a la base de datos (asegúrate de tener una conexión establecida)
$sql = "SELECT `id`, `codigo`, `suc`, `zona`, `subzona`, `nombre`, `dir`, `tel1`, 
`tel2`, `ciudad`, `cupo`, `legal`, `fecha_ini`, `forma_pago`, `correo`, `caract_dev`, 
`digito`, `riva`, `rfte`, `rica`, `estado` FROM proveedores WHERE activo = 1;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$lstResult = $stmt->fetchAll();

// Obtener registros a traves de la consulta SQL
if (count($lstResult)) {
    foreach ($lstResult as $result) {
        $html .= '
            <tr>
                <td style="text-align: center;">' . $result["codigo"] . '</td>
                <td> '. $result["suc"] . '</td>
                <td> '. $result["zona"] . '</td>
                <td> '. $result["subzona"] . '</td>
                <td> '. $result["nombre"] . '</td>
                <td> '. $result["dir"] . '</td>
                <td> '. $result["tel1"] . '</td>
                <td> '. $result["tel2"] . '</td>
                <td> '. $result["ciudad"] . '</td>
                <td> '. $result["cupo"] . '</td>
                <td> '. $result["legal"] . '</td>
                <td> '. $result["fecha_ini"] . '</td>
                <td> '. $result["forma_pago"] . '</td>
                <td> '. $result["correo"] . '</td>
                <td> '. $result["caract_dev"] . '</td>
                <td> '. $result["digito"] . '</td>
                <td> '. $result["riva"] . '</td>
                <td> '. $result["rfte"] . '</td>
                <td> '. $result["rica"] . '</td>
                <td> '. $result["estado"] . '</td>
            </tr>
        ';
    }
} else {
    $html .= '<tr><td colspan="19" style="text-align: center;">No se encontraron resultados.</td></tr>';
}

$html .= '</table>';
$pdf->setTitle('Reporte de proveedores - Visual100');
$pdf->writeHTML($html, true, false, true, false, '');

// Obtén el número total de páginas después de escribir el contenido HTML
$numeroTotalPaginas = $pdf->getNumPages();

// Configurar el pie de página después de obtener el número total de páginas
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));  // Configurar el espacio del pie de página
$pdf->SetMargins(10, 10, 10);

// Nombrar el archivo PDF y descargarlo
$pdf->Output('reporte_proveedores.pdf', 'I');
