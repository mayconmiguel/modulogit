<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$cpf        = str_replace("/","",str_replace("-","",str_replace(".","",$_POST['cpf'])));
    @$rg         = str_replace(".","",$_POST['rg']);
    @$nasc 		 = substr($_POST['nasc'],6,4)."-".substr($_POST['nasc'],3,2)."-".substr($_POST['nasc'],0,2);
    @$cep        = str_replace("-","",$_POST['cep']);
    @$endereco   = utf8_decode($_POST['endereco']);
    @$numero     = $_POST['numero'];
    @$bairro     = utf8_decode($_POST['bairro']);
    @$cidade     = utf8_decode($_POST['cidade']);
    @$estado     = $_POST['estado'];
    @$telefone   = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace("-","",$_POST['telefone']))));
    @$celular    = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace("-","",$_POST['celular']))));
    @$email      = $_POST['email'];
    @$banco      = utf8_decode($_POST['banco']);
    @$titular    = utf8_decode($_POST['titular']);
    @$agencia    = $_POST['agencia'];
    @$conta      = $_POST['conta'];
    @$razao      = $_POST['razao'];
    @$cnpj       = str_replace("/","",str_replace("-","",str_replace(".","",$_POST['cnpj'])));
    @$especial   = $_POST['especial'];
    @$repasse1   = $_POST['repasse'];
    @$comissao   = $_POST['comissao'];
    @$acesso     = $_POST['acesso'];
    @$obs        = utf8_decode($_POST['obs']);
    @$usuario    = $_POST['usuario'];
    @$senha      = $_POST['senha'];
    @$busca      = $_POST['busca'];
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");
    @$tipo       = $_POST['tipo'];
    @$seguradora = implode(",",$_POST['seguradora']);
    @$menus      = implode(",",$_POST['menus']);
    @$empresa      = implode(",",$_POST['empresa']);
    @$emp_padrao = $_POST['emp_padrao'];
    @$chk_cliente       = $_POST['chk_cliente'];
    @$chk_fornecedor    = $_POST['chk_fornecedor'];
    @$chk_produtor      = $_POST['chk_produtor'];
    $grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];


// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from pessoa where grp_emp_id = $grupoEmpresa and cpf = '$cpf'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into pessoa(grp_emp_id,titular,empresa,emp_padrao,menus,cliente,produtor,fornecedor,seguradora,nome,dt_cad,nasc,rg,cpf,cep,endereco,numero,bairro,cidade,estado,telefone,celular,email,banco,agencia,conta,especial,repasse1,comissao,acesso,obs,usuario,senha,status)values('$grupoEmpresa','$titular','$empresa','$emp_padrao','$menus','$chk_cliente','$chk_produtor','$chk_fornecedor','$seguradora','$nome','$today','$nasc','$rg','$cpf','$cep','$endereco','$numero','$bairro','$cidade','$estado','$telefone','$celular','$email','$banco','$agencia','$conta','$especial','$repasse1','$comissao','$acesso','$obs','$usuario','$senha','$tipo')";
            $valida = mysqli_query($con,$insert);
            //echo $insert;
            if($valida)
            {
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    elseif($funcao == 2)
    {
        $update = "update ignore pessoa set empresa = '$empresa', titular = '$titular', emp_padrao = '$emp_padrao', menus = '$menus', cliente = '$chk_cliente', fornecedor = '$chk_fornecedor', produtor = '$chk_produtor', seguradora = '$seguradora', nome = '$nome', nasc = '$nasc', rg = '$rg', cpf = '$cpf', cep = '$cep', endereco = '$endereco', bairro = '$bairro', cidade = '$cidade', estado = '$estado', telefone = '$telefone', celular = '$celular', email = '$email', banco = '$banco', agencia = '$agencia', conta = '$conta', especial = '$especial', repasse1 = '$repasse1', comissao = '$comissao', acesso = '$acesso', obs = '$obs', usuario = '$usuario', senha = '$senha' where id = '$id'";

        $valida = mysqli_query($con,$update);
        if($valida)
        {
            echo 1;
        }else{
            echo 0;
        }
    }
    elseif($funcao == 3)
    {
        $delete = "delete from pessoa where id = '$id'";
        $valida = mysqli_query($con,$delete);
        if($valida)
        {
           echo 1;
        }
        else
        {
            echo 0;
        }
    };

?>