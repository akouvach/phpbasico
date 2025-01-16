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


        <div class="row">
            <form method="post" action="agenda.php">
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Buscar algo...">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" name="accion" id="accion" value="buscar">Buscar</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-secondary" name="accion" id="accion" value="agregar">+</button>
                </div>
            </form>
        </div>

<?php
readfile('footer.html');
?>