<?php 
include_once("common.php"); 
include_once("db.php"); 

readfile('header.html');
?>
    
    <?php echo Menu(); ?>
        <div class = "row">
            <div class="col-2"></div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block img-fluid" src="images/uno.png" alt="Gestioná tus contactos">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/dos.png" alt="Actualizá tus contactos">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/tres.png" alt="Compartí y creá comunidad">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="col-2"></div>
        </div>

<?php
readfile('footer.html');
?>


