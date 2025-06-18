<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🎬 Registro de Películas</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f0f0f0; }
        h1 { color: #333; }
        input, select, button { margin: 5px; padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        .acciones button { margin-right: 5px; }
    </style>
</head>
<body>

<h1>Registro de Películas</h1>

<form id="formPelicula">
    <input type="hidden" id="idPelicula" name="idPelicula">
    <input type="text" id="titulo" name="titulo" placeholder="Título" required>
    <input type="number" id="anio" name="anio" placeholder="Año" required>
    <input type="number" id="duracionMin" name="duracionMin" placeholder="Duración (min)" required>
    <input type="number" id="idGenero" name="idGenero" placeholder="ID Género" required>
    <input type="number" id="idDirector" name="idDirector" placeholder="ID Director" required>
    <br>
    <button type="submit">Guardar</button>
    <button type="button" onclick="limpiarFormulario()">Limpiar</button>
</form>

<hr>

<h2>Películas Registradas</h2>
<table id="tablaPeliculas">
    <thead>
        <tr>
            <th>ID</th><th>Título</th><th>Año</th><th>Duración</th>
            <th>Género</th><th>Director</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</body>
</html>
