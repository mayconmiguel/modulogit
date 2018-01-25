<?php
require_once "seguranca.php";

@$id            = $_POST['id'];
@$cli_id        = $_POST['cli_id'];
@$funcao        = $_POST['funcao'];
@$tipo          = $_POST['tipo'];
@$dt_emi        = substr($_POST['dt_emi'],6,4)."-".substr($_POST['dt_emi'],3,2)."-".substr($_POST['dt_emi'],0,2)." ".date('H:i:s');
@$dt_cad        = date('Y-m-d H:i:s');
@$dt_fat        = substr($_POST['dt_fat'],6,4)."-".substr($_POST['dt_fat'],3,2)."-".substr($_POST['dt_fat'],0,2)." ".date('H:i:s');
@$dt_baixa       = substr($_POST['dt_baixa'],6,4)."-".substr($_POST['dt_baixa'],3,2)."-".substr($_POST['dt_baixa'],0,2)." ".date('H:i:s');
@$for_pag       = $_POST['pag_id'];
@$cen_cus       = $_POST['cen_id'];
@$nat_fin       = $_POST['nat_id'];
@$emp_id        = $_POST['emp_id'];
@$apo_id        = $_POST['apo_id'];
@$boleto        = $_POST['boleto'];
@$cheque        = $_POST['cheque'];
@$banco         = $_POST['ban_id'];
@$valorBruto    = $_POST['pr_bruto'];
@$valor         = $_POST['valor'];
@$jurosPer      = $_POST['juros_per'];
@$jurosReal     = $_POST['juros_real'];
@$descPer       = $_POST['desc_per'];
@$descReal      = $_POST['desc_real'];
@$valorLiquido  = $_POST['pr_liquido'];
@$obs           = utf8_decode($_POST['obs']);
@$quant         = $_POST['quant'];
@$cb            = $_POST['cb'];
@$ap            = $_POST['ap'];
@$ex            = $_POST['ex'];
@$type          = $_POST['type'];
@$conciliada    = $_POST['conciliada'];
@$porcentagem   = $_POST['porcentagem'];
@$aglutinado    = $_POST['aglutinado'];
@$i			    = 0;
$grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];

if(!isset($_POST['dt_emi'])){
    $dt_emi = $dt_cad;
}

