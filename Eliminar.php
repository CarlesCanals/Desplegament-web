<?php

require_once('Connexio.php');


class Eliminar {
    
    public function eliminar($id) {
        // 
        if (!isset($id) || !is_numeric($id)) {
            echo '<p>ID de producto no válido.</p>';
            return;
        }

        // 
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // 
        $id = $conexion->real_escape_string($id);

        // 
        $consulta = "DELETE FROM productes WHERE id = '$id'";

        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            echo '<p>Error al eliminar el producto: ' . $conexion->error . '</p>';
        }

        // 
        $conexion->close();
    }
}

// 
$idProducto = isset($_GET['id']) ? $_GET['id'] : null;

// 
$eliminarProducto = new Eliminar();
$eliminarProducto->eliminar($idProducto);

?>
