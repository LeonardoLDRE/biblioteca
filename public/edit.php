<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$id = intval($_GET['id']);
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute([':id' => $id]);
$book = $stmt->fetch();

if (!$book) {
  echo "<div class='alert alert-danger text-center mt-5'>❌ Libro no encontrado</div>";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $update = $pdo->prepare('UPDATE books SET titulo=:titulo, autor=:autor, genero=:genero, year=:year, isbn=:isbn, estado=:estado, descripcion=:descripcion, link=:link WHERE id=:id');
  $update->execute([
    ':titulo' => $_POST['titulo'],
    ':autor' => $_POST['autor'],
    ':genero' => $_POST['genero'],
    ':year' => $_POST['year'],
    ':isbn' => $_POST['isbn'],
    ':estado' => $_POST['estado'],
    ':descripcion' => $_POST['descripcion'],
    ':link' => $_POST['link'],
    ':id' => $id
  ]);
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Libro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      max-width: 700px;
      margin: 40px auto;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    img#preview {
      width: 100%;
      max-height: 300px;
      object-fit: contain;
      border: 1px solid #ddd;
      border-radius: 10px;
      display: block;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="card p-4">
      <h2 class="text-center mb-4">Editar Libro</h2>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Título:</label>
          <input type="text" name="titulo" class="form-control" value="<?= esc($book['titulo']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Autor:</label>
          <input type="text" name="autor" class="form-control" value="<?= esc($book['autor']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Género:</label>
          <input type="text" name="genero" class="form-control" value="<?= esc($book['genero']) ?>">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Año:</label>
            <input type="number" name="year" class="form-control" value="<?= esc($book['year']) ?>">
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">ISBN:</label>
            <input type="text" name="isbn" class="form-control" value="<?= esc($book['isbn']) ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Estado:</label>
          <select name="estado" class="form-select">
            <option value="Disponible" <?= $book['estado']=='Disponible'?'selected':'' ?>>Disponible</option>
            <option value="Prestado" <?= $book['estado']=='Prestado'?'selected':'' ?>>Prestado</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Descripción:</label>
          <textarea name="descripcion" rows="3" class="form-control"><?= esc($book['descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Link o Imagen del Libro:</label>
          <input type="text" name="link" id="link" class="form-control" value="<?= esc($book['link']) ?>" placeholder="https://...">
          <div class="mt-3 text-center">
            <img id="preview" src="<?= esc($book['link']) ?>" alt="Vista previa de la imagen">
          </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <a href="index.php" class="btn btn-secondary">← Cancelar</a>
          <button type="submit" class="btn btn-primary">💾 Actualizar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Vista previa dinámica
    const linkInput = document.getElementById('link');
    const preview = document.getElementById('preview');

    linkInput.addEventListener('input', () => {
      const url = linkInput.value.trim();
      if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
        preview.src = url;
        preview.style.display = 'block';
      } else {
        preview.style.display = 'none';
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
