<?php
    $seccion = "Account";
    require("database.php");

    session_start();

    if(isset($_SESSION['usuario'])){
        $sql = "SELECT * FROM user WHERE id=:id";
        $resultado = $conn->prepare($sql);
        $resultado->bindParam(":id", $_SESSION['usuario']);
        $resultado->execute();
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
    }else{
    }

    $direccionIMG = "/proyectos/Login con Datos/perfiles/";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        include("include/metas.php");
    ?>
    <link rel="stylesheet" href="css/account.css">
</head>
<body>
    <?php if(!empty($_SESSION['usuario'])): 
        
        if(isset($_POST['user']) and isset($_POST['correo']) and isset($_POST['clave'])){
        
            if($_FILES['archivo']['type'] == "image/jpeg" or $_FILES['archivo']['type'] == "image/png" or $_FILES['archivo']['type'] == "image/jpg" or $_FILES['archivo']['type'] == "image/gif"){
                $nombreIMG = $_FILES['archivo']['name'];
                $tipo = $_FILES['archivo']['type'];
                $size = $_FILES['archivo']['size'];
                
                $destino = $_SERVER['DOCUMENT_ROOT'].$direccionIMG;
                
    
                move_uploaded_file($_FILES['archivo']['tmp_name'],$destino.$nombreIMG);
    
                $contenidoLN = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
                $nuevoNombre = "";
                for($i = 1; $i<=rand(10,20); $i++){
                    $rand = rand(0,35);
                    $nuevoNombre = $nuevoNombre.$contenidoLN[$rand];
                }
    
                $nuevoNombre = $nuevoNombre.".png";
    
                rename($destino.$nombreIMG,$destino.$nuevoNombre);
    
                $cambio = "perfiles/".$nuevoNombre;
    
            }else{
                $cambio = $fila['img'];
            }
    
            $nombre = htmlspecialchars($_POST['user']);
            $correo = htmlspecialchars($_POST['correo']);
            $clave = htmlspecialchars($_POST['clave']);


            $sqlDos = "UPDATE user SET nombre=:user, correo=:correo, clave=:clave, img=:img WHERE id=:id";
            $consulta = $conn->prepare($sqlDos);
            $consulta->bindParam(":user", $nombre);
            $consulta->bindParam(":correo", $correo);
            $consulta->bindParam(":clave", $clave);
            $consulta->bindParam(":id", $_SESSION['usuario']);
            $consulta->bindParam(":img", $cambio);
            if($consulta->execute()){
                header("Location: account.php");
            }else{
                
            }
        }

        if(isset($_POST['desc'])){

            $change = htmlspecialchars($_POST['desc']);
            $remplazo = str_replace("
","<br>",$change);
            $descripcion = $remplazo;


            $sqlDos = "UPDATE user SET descripcion=:descripcion WHERE id=:id";
            $consulta = $conn->prepare($sqlDos);
            $consulta->bindParam(":id", $_SESSION['usuario']);
            $consulta->bindParam(":descripcion", $descripcion);
            if($consulta->execute()){
                header("Location: account.php");
            }else{
                
            }
        }

    ?>
    <?php include("include/headerPL.php"); ?>
        <div class="dobleBody">
                    <?php
                        if(isset($fila['img'])){
                            $cambio = $fila['img'];
                        }else{
                            $cambio = "img/anonimo.png";
                        }
                    ?>
                
                    <?php
                        echo    "
                        
                        <div class='prf'>
                            <center>
                                <form method='post' enctype='multipart/form-data'>
                                <img src='".$cambio."' style='height:150px; width:150px;'>
                                <h3>Nombre: <br><input class='input' type='text' value='".$fila['nombre']."' name='user'><br>
                                Correo: <br><input class='input' type='email' value='".$fila['correo']."' name='correo'><br>
                                Clave: <br><input class='input' type='password' value='".$fila['clave']."' name='clave'><br>
                                Foto: <br><label><input type='file' name='archivo'>Subir Foto de Perfil</label><br>
                                <button type='submit' class='sendForm'>Cambiar</button>
                                </h3>
                                </form>
                            </center>
                        </div>
                        ";

                ?>
        </div></div>
    <?php else: ?>
        <?php header("Location: ./"); ?>
    <?php endif; ?>
</body>
</html>