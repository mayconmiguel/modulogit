<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once ("seguranca.php");

$den_id = $_GET['den_id'];
$inicio = $_GET['start']." 00:00:00";
$fim    = $_GET['end']." 23:59:59";

$myArray = array();
mysqli_set_charset($con,"utf8");
$query = "select concat(cli_nome) as title, ficha, ficha2, obs, dt_start as start, dt_end as end, servico , id, cli_id, den_id, status, color, '2' as tipo FROM consulta where dt_start between '".$inicio."' and '".$fim."' and den_id = '$den_id'";

if ($result = $con->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		$myArray[] = $row;
	}
	echo json_encode($myArray);
}

$result->close();
$con->close();

?>