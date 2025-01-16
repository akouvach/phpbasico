<?php 
include_once("common.php"); 
include_once("db.php"); 

readfile('header.html');

if(!isset($_SESSION["id"])){
    // no esta logoneado, lo redirijo
    header("Location: login.php");
}
?>
        <?php echo Menu(); ?>
        <h1>Agenda</h1>

        <form method="post" action="agenda.php" id="buscar_agenda">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="texto" id="texto" class="form-control" placeholder="Buscar algo...">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary" name="accion" id="accion" value="buscar">Buscar</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-secondary" name="accion" id="accion" data-toggle="modal" data-target="#agregarModal" alt="agregar contacto">+</button>
                </div>
            </div>
        </form>
        
        
        <?php
        if (isset($_POST["accion"])){
            
            // Inicializo la variables
            $nombre = "";
            $email = "";
            $telefono = "";
            $fecha_nac = "";
            $ciudad = "";
            $tags = "";
            $visibilidad = "";

            // investigo qué hizo
            $accion = $_POST["accion"];
            
            switch ($accion) {

                case "agregar":

                    // variables para el control de errores
                    $ok = true; // utilizao esta variable para hacer la verificación de valores recibidos
                    $errores = []; // acá voy a poner los sucesivos errores para después mostrarlos

                    // pregunto si tienen cargado algo..
                    if(isset($_POST["nombre"]) && verificaTexto($_POST["nombre"])){
                        $nombre = $_POST["nombre"];            
                    } else {
                        $ok = false;
                        array_push($errores, "El nombres es incorrecto");
                    }

                    if(isset($_POST["email"]) && verificaEmail($_POST["email"])){
                        $email = $_POST["email"];            
                    } else {
                        $ok = false;
                        array_push($errores, "El email es incorrecto");
                    }

                    if(isset($_POST["telefono"]) && verificaTexto($_POST["telefono"])){
                        $telefono = $_POST["telefono"];            
                    } else {
                        $ok = false;
                        array_push($errores, "El telefono es incorrecto");
                    }

                    if(isset($_POST["ciudad"]) && verificaTexto($_POST["ciudad"])){
                        $ciudad = $_POST["ciudad"];            
                    } else {
                        $ok = false;
                        array_push($errores, "La ciudad es incorrecta");
                    }

                    if(isset($_POST["fecha_nac"]) && verificaFecha($_POST["fecha_nac"])){
                        $fecha_nac = date('Y-m-d', strtotime($_POST['fecha_nac']));            
                    } else {
                        $ok = false;
                        array_push($errores, "La fecha de nacimiento es incorrecta");
                    }

                    if(isset($_POST["tags"]) && verificaTexto($_POST["tags"])){
                        $tags = $_POST["tags"];            
                    } else {
                        $ok = false;
                        array_push($errores, "Los tags son incorrectos");
                    }

                    if(isset($_POST["visibilidad"]) && verificaNumero($_POST["visibilidad"])){
                        $visibilidad = $_POST["visibilidad"];            
                    } else {
                        $ok = false;
                        array_push($errores, sprintf("La visibilidad es incorrecta %s", $_POST["visibilidad"]));
                    }


                    if(!$ok){
                        // hubo errores
                        print("<br>Errores:<br>");
                        print_r($errores);
                        print("<br><a href='javascript:history.go(-1);'>Volver</a>");

                    } else {


                        $fecha_act = date("Y-m-d H:i:s");
                        $owner = $_SESSION['id'];

                        // Create connection
                        $conn = db_open();                    

                        // Insert user data
                        $stmt = mysqli_prepare(
                            $conn,
                            "insert into agenda (nombre, emails, telefonos, ciudad, fecha_nac, tags, visibilidad, fecha_act, owner) values (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                        );
                        mysqli_stmt_bind_param($stmt,'ssssssisi',$nombre, $email, $telefono, $ciudad, $fecha_nac, $tags, $visibilidad, $fecha_act, $owner); // el ss significa que tanto el primer como el segundo parametro son strings.
                        if(!mysqli_stmt_execute($stmt)){
                            mostrarError(sprintf("Error al insertar datos %s %s %s", $nombre, $email, $ciudad)); 
                        };

                        db_close($conn);
                        
                    }
                    
                    break;
                    
                case "borrar":

                        // variables para el control de errores
                        $ok = true; // utilizao esta variable para hacer la verificación de valores recibidos
                        $errores = []; // acá voy a poner los sucesivos errores para después mostrarlos
                        $id = 0;
    
                        // pregunto si tienen cargado algo..
                        if(isset($_POST["id"])){
                            $id = $_POST["id"];            
                        } else {
                            $ok = false;
                            array_push($errores, "El id no es correcto");
                        }
    
                        if(!$ok){
                            // hubo errores
                            print("<br>Errores:<br>");
                            print_r($errores);
                            print("<br><a href='javascript:history.go(-1);'>Volver</a>");
    
                        } else {
    
                            $owner = $_SESSION['id'];
                            $params = []; 

                            echo $owner, $id;
    
                            // Create connection
                            $conn = db_open();                    

                            $sql = "delete from agenda where owner = ? and id = ?";
                            array_push($params, $owner, $id); 

                            echo $sql;
                            echo "<br>Owner:" . $owner;
                            echo print_r($params);
                            
                            $result= mysqli_execute_query($conn,$sql,$params);
                            if(!$result){
                                mostrarError(sprintf("Error borrar los registros %s ", $sql)); 
                            } 
   
                            db_close($conn);

                            header("Location: agenda.php");
                            die();                            
                            
                        }
                        
                        break;

                case "buscar":
                        
                    $filas = "";
                    $owner = $_SESSION['id'];
                    $texto = "";
                    if(isset($_POST["texto"]) && $_POST["texto"]!=""){  // si puso algo en buscar, lo filtro....
                        $texto = "%" . $_POST["texto"] . "%";            
                    }

                    $sql = "";
                    $params = [];
                    
                    // Create connection
                    $conn = db_open();         
                    
                    if($texto==""){
                        $sql = "select * from agenda where owner = ? or visibilidad = 2";
                        array_push($params, $owner); 
                    } else {
                        $sql = "select * from agenda where (owner = ? and tags like ?)  or (visibilidad = 2 and tags like ?)";
                        array_push($params, $owner, $texto, $texto); 
                    }
                    echo $sql;
                    echo "<br>Owner:" . $owner;
                    echo print_r($params);
                    
                    $result= mysqli_execute_query($conn,$sql,$params);
                    if(!$result){
                        mostrarError(sprintf("Error al recuperar los datos de usuario %s ", $sql)); 
                    } else {
                        // pongo los resultados en una tabla

?>
                        <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col"> - </th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col">Cumpleaños</th>
                            </tr>
                        </thead>
                        <tbody>

<?php
                        foreach($result as $row){
                            $filas = $filas . "<tr>" . 
                            "<td><form id='". $row["id"] . "' action='agenda.php' method='post'><button type='submit' name='accion' value='borrar'><input type=hidden name='id' value='" . $row['id'] .  "'><i class='material-icons' >delete</i></button></form></td>" . 
                            "<td>" .  $row['nombre'] . "</td> <td>" . $row['emails'] . "</td><td>" . $row['telefonos'] . "</td>" . 
                            "<td>" . $row['tags'] . "</td><td>" . $row['ciudad'] . "</td><td>" . $row['fecha_nac'] . "</td></tr>";
                        }   

                    }
        
                    // Select data

                    db_close($conn);

                    echo $filas;

?>
                    </tbody>
                    </table>                    

<?php
                    break;

                default:
                    echo "Opción inválida";

            }        


        } else {
        ?>

        

<?php
}

?>
        <!-- Modal -->
        <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="agenda.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar contacto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- <label for="nombre">Nombre</label> -->
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <!-- <label for="telefono">Teléfono</label> -->
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                        </div>
                        <div class="form-group">
                            <!-- <label for="fecha_nac">Fecha Nacimiento</label> -->
                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Fecha de nacimiento">
                        </div>
                        <div class="form-group">
                            <!-- <label for="ciudad">Ciudad</label> -->
                            <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad">
                        </div>                        
                        <div class="form-group">
                            <!-- <label for="tags">Tags</label> -->
                            <textarea class="form-control" id="tags" rows="3" name="tags" placeholder="Tags..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="visibilidad">Visibilidad</label>
                            <select class="form-control" id="visibilidad" name="visibilidad">
                                <option value = 1 selected>Privado</option>
                                <option value=2>Publico</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="accion" value="agregar">Confirmar</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
<?php
readfile('footer.html');
?>


