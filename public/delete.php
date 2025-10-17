<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$id = intval($_GET['id']);
$stmt = $pdo->prepare('SELECT * FROM books WHERE id=:id');
$stmt->execute([':id' => $id]);
$book = $stmt->fetch();

if (!$book) {
  echo "<div class='alert alert-danger text-center mt-5'>❌ Libro no encontrado</div>";
  exit;
}

// Si el usuario confirma la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $delete = $pdo->prepare('DELETE FROM books WHERE id=:id');
  $delete->execute([':id' => $id]);
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar Libro - <?= esc($book['titulo']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <div class="confirm-card">
      <h3 class="text-danger mb-3"><i class="fa-solid fa-triangle-exclamation"></i> Confirmar Eliminación</h3>
      <p>¿Seguro que deseas eliminar el siguiente libro?</p>

      <?php if (!empty($book['link'])): ?>
        <img src="<?= esc($book['link']) ?>" alt="Portada del libro" class="book-img mb-3">
      <?php else: ?>
        <div class="text-muted fst-italic mb-3">Sin imagen disponible</div>
      <?php endif; ?>

      <h5 class="fw-bold"><?= esc($book['titulo']) ?></h5>
      <p class="mb-4"><?= esc($book['autor']) ?> — <?= esc($book['year']) ?></p>

      <form method="POST" class="d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-danger">
          <i class="fa-solid fa-trash"></i> Eliminar definitivamente
        </button>
        <a href="index.php" class="btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Cancelar
        </a>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
