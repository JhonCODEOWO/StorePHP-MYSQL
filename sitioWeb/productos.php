<?php include("template/cabecera.php");?> <!--Jala o incluye el diseño de cabecera principal-->
<!--Lo unico que cambia es el contenedor-->

<?php include("administrador/cofig/bd.php");
$sentenciaSQL = $conexion -> prepare("SELECT * FROM productos");
$sentenciaSQL -> execute();
$listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($listaLibros as $libro) { ?>
<div class="col-md-3">
    <div class="card bg-dark rounded" style="color:white">
        <img class="card-img-top" src="img/<?php echo $libro['Imagen']; ?>" alt="">
            <div class="card-body">
                <h3 class="card-title"><?php echo $libro['Nombre']; ?></h3>
                <p class="card-text"><?php echo $libro['Descripcion'] ?></p>
                <h5><?php echo "$".$libro['Precio']; ?></h5>
                <button type="button" class="btn btn-secondary container-fluid">Comprar</button>
            </div>
    </div>
</div>
<?php } ?>

<?php include("template/pie.php");?><!--Jala el diseño de pie de pagina-->
