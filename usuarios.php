<?php 
include_once("common.php"); 
include_once("db.php"); 

readfile('header.html');
?>

        <?php echo Menu(); ?>
        
        <h1>Usuarios del sistema</h1>

            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Pass</th>
                </tr>
            </thead>
            <tbody>

        <?php

            $filas=""; // para armar todas las filas de la tabla... 1 por cada registro existente en usuarios
            // Create connection
            $conn = db_open();                    

            // select data
            $sql = "select * from usuarios";
            $result = mysqli_execute_query($conn,$sql);
            if(!$result){
                mostrarError(sprintf("Error al recuperar los datos de usuario %s ", $sql)); 
            } else {
                // pongo los resultados en una tabla
                foreach($result as $row){
                    $filas = $filas . "<tr><th scope='row'>" . $row['id'] . "</th><td>" .  $row['nombre'] . "</td> <td>" . $row['email'] . "</td><td>" . $row['pass'] . "</td></tr>";
                }                
            }

            db_close($conn);

            echo $filas;
            ?>

        </tbody>
        </table>

<?php
readfile('footer.html');
?>