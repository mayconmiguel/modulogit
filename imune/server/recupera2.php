<?php
    header("Content-Type: text/html; charset=UTF-8",true);
    require_once "seguranca.php";
    $tabela = $_POST['tabela'];

    $myArray = array();

    mysqli_set_charset($con,"utf8");

if ($result = $con->query($tabela)) {

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $myArray[] = $row;
    }
    echo json_encode($myArray);
}

$result->close();
$con->close();
?>