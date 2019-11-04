<?php
    $seccion = "";
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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        require("include/metas.php");
    ?>
    <link rel="stylesheet" href="css/index.css">
</head>
    <body>
    <?php if(!empty($_SESSION['usuario'])): ?>
    <?php include("include/headerPL.php");?>
        <div class="dobleBody">
            
    <?php else: ?>
        <?php
            include("include/headerPNL.php");
        ?>
    <?php endif; ?>
        </div>
</body>
</html>