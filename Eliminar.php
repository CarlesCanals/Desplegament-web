<?php

// Incluye el archivo de conexión
require_once('Connexio.php');

class Eliminar {
    
    // Método para eliminar un producto de la base de datos
    public function eliminar($id) {
        // Verifica si el ID del producto es válido
        if (!isset($id) || !is_numeric($id)) {
            echo '<p>ID de producto no válido.</p>';
            return;
        }

        // Crea una instancia de la clase de conexión
        $conexionObj = new Connexio();
        // Obtiene la conexión a la base de datos
        $conexion = $conexionObj->obtenirConnexio();

        // Escapa el ID para prevenir SQL injection
        $id = $conexion->real_escape_string($id);

        // Construye la consulta SQL de eliminación
        $consulta = "DELETE FROM productes WHERE id = '$id'";

        // Ejecuta la consulta y redirige a la página principal si tiene éxito
        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al eliminar el producto: ' . $conexion->error . '</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Obtiene el ID del producto de la variable GET
$idProducto = isset($_GET['id']) ? $_GET['id'] : null;

// Crea una instancia de la clase Eliminar y llama al método eliminar
$eliminarProducto = new Eliminar();
$eliminarProducto->eliminar($idProducto);

?>
