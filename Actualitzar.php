<?php

require_once('Connexio.php');


class Actualitzar {
    
    public function actualizar($id, $nom, $descripcio, $preu, $categoria) {
        // Verificar si se han proporcionado valores válidos
        if (!isset($id) || !isset($nom) || !isset($descripcio) || !isset($preu) || !isset($categoria)) {
            echo '<p>Se requieren todos los campos para actualizar el producto.</p>';
            return;
        }

        // Crear una instancia de la clase de conexión
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Escapar valores para evitar inyección SQL
        $id = $conexion->real_escape_string($id);
        $nom = $conexion->real_escape_string($nom);
        $descripcio = $conexion->real_escape_string($descripcio);
        $preu = $conexion->real_escape_string($preu);
        $categoria = $conexion->real_escape_string($categoria);

        // Consulta para actualizar el producto en la base de datos
        $consulta = "UPDATE productes
                     SET nom = '$nom', descripció = '$descripcio', preu = '$preu', categoria_id = '$categoria'
                     WHERE id = '$id'";

        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            echo '<p>Error al actualizar el producto: ' . $conexion->error . '</p>';
        }

        // Cerrar la conexión
        $conexion->close();
    }
}

// Obtener los valores del formulario
$id = isset($_POST['id']) ? $_POST['id'] : null;
$nom = isset($_POST['nom']) ? $_POST['nom'] : null;
$descripcio = isset($_POST['descripcio']) ? $_POST['descripcio'] : null;
$preu = isset($_POST['preu']) ? $_POST['preu'] : null;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

// Crear una instancia de la clase y actualizar el producto
$actualizarProducto = new Actualitzar();
$actualizarProducto->actualizar($id, $nom, $descripcio, $preu, $categoria);

?>
