<?php

	require ("seguranca.php");
	$id = $_POST['id'];
	$funcao	= $_POST['funcao'];
	$tipo	= $_GET['tipo'];
	$div	= $_POST['div'];


	if($funcao == 1)
	{
		// pega nome do fornecedor
		$fornec	= "select * from produtor where id = '$id'";
		echo $fornec;
		$valida 	= mysqli_query($con,$fornec);
		$resultado  = mysqli_fetch_assoc($valida);
		if (empty($resultado)) {
			// Nenhum registro foi encontrado => o usuário é inválido
			?>
				<script>
					$("#cod").val("").focus().select();
					$("#label").val("");
					alerta("","Fornecedor não encontrado.","warning");
				</script>
			<?php
		}
		else
		{
			if($resultado['razao'] === "" || $resultado['razao'] == null){
				$for_fantasia = $resultado['nome'];
			}else{
				$for_fantasia = $resultado['razao'];
			}
			?>
			<script>
				$("#label").val("<?php echo $for_fantasia;?>");
				//alerta("","Fornecedor encontrado.","system");
			</script>
			<?php
		};
	}
	elseif($funcao ==2)
	{
		// pega nome do CLIENTE
		$clien 	= "select * from produtor where id = '$id' limit 1";
		echo $clien;
		$valida 	= mysqli_query($con,$clien);
		$resultado  = mysqli_fetch_assoc($valida);
		if (empty($resultado)) {
			// Nenhum registro foi encontrado => o usuário é inválido
			?>
				<script>
					$("#cod").val("").focus().select();
					$("#label").val("");
				alerta("","Cliente não encontrado.","warning");
				</script>
			<?php
		}
		else
		{
			$cli_fantasia = $resultado['nome'];
			?>
			<script>
				$("#label").val("<?php echo $cli_fantasia;?>");
				//alerta("","Cliente encontrado.","system");
			</script>
			<?php
		};
	}
	elseif($funcao ==3)
	{
		// pega nome do fornecedor
		$vend 	= "select * from usuarios where us_id = $id and us_vendedor = 1 limit 1";
		$valida 	= mysqli_query($con,$vend);
		$resultado  = mysqli_fetch_assoc($valida);
		if (empty($resultado)) {
			// Nenhum registro foi encontrado => o usuário é inválido
			?>
				<script>
					$("#ct_rc_cod_vend,#cod_vend").val("");
					$("#ct_rc_label_vend,#label_vend").val("");
					setTimeout(function(){
						$("#ct_rc_cod_vend,#cod_vend").focus().select();
					},500);
					
					alerta("","Vendedor não encontrado.","warning");
				</script>
			<?php
		}
		else
		{
			$vend_nome = $resultado['us_nome'];
			?>
			<script>
				$("#ct_rc_label_vend,#label_vend").val("<?php echo $vend_nome;?>");
				//alerta("","Vendedor encontrado.","system");
			</script>
			<?php
		};
	}
	elseif($funcao == 4)
	{
		$produto = "select codbarras.cod_barra as cod_barra, produtos.pro_cod as cod, produtos.pro_desc as descricao, produtos.pro_pr_custo as pr_custo, produtos.pro_pr_varejo as pr_varejo, produtos.pro_pr_atacado as pr_atacado from codbarras inner join produtos where codbarras.cod_produto = produtos.pro_cod and codbarras.cod_barra = '$id' limit 1";
		$valida	= mysqli_query($con,$produto);
		if($row = mysqli_fetch_array($valida))
		{
			$cod 		= $row['cod'];
			$codbarra 	= $row['cod_barra'];
			$descricao	= $row['descricao'];
			$pr_custo	= $row['pr_custo'];
			$pr_varejo	= $row['pr_varejo'];
			$pr_atacado	= $row['pr_atacado'];
			?>
            <script>
				
				$("#pv_cod").val("<?php echo $cod;?>");
				$("#pv_cod_barra").val("<?php echo $codbarra;?>");
				$("#pv_desc").val("<?php echo $descricao;?>");
				$("#pv_quant").val(1);
				$("#valorbruto").val("<?php
									if($tipo == 2)
									{
										echo $pr_custo;
									}
									else
									{
										if ($cliPreco == 1) {echo $pr_varejo;} elseif($cliPreco == 2) {echo $pr_atacado;} elseif(empty($cliPreco) || $cliPreco =="") {echo $pr_varejo;}
									}
									?>");
				$("#valorliquido").val("<?php
									if($tipo == 2)
									{
										echo $pr_custo;
									}
									else
									{
										if ($cliPreco == 1) {echo $pr_varejo;} elseif($cliPreco == 2) {echo $pr_atacado;} elseif(empty($cliPreco) || $cliPreco =="") {echo $pr_varejo;}
									}
									?>");
				$("#inserir,#descper,#descreal,#jurosreal,#jurosper").removeAttr("disabled");
				
			</script>
            <?php
		}
		else
		{
			?>
            <script>
				alerta("","Produto não encontrado!","warning");
				$("#pv_busca").focus().select();
			</script>
            <?php	
		};
	};

mysqli_close ( $con );

?>