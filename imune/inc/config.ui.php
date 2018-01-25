<?php

require_once "./server/seguranca.php";


//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");


/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_blank",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/
//DASHBOARD
$page_nav = array(
	"dashboard" => array(
		"title" => "Dashboard",
		"icon" => "fa-dashboard",
		"url" => "ajax/dashboard.php"
	)
);
//SUBMENUS - INICIO
/*$subCadastro = array(
	"centrocusto" => array(
		"title" => "Centro de Custo",
		"url" => 'ajax/centrocusto.php'
	)
);

$subCadastro += array(
	"banco" => array(
		"title" => "Contas Bancárias",
		"url" => 'ajax/banco.php'
	)
);*/
$subCadastro = array(
	"empresas" => array(
		"title" => $_SESSION['config']['empresa'],
		"url" => "ajax/empresa.php"
	)
);
/*$subCadastro += array(
	'pagamento' => array(
		'title' => 'Formas de Pagamento',
		'url' => 'ajax/pagamento.php'
	)
);*/
$subCadastro += array(
	'fornecedor' => array(
	'title' => 'Fornecedores',
	'url' => 'ajax/produtor.php?type=2'
));
$subCadastro += array(
	'funcionarios' => array(
		'title' => $_SESSION['config']['funcionarios'],
		'url' => 'ajax/produtor.php?type=1'
	)
);
/*$subCadastro += array(
	'contas' => array(
	'title' => 'Natureza Financeira',
	'url' => 'ajax/natureza.php'
));*/
$subCadastro += array(
	'vacinas' => array(
	'title' => 'Vacinas',
	'url' => 'ajax/vacinas.php'
));
$subCadastro += array(
	'Medico' => array(
	'title' => 'Medico',
	'url' => 'ajax/medico.php'
));
$subCadastro += array(
	'Transferencia' => array(
	'title' => 'Transferencia',
	'url' => 'ajax/transferencia.php'
));






//$subCadastro += array();


/*if($_SESSION['config']['modalidade'] == 1){
	$subCadastro += array(
		'convenios' => array(
			'title' => 'Convênios',
			'url' => 'ajax/convenio.php'
		)
	);

	$subCadastro += array(
		"cursos" => array(
			"title" => "Cursos",
			"url" => 'ajax/curso.php'
		)
	);

	$subCadastro += array(
		"disciplinas" => array(
			"title" => "Disciplinas",
			"url" => 'ajax/disciplina.php'
		)
	);


	$subCadastro += array(
		'modalidades' => array(
			'title' => 'Modalidades',
			'url' => 'ajax/modalidade.php'
		)
	);
}
else if($_SESSION['config']['modalidade'] == 2) {
	$subCadastro += array(
		'especialidade' => array(
			'title' => 'Especialidades',
			'url' => 'ajax/especialidade.php'
		),
		'procedimento' => array(
			'title' => 'Procedimentos',
			'url' => 'ajax/procedimento.php'
		),
		/*'beneficios' => array(
			'title' => 'Clube de Benefícios',
			'url' => 'ajax/beneficio.php'
		),
		'novaagenda' => array(
			'title' => 'Abertura de Agenda',
			'url' => 'ajax/novaAgenda.php'
		)
	);
}
else if($_SESSION['config']['modalidade'] == 3){

}
//consercionária sem financeiro
else if($_SESSION['config']['modalidade'] == 5){
	$subCadastro = array(
		'acessorios' => array(
			'title' => 'Acessórios',
			'url' => 'ajax/acessorios.php'
		),
		'cores' => array(
			'title' => 'Cores',
			'url' => 'ajax/cores.php'
		),
		'marca' => array(
			'title' => 'Marca',
			'url' => 'ajax/marca.php'
		),
		'modelo' => array(
			'title' => 'Modelo',
			'url' => 'ajax/modelo.php'
		),
		'veiculos' => array(
			'title' => 'Veículos',
			'url' => 'ajax/veiculos.php'
		)
	);
}*/

$subCadastro += array(
	'usuarios' => array(
		'title' => 'Usuários do sistema',
		'url' => 'ajax/usuario.php'
	));







$subFinanceiro = array(
	"centraldecontas" => array(
		"title" => "Central de Contas",
		"url" => "ajax/centraldecontas.php"
	)
);
$subAtendimento = array(
	"Medico" => array(
		"title" => "Medico/Indicão",
		"url" => "ajax/medico.php"
	),"Vacina" => array(
		"title" => "Vacinas",
		"url" => "ajax/vacinas.php"
	),
);

