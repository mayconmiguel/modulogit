<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    $digital = $_POST['digital'];

    $select = "select biometria from pessoa where status = 1";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){
        $bio = $row['biometria'];
        similar_text(md5($digital), md5($bio), $percent);
        if($percent > 40){
            echo number_format($percent);
        }
    }

?>