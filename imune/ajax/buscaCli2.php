<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once ("../server/seguranca.php");
mysqli_set_charset($con,"utf8");
$term = $_GET['term'];
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
if(strlen($term) >= 3){
	$query = "select concat(nome,' - PASTA: ',id,' - ANTIGO: ',ficha2,' - CPF: ',cpf) as label, id, cpf, telefone, celular, nome, ficha2 FROM pessoa where cliente = 1 and (nome like '$term%' or id = '$term' or ficha2 = '$term' or cpf = '$term') and grp_emp_id = $empresa";
}
$myArray = array();
if ($result = $con->query($query)) {

	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$myArray[] = $row;
	}

	echo json_encode($myArray);
}

$result->close();
$con->close();

?>