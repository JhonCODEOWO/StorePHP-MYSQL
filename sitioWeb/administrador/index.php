<?php
session_start();
//$nombre = (isset($_POST['usuario']))?$_POST['usuario']:"";
if($_POST){ #Si hay un envio tipo post
    if ($_POST['usuario']=="jhon" && ($_POST['contrasenia']== "sistema")) {
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']= "Jhon";
        header('Location:inicio.php');
    }else{
        $mensaje = "Error: Usuario oncontraseña incorrectos";
    }
     /*Hace la redireccion a esta pagina de inicio.php */
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Iniciar Sesión</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>

            <div class="col-md-4">
                <br/> <br/> <br/> <br/> <br/><br/>
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Inicia Sesión</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($mensaje)) {?>

                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje;?>
                            </div>

                        <?php } ?>
                        <form method="POST"> <!--Envio de datos-->
                            <div class = "form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Escribe tu usuario">
                            
                            </div>

                            <div class="form-group">
                                <label >Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
  </body>
</html>