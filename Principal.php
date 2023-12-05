<?php

require_once('Connexio.php');
require_once('Header.php');

class Principal {
    
    public function mostrarProductes() {
        // Crear una instancia de la clase de conexión
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Consulta para obtener la lista de productos
        $consulta = "SELECT p.id, p.nom, p.descripció, p.preu, c.nom as categoria
                     FROM productes p
                     INNER JOIN categories c ON p.categoria_id = c.id";
        $resultado = $conexion->query($consulta);

        // Cabecera HTML con Bootstrap
        echo '<!DOCTYPE html>
              <html lang="es">
              <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Llista de productes</title>
                <!-- Enllaç a Bootstrap des del seu repositori remot -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
              </head>
              <body>
                <div class="container mt-5" style="margin-bottom: 100px">';

        // Verificar si hi ha resultats
        if ($resultado->num_rows > 0) {
            echo '<hr><a href="Nou.php" class="btn btn-primary">Nou producte</a><hr>';
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Descripció</th>
                        <th>Preu</th>
                        <th>Categoria</th>
                        <th colspan="2">Accions</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            $i = 1;
         while ($fila = $resultado->fetch_assoc()) {
             
             echo '<tr>
                     <td>' . $i . '</td>
                     <td>' . 'prod-' . $fila['id'] . '</td>
                     <td>' . $fila['nom'] . '</td>
                     <td>' . $fila['descripció'] . '</td>
                     <td>' . $fila['preu'] . '</td>
                     <td>' . $fila['categoria'] . '</td>
                   
                     <td><a href="Modificar.php?id=' . $fila['id'] . '" class="btn btn-warning">Modificar</a></td>
                     <td><a href="Eliminar.php?id=' . $fila['id'] . '" class="btn btn-danger">Eliminar</a></td>
                   </tr>';
             $i++;
         }
         echo '</tbody>';

            echo '</table>';
        echo '</div>';    
            require_once('Footer.php');
        } else {
            echo '<p>No hi ha productes.</p>';
        }

        

        // Cerrar la conexión
        $conexion->close();
    }
}

// Crear una instancia de la clase y mostrar la lista de productos
$listaProductos = new Principal();
$listaProductos->mostrarProductes();



?>
