<?php
require_once('Connexio.php');

class Nou {

    public function afegirProducte($nom, $descripcio, $preu, $categoria) {
        // 
        if (!isset($nom) || !isset($descripcio) || !isset($preu) || !isset($categoria)) {
            echo '<p>Se requieren todos los campos para agregar un nuevo producto.</p>';
            return;
        }

        // 
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // 
        $nom = $conexion->real_escape_string($nom);
        $descripcio = $conexion->real_escape_string($descripcio);
        $preu = $conexion->real_escape_string($preu);
        $categoria = $conexion->real_escape_string($categoria);

        // 
        $consulta = "INSERT INTO productes (nom, descripció, preu, categoria_id)
                     VALUES ('$nom', '$descripcio', '$preu', '$categoria')";

        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            echo '<p>Error al agregar el nuevo producto: ' . $conexion->error . '</p>';
        }

        //
        $conexion->close();
    }
}

// 
function obtenirCategories() {
    $conexionObj = new Connexio();
    $conexion = $conexionObj->obtenirConnexio();

    $consulta = "SELECT id, nom FROM categories";
    $resultado = $conexion->query($consulta);

    $categories = [];

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $categories[$fila['id']] = $fila['nom'];
        }
    }

    //
    $conexion->close();

    return $categories;
}

//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $descripcio = isset($_POST['descripcio']) ? $_POST['descripcio'] : null;
    $preu = isset($_POST['preu']) ? $_POST['preu'] : null;
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

    //
    $nouProducte = new Nou();
    $nouProducte->afegirProducte($nom, $descripcio, $preu, $categoria);
}

// 
$categorias = obtenirCategories();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Nuevo Producto</title>
        <!--  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>

<?php
require_once('Header.php');
?>
        <div class="container mt-5">
            <form action="" method="POST" class="needs-validation" novalidate>
                <!-- Campos del formulario -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nombre:</label>
                    <input type="text" name="nom" class="form-control" required>
                    <div class="invalid-feedback">Por favor, ingresa un nombre.</div>
                </div>

                <div class="mb-3">
                    <label for="descripcio" class="form-label">Descripción:</label>
                    <input type="text" name="descripcio" class="form-control" required>
                    <div class="invalid-feedback">Por favor, ingresa una descripción.</div>
                </div>

                <div class="mb-3">
                    <label for="preu" class="form-label">Precio:</label>
                    <input type="number" name="preu" class="form-control" required>
                    <div class="invalid-feedback">Por favor, ingresa un precio válido.</div>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <select name="categoria" class="form-select" required>
<?php
foreach ($categorias as $id => $nomCategoria) {
    echo "<option value=\"$id\">$nomCategoria</option>";
}
?>
                    </select>
                    <div class="invalid-feedback">Por favor, selecciona una categoría.</div>
                </div>

                <hr>

                <!-- Botón de enviar formulario -->
                <input type="submit" value="Afegir producte" class="btn btn-primary">
                <a href="Principal.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>

<?php
echo '<script>
    // Añadir el script para validar el formulario usando Bootstrap
    (function () {
        \'use strict\';

        // Seleccionar todos los formularios que necesitan validación
        var forms = document.querySelectorAll(\'.needs-validation\');

        // Iterar sobre ellos y evitar el envío si no son válidos
        Array.from(forms).forEach(function (form) {
            form.addEventListener(\'submit\', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add(\'was-validated\');
            }, false);
        });
    })();
</script>';
require_once('Footer.php');
?>