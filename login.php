<?php 
include_once("common.php"); 
include_once("db.php"); 

readfile('header.html');
echo Menu(); 
?>

    <h1>Ingrese</h1>

<?php    

    if (isset($_POST["accion"])){


        // Inicializo la variables
        $email = "";
        $pass = "";

        // variables para el control de errores
        $ok = true; // utilizao esta variable para hacer la verificación de valores recibidos
        $errores = []; // acá voy a poner los sucesivos errores para después mostrarlos

        // pregunto si tienen cargado algo..
        if(isset($_POST["email"]) && verificaEmail($_POST["email"])){
            $email = $_POST["email"];            
        } else {
            $ok = false;
            array_push($errores, "El email es incorrecto");
        }
        
        if(isset($_POST["pass"]) && verificaPass($_POST["pass"])){
            $pass = $_POST["pass"];            
        } else {
            $ok = false;
            array_push($errores, "La contraseña es incorrecta");
        }

        
        if(!$ok){
            // hubo errores
            print("<br>Errores:<br>");
            print_r($errores);
            print("<br><a href='javascript:history.go(-1);'>Volver</a>");
            printf("<br><hr><br> email:%s  pass:%s", htmlspecialchars($email), htmlspecialchars($pass));
        } else {
            // sigo procesando
            $accion = $_POST["accion"];
            echo "<br>Accion: " . ": " . htmlspecialchars($accion); // htmlspecialchars se utiliza para que no escriba código malicioso
    
            switch ($accion) {
                case "ingresar":

                    // hasheo la password para compararla con la que hay en la base de datos
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                    $params = [];

                    // Create connection
                    $conn = db_open();                    

                    // select data
                    $sql = "select * from usuarios where email = ?";
                    array_push($params, $email);
                    $result = mysqli_execute_query($conn,$sql, $params);
                    if(!$result){
                        mostrarError(sprintf("Error al recuperar los datos de usuario %s ", $sql)); 
                    } else {
                        // pongo los resultados en una tabla
                        foreach ($result as $row) {
                            // Verificar la password 
                            if (password_verify($pass, $row["pass"])) {
                                echo "Login successful!";
                                $_SESSION['id'] = $row["id"]; // el usuario logueado
                                $_SESSION['is_admin'] = $row["is_admin"]; // si el usuario es administrador
                                $_SESSION['nombre'] = $row["nombre"]; // si el usuario es administrador
                                // redirijo a la pagina inicial y termino de procesar esta
                                header("Location: agenda.php");
                                die();

                            } else {
                                echo "usuario/contraseña inválida";
                            }

                        }

                    }                        

                    db_close($conn);

                    break;
                default:
                    echo "Opción inválida";
            }        
    

        }    


    } else {
?>

    

        <form method="post" action="login.php">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailDesc" placeholder="ingrese su email">
            </div>
            <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña">
            </div>
            <div class="form-check">
                <button type="submit" class="btn btn-primary" name="accion" id="accion" value="ingresar">Ingrese</button>
            </div>
        </form>

<?php
    }
readfile('footer.html');
?>

