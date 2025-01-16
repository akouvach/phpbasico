<?php 
include_once("common.php"); 
include_once("db.php"); 

readfile('header.html');
echo Menu();        
?>

<h1>Registro</h1>

<?php
    if (isset($_POST["accion"])){

        // Inicializo la variables
        $email = "";
        $nombre = "";
        $pass = "";
        $pais = "";

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
        
        if(isset($_POST["nombre"]) && verificaTexto($_POST["nombre"])){
            $nombre = $_POST["nombre"];            
        } else {
            $ok = false;
            array_push($errores, "El nombres es incorrecto");
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
            printf("<br><hr><br>nombre: %s, email:%s pais:%s pass:%s",htmlspecialchars($nombre), htmlspecialchars($email), htmlspecialchars($pais), htmlspecialchars($pass));
        } else {
            // sigo procesando
            $accion = $_POST["accion"];
            echo "<br>Accion: " . ": " . htmlspecialchars($accion); // htmlspecialchars se utiliza para que no escriba código malicioso
    
            switch ($accion) {
                case "registrar":

                    // hasheo la password para almacenarla en la base de datos
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                    // Create connection
                    $conn = db_open();                    

                    // Insert user data
                    $stmt = mysqli_prepare(
                        $conn,
                        "insert into usuarios (email, nombre, pass) values (?, ?, ?)"
                    );
                    mysqli_stmt_bind_param($stmt,'sss',$email, $nombre, $hashed_pass); // el ss significa que tanto el primer como el segundo parametro son strings.
                    if(!mysqli_stmt_execute($stmt)){
                        mostrarError(sprintf("Error al insertar datos %s %s %s", $email, $nombre, $pass)); 
                    };

                    db_close($conn);

                    break;
                default:
                    echo "Opción inválida";
            }        
    

        }    


    } else {
?>


        <form action="registro.php" method="post">
            <div class="mb-3">
                Nombre: <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
            <div class="mb-3">
                Email: <input type="email" name="email" id="email" class="form-control">
            </div>
            <!-- <div class="mb-3">
                Pais: <select name="pais" id="pais" class="form-select">
                    <option value="ar">Argentina</option>
                    <option value="py">Paraguay</option>
                    <option value="uy">Uruguay</option>
                </select>
            </div> -->
            <div class="mb-3">
                Contraseña: <input type="password" name="pass" id="pass" class="form-control">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="accion" value="registrar">Registrese</button>
            </div>
    
        </form>

    </div>
    
<?php
}
readfile('footer.html');
?>