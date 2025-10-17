<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare('INSERT INTO books (titulo, autor, genero, year, isbn, estado, descripcion, link)
    VALUES (:titulo, :autor, :genero, :year, :isbn, :estado, :descripcion, :link)');
  $stmt->execute([
    ':titulo' => $_POST['titulo'],
    ':autor' => $_POST['autor'],
    ':genero' => $_POST['genero'],
    ':year' => $_POST['year'],
    ':isbn' => $_POST['isbn'],
    ':estado' => $_POST['estado'],
    ':descripcion' => $_POST['descripcion'],
    ':link' => $_POST['link']
  ]);
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Libro</title>
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
      display: none;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="card p-4">
      <h2 class="text-center mb-4">Agregar Nuevo Libro</h2>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Título:</label>
          <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Autor:</label>
          <input type="text" name="autor" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Género:</label>
          <input type="text" name="genero" class="form-control">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Año:</label>
            <input type="number" name="year" class="form-control">
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">ISBN:</label>
            <input type="text" name="isbn" class="form-control">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Estado:</label>
          <select name="estado" class="form-select">
            <option value="Disponible">Disponible</option>
            <option value="Prestado">Prestado</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Descripción:</label>
          <textarea name="descripcion" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Link o Imagen del Libro:</label>
          <input type="text" name="link" id="link" class="form-control" placeholder="https://...">
          <div class="mt-3 text-center">
            <img id="preview" alt="Vista previa de la imagen">
          </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <a href="index.php" class="btn btn-secondary">← Volver</a>
          <button type="submit" class="btn btn-primary">💾 Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Vista previa de la imagen
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
