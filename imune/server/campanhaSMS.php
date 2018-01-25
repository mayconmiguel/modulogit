<?php
    header("Content-Type: text/html; charset=UTF-8",true);
    require_once "../server/seguranca.php";
    mysqli_set_charset($con,"utf8");
    $empresa = $_GET['empresa'];
    $funcao  = $_REQUEST['funcao'];


    if($funcao == 1){
        $query = "select * from config_sms where status = 1 and grp_emp_id=$empresa";
        $valida = mysqli_query($con,$query);
        while($row=mysqli_fetch_array($valida)){
            //Lembrete de Falta na consulta
            if($row['tipo'] == 3){
                $query2 = "select  concat(mid(consulta.dt_start,9,2),'/',mid(consulta.dt_start,6,2),'/',mid(consulta.dt_start,1,4),' ',mid(consulta.dt_start,12,5)) as dia, empresa.fantasia as empresa,consulta.cli_nome as cliente, pes2.celular as celular, (select pes.nome from pessoa as pes where pes.id = consulta.den_id limit 1) as dentista from empresa,consulta,pessoa as pes2 where empresa.id = consulta.emp_id and  pes2.id = consulta.cli_id and consulta.dt_start between '".date('Y-m-d H:i:s',strtotime('-1 day'))."' and '".date('Y-m-d H:i:s')."' and consulta.status = 5 and pes2.grp_emp_id =$empresa";
                $val2 = mysqli_query($con,$query2);
                while($rr = mysqli_fetch_array($val2)){
                    $mensagem = $row['msg'];
                    $mensagem = str_replace("[TELEFONE]",$_MT['telefone'],$mensagem);
                    $mensagem = str_replace("[DIA]",$rr['dia'],$mensagem);
                    $mensagem = str_replace("[EMPRESA]",$rr['empresa'],$mensagem);
                    $dentista = @explode(" ",$rr['dentista']);
                    if(count($dentista) > 1){
                        $dentista = $dentista[0]." ".substr($dentista[count($dentista)-1],0,1).".";
                    }else{
                        $dentista = $dentista[0];
                    }
                    enviaSMS($mensagem,$rr['celular'],$_MT['sms_chave']);
                    //echo $mensagem;
                }
            }
            else if($row['tipo'] == 4){
                //Feliz Aniversário
                $query2 = "select grupoempresa.nome as empresa,pessoa.nome,(case when length(pessoa.celular) = 8 then concat('319',pessoa.celular) when length(pessoa.celular) = 9 then concat('31',pessoa.celular) when  length(pessoa.celular) = 10 then concat(mid(celular,1,2),'9',mid(celular,3,8)) ELSE pessoa.celular End) as celular from pessoa,grupoempresa where grupoempresa.id = pessoa.grp_emp_id and length(pessoa.celular) >=8 and pessoa.celular like '%9%' and mid(pessoa.nasc,6,5) = '".date('m-d')."' and pessoa.grp_emp_id = $empresa";
                $val2 = mysqli_query($con,$query2);
                while($rr = mysqli_fetch_array($val2)){
                    $mensagem = $row['msg'];
                    $nome = explode(" ",$rr['nome']);
                    $nome = $nome[0]." ".$nome[count($nome)-1];
                    $mensagem = str_replace("[NOME]",$nome,$mensagem);
                    $mensagem = str_replace("[EMPRESA]",$rr['empresa'],$mensagem);

                    enviaSMS($mensagem,$rr['celular'],$_MT['sms_chave']);
                    //echo $mensagem;
                }
            }
            else if(($row['tipo'] == 5 && date('m-d') == '25-12') || ($row['tipo']== 6 && date('m-d') == '01-01')){
                //Feliz Natal e Ano Novo
                $query2 = "select grupoempresa.nome as empresa,pessoa.nome,(case when length(pessoa.celular) = 8 then concat('319',pessoa.celular) when length(pessoa.celular) = 9 then concat('31',pessoa.celular) when  length(pessoa.celular) = 10 then concat(mid(celular,1,2),'9',mid(celular,3,8)) ELSE pessoa.celular End) as celular from pessoa,grupoempresa where grupoempresa.id = pessoa.grp_emp_id and length(pessoa.celular) >=8 and pessoa.celular like '%9%' and pessoa.grp_emp_id = $empresa";
                $val2 = mysqli_query($con,$query2);
                while($rr = mysqli_fetch_array($val2)){
                    $mensagem = $row['msg'];
                    $nome = explode(" ",$rr['nome']);
                    $nome = $nome[0]." ".$nome[count($nome)-1];
                    $mensagem = str_replace("[NOME]",$nome,$mensagem);
                    $mensagem = str_replace("[EMPRESA]",$rr['empresa'],$mensagem);

                    enviaSMS($mensagem,$rr['celular'],$_MT['sms_chave']);
                    //echo $mensagem;
                }
            }
            else if($row['tipo'] == 7){
                //Lembrete de Consulta
                $query2 = "select concat(mid(consulta.dt_start,9,2),'/',mid(consulta.dt_start,6,2),'/',mid(consulta.dt_start,1,4),' ',mid(consulta.dt_start,12,5)) as dia, empresa.fantasia as empresa,consulta.cli_nome as cliente, pes2.celular as celular, (select pes.nome from pessoa as pes where pes.id = consulta.den_id limit 1) as dentista from empresa,consulta,pessoa as pes2 where empresa.id = consulta.emp_id and  pes2.id = consulta.cli_id and consulta.dt_start between '".date('Y-m-d H:i:s')."' and '".date('Y-m-d H:i:s',strtotime('+1 day'))."' and consulta.status = 1 and pes2.grp_emp_id =$empresa";
                $val2 = mysqli_query($con,$query2);
                while($rr = mysqli_fetch_array($val2)){
                    $mensagem = $row['msg'];
                    $mensagem = str_replace("[TELEFONE]",$_MT['sms_telefone'],$mensagem);
                    $mensagem = str_replace("[DIA]",$rr['dia'],$mensagem);
                    $mensagem = str_replace("[EMPRESA]",$rr['empresa'],$mensagem);
                    $dentista = @explode(" ",$rr['dentista']);
                    if(count($dentista) > 1){
                        $dentista = $dentista[0]." ".substr($dentista[count($dentista)-1],0,1).".";
                    }else{
                        $dentista = $dentista[0];
                    }
                    $mensagem = str_replace("[DENTISTA]",$dentista,$mensagem);
                    enviaSMS($mensagem,$rr['celular'],$_MT['sms_chave']);
                    //echo $mensagem;
                }

            }
        }
    }else if($funcao == 2){

        $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
        $query = "select * from config_sms where tipo <= 2 and status = 1 and grp_emp_id=$empresa";

        $valida = mysqli_query($con,$query);
        while($row = mysqli_fetch_array($valida)){
            if($row['tipo'] == 2){

                $query2 = "select pessoa.nome, agenda.prefixo from pessoa,agenda where pessoa.id = agenda.pes_id and pessoa.id = '".$_POST['prof']."'";
                $val2 = mysqli_query($con,$query2);
                if($rr = mysqli_fetch_array($val2)){
                    $dentista = @explode(" ",$rr['nome']);
                    if(count($dentista) > 1){
                        $dentista = @$rr['prefixo']." ".$dentista[0]." ".substr($dentista[count($dentista)-1],0,1).".";
                    }else{
                        $dentista = @$rr['prefixo']." ".$dentista[0];
                    }
                }

                $mensagem = $row['msg'];

                $nome = explode(" ",$_SESSION['imunevacinas']['usuarioNome']);
                $nome = $nome[0]." ".$nome[count($nome)-1];

                if($_POST['status'] == 1){
                    $status = 'AGENDADA';
                }
                else if($_POST['status'] == 2){
                    $status = 'CONFIRMADA';
                }
                else if($_POST['status'] == 4){
                    $status = 'REMARCADA';
                }
                else if($_POST['status'] == 6){
                    $status = 'CANCELADA';
                }

                $mensagem = str_replace("[TELEFONE]",$_MT['sms_telefone'],$mensagem);
                $mensagem = str_replace("[EMPRESA]",$_MT['sms_empresa'],$mensagem);
                $mensagem = str_replace("[ATENDENTE]",$nome,$mensagem);
                $mensagem = str_replace("[DIA]",$_POST['data'],$mensagem);
                $mensagem = str_replace("[DENTISTA]",$dentista,$mensagem);
                $mensagem = str_replace("[STATUS]",$status,$mensagem);
                $num = $_POST['numero'];

                enviaSMS($mensagem,$num,$_MT['sms_chave']);
            }
        }
    }



