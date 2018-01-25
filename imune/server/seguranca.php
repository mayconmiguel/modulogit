<?php


/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site
*
* @author Thiago Belem <contato@thiagobelem.net>
* @link http://thiagobelem.net/
*
* @version 1.0
* @package SistemaSeguranca
*/
date_default_timezone_set('America/Sao_Paulo');



//configurações SMS
//global $_MT;
//$_MT['sms_usuario'] = "vipedent";
//$_MT['sms_telefone'] = "(31) 3392-0518";
//$_MT['sms_empresa'] = "VIP&DENT";
//$_MT['sms_senha'] = "7PAZGZbD";
//$_MT['sms_chave'] = base64_encode($_MT['sms_usuario'].":".$_MT['sms_senha']);
//$_MT['sms_chave'] 	= '&lgn='.$_MT['sms_usuario'].'&pwd='.$_MT['sms_senha'];

$script_tz = date_default_timezone_get();

$pasta = 'imune';

	//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['servidor'] = 'test.miraitech.com.br';    // Servidor MySQL
$_SG['usuario'] = 'miraitech_user';          // Usuário MySQL
$_SG['senha'] = 'Mtech2015';                // Senha MySQL
$_SG['banco'] = 'imunevacinas';            // Banco de dados MySQL

$_SG['paginaLogin'] = './login.php'; // Página de login

// ==============================
mysqli_connect($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);

	// Check connection
	if (mysqli_connect_errno())
  	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}		
	//mysqli_close($con);
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
$_SG['link'] = mysqli_connect($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);
$con = mysqli_connect($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
	@session_start();
}

/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
global $_SG;
global $con;

$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

// Usa a função addslashes para escapar as aspas
$nusuario = addslashes($usuario);
$nsenha = addslashes($senha);

// Monta uma consulta SQL (query) para procurar um usuário
$sql = "SELECT * FROM usuarios where email = '".$nusuario."' and senha = '".$nsenha."' and email != '' and senha != ''  LIMIT 1";
$query = mysqli_query($con,$sql);
$resultado = mysqli_fetch_assoc($query);

// Verifica se encontrou algum registro
if (empty($resultado)) {
// Nenhum registro foi encontrado => o usuário é inválido
return false;

} else {

	// O registro foi encontrado => o usuário é valido
	// Definimos dois valores na sessão com os dados do usuário
	$_SESSION['imunevacinas']['usuarioID'] 		= $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
	$_SESSION['imunevacinas']['usuarioNome'] 	= $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['imunevacinas']['usuarioEmpresa'] = $resultado['grp_emp_id']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['imunevacinas']['usuarioMenus'] 	= $resultado['menus'];


	$selsel = "select * from grupoempresa where id = '".$resultado['grp_emp_id']."'";
	//echo $selsel;
	mysqli_set_charset($con,'utf8');
	$valida = mysqli_query($con,$selsel);
	$row = mysqli_fetch_assoc($valida);
	if(empty($row)){

	}else{
		@$_SESSION['config']['clientes'] = $row['clientes'];
		@$_SESSION['config']['cliente'] = $row['cliente'];
		@$_SESSION['config']['profissional'] = $row['profissional'];
		@$_SESSION['config']['clienteDocumento'] = $row['clienteDocumento'];
		@$_SESSION['config']['funcionario'] = $row['funcionario'];
		@$_SESSION['config']['funcionarios'] = $row['funcionarios'];
		@$_SESSION['config']['sms'] = $row['sms'];


		@$_SESSION['config']['empresa'] = $row['empresa'];

		@$_SESSION['config']['aba2'] = $row['aba2'];
		@$_SESSION['config']['aba2url'] = $row['aba2url'];
		@$_SESSION['config']['aba3'] = $row['aba3'];
		@$_SESSION['config']['aba3url'] = $row['aba3url'];
		@$_SESSION['config']['aba4'] = $row['aba4'];
		@$_SESSION['config']['aba4url'] = $row['aba4url'];



		/*LISTA DE MODALIDADES
         * 1 - ESCOLAS, FACULDADES E UNIVERSIDADES
         * 2 - CLINICAS DENTÁRIAS E MÉDICAS
         * 3 - CORRETORAS DE SEGUROS E PLATAFORMAS
         */
		$_SESSION['config']['modalidade'] = $row['modalidade'];

		$_SESSION['config']['transf_pes_id'] = $row['transf_pes_id'];
		$_SESSION['config']['transf_pag_id'] = $row['transf_pag_id'];
		$_SESSION['config']['transf_cen_id'] = $row['transf_cen_id'];
		$_SESSION['config']['transf_nat_id'] = $row['transf_nat_id'];

		$_SESSION['config']['statusAgenda'] = array(array("id"=>'1',"color"=>'#20202F',"status"=>"Agendada"),array("id"=>'2',"color"=>'#001A66',"status"=>"Confirmada"),array("id"=>'3',"color"=>'#008C23',"status"=>"Comparecida"),array("id"=>'4',"color"=>'#D9A300',"status"=>"Remarcada"),array("id"=>'5',"color"=>'#B20000',"status"=>"Não Comparecida"),array("id"=>'6',"color"=>'orangeRed',"status"=>"Cancelada"),array("id"=>'7',"color"=>'#00B2B2',"status"=>"Encaixada"));

	}

// Verifica a opção se sempre validar o login
if ($_SG['validaSempre'] == true) {
// Definimos dois valores na sessão com os dados do login
$_SESSION['imunevacinas']['usuarioLogin'] 	= $usuario;
$_SESSION['imunevacinas']['usuarioSenha'] 	= $senha;
}


return true;
}
}


/**
* Função que protege uma página
*/
function protegePagina() {
global $_SG;

if (!isset($_SESSION['imunevacinas']['usuarioID']) OR !isset($_SESSION['imunevacinas']['usuarioNome']) OR $_SESSION['imunevacinas']['usuarioID'] == "") {
// Não há usuário logado, manda pra página de login
expulsaVisitante();
} else if (!isset($_SESSION['imunevacinas']['usuarioID']) OR !isset($_SESSION['imunevacinas']['usuarioNome'])) {
// Há usuário logado, verifica se precisa validar o login novamente
if ($_SG['validaSempre'] == true) {
// Verifica se os dados salvos na sessão batem com os dados do banco de dados
if (!validaUsuario($_SESSION['imunevacinas']['usuarioLogin'], $_SESSION['imunevacinas']['usuarioSenha'])) {
// Os dados não batem, manda pra tela de login
expulsaVisitante();
}
}
}
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
global $_SG;
global $pasta;

// Remove as variáveis da sessão (caso elas existam)
unset($_SESSION['imunevacinas']['usuarioID'], $_SESSION['imunevacinas']['usuarioNome'], $_SESSION['imunevacinas']['usuarioLogin'], $_SESSION['imunevacinas']['usuarioSenha'],$_SESSION['imunevacinas']['usuarioFoto']);

// Manda pra tela de login
	?>
	<script> location.replace('<?php echo "http://".$_SERVER['HTTP_HOST']."/".$pasta."/login.php";?>'); </script>
	<?php
}
function auditoria($pes_id,$dt_cad,$modulo,$acao,$obs,$con){
	$query   = "insert into auditoria(pes_id,dt_cad,modulo,acao,obs)values('$pes_id','$dt_cad','$modulo','$acao','$obs')";
	mysqli_query($con,$query);
}


// diretorios

?>
