<?php 
include_once("common.php"); 
include_once("db.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>



<body>
    <div class="container">
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


    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
</body>


</html>