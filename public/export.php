<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/config.php';

$stmt = $pdo->query('SELECT * FROM books ORDER BY id');
$rows = $stmt->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=biblioteca_export.csv');

$output = fopen('php://output', 'w');

// Cabeceras del CSV
fputcsv($output, ['ID', 'Título', 'Autor', 'Género', 'Año', 'ISBN', 'Estado', 'Link']);

// Filas de datos
foreach ($rows as $r) {
  fputcsv($output, [
    $r['id'],
    $r['titulo'],
    $r['autor'],
    $r['genero'],
    $r['year'],
    $r['isbn'],
    $r['estado'],
    $r['link']
  ]);
}

fclose($output);
exit;
?>
