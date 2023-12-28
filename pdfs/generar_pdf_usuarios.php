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
$pdf->AddPage('P', 'A4');

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
<h1 style="text-align: center;">Reporte de Usuarios</h1>
<p style="text-align: center;">Fecha de Generación: ' . $fechaGeneracion . '</p>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th style="width: 5%;text-align: center;">ID</th>
        <th style="width: 45%;">Nombre</th>
        <th style="width: 30%;">Correo Electrónico</th>
        <th style="width: 20%;">Rol</th>
        <!-- Puedes ajustar los porcentajes según tus necesidades -->
    </tr>
';

// Realizar una consulta a la base de datos (asegúrate de tener una conexión establecida)
$sql = "SELECT U.fld_codusuario AS id, U.nombres As nombre, U.fld_nomusuario AS correo_electronico, R.id AS id_rol, R.nombre AS rol 
FROM user U
INNER JOIN roles R ON R.id  = U.rol_id
WHERE U.activo = 1 ORDER BY U.fld_codusuario ASC;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$lstResult = $stmt->fetchAll();

// Obtener registros a traves de la consulta SQL
if (count($lstResult)) {
    foreach ($lstResult as $result) {
        $html .= '
            <tr>
                <td style="text-align: center;">' . $result["id"] . '</td>
                <td>' . $result["nombre"] . '</td>
                <td>' . $result["correo_electronico"] . '</td>
                <td>' . $result["rol"] . '</td>
                <!-- Agrega más celdas según tus necesidades -->
            </tr>
        ';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align: center;">No se encontraron resultados.</td></tr>';
}

$html .= '</table>';
$pdf->setTitle('Reporte de usuarios - Visual100');
$pdf->writeHTML($html, true, false, true, false, '');

// Obtén el número total de páginas después de escribir el contenido HTML
$numeroTotalPaginas = $pdf->getNumPages();

// Configurar el pie de página después de obtener el número total de páginas
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));  // Configurar el espacio del pie de página
$pdf->SetMargins(10, 10, 10);

// Nombrar el archivo PDF y descargarlo
$pdf->Output('reporte_usuarios.pdf', 'I');
