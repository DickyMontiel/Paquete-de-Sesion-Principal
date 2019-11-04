<?php
    $seccion = "Login";
    session_start();
    require("database.php");
    if(isset($_POST['correo']) and isset($_POST['clave'])){
        $sql = "SELECT * FROM user WHERE correo=:correo AND clave=:clave";
        $resultado = $conn->prepare($sql);

        $correo = htmlspecialchars($_POST['correo']);
        $clave = htmlspecialchars($_POST['clave']);

        $resultado->bindParam(":correo", $correo);
        $resultado->bindParam(":clave", $clave);
        $resultado->execute();
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);

        $_SESSION['usuario'] = $fila['id'];
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
            <form method="post" style="grid-area:form;">
                <h2>Correo</h2>
                <input type="email" name="correo">
                <h2>Contraseña</h2>
                <input type="password" name="clave">
                <br><br>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </center>
    </div>
    <?php endif; ?>
</body>
</html>