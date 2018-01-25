<?php

// diretorios

$apikey = 'THMPV-77D6F-94376-8HGKG-VRDRQ';

$apiuser = 'imunevacinas';

$username =
$password =
$mod = NULL;
require_once "seguranca.php";

// Método para mod_php (Apache)
if ( isset( $_SERVER['PHP_AUTH_USER'] ) ):
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $mod = 'PHP_AUTH_USER';

// Método para demais servers
elseif ( isset( $_SERVER['HTTP_AUTHORIZATION'] ) ):

    if ( preg_match( '/^basic/i', $_SERVER['HTTP_AUTHORIZATION'] ) )
        list( $username, $password ) = explode( ':', base64_decode( substr( $_SERVER['HTTP_AUTHORIZATION'], 6 ) ) );

    $mod = 'HTTP_AUTHORIZATION';

endif;



if($username == $apiuser && $password == $apikey){

    $id         = @$_POST['id'];
    $nome       = @$_POST['nome'];
    $cli_id     = @$_POST['cli_id'];
    $email      = @$_POST['email'];
    $telefone   = @str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$_POST['telefone']))));
    $celular    = @str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$_POST['celular']))));
    $cpf        = @str_replace(" ","",str_replace("-","",str_replace(".","",str_replace("/","",$_POST['cpf']))));
    $rg         = @$_POST['rg'];
    $nasc       = @substr($_POST['nasc'],6,4)."-".substr($_POST['nasc'],3,2)."-".substr($_POST['nasc'],0,2);
    $cep        = @str_replace("-","",$_POST['cep']);
    $endereco   = @$_POST['endereco'];
    $numero     = @$_POST['numero'];
    $complemento= @$_POST['complemento'];
    $bairro     = @$_POST['bairro'];
    $cidade     = @$_POST['cidade'];
    $venda      = @$_POST['venda'];
    $estado     = @$_POST['estado'];
    $proc       = @$_POST['procedimentos'];
    $funcao     = @$_POST['funcao'];
    $especial   = @$_POST['especial'];
    $status     = @$_POST['tp_especial'];
    $convenio   = @$_POST['convenio'];
    $dentista   = @$_POST['dentista'];
    $especialidade = @$_POST['especialidade'];
    $obs        = @$_POST['obs'];
    $qual     = @$_POST['qual'];
    $contato     = @$_POST['contato'];
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
    $emp_id  = '2';
    $usuario = $_SESSION['imunevacinas']['usuarioID'];
    $valor   = $_POST['valor'];
    mysqli_set_charset($con,'utf8');

    if($funcao == '1'){
        $query = "insert ignore into orcamento(nome,email,telefone,celular,cpf,rg,nasc,cep,endereco,numero,complemento,bairro,cidade,estado,obs,status,dentista,convenio,especialidade,qual,us_id,grp_emp_id,procedimentos,valor,contato,cli_id)values('$nome','$email','$telefone','$celular','$cpf','$rg','$nasc','$cep','$endereco','$numero','$complemento','$bairro','$cidade','$estado','$obs','$status','$dentista','$convenio','$especialidade','$qual','".$usuario."','$empresa','$proc','$valor','$contato','$cli_id')";


    }else if($funcao == '2'){

    }else if($funcao == '3'){

        $query = "delete from orcamento where id = '$id'";

    }

    if(mysqli_query($con,$query)){
        if(isset($_POST['venda'])){
            $ex_id = mysqli_insert_id($con);
            //criando novo usuário;
            if($cli_id != 0){
                $last = $cli_id;

                //validar se já existe a pasta, se não criar
                $sel = "select id,numero from pasta where pes_id = '$cli_id' and esp_id = '$especialidade' and emp_id = '$emp_id'";
                $val = mysqli_query($con,$sel);
                if(mysqli_num_rows($val) <= 0){
                    $pas = $last.".".$emp_id.".".$especialidade;
                    $pasta_query = "insert into pasta(pes_id,numero,esp_id,emp_id,grp_emp_id)values('$last','$pas','$especialidade','$emp_id','$empresa')";

                    if(mysqli_query($con,$pasta_query)){
                        $pass = mysqli_insert_id($con);
                    }
                }else{
                    $pass = mysqli_fetch_array($val)['id'];
                }

                // inserir os procedimentos e financeiro
                $procedimentos = json_decode($proc,true);
                $tt = 0;
                foreach($procedimentos as $p){
                    $pasta_aux = "insert into pasta_aux(dt_cad,pas_id,pro_id,ben_id,den_id,dente,valor)values('".date('Y-m-d')."','".$pass."','".$p['pro_id']."','".$convenio."','".$dentista."','".$p['dente']."','".$p['valor']."')";

                    mysqli_query($con,$pasta_aux);
                    $dtt = date('Y-m-d H:i:s');
                    $last_pro = mysqli_insert_id($con);
                    $orc_pag = '1';
                    $orc_cen = '1';
                    $orc_nat = '1';
                    $orc_ban = '1';
                    $fin = "insert into financeiro(pag_id,cen_id,nat_id,ban_id,pes_id,emp_id,dt_cad,dt_emi,dt_fat,qtd,parcela,valorbruto,valorliquido,status,grp_emp_id,apo_id,ex_id)values('$orc_pag','$orc_cen','$orc_nat','$orc_ban',$last,$emp_id,'$dtt','$dtt','$dtt','1','1','".$p['valor']."','".$p['valor']."','2',$empresa,'$last_pro','$ex_id')";
                    //echo $fin;
                    mysqli_query($con,$fin);
                    $tt++;
                    if($tt == count($procedimentos)){
                        header('WWW-Authenticate: Basic realm="Bem-vindo"');
                        header('HTTP/1.0 200 OK');
                        echo 1;
                    }
                }

            }else{

                $insert = "insert into pessoa(nome,email,telefone,celular,cpf,rg,nasc,cep,endereco,numero,complemento,bairro,cidade,estado,obs,grp_emp_id)values('$nome','$email','$telefone','$celular','$cpf','$rg','$nasc','$cep','$endereco','$numero','$complemento','$bairro','$cidade','$estado','$obs','$empresa')";

                if(mysqli_query($con,$insert)){
                    $last = mysqli_insert_id($con);
                    if(strlen($cpf) < 11){
                        $cpf = $last;
                        mysqli_query($con,"update pessoa set cpf = '$cpf' where id = $last");
                    }
                    mysqli_query($con,"update orcamento set cli_id = '$last' where id = $ex_id");
                    $pas = $last.".".$emp_id.".".$especialidade;
                    $pasta_query = "insert into pasta(pes_id,numero,esp_id,emp_id,grp_emp_id)values('$last','$pas','$especialidade','$emp_id','$empresa')";

                    if(mysqli_query($con,$pasta_query)){
                        $pass = mysqli_insert_id($con);
                        $procedimentos = json_decode($proc,true);
                        $tt = 0;
                        foreach($procedimentos as $p){
                            $pasta_aux = "insert into pasta_aux(dt_cad,pas_id,pro_id,ben_id,den_id,dente,valor)values('".date('Y-m-d')."','".$pass."','".$p['pro_id']."','".$convenio."','".$dentista."','".$p['dente']."','".$p['valor']."')";

                            mysqli_query($con,$pasta_aux);
                            $dtt = date('Y-m-d H:i:s');
                            $last_pro = mysqli_insert_id($con);
                            $orc_pag = '1';
                            $orc_cen = '1';
                            $orc_nat = '1';
                            $orc_ban = '1';
                            $fin = "insert into financeiro(pag_id,cen_id,nat_id,ban_id,pes_id,emp_id,dt_cad,dt_emi,dt_fat,qtd,parcela,valorbruto,valorliquido,status,grp_emp_id,apo_id,ex_id,ap)values('$orc_pag','$orc_cen','$orc_nat','$orc_ban',$last,$emp_id,'$dtt','$dtt','$dtt','1','1','".$p['valor']."','".$p['valor']."','2',$empresa,'$last_pro','$ex_id','2')";
                            //echo $fin;
                            mysqli_query($con,$fin);
                            $tt++;
                            if($tt == count($procedimentos)){
                                header('WWW-Authenticate: Basic realm="Bem-vindo"');
                                header('HTTP/1.0 200 OK');
                                echo 1;
                            }
                        }
                    }
                }
            };
        }else{

            header('WWW-Authenticate: Basic realm="Bem-vindo"');
            header('HTTP/1.0 200 OK');
            echo 1;
        }
    }else{
        header('HTTP/1.0 401 Unauthorized');
    }

}
else{
    header('WWW-Authenticate: Basic realm="Acesso negado!"');
    header('HTTP/1.0 401 Unauthorized');
    die('Acesso negado.');
}
?>