<?php

require_once('Connexio.php');


class Eliminar {
    
    public function eliminar($id) {
        // Verificar si se ha proporcionado un ID válido
        if (!isset($id) || !is_numeric($id)) {
            echo '<p>ID de producto no válido.</p>';
            return;
        }

        // Crear una instancia de la clase de conexión
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Escapar el ID para evitar inyección SQL
        $id = $conexion->real_escape_string($id);

        // Consulta para eliminar el producto de la base de datos
        $consulta = "DELETE FROM productes WHERE id = '$id'";

        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            echo '<p>Error al eliminar el producto: ' . $conexion->error . '</p>';
        }

        // Cerrar la conexión
        $conexion->close();
    }
}

// Obtener el ID del producto a eliminar
$idProducto = isset($_GET['id']) ? $_GET['id'] : null;

// Crear una instancia de la clase y eliminar el producto
$eliminarProducto = new Eliminar();
$eliminarProducto->eliminar($idProducto);

?>
