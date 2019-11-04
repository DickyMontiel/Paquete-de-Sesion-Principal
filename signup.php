<?php
    $seccion = "Register";
    session_start();
    require("database.php");
    if(isset($_POST['nombre']) and isset($_POST['correo']) and isset($_POST['clave'])){
        $rol = 2;
        $nombre = htmlspecialchars($_POST['nombre']);
        $correo = htmlspecialchars($_POST['correo']);
        $clave = htmlspecialchars($_POST['clave']);

        $sql = "INSERT INTO user (nombre, correo, clave) VALUES (:nombre, :correo, :clave)";
        $resultado = $conn->prepare($sql);
        $resultado->bindParam(":nombre", $nombre);
        $resultado->bindParam(":correo", $correo);
        $resultado->bindParam(":clave", $clave);
        
        if($resultado->execute()){
            header("Location: login.php");
        }else{
            echo "";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        include("include/metas.php");
    ?>
    <link rel="stylesheet" href="css/loginandregister.css">
</head>
<body>
    <?php 
        if(!empty($_SESSION['usuario'])): 
        header("Location: ./");
    ?>
        
    <?php else: ?>
    <?php include("include/headerPNL.php"); ?>
        <div class="dobleBody">
            <center>
                <form method="post" style="">
                    <h2>Usuario</h2>
                    <input type="text" name="nombre">
                    <h2>Correo</h2>
                    <input type="email" name="correo">
                    <h2>Contraseña</h2>
                    <input type="password" name="clave">
                    <br><br>
                    <button type="submit">Registrarse</button>
                </form>
            </center>
        </div>
    <?php endif; ?>
</body>
</html>

