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
    $nome       = @$_POST['nome'];
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
    $estado     = @$_POST['estado'];
    $enem       = @$_POST['enem'];
    $nota_enem  = @$_POST['nota_enem'];
    $especial   = @$_POST['especial'];
    $tp_especial= @$_POST['tp_especial'];
    $curso1     = @$_POST['curso1'];
    $curso2     = @$_POST['curso2'];
    $obs        = @$_POST['obs'];
    $origem     = @$_POST['origem'];
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
    if($origem == 1){
        $usuario = $_SESSION['imunevacinas']['usuarioID'];

    }else{
        $usuario = 0;
    }


    $query = "insert ignore into inscricao(nome,email,telefone,celular,cpf,rg,nasc,cep,endereco,numero,complemento,bairro,cidade,estado,enem,nota_enem,especial,tp_especial,curso1,curso2,origem,us_id,grp_emp_id)values('$nome','$email','$telefone','$celular','$cpf','$rg','$nasc','$cep','$endereco','$numero','$complemento','$bairro','$cidade','$estado','$enem','$nota_enem','$especial','$tp_especial','$curso1','$curso2','$origem','".$usuario."','$empresa')";

    if(mysqli_query($con,$query)){
        header('WWW-Authenticate: Basic realm="Bem-vindo"');
        header('HTTP/1.0 200 OK');
        echo 1;
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