<?php 
include_once("common.php"); 
include_once("db.php"); 
?>
    
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>

    <div class="container">
        <?php echo Menu(); ?>


        <h1>Resultados de la busqueda</h1>

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

            // Cargo distintos valores para realizar la búsqueda
            $valores=[];

            // Defino una clase con cada uno de los items a almacenar
            class Item {
                public $nombre;
                public $tags;
                public $categoria;
                public $link;
                
                public function __construct($nombre, $tags, $categoria, $link) {
                    $this->nombre = $nombre;
                    $this->tags = $tags;
                    $this->categoria = $categoria;
                    $this->link = $link;
                }
            }

            // Datos de ejemplo
            $valores = [
                new Item("nosotros", "descripcion,objetivo,la empresa","Nosotros","/index.php"),
                new Item("registro", "registro,sign up","Administracion","/registrese.php"),
                new Item("login", "ingreso, login","Administracion","/login.php"),
                new Item("usuarios", "usuarios","Administracion","/usuarios.php"),
            ];

            $mytexto="";
            $ok = true; // utilizao esta variable para hacer la verificación de valores recibidos
            $errores = []; // acá voy a poner los sucesivos errores para después mostrarlos

            if(isset($_POST["accion"])){
                $accion = $_POST["accion"];
                if($accion=="buscar"){
                    if(isset($_POST["texto"]) && verificaTexto($_POST["texto"])){
                        $mytexto = $_POST["texto"];            
                    } else {
                        $ok = false;
                        array_push($errores, "El texto de busqueda es incorrecto");
                    }

                    if(!$ok){
                        // hubo errores
                        print("<br>Errores:<br>");
                        print_r($errores);
                        print("<br><a href='javascript:history.go(-1);'>Volver</a>");
                    } else {        
                        
                        echo "<div class='row'><div class='col-3'><h4>Texto buscado:</h4></div><div class='col-8'>" . $mytexto . "</div></div>";

                        $filteredItems = array_filter($valores, function($item) use ($mytexto)  {
                            if($item->categoria == $mytexto){
                                return true;
                            }
                            return false; 
                        });         
                        
                        if(count($filteredItems)==0){
                            echo "<tr>";
                            echo "<td colspan=5>" . "No se encontraron registros" . "</td>";
                            echo "</tr>";

                        } else {

                            foreach ($filteredItems as $item){
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($item->categoria) . "</td>";
                                echo "<td>" . htmlspecialchars($item->nombre) . "</td>";
                                echo "<td>" . htmlspecialchars($item->tags) . "</td>";
                                echo "<td><a href='" . htmlspecialchars($item->link) . "'> --> </a></td>";
                                echo "</tr>";
    
                            }
                        }


                    }

                }
            }
        ?>

            

        </tbody>
        </table>


    </div>

 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>

