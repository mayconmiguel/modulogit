<?php
// Inclui o arquivo com o sistema de segurança
include("seguranca.php");

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario =  $_POST['usuario'];
	$senha   =  sha1($_POST['senha']);

	// Utiliza uma função criada no seguranca.php pra validar os dados digitados
	if (validaUsuario($usuario, $senha) == true) {

		auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),"SISTEMA","LOGIN",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." se conectou ao sistema."),$con);
		
		?>
		<script> location.replace('<?php echo "http://".$_SERVER['HTTP_HOST']."/".$pasta."/index.php";?>'); </script>
		<?php
	}
	else {
		?>
		<script> location.replace('<?php echo "http://".$_SERVER['HTTP_HOST']."/".$pasta."/login.php?error=Usuário ou Senha inválidos!";?>'); </script>
		<?php
	}
}
?>