@$valorBruto = $valorBruto / $quant;
@$valorLiquido = $valorLiquido / $quant;
if($funcao == 1){// funcao = 1, insere financeiro;
    $i = 0;
    while($i < $quant){
        $parcela = $i+1;
        if($i > 0){
            $timestamp = strtotime($dt_fat . "+1 month");
            $dt_fat = date('Y-m-d', $timestamp);
        };

        if(!isset($_POST['dt_baixa'])){
            $dt_baixa = "";
        };


        if(isset($_POST['sp'])){
            $sp = $_POST['sp'];

            if($sp == 2){
                $dt_baixa = $dt_fat;
                $tipo = $tipo + 2;
                $conciliada = 0;
            }else if($sp == 3){
                $dt_baixa = $dt_fat;
                $tipo = $tipo + 2;
                $conciliada = 1;
            }else{
                $dt_baixa = "";
                $tipo = $tipo;
                $conciliada = 0;
            }
        }else{
            $dt_baixa = "";
            $tipo = $tipo;
            $conciliada = 0;
        }

        $query = "insert ignore into financeiro(grp_emp_id,aglutinado,parcela,apo_id,pes_id,dt_cad,dt_emi,dt_fat,dt_baixa,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,obs,status,cb,ex_id,conciliada)values('$grupoEmpresa','$aglutinado',$parcela,'$apo_id','$cli_id','$dt_cad','$dt_emi','$dt_fat','$dt_baixa','$for_pag','$cen_cus','$nat_fin','$banco','$emp_id','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','".$obs."','$tipo','$cb','$ex','$conciliada')";
        if(mysqli_query($con,$query)){
            if($i+1 == $quant){
                echo mysqli_insert_id($con);
                auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"CADASTRAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." cadastrou o titulo: ".mysqli_insert_id(($con))." com sucesso."),$con,$grupoEmpresa);
            }
        }else{
            if($i+1 == $quant){
                echo 0;
            }
        }
        $i++;
    }
}
elseif($funcao == 2){
    if(!isset($_POST['dt_baixa'])){
        $dt_baixa = "";
    }
    $query = "update ignore financeiro set status = $tipo, dt_cad = '$dt_cad', dt_emi = '$dt_emi', dt_fat = '$dt_fat', dt_baixa = '$dt_baixa', emp_id = '$emp_id', cen_id = '$cen_cus',pag_id = '$for_pag', nat_id = '$nat_fin', ban_id = '$banco', boleto = '$boleto', cheque = '$cheque',obs = '$obs' where id = '$id'";
    $valida = mysqli_query($con,$query);
    //echo $query;
    if($valida){
        echo 1;
        auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"ATUALIZAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." atualizou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
    }else{
        echo 0;
    }
}
elseif($funcao == 3){
    $repTipo    = $_POST['repTipo'];
    $select		= "select * from financeiro where id = '$id'";
    $valida =   mysqli_query($con,$select);
    $ult        = mysqli_insert_id($con);
    if($row = mysqli_fetch_array($valida))
    {
        $cli_id			= $row['pes_id'];
        $val_bruto		= $row['valorbruto'];
        $por_juros		= $row['jurosper'];
        $val_juros		= $row['jurosreal'];
        $por_desconto	= $row['descper'];
        $val_desconto	= $row['descreal'];
        $val_liquido  	= $row['valorliquido'];
        $cen_custo		= $row['cen_id'];
        $nat_fin		= $row['nat_id'];
        $ban_id			= $row['ban_id'];
        $qtd            = $row['qtd'];
        $dt_emi         = $row['dt_emi'];
        $dt_fat		    = $row['dt_fat'];
        $tipo_pagamento	= $row['pag_id'];
        $cheque			= $row['cheque'];
        $boleto			= $row['boleto'];
        $obs			= utf8_decode("Titulo Replicado: Titulo de origem > nº:". $id);
        $status         = $row['status'];
        $empresa      	= $row['emp_id'];
    };
    if ($repTipo == 1)
    {
        $timestamp = strtotime($dt_fat . "+7 days");
        $dt_fat = date('Y-m-d', $timestamp);
    }
    elseif ($repTipo == 2)
    {
        $timestamp = strtotime($dt_fat . "+1 month");
        $dt_fat = date('Y-m-d', $timestamp);
    };
    $i = 0;
    while ($i < $quant)
    {
        $query = "insert ignore into financeiro(grp_emp_id,emp_id,qtd,pes_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,cen_id,nat_id,ban_id,dt_emi,dt_cad,dt_fat,pag_id,boleto,cheque,obs,status)values('$grupoEmpresa','$empresa','$qtd','$cli_id','$val_bruto','$por_juros','$val_juros','$por_desconto','$val_desconto','$val_liquido','$cen_custo','$nat_fin','$ban_id','$dt_emi','$dt_cad','$dt_fat','$tipo_pagamento','$cheque','$boleto','$obs : ".($i+1)." de $quant','$status');";
        if($valida =   mysqli_query($con,$query))
        {
            if($i+1 == $quant){
                echo 1;
                auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"REPLICAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." replicou o título: ".mysqli_insert_id(($con))." com sucesso."),$con,$grupoEmpresa);
            }
        }
        else
        {
            if($i+1 == $quant){
                echo 0;
            }
        };
        $i++;
    };
}
elseif($funcao == 4){
    $query = "select * from financeiro where id = '$id'";
    $valida = mysqli_query($con,$query);
    if($row = mysqli_fetch_array($valida)){
        $fin_id     = $row['id'];
        $apo_id     = $row['apo_id'];
        $pes_id     = $row['pes_id'];
        $dt_fat     = $row['dt_fat'];
        $pagamento  = $row['pag_id'];
        $empresa    = $row['emp_id'];
        $ban_id     = $row['ban_id'];
        $cen_id     = $row['cen_id'];
        $nat_id     = $row['nat_id'];
        $pag_id     = $row['pag_id'];
        $qtd        = $row['qtd'];
        $cheque     = $row['cheque'];
        $boleto     = $row['boleto'];
        $valorBruto2 = $row['valorbruto'];
        $descPer    = $row['descper'];
        $descReal   = $row['descreal'];
        $jurosPer   = $row['jurosper'];
        $jurosReal  = $row['jurosreal'];
        $valorConta = $row['valorliquido'];
        $porcentagem = $row['porcentagem'];
    };
    $tipo = $tipo + 2;
    $query = "update ignore financeiro set apo_id = '$apo_id', dt_baixa = '$dt_baixa', pag_id = '$for_pag',  ban_id = '$banco', valorbruto = '$valorBruto', valorliquido = '$valorLiquido',obs = '$obs', status = '$tipo' where id = '$id'";
    if($valorConta == $valorLiquido){
        if(mysqli_query($con,$query)){
            echo $id;
            auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"BAIXAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." baixou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
        }else{
            echo 0;
        }
    }else{
        mysqli_query($con,$query);
        $valorLiquido = $valorConta - $valorLiquido;
        $valorConta = $valorBruto2;
        $valorBruto = $valorConta - $valorBruto;
        $obs = utf8_decode("Titulo gerado através da baixa parcial do título nº: $id");
        $tipo = $tipo - 2;
        $query = "insert ignore into financeiro(grp_emp_id,porcentagem,apo_id,pes_id,dt_cad,dt_emi,dt_fat,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,obs,status)values('$grupoEmpresa','$porcentagem','$apo_id','$pes_id','$dt_cad','$dt_cad','$dt_fat','$pag_id','$cen_id','$nat_id','$ban_id','$empresa','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','$obs','$tipo')";
        if(mysqli_query($con,$query)){
            echo $id;
            auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"BAIXAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." baixou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
        }else{
            echo 0;
        }
    }
}
elseif($funcao == 5){
    $query = "update ignore financeiro set status = ".($tipo - 2)." where id = '$id'";
    if(mysqli_query($con,$query)){
        echo 1;
    }else{
        echo 0;
    }
}
elseif($funcao == 6){
    $dt_ini = substr($_POST['dt_ini'],6,4)."-".substr($_POST['dt_ini'],3,2)."-".substr($_POST['dt_ini'],0,2)." 00:00:00";
    $dt_fim = substr($_POST['dt_fim'],6,4)."-".substr($_POST['dt_fim'],3,2)."-".substr($_POST['dt_fim'],0,2)." 23:59:59";
    $status = $_POST['tipo'];
    $query = "select * from financeiro where dt_fat between '$dt_ini' and '$dt_fim' and status = '$status'";

    $valida = mysqli_query($con,$query);
    $n_linhas = mysqli_num_rows($valida);

    if($n_linhas >= 1){
        while($row = mysqli_fetch_array($valida)){
            $id     = $row['id'];
            $status = $row['status']+2;
            $update = "update ignore financeiro set status = '$status', dt_baixa = '$dt_cad' where id = '$id'";
            if(mysqli_query($con,$update)){
                if($i+1 == $n_linhas){
                    echo 1;
                    auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"BAIXAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." baixou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
                }
            }else{
                if($i+1 == $n_linhas){
                    echo 0;
                }
            };
            $i++;
        }
    }else{
        echo 2;
    }
}
elseif($funcao == 7){
    $titulos = $_POST['titulos'];
    $status = $_POST['tipo']+2;

    foreach($titulos as $id){
        if(isset($_POST['banco'])){
            $banco = $_POST['banco'];
            $update = "update ignore financeiro set ban_id = '$banco', status = '$status', dt_baixa = '$dt_cad' where id = '$id'";
        }else{
            $update = "update ignore financeiro set status = '$status', dt_baixa = dt_fat where id = '$id'";
        }

        if(mysqli_query($con,$update)){
            if($i+1 == count($id)){
                echo 1;
                auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"BAIXAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." baixou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
            }
        }else{
            if($i+1 == count($id)){
                echo 0;
            }
        };
        $i++;
    };
}
elseif($funcao == 8){
    $titulos = $_POST['titulos'];
    $status = $_POST['tipo']-2;
    $id     = implode(",",$titulos);
    $id     = explode(",",$id);
    while($i<count($id)){
        $update = "update ignore financeiro set status = '$status', dt_baixa = '$dt_cad' where id = '$id[$i]'";

        if(mysqli_query($con,$update)){
            if($i+1 == count($id)){
                echo 1;
                auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"CANCELAR BAIXA",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." cancelou a baixa do título: ".$id." com sucesso."),$con,$grupoEmpresa);
            }
        }else{
            if($i+1 == count($id)){
                echo 0;
            }
        };
        $i++;
    };
}
elseif($funcao == 9){// funcao = 1, insere financeiro;
    $query = "insert ignore into financeiro(grp_emp_id,conciliada,ap,apo_id,pes_id,dt_cad,dt_emi,dt_fat,dt_baixa,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,obs,status)values('$grupoEmpresa','$conciliada','$ap','$apo_id','$cli_id','$dt_cad','$dt_emi','$dt_fat','$dt_fat','$for_pag','$cen_cus','$nat_fin','$banco','$emp_id','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','$obs','$tipo')";
    if(mysqli_query($con,$query)){
        echo mysqli_insert_id($con);
    }else{
        echo 0;
    }

}
elseif($funcao == 10){
    $query = "select * from financeiro where id = $id and (apo_id != null or apo_id != '' or apo_id != 0)";
    $valida = mysqli_query($con,$query);
    $n_linhas = mysqli_num_rows($valida);
    if($n_linhas > 0){
        echo 0;
    }else{
        $del = "delete from financeiro where id = $id";
        if(mysqli_query($con,$del)){
            echo 1;
            auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"EXCLUIR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." deletou o título: ".$id." com sucesso."),$con,$grupoEmpresa);
        }
        else{
            echo 0;
        }
    }
}
elseif($funcao == 11){
    if($type == 4){
        $query = "insert ignore into financeiro(grp_emp_id,apo_id,pes_id,dt_cad,dt_emi,dt_fat,dt_baixa,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,obs,status)values('$grupoEmpresa','$apo_id','$cli_id','$dt_cad','$dt_emi','$dt_fat','$dt_baixa','$for_pag','$cen_cus','$nat_fin','$banco','$emp_id','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','$obs','3')";

        if(mysqli_query($con,$query)){
            if($i+1 == $quant){
                echo 1;
            }
        }else{
            if($i+1 == $quant){
                echo 0;
            }
        }
        $i++;
    }else{
        $del = "delete from financeiro where apo_id = '$apo_id' and (apo_id != null or apo_id != '' or apo_id != 0)";
        if(mysqli_query($con,$del)){
            while($i < $quant){
                if($i > 0){
                    $timestamp = strtotime($dt_fat . "+1 month");
                    $dt_fat = date('Y-m-d', $timestamp);
                }
                @$parcela = $i+1;
                $query = "insert ignore into financeiro(grp_emp_id,porcentagem,apo_id,pes_id,dt_cad,dt_emi,dt_fat,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,parcela,obs,status)values('$grupoEmpresa','$porcentagem','$apo_id','$cli_id','$dt_cad','$dt_emi','$dt_fat','$for_pag','$cen_cus','$nat_fin','$banco','$emp_id','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','$parcela','$obs','$tipo')";

                if(mysqli_query($con,$query)){
                    if($i+1 == $quant){
                        echo 1;
                    }
                }else{
                    if($i+1 == $quant){
                        echo 0;
                    }
                }
                $i++;
            }
        }
        else{
            echo 0;
        }
    }
}
elseif($funcao == 12){

    $del = "delete from financeiro where ex_id = '$ex'";
    if(mysqli_query($con,$del)){
        while($i < $quant){
            if($i > 0){
                $timestamp = strtotime($dt_fat . "+1 month");
                $dt_fat = date('Y-m-d', $timestamp);
            }
            if($tipo == 3){
                $situacao = 1;
            }else{
                $situacao = 0;
            }
            $query = "insert ignore into financeiro(grp_emp_id,ex_id,pes_id,dt_cad,dt_emi,dt_fat,dt_baixa,pag_id,cen_id,nat_id,ban_id,emp_id,valorbruto,jurosper,jurosreal,descper,descreal,valorliquido,boleto,cheque,qtd,obs,status,conciliada)values('$grupoEmpresa','$ex','$cli_id','$dt_cad','$dt_emi','$dt_fat','$dt_baixa','$for_pag','$cen_cus','$nat_fin','$banco','$emp_id','$valorBruto','$jurosPer','$jurosReal','$descPer','$descReal','$valorLiquido','$boleto','$cheque','$quant','$obs','$tipo','$conciliada')";
            echo $query;
            if(mysqli_query($con,$query)){
                if($i+1 == $quant){
                    echo 1;
                }
            }else{
                if($i+1 == $quant){
                    echo 0;
                }
            }
            $i++;
        }
    }
    else{
        echo 0;
    }
}
elseif($funcao == 13){
    $titulos = $_POST['titulos'];


    foreach($titulos as $id){
        $select = "select pes_id,ban_id,valorliquido,obs,status from financeiro where id = $id";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            $pr_liquido = $row['valorliquido'];
            $pes_id     = $row['pes_id'];
            $ban_id     = $row['ban_id'];
            $status     = $row['status'];
            $obs        = $row['obs'];
        }
        $update = "update ignore financeiro set conciliada = 1 where id = '$id'";
        if(mysqli_query($con,$update)){
            $sel = "select saldo from banco where id = '$ban_id'";
            $val = mysqli_query($con,$sel);
            if($r = mysqli_fetch_array($val)){
                $saldoanterior = $r['saldo'];
            };



            if($status == 3){
                $obs = "Pagamento: \n\r" . $obs;
                if($pr_liquido < 0){
                    $obs = utf8_decode("Conciliação de Adiantamento de pagamento no valor de $pr_liquido<br> - Será descontato do extrato do banco quando o pagamento real for efetuado: <br>") . $obs;
                    $pr_liquido = 0;
                }
                $saldoatual = $saldoanterior - $pr_liquido;
            }
            else if($status == 4){
                $obs = "Recebimento: \n\r" . $obs;
                $saldoatual = $saldoanterior + $pr_liquido;
            };
            mysqli_query($con,"update ignore banco set saldo = $saldoatual where id = '$ban_id'");
            $extrato = "insert ignore into extratobanco(pes_id,ban_id,valor,obs,status)values('$pes_id','$ban_id','$pr_liquido','$obs','$status')";
            mysqli_query($con,$extrato);

            if($id === end($titulos)){
                echo 1;
                auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"CONCILIAR",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." conciliou o título: ".$id." com sucesso."),$con);
            }
        }else{
            if($id === end($titulos)){
                echo 0;
            }
        };
    }
}
elseif($funcao == 14){
    @$dt_baixa       = substr($_POST['dt_baixa'],6,4)."-".substr($_POST['dt_baixa'],3,2)."-".substr($_POST['dt_baixa'],0,2)." ".date('H:i:s');
    $dt_baixa2       = date('Y-m-d H:i:s',strtotime($dt_baixa.' + 1 day'));
    $valorLiquido = @$_POST['valor'];
    $valorBruto = @$_POST['valor'];
    if($tipo == 1){
        $select = "select * from financeiro where id = ".$id;
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            $ban = $row['ban_id'];
            $emp = $row['emp_id'];
            $dt_bx = $row['dt_baixa'];
            $obs = utf8_decode("Dt. Baixa: ".substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)." ".utf8_encode($row['obs']).". \n\r".$_POST['obs']);
        };

        if($ban != 1){
            $banco = $ban;
            $emp_id = $emp;
        }
        $query = "update ignore financeiro set conciliada = 1, obs= '$obs', emp_id = '$emp_id', ban_id = '$banco', pag_id = '$for_pag', dt_baixa = '".$dt_baixa."', dt_bx = '".$dt_bx."' where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 2){
        $select = "select * from financeiro where id = ".$id;
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            $dt_bx = $row['dt_baixa'];
            $obs = utf8_decode("Dt. Pag: ".substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)." ".utf8_encode($row['obs']).". \n\r".$_POST['obs']);
        };
        $query = "update ignore financeiro set status = 4, obs = '$obs', dt_baixa = '$dt_baixa' where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 3){
        $query = "insert ignore into financeiro(cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,porcentagem,apo_id,grp_emp_id,aglutinado)values('$cheque','$cli_id','$valorBruto','$valorLiquido','$dt_cad','$dt_cad','$dt_cad','$dt_cad','$emp_id','$banco','$for_pag','1','1','1','1','".$obs."','2','2','$porcentagem','$apo_id','$grupoEmpresa','1')";
        if(mysqli_query($con,$query)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
        echo $insert;
    }
    else if($tipo == 4){
        $query = "insert ignore into financeiro(cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,porcentagem,apo_id,ap,grp_emp_id)values('$cheque','$cli_id','$valorBruto','$valorLiquido','$dt_cad','$dt_cad','$dt_baixa','$dt_baixa','$emp_id','$banco','$for_pag','1','1','1','1','".$obs."','0','5','$porcentagem','0','3','$grupoEmpresa')";
        $valorBruto = $valorBruto * (-1);
        $valorLiquido = $valorLiquido * (-1);
        $query2 = "insert ignore into financeiro(cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,porcentagem,apo_id,ap,grp_emp_id)values('$cheque','$cli_id','$valorBruto','$valorLiquido','$dt_cad','$dt_cad','$dt_baixa2','$dt_baixa2','$emp_id','$banco','$for_pag','1','1','1','1','".utf8_decode('Pagamento referente a arredondamento do período anterior.')."','0','4','$porcentagem','0','2','$grupoEmpresa')";
        if(mysqli_query($con,$query) && mysqli_query($con,$query2)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
        echo $query2;
    }
}
elseif($funcao == 15){
    if($tipo == 1){
        $select = "select * from financeiro where id = ".$id;
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            $ban = $row['ban_id'];
            $emp = $row['emp_id'];
        };

        if($ban != 1){
            $banco = $ban;
            $emp_id = $emp;
        }
        $query = "update financeiro set conciliada = 1, emp_id = '$emp_id', ban_id = '$banco', pag_id = '$for_pag' where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 2){
        $query = "delete from financeiro where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 3){
        $query = "insert ignore into financeiro(grp_emp_id,cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,apo_id,porcentagem)values('$grupoEmpresa','$cheque','$cli_id','$valor','$valor','$dt_cad','$dt_cad','$dt_cad','$dt_cad','$emp_id','$banco','$for_pag','1','5','1','1','".$obs."','2','3','$apo_id','$porcentagem')";
        if(mysqli_query($con,$query)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
    }
    else if($tipo == 4){
        $query = "insert ignore into financeiro(grp_emp_id,cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,apo_id,porcentagem)values('$grupoEmpresa','','$cli_id','$valor','$valor','$dt_cad','$dt_cad','$dt_cad','$dt_cad','$emp_id','$banco','$for_pag','1','5','1','1','".$obs."','0','3','$apo_id','$porcentagem')";
        if(mysqli_query($con,$query)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
    }
}
elseif($funcao == 16){
    if($tipo == 1){
        $select = "select * from financeiro where id = ".$id;
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            $ban = $row['ban_id'];
            $emp = $row['emp_id'];
        };

        if($ban != 1){
            $banco = $ban;
            $emp_id = $emp;
        }
        $query = "update financeiro set conciliada = 1, emp_id = '$emp_id', ban_id = '$banco', pag_id = '$for_pag' where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 2){
        $query = "delete from financeiro where id = ".$id;
        mysqli_query($con,$query);
    }else if($tipo == 3){
        $query = "insert ignore into financeiro(grp_emp_id,cheque,pes_id,valorbruto,valorliquido,dt_cad,dt_emi,dt_fat,dt_baixa,emp_id,ban_id,pag_id,cen_id,nat_id,qtd,parcela,obs,conciliada,status,apo_id,porcentagem)values('$grupoEmpresa','$cheque','$cli_id','$valor','$valor','$dt_cad','$dt_cad','$dt_cad','$dt_cad','$emp_id','$banco','$for_pag','1','11','1','1','".$obs."','0','3','$apo_id','$porcentagem')";
        if(mysqli_query($con,$query)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
    }
}
elseif($funcao == 17){
    $titulos = $_POST['titulos'];
    $status = $_POST['tipo']+2;

    foreach($titulos as $id){
        $update = "update ignore financeiro set status = '$status', dt_baixa = '$dt_cad', conciliada = 1 where id = '$id'";

        if(mysqli_query($con,$update)){
            if($i+1 == count($id)){
                echo 1;
            }
        }else{
            if($i+1 == count($id)){
                echo 0;
            }
        };
        $i++;
    };
}
elseif($funcao == 18){
    $aglu_id = @$_POST['aglu_id'];
    $titulos = $_POST['id'];
    $status = $_POST['tipo']+2;
    $update = "update ignore financeiro set aglu_id = '$aglu_id', status = '$status', dt_baixa = '$dt_baixa', conciliada = 0 where id = '$id'";

    if(mysqli_query($con,$update)){
        if($i+1 == count($id)){
            echo 1;
        }
    }else{
        if($i+1 == count($id)){
            echo 0;
        }
    };
}

elseif($funcao == 20){
    $del = "delete from financeiro where id = $id";
    if(mysqli_query($con,$del)){
        echo 1;
    }
    else{
        echo 0;
    }
}
elseif($funcao == 21){
    $titulos = $_POST['titulos'];


    foreach($titulos as $id){
        $query = "select * from financeiro where id = '$id'";

        $valida = mysqli_query($con,$query);
        if($row = mysqli_fetch_array($valida)){
            $fin_id         = $row['id'];
            $empresa        = $row['emp_id'];
            $banco          = $row['ban_id'];
            $centrocusto    = $row['cen_id'];
            $natureza       = $row['nat_id'];
            $qtd            = $row['qtd'];
            $parcela        = $row['parcela'];
            $pagamento      = $row['pag_id'];
            $cheque         = $row['cheque'];
            $valorLiquido   = $row['valorliquido']*(-1);
            $valorBruto     = $row['valorbruto']*(-1);
            $descPer        = $row['descper'];
            $descReal       = $row['descreal'];
            $jurosPer       = $row['jurosper'];
            $jurosReal      = $row['jurosreal'];
            $porcentagem    = $row['porcentagem'];
            $pessoa         = $row['pes_id'];
            $dt_fat         = $row['dt_fat'];

            $dt_emi         = $row['dt_emi'];

            $cb             = $row['cb'];
            $obs            = utf8_decode("Devolução de cheque, Data: ".date('d/m/Y H:i:s'));
        };

        $update = "update financeiro set status = 2, dt_baixa = '', obs = '$obs', aglu_id = 0 where id = '$id'";
        if(mysqli_query($con,$update)){
            $insert = "insert ignore into financeiro(grp_emp_id,emp_id,ban_id,cen_id,nat_id,pag_id,pes_id,qtd,parcela,cheque,valorbruto,descper,descreal,jurosper,jurosreal,valorliquido,porcentagem,cb,dt_emi,dt_cad,dt_fat,dt_baixa,obs,status)values('$grupoEmpresa','$empresa','$banco','$centrocusto','$natureza','$pagamento','$pessoa','$qtd','$parcela','$cheque','$valorBruto','$descPer','$descReal','$jurosPer','$jurosReal','$valorLiquido','$porcentagem','$cb','$dt_emi','$dt_cad','$dt_fat','$dt_cad','$obs','4')";
            mysqli_query($con,$insert);
            if($i+1 == count($id)){
                echo 1;
            }
            auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),utf8_decode("FINANCEIRO"),"DEVOLUÇÃO DE CHEQUE",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." realizou a devolução do cheque : ".$cheque." com sucesso."),$con,$grupoEmpresa);
        }else{
            if($i+1 == count($id)){
                echo 0;
            }
        };
        $i++;
    };
}
elseif($funcao == 22){
    if(!isset($_POST['dt_baixa'])){
        $dt_baixa = "";
    }
    $query = "update ignore financeiro set status = $tipo, dt_cad = '$dt_cad', dt_emi = '$dt_emi', dt_fat = '$dt_fat', dt_baixa = '$dt_baixa', emp_id = '$emp_id', cen_id = '$cen_cus',pag_id = '$for_pag', nat_id = '$nat_fin', ban_id = '$banco', boleto = '$boleto', cheque = '$cheque',obs = '$obs', valorbruto = '$valorBruto', valorliquido = '$valorLiquido', cb='$cb' where id = '$id'";
    $valida = mysqli_query($con,$query);
    //echo $query;
    if($valida){
        echo 1;
    }else{
        echo 0;
    }
}
elseif($funcao == 25){
    if(!isset($_POST['dt_baixa'])){
        $dt_baixa = "";
    }
    $tipo = $tipo -2;
    $query = "select * from financeiro where aglu_id = '".$id."'";
    $valida = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($valida)){
        $update = "update financeiro set status = $tipo where id = '".$row['id']."'";
        mysqli_query($con,$update);
    };
    if(mysqli_query($con,"delete from financeiro where id = '$id'")){
        echo 1;
    }else{
        echo 0;
    }
}

?>
