<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$id = intval($_GET['id']);
$stmt = $pdo->prepare('SELECT * FROM books WHERE id=:id');
$stmt->execute([':id' => $id]);
$b = $stmt->fetch();

if (!$b) {
  echo "<div class='alert alert-danger text-center mt-5'>❌ Libro no encontrado</div>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= esc($b['titulo']) ?> - Biblioteca Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .book-card {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .book-img {
      width: 200px;
      height: 280px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #ddd;
    }
    .book-title {
      font-weight: bold;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="book-card">
      <div class="text-center mb-4">
        <?php if (!empty($b['link'])): ?>
          <img src="<?= esc($b['link']) ?>" alt="Portada del libro" class="book-img mb-3">
        <?php else: ?>
          <div class="text-muted fst-italic">Sin imagen disponible</div>
        <?php endif; ?>
        <h2 class="book-title mt-3"><?= esc($b['titulo']) ?></h2>
        <span class="badge <?= $b['estado'] == 'Disponible' ? 'bg-success' : 'bg-danger' ?>">
          <?= esc($b['estado']) ?>
        </span>
      </div>

      <div class="mb-3">
        <p><b><i class="fa-solid fa-user"></i> Autor:</b> <?= esc($b['autor']) ?></p>
        <p><b><i class="fa-solid fa-tags"></i> Género:</b> <?= esc($b['genero']) ?></p>
        <p><b><i class="fa-solid fa-calendar"></i> Año:</b> <?= esc($b['year']) ?></p>
        <p><b><i class="fa-solid fa-barcode"></i> ISBN:</b> <?= esc($b['isbn']) ?></p>
      </div>

      <div class="mb-4">
        <h5><i class="fa-solid fa-book-open"></i> Descripción</h5>
        <p class="text-muted"><?= nl2br(esc($b['descripcion'])) ?></p>
      </div>

      <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-primary">
          <i class="fa-solid fa-pen"></i> Editar
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
