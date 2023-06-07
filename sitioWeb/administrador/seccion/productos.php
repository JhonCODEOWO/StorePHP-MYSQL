<?php include("../template/cabecera.php"); ?> <!-- Hace referencia a la cabecera de administrador -->

<?php
$accion = "";
$id = (isset($_POST['txtID']))?$_POST['txtID']:"";
$nombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$descripcion = (isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$precio = (isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$imagen = (isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion = (isset($_POST['accion']))?$_POST['accion']:"";

include("../cofig/bd.php");

switch ($accion) {
    case 'Agregar':
        $sentenciaSQL = $conexion->prepare("INSERT INTO productos(Nombre, Descripcion, Precio, Imagen) VALUES (:Nombre, :Descripcion, :Precio, :Imagen);");

        $fecha = new DateTime();
        $nombreArchivo =($imagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);
        }

        $sentenciaSQL -> bindParam(':Nombre', $nombre);
        $sentenciaSQL -> bindParam(':Descripcion', $descripcion);
        $sentenciaSQL -> bindParam(':Precio', $precio);
        $sentenciaSQL -> bindParam(':Imagen', $nombreArchivo);
        $sentenciaSQL -> execute();

        header("Location:productos.php");
        break;
    

    case 'Modificar':
        // $sentenciaSQL = $conexion -> prepare("UPDATE productos SET Nombre = :Nombre, Descripcion = :Descripcion, Precio = :Precio, Imagen = :Imagen WHERE ID = :ID");
        // $sentenciaSQL -> bindParam(":Nombre", $nombre);
        // $sentenciaSQL -> bindParam(":Descripcion", $descripcion);
        // $sentenciaSQL -> bindParam(":Precio", $precio);
        // $sentenciaSQL -> bindParam(":Imagen", $imagen);
        // $sentenciaSQL -> bindParam(":ID", $id);
        // $sentenciaSQL -> execute();

        if ($imagen !="") {
            
            $fecha = new DateTime();
            $nombreArchivo =($imagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);

            $sentenciaSQL = $conexion -> prepare("SELECT * FROM productos WHERE ID = :ID");
            $sentenciaSQL -> bindParam(":ID", $id);
            $sentenciaSQL -> execute();
            $producto = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

            if (isset($producto["Imagen"]) && $producto["Imagen"] != "imagen.jpg") {
                if (file_exists("../../img/".$producto["Imagen"])) {
                    unlink("../../img/".$producto["Imagen"]);
                }
            }
            
            $sentenciaSQL = $conexion -> prepare("UPDATE productos SET Nombre = :Nombre, Descripcion = :Descripcion, Precio = :Precio, Imagen = :Imagen WHERE ID = :ID");
            $sentenciaSQL -> bindParam(":Nombre", $nombre);
            $sentenciaSQL -> bindParam(":Descripcion", $descripcion);
            $sentenciaSQL -> bindParam(":Precio", $precio);
            $sentenciaSQL -> bindParam(":Imagen", $nombreArchivo);
            $sentenciaSQL -> bindParam(":ID", $id);
            $sentenciaSQL -> execute();

            header("Location:productos.php");
        }else{
            
        }
        break;

    case 'Cancelar':
        echo "Cancelar";
        break;

    case 'Eliminar':
        $sentenciaSQL = $conexion -> prepare("SELECT * FROM productos WHERE ID = :ID");
        $sentenciaSQL -> bindParam(":ID", $id);
        $sentenciaSQL -> execute();
        $producto = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

        if (isset($producto["Imagen"]) && $producto["Imagen"] != "imagen.jpg") {
            if (file_exists("../../img/".$producto["Imagen"])) {
                unlink("../../img/".$producto["Imagen"]);
            }
        }

        $sentenciaSQL = $conexion -> prepare("DELETE FROM productos WHERE ID = :ID");
        $sentenciaSQL -> bindParam(":ID", $id);
        $sentenciaSQL -> execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        header("Location:productos.php");
        break;

    case 'Seleccionar':
        $sentenciaSQL = $conexion -> prepare("SELECT * FROM productos WHERE ID = :ID");
        $sentenciaSQL -> bindParam(":ID", $id);
        $sentenciaSQL -> execute();
        $producto = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

        $nombre = $producto['Nombre'];
        $descripcion = $producto['Descripcion'];
        $precio = $producto['Precio'];
        $imagen = $producto['Imagen'];
        break;
    default:
        # code...
        break;
}

$sentenciaSQL = $conexion -> prepare("SELECT * FROM productos");
$sentenciaSQL -> execute();
$listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-5">
<div class="card">
    <div class="card-header bg-dark">
        <h5 class="text-light">Datos del producto</h5>
    </div>

    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
                <input type="text" value="<?php echo $id;?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
                <input type="text" value="<?php echo $nombre; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre del producto">
            </div>

            <div class = "form-group">
                <input type="text" value="<?php echo $descripcion; ?>" class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Descripción del producto">
            </div>
            
            <div class = "form-group">
                <input type="text" value="<?php echo $precio; ?>" class="form-control" name="txtPrecio" id="txtPrecio" placeholder="Precio para el producto">
            </div>

            <div class = "form-group">
                <?php echo $imagen; ?>
                <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del libro">
            </div>


            <div class="btn-group container-fluid" role="group" aria-label="">
                <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="Cancelar"  class="btn btn-info">Cancelar</button>
            </div>
        </form>
    
    </div>
</div>

    
    
</div>

<div class="col-md-7">
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listaLibros as $libro) { ?>
        
            <tr>
                <td> <?php echo $libro['ID'] ?> </td>
                <td> <?php echo $libro['Nombre'] ?> </td>
                <td> <?php echo $libro['Descripcion'] ?> </td>
                <td> <?php echo $libro['Precio'] ?> </td>
                <td>
                    <img src="../../img/<?php echo $libro['Imagen'];?>" width="100" alt=""> 
                </td>
                <td> 
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['ID'] ?>">
                        <button type="submit" name="accion" value="Eliminar" class="btn btn-danger container-fluid">Eliminar</button>

                        <button type="submit" name="accion" value="Seleccionar" class="btn btn-primary container-fluid mb-2">Seleccionar</button>
                    </form>
                </td>
            </tr>

        <?php }?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?> <!-- Hace referencia al pie de cabecera de administrador -->
