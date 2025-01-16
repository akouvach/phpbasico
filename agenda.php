<?php 
include_once("common.php"); 
include_once("db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 

</head>
<body>
    <div class="container">
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

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>