$subRel = array(
	"financeiro" => array(
		"title" => "Relatorios",
		"sub" => array(
			"relfinanceiro" => array(
				"title" => "Central de Contas",
				"url" => "rel/financeiro.php"
			),
			"extratoBanco" => array(
				"title" => "Extrato Bancário",
				"url" => "rel/extratoBanco.php"
			),
            "relVendas" => array(
                "title" => "Vendas por Unidade",
                "url" => "rel/relVendas.php"
            ),
            "relEstoque" => array(
                "title" => "Estoque com Vencimentos",
                "url" => "rel/relEstoque.php"
            ),
            "relretornoCliente" => array(
                "title" => "Retorno Clientes",
                "url" => "rel/relretornoCliente.php"
            ),
            "relvacinas" => array(
                "title" => "Vacinas por Periodo",
                "url" => "rel/relVacinas.php"
            ),
                "relHistorico" => array(
                "title" => "Historico Vacinação",
                "url" => "rel/relHistorico.php"
            ),

		)
	)
);
// SUBMENUS - FIM



$cadastro = array(
	"id" => "1",
	"title" => "Cadastros",
	"icon" => "fa-pencil",
	"sub" => $subCadastro
);
$cliente = array(
	"id" => "2",
	"title" => $_SESSION['config']['cliente'],
	"icon"  => "fa-users",
	"url" => 'ajax/cliente.php'
);
$Atendimento = array(
    "id" => "1",
    "title" => "Atendimento",
    "icon" => "fa-pencil",
    "sub" => $subAtendimento
);
$financeiro = array(
	"id" => "3",
	"title" => "Financeiro",
	"icon" => "fa-money",
	"sub" => $subFinanceiro
);


$agenda = array(
	"id" => "6",
	'title' => 'Agenda',
	'icon' => 'fa-calendar',
	"url" => "ajax/agenda.php"
);

//modalidade seguradora
$importacao = array(
	'id'	=>'7',
	"title" => "Importações",
	"icon" => "fa-download",
	"sub" => array(
		"propostas" => array(
			"title" => "Propostas / Apólices",
			"url" => "ajax/impPropostas.php"
		)
	)
);
$seguradora = array(
	'id'	=>'8',
	'title' => 'Seguradoras',
	'icon' => 'fa-car',
	'url' => 'ajax/seguradora.php'
);



//MODALIDADE 1
$inscricoes = array(
	"id" => "9",
	"title" => "Inscrições",
	"icon" => "fa-graduation-cap",
	"url" => "ajax/gridInscricoes.php"
);
$solicitacoes = array(
	"id" => "10",
	"title" => "Solicitações",
	"icon" => "fa-life-ring ",
	"url" => "ajax/gridSolicitacoes.php"
);
//FIM

//MODALIDADE 5
$banner = array(
	"id" => "9",
	"title" => "Banner",
	"icon" => "fa-picture-o",
	"url" => "ajax/banner.php"
);

$callcenter = array("id" => "80",
	"title" => "CallCenter",
	"icon" => "fa-headphones ",
	"url" => "ajax/callcenter.php"

);

$orcamento = array("id" => "81",
	"title" => "Orçamento",
	"icon" => "fa-paperclip ",
	"url" => "ajax/gridOrcamento.php"

);

/*$sms = array(
	"id" => "90",
	"title" => "SMS",
	"icon" => "fa-envelope",
	"url" => "ajax/centralSMS.php",
	"label_htm" => '<span class="badge bg-color-blueDark bounceIn animated pull-right inbox-badge margin-right-5" id="nav_saldo_sms"></span>'
);*/

$relatorios = array(
	"id" => "99",
	'title' => 'Relatórios',
	'icon' => 'fa-file-text',
	"sub" => $subRel
);



$auditoria = array(
	"id" => "100",
	'title' => 'Auditoria',
	'icon' => 'fa-eye',
	"url" => "rel/auditoria.php"
);



@$usuarioMenu = explode(',',$_SESSION['imunevacinas']['usuarioMenus']);


$li = array($cadastro,$cliente);
$li = array($cadastro,$cliente,/*$financeiro,*/$relatorios,/*$auditoria*/);
if($_SESSION['config']['modalidade'] == 1){
	array_push($li,$inscricoes);
	array_push($li,$solicitacoes);
	//array_push($li,$sms);
}
else if($_SESSION['config']['modalidade'] == 2){
	//array_push($li,$agenda);
	//array_push($li,$callcenter);
	//array_push($li,$orcamento);
	//array_push($li,$sms);
}
else if($_SESSION['config']['modalidade'] == 3){
	array_push($li,$importacao);
	array_push($li,$seguradora);
}
else if($_SESSION['config']['modalidade'] == 5){
	$li = array($cadastro);
	array_push($li,$banner);
}

$novoMenu = array();
foreach($usuarioMenu as $menu2){
	foreach($li as $menu){
		if($menu['id'] == $menu2){
			array_push($novoMenu,$menu);
		}
	}
}
$page_nav += $novoMenu;
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>

?>