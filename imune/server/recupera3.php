<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once "seguranca.php";

$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
if($_REQUEST['tabela'] == 1){
    $tabela = "select id as value, razao as text from empresa where tipo = 1";
    tabela($con,$tabela);
}else if($_REQUEST['tabela'] == 2){
    $tabela = "select id as value, concat(cod,'-',banco) as text from banco";
    tabela($con,$tabela);
}else if($_REQUEST['tabela'] == 3){
    $tabela = "select id as value, nome as text from pagamento";
    tabela($con,$tabela);
}else if($_REQUEST['tabela'] == 4){
    $tabela = "select id as value, nome as text from centrocusto";
    tabela($con,$tabela);
}else if($_REQUEST['tabela'] == 5){
    $tabela = "select pessoa.id as value, pessoa.nome as text from pessoa,agenda where pessoa.id = agenda.pes_id and agenda.grp_emp_id = ".$empresa;
}
else if($_REQUEST['tabela'] == 6){
    $tabela = "select id, nome, msg, status from config_sms where grp_emp_id = ".$empresa;
}
$myArray = array();
mysqli_set_charset($con,"utf8");
if ($result = $con->query($tabela)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $myArray[] = $row;
    }
    echo json_encode($myArray);
}



$result->close();
$con->close();
?>