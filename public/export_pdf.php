<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/config.php';

// Consulta de datos
$stmt = $pdo->query('SELECT * FROM books ORDER BY id');
$books = $stmt->fetchAll();

// Contenido HTML del PDF
$html = '<h2 style="text-align:center;">Biblioteca Digital - Lista de Libros</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%">
<thead>
<tr style="background-color:#f2f2f2;">
  <th>ID</th>
  <th>Imagen</th>
  <th>Título</th>
  <th>Autor</th>
  <th>Género</th>
  <th>Año</th>
  <th>Estado</th>
</tr>
</thead>
<tbody>';

foreach ($books as $book) {
    $html .= '<tr>
        <td>' . htmlspecialchars($book['id']) . '</td>
        <td>';
    
    if (!empty($book['link'])) {
        // Evitar mostrar GIF para que Dompdf no falle
        $ext = strtolower(pathinfo($book['link'], PATHINFO_EXTENSION));
        if ($ext !== 'gif') {
            $html .= '<img src="' . htmlspecialchars($book['link']) . '" width="50" height="70">';
        } else {
            $html .= '—'; // O poner un placeholder PNG
        }
    } else {
        $html .= '—';
    }

    $html .= '</td>
        <td>' . htmlspecialchars($book['titulo']) . '</td>
        <td>' . htmlspecialchars($book['autor']) . '</td>
        <td>' . htmlspecialchars($book['genero']) . '</td>
        <td>' . htmlspecialchars($book['year']) . '</td>
        <td>' . htmlspecialchars($book['estado']) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Configuración de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Permite mostrar imágenes externas
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('biblioteca_libros.pdf', ['Attachment' => true]);
?>
