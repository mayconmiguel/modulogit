<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once ("../server/seguranca.php");
mysqli_set_charset($con,"utf8");
$term = $_GET['term'];
if(strlen($term) >= 3){
	$query = "select concat(nome) as label, id, cpf, telefone, celular, nome FROM pessoa where grp_emp_id = '".$_SESSION['imunevacinas']['usuarioEmpresa']."' and (nome like '$term%' or id = '$term')";
}
$myArray = array();
if ($result = $con->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		$myArray[] = $row;
	}

	echo json_encode($myArray);
}

$result->close();
$con->close();

?>