function enviaSMS($msg,$numbers,$chave){
    $ch = curl_init();

    if(!isset($_SESSION['imunevacinas'])){
        $config = $_GET['config_sms'];
    }else{
        $config = $_SESSION['config']['sms'];
    }



    if($config == 2){
        $msg  = urlencode(utf8_encode($_POST['msg']));
        curl_setopt($ch, CURLOPT_URL, 'http://marketing.allcancesms.com.br/app/modulo/api/index.php?action=sendsms'.$chave.'&msg='.$msg.'&numbers='.$numbers);
    }else if($config == 1){

        $numbers = "55".$numbers;

        curl_setopt($ch, CURLOPT_URL, 'http://api.allcancesms.com.br/sms/1/text/single');

        $request_headers = array();
        $request_headers[] = "Authorization: Basic ".$chave;
        $request_headers[] = "Content-Type: application/json" ;
        $request_headers[] = "Accept: application/json";

        curl_setopt($ch, CURLOPT_POST, 1);

        $data = json_encode(array(
            'from' => $_SESSION['usuarioID']."-".$_SESSION['usuarioNome'],
            'to' => $numbers,
            'text' => $msg,
            'flash' => true
        ));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    }

    $head = curl_exec($ch);
    curl_close($ch);
    return $head;




}

?>

