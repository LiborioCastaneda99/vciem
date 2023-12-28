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
<h1 style="text-align: center;">Reporte de articulos</h1>
<p style="text-align: center;">Fecha de Generación: ' . $fechaGeneracion . '</p>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th>Código</th>
        <th>Homologación</th>
        <th>Nombre</th>
        <th>Clase</th>
        <th>Grupo</th>
        <th>Referencia</th>
        <th>Umedida</th>
        <th>Stmin</th>
        <th>Stmax</th>
        <th>Ctostan</th>
        <th>Ctoult</th>
        <th>Fecult</th>
        <th>Nal</th>
        <th>Pv1</th>
        <th>Pv2</th>
        <th>Pv3</th>
        <th>Ubicación</th>
        <th>Uxemp</th>
        <th>Peso</th>
        <th>IVA</th>
        <th>Impo</th>
        <th>Flete</th>
        <th>Estado</th>
        <th>Canen</th>
        <th>Valen</th>
        <th>Pdes</th>
        <th>Ultpro</th>
        <th>Docpro</th>
    </tr>
';

// Realizar una consulta a la base de datos (asegúrate de tener una conexión establecida)
$sql = "SELECT `id`, `codigo`, `homol`, `nombre`, `clase`, `grupo`, `referencia`, `umedida`, 
`stmin`, `stmax`, `ctostan`, `ctoult`, `fecult`, `nal`, `pv1`, `pv2`, `pv3`, `ubicacion`, `uxemp`, 
`peso`, `iva`, `impo`, `flete`, `estado`, `canen`, `valen`, `pdes`, `ultpro`, `docpro` FROM tbarticulos WHERE activo = 1;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$lstResult = $stmt->fetchAll();

// Obtener registros a traves de la consulta SQL
if (count($lstResult)) {
    foreach ($lstResult as $result) {
        $html .= '
            <tr>
                <td style="text-align: center;">' . $result["codigo"] . '</td>
                <td>' . $result["codigo"] . '</td>
                <td>' . $result["homol"] . '</td>
                <td>' . $result["nombre"] . '</td>
                <td>' . $result["clase"] . '</td>
                <td>' . $result["grupo"] . '</td>
                <td>' . $result["referencia"] . '</td>
                <td>' . $result["umedida"] . '</td>
                <td>' . $result["stmin"] . '</td>
                <td>' . $result["stmax"] . '</td>
                <td>' . $result["ctostan"] . '</td>
                <td>' . $result["ctoult"] . '</td>
                <td>' . $result["fecult"] . '</td>
                <td>' . $result["nal"] . '</td>
                <td>' . $result["pv1"] . '</td>
                <td>' . $result["pv2"] . '</td>
                <td>' . $result["pv3"] . '</td>
                <td>' . $result["ubicacion"] . '</td>
                <td>' . $result["uxemp"] . '</td>
                <td>' . $result["peso"] . '</td>
                <td>' . $result["iva"] . '</td>
                <td>' . $result["impo"] . '</td>
                <td>' . $result["flete"] . '</td>
                <td>' . $result["estado"] . '</td>
                <td>' . $result["canen"] . '</td>
                <td>' . $result["valen"] . '</td>
                <td>' . $result["pdes"] . '</td>
                <td>' . $result["ultpro"] . '</td>
                <td>' . $result["docpro"] . '</td>
            </tr>
        ';
    }
} else {
    $html .= '<tr><td colspan="19" style="text-align: center;">No se encontraron resultados.</td></tr>';
}

$html .= '</table>';
$pdf->setTitle('Reporte de articulos - Visual100');
$pdf->writeHTML($html, true, false, true, false, '');

// Obtén el número total de páginas después de escribir el contenido HTML
$numeroTotalPaginas = $pdf->getNumPages();

// Configurar el pie de página después de obtener el número total de páginas
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));  // Configurar el espacio del pie de página
$pdf->SetMargins(10, 10, 10);

// Nombrar el archivo PDF y descargarlo
$pdf->Output('reporte_articulos.pdf', 'I');
