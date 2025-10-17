<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$stmt = $pdo->query('SELECT * FROM books ORDER BY id DESC');
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Biblioteca Digital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    h1 {
      color: #007bff;
      font-weight: 700;
    }
    .btn-custom {
      border-radius: 8px;
      font-weight: 500;
    }
    .table th {
      background-color: #007bff !important;
      color: #fff;
    }
    .table td img {
      border-radius: 5px;
    }
    .container {
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center">
        <i class="fas fa-book-open fa-2x text-primary me-2"></i>
        <h1 class="m-0">Biblioteca Digital</h1>
      </div>
      <div class="d-flex gap-2">
        <a href="add.php" class="btn btn-success btn-custom">
          <i class="fas fa-plus"></i> Agregar Libro
        </a>
        <a href="export.php" class="btn btn-info btn-custom text-white">
          <i class="fas fa-file-csv"></i> Exportar CSV
        </a>
        <a href="export_pdf.php" class="btn btn-danger btn-custom">
          <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
      </div>
    </div>

    <!-- Tabla de libros -->
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <?php if (!empty($books)): ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Imagen</th>
                  <th>Título</th>
                  <th>Autor</th>
                  <th>Género</th>
                  <th>Año</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($books as $b): ?>
                <tr>
                  <td><?= htmlspecialchars($b['id']) ?></td>
                  <td>
                    <?php if (!empty($b['link'])): ?>
                      <img src="<?= htmlspecialchars($b['link']) ?>" 
                           alt="Portada" 
                           style="width:60px; height:80px; object-fit:cover;">
                    <?php else: ?>
                      <span class="text-muted">Sin imagen</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($b['titulo']) ?></td>
                  <td><?= htmlspecialchars($b['autor']) ?></td>
                  <td><?= htmlspecialchars($b['genero']) ?></td>
                  <td><?= htmlspecialchars($b['year']) ?></td>
                  <td>
                    <span class="badge <?= ($b['estado'] == 'Disponible') ? 'bg-success' : 'bg-secondary' ?>">
                      <?= htmlspecialchars($b['estado']) ?>
                    </span>
                  </td>
                  <td>
                    <a href="view.php?id=<?= $b['id'] ?>" class="btn btn-primary btn-sm me-1">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-warning btn-sm me-1">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete.php?id=<?= $b['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este libro?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-info text-center mb-0">
            No hay libros registrados en la biblioteca.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
