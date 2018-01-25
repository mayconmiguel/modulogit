<?php
require_once "../server/seguranca.php";
header("Content-Type: text/html; charset=UTF-8",true);
mysqli_set_charset($con,"utf8");


$array['data'] = array();

$query = "select consulta.den_id,consulta.cli_id,consulta.obs,consulta.id,consulta.dt_start, pessoa.celular, pessoa.telefone,pessoa.ult_lig, consulta.motivo, pessoa.nome as cliente, (select pes2.nome from pessoa as pes2 where pes2.id = consulta.den_id limit 1) as dentista, consulta.status,consulta.color from pessoa,consulta where pessoa.id = consulta.cli_id and  pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa'];
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    $query .= " and (consulta.cli_id = '".$_GET['busca']."' or consulta.dt_start like '$redata%' or pessoa.nome like '".$_GET['busca']."%' or (select pes2.nome from pessoa as pes2 where pes2.id = consulta.den_id limit 1) like '$busca%')";
}else{
    $query .= " and consulta.dt_start between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59',strtotime('+1 day'))."'";
}


$valida = mysqli_query($con,$query);
while($row=mysqli_fetch_array($valida)){
    if($row['status'] == 1){
        $status = "<label class='label bg-color-blueDark' id='status'>1 - AGENDADO(A)</label>";
    }
    else if($row['status'] == 2){
        $status = "<label class='label label-primary' id='status'>2 - CONFIRMADO(A)</label>";
    }
    else if($row['status'] == 3){
        $status = "<label class='label bg-color-green' id='status'>3 - COMPARECIDO(A)</label>";
    }
    else if($row['status'] == 4){
        $status = "<label class='label label-warning' id='status'>4 - REMARCADO(A)</label>";
    }
    else if($row['status'] == 5){
        $status = "<label class='label label-danger' id='status'>5 - NÃO COMPARECIDO(A)</label>";
    }
    else if($row['status'] == 6){
        $status = "<label class='label bg-color-redLight' id='status'>6 - CANCELADO(A)</label>";
    }
    else if($row['status'] == 7){
        $status = "<label class='label bg-color-blueLight' id='status'>7 - ENCAIXADO(A)</label>";
    }

    $dt_start = substr($row['dt_start'],8,2)."/".substr($row['dt_start'],5,2)."/".substr($row['dt_start'],0,4);
    $hora     = substr($row['dt_start'],11,5);


    $motivo		= $row['motivo'];
    if($motivo != "" || $motivo != null){
        if($motivo == 0){
            $mt = "NÃO INFORMADO";
        }elseif($motivo == 1){
            $mt = "CONTATO REALIZADO COM SUCESSO";
        }elseif($motivo == 2){
            $mt = "RETORNAR LIGAÇÃO MAIS TARDE";
        }elseif($motivo == 3){
            $mt = "CAIXA POSTAL";
        }elseif($motivo == 4){
            $mt = "TELEFONE OCULPADO";
        }elseif($motivo == 5){
            $mt = "FORA DE AREA OU DESLIGADO";
        }elseif($motivo == 6){
            $mt = "NÚMERO DE TELEFONE NÃO EXISTE";
        }elseif($motivo == 7){
            $mt = "ENGANO / NÚMERO ERRADO";
        }
    }else{
        $mt = "NÃO INFORMADO";
    }
    $ult_lig 	= $row['ult_lig'];
    if($ult_lig == "0000-00-00"){
        $ult_lig = "NUNCA";
    }else{
        $ult_lig = substr($ult_lig,8,2)."/".substr($ult_lig,5,2)."/".substr($ult_lig,0,4);
    };


    array_push($array['data'],array(
        "color"=>$row['color'],
        "telefone"=>$row['telefone'],
        "celular"=>$row['celular'],
        "motivo"=>$mt,
        "mot"=>$motivo,
        "obs"=>$row['obs'],
        "id"=>$row['id'],
        "cli_id"=>$row['cli_id'],
        "profissional"=>$row['dentista'],
        "pro_id"=>$row['den_id'],
        "dt_start"=>"$dt_start",
        "hora"=>$hora,
        "cliente"=>$row['cliente'],
        "ult_lig"=>$ult_lig,
        "status"=>$status,
        "st"=>$row['status']
    ));
}


echo json_encode($array);
?>

