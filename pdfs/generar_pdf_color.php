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
<h1 style="text-align: center;">Reporte de colores</h1>
<p style="text-align: center;">Fecha de Generación: ' . $fechaGeneracion . '</p>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th style="width: 20%;text-align: center;">Codigo</th>
        <th style="width: 80%;">Nombre</th>
    </tr>
';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        /* Estilos para la factura */
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            /* width: 100%; */
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .invoice-header,
        .invoice-body {
            margin-bottom: 20px;
            text-align: center;
        }
        .invoice-footer {
            margin-bottom: 20px;
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .invoice-total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Factura de venta</h1>
            <p>Fecha: 6 de febrero de 2024</p>
            <p>Cliente: Juan Pérez</p>
            <p>Caja: Juan Pérez</p>
            <p>Factura No.: 12345</p>
        </div>
        <div class="invoice-body">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>UM</th>
                        <th>Cant</th>
                        <th>Vlr.Unit</th>
                        <th>Desc</th>
                        <th>Vlr.Desc</th>
                        <th>Vlr.Unit Final</th>
                        <th>% Imp</th>
                        <th>Vlr. Imp</th>
                        <th>Vlr. Parcial</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Producto 1</td>
                        <td>2</td>
                        <td>$10.00</td>
                        <td>$20.00</td>
                    </tr>
                    <!-- Agrega más filas según los productos -->
                </tbody>
            </table>
        </div>
        <div class="invoice-footer">
            <p>Subtotal: $20.00</p>
            <p>Impuestos: $2.00</p>
            <p class="invoice-total">Total: $22.00</p>
        </div>
    </div>
</body>

</html>