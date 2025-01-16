<?php
ini_set('session.gc_maxlifetime',1800);

session_start(); // para el manejo de sesiones que me permite almacenar valores entre llamados.
if(isset($_SESSION['last_activity']) && ( time()-$_SESSION['last_activity'] > 1800 )){
    session_unset();
    session_destroy();
}

$_SESSION['last_activity'] = time();

function Menu(){

    $lineas="";
    $logueado = false;
    if(isset($_SESSION["id"]) && $_SESSION["id"]>0){
        // esta logoneado
        $logueado=true;
    }

    if($logueado){
        // echo "esta logueado";
        $lineas = $lineas . "<li class='nav-item'><a class='nav-link' href='/agenda.php'>Agenda</a></li>";
        $lineas = $lineas . "<li class='nav-item'><a class='nav-link' href='/cerrar.php'>Salir</a></li>";
    } else {
        $lineas = $lineas . "<li class='nav-item'><a class='nav-link' href='/login.php'>Ingresar</a></li>";
        $lineas = $lineas . "<li class='nav-item'><a class='nav-link' href='/registro.php'>Registarse</a></li>";
    }

    $rdo = <<<EOD
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="/index.php"><img src="./images/agenda.jpg" width="80"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                $lineas
            </ul>
            <form class="form-inline my-2 my-lg-0" method="post" action="buscar.php" onsubmit="return validarBuscar(event);">
              <input class="form-control mr-sm-2" type="search" placeholder="Buscar" name="texto" id="texto">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="accion_buscar" id="accion_buscar" value="buscar">Buscar</button>
            </form>
          </div>
        </nav>    
    </div>
    EOD;
    return $rdo;
}

function mostrarError($mensaje){
    echo Menu(). "<div class='container'><div><h3>Error:</h3><hr><p>" . $mensaje . "</p><br><button>volver</button> </div> </div>";
}

function verificaEmail($myemail){
    if($myemail==""){
        return false;
    }
    // Regular expression for basic email validation
    $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; 
    return preg_match($regex, $myemail) === 1; 
}

function verificaTexto($mytexto){
    if($mytexto==""){
        return false;
    }
    return true;
}

function verificaPass($mypass){
    if($mypass==""){
        return false;
    }
    return true;
}

function verificaFecha($myfecha){
    if($myfecha==""){
        return false;
    }
    return true;
}

function verificaNumero($mynumero){
    if($mynumero==0){
        return false;
    }
    return true;
}

function verificaArray($myarray){
    if(!is_array($myarray)){
        return false;
    }
    return true;
}


?>
<!-- 
<li class="nav-item active">
                <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
              </li> -->
