<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once ("seguranca.php");

$den_id = $_GET['den_id'];
$mes = date('Y-m');
$day = date('w');
$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
if(isset($_GET['inicio'])){
	$inicio = date('Y-m-d H:i:s',@$_GET['Inicio']);
	$fim    = date('Y-m-d H:i:s',@$_GET['Fim']);
}else{
	$inicio = $week_start." 00:00:00";
	$fim	= $week_end." 23:59:59";
}
$myArray = array();
mysqli_set_charset($con,"utf8");
$query = "select concat(cli_nome) as title,tipo, ficha, obs, dt_start as start, dt_end as end, id, cli_id, den_id, status, 'pink' as color, '#000' as textColor  FROM eventos where dt_start between '".$inicio."' and '".$fim."' and den_id = '$den_id' or den_id = '999'";
if ($result = $con->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		$row["editable"] = false;
		$myArray[] = $row;
	}
	echo $json_decode = json_encode($myArray, JSON_HEX_QUOT);
}

$result->close();
$con->close();
function array_insert(&$array, $position, $insert)
{
	if (is_int($position)) {
		array_splice($array, $position, 0, $insert);
	} else {
		$pos   = array_search($position, array_keys($array));
		$array = array_merge(
			array_slice($array, 0, $pos),
			$insert,
			array_slice($array, $pos)
		);
	}
}

?>