<?php
require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";


class PDF_Javascript extends FPDF {

    var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }
    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }
    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }
    function _putcatalog() {
        parent::_putcatalog();
        if (isset($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }
    function Header()
    {
        // Logo
        $this->Image('../img/logo3.png',1,0.5,4);
        $this->SetY(1.7);
        // Arial bold 15
        $this->SetY($this->GetY() - 1);
        $this -> SetFont('Arial','','7');
        $this -> Cell("",1,utf8_decode("GERADO POR: ".$_SESSION['imunevacinas']['usuarioNome'])." - ".date('d/m/y H:i:s'),0,1,'R');

    }
    function Footer()
    {
        //Vai para 1.5 cm da borda inferior
        $this->SetY(-7);
        //Seleciona Arial it?lico 8
        $this->SetFont('Arial','I',8);
        //Imprime o n?mero da p?gina centralizado
        $this->Cell(0,11,utf8_decode('Página ').$this->PageNo(),0,0,'C');
    }
}

class PDF_AutoPrint extends PDF_Javascript
{
    function AutoPrint($dialog=false)
    {
        //Embed some JavaScript to show the print dialog or start printing immediately
        $param=($dialog ? 'true' : 'false');
        $script="print($param);";
        $this->IncludeJS($script);
    }
}



$pdf=new PDF_AutoPrint('L','cm','A4');
$pdf->SetTitle(utf8_decode('RELATÓRIO DE COMISSÃO - FFSEGUROS'));
$pdf->Open();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    @$_SESSION['imunevacinas']['tipo']       = @$_POST['tipo'];
    @$_SESSION['imunevacinas']['condicao']       = @$_POST['condicao'];
    $_SESSION['imunevacinas']['seguradora']     = $_POST['seguradora'];
    $_SESSION['imunevacinas']['retorno']        = $_POST['retorno'];
    $_SESSION['imunevacinas']['especial']       = 2;
    $_SESSION['imunevacinas']['dt_ini']         = substr($_POST['from'],6,4)."-".substr($_POST['from'],3,2)."-".substr($_POST['from'],0,2)." 00:00:00";
    $_SESSION['imunevacinas']['dt_fim']         = substr($_POST['to'],6,4)."-".substr($_POST['to'],3,2)."-".substr($_POST['to'],0,2)." 23:59:59";
}



    $query      = "select apo2.id as apolice,apo2.tipo,apo2.pr_liquido, apo2.comissao,apo2.ram_id, apo2.n_apo, apo2.n_pro, apo2.dt_end,financeiro.dt_fat, concat(financeiro.parcela,'/',financeiro.qtd) as parcela, financeiro.dt_baixa, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, financeiro.porcentagem as repasse1, financeiro.valorbruto, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status as status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status=2  and financeiro.conciliada = 0 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id ";

if($_SESSION['imunevacinas']['tipo'] == 1){
    $query .= " and ((financeiro.status = 1 and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."') or (financeiro.status = 3 and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."') ) ";
    $title = "GERAL";
}elseif($_SESSION['imunevacinas']['tipo'] == 2){
    $title = "PENDENTES / FUTURAS";
    $query .= " and financeiro.status = 1 and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."'";
}elseif($_SESSION['imunevacinas']['tipo'] == 3){
    $title = "BAIXADAS / À PAGAR";
    $query .= " and financeiro.status = 3 and (financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."')";
}
elseif($_SESSION['imunevacinas']['tipo'] == 4){
    $title = "BAIXADAS / À PAGAR";
    $query .= " and financeiro.status = 5  and (financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."')";
};


if($_SESSION['imunevacinas']['seguradora'][0]== 999){

}else{
    $query .= " and (";
    foreach ($_SESSION['imunevacinas']['seguradora'] as $selectedOption){
        $query .= " seg_id = '".$selectedOption."' or ";
    }
    $query = substr($query,0,strlen($query)-3);
    $query .= ") ";
};


if($_SESSION['imunevacinas']['especial'] == 2){
    $order = ' seguradora';
}
$produtor = [];
if($_SESSION['imunevacinas']['retorno'] != ""){
    array_push($produtor,$_SESSION['imunevacinas']['retorno']);
}else{
    $sel = "select * from pessoa where produtor = 1 order by nome";
    $val = mysqli_query($con,$sel);
    while($rrr = mysqli_fetch_array($val)){
        array_push($produtor,$rrr['id']);
    }
}

foreach($produtor as $pid){
    $complemento = ' and pessoa.id = '.$pid.' order by '.$order.', financeiro.dt_fat asc';
    $i = 0;
    $seguradora = "";
    if($valval = mysqli_query($con,$query.$complemento)){
        $pdf->AddPage();
        $pdf ->Cell("",2.4,"",1,1,'L');
        $pdf->SetY($pdf->GetY() - 2.1);
        $pdf -> SetFont('Arial','I','12');
        $pdf -> Cell("",0.6,utf8_decode("RELATÓRIO DE COMISSÃO  -  PAGAMENTO DE COMISSÃO - ".$title." -  PERÍODO: ".substr($_SESSION['imunevacinas']['dt_ini'],8,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],5,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],0,4)." À ".substr($_SESSION['imunevacinas']['dt_fim'],8,2)."/".substr($_SESSION['imunevacinas']['dt_fim'],5,2)."/".substr($_SESSION['imunevacinas']['dt_fim'],0,4)),0,1,'C');
        $pdf -> SetFont('Arial','B','10');
        $pdf -> Cell(0.3,0.6,"",0,0,'L');

        $select = "select * from pessoa where id = ".$pid;
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida)){
            if(strlen($row['cpf']) == 11){
                $cpf = substr($row['cpf'],0,3).".".substr($row['cpf'],3,3).".".substr($row['cpf'],6,3)."-".substr($row['cpf'],9,2);
            }elseif(strlen($row['cpf']) == 14){
                $cpf = substr($row['cpf'],0,2).".".substr($row['cpf'],2,3).".".substr($row['cpf'],5,3)."/".substr($row['cpf'],8,4)."-".substr($row['cpf'],13,2);
            }
            $pdf -> Cell("",0.6,utf8_decode($row['nome'])." - CPF / CNPJ: ".$cpf,0,1,'L');
            $pdf -> Cell(0.3,0.6,"",0,0,'L');
            $pdf -> Cell("",0.6,"BANCO: ".utf8_decode($row['banco'])." - AGENCIA: ".utf8_decode($row['agencia'])." - C/C: ".utf8_decode($row['conta'])." - TITULAR: ".utf8_decode($row['titular']),0,1,'l');

        }

        if($valida = mysqli_query($con,$query.$complemento)){
            $complemento = "";
            while($row = mysqli_fetch_array($valida)){
                if($seguradora != $row['seguradora']){
                    if($i == 0){

                    }else{
                        if($_SESSION['imunevacinas']['tipo'] == 1){
                            $comipaga = utf8_decode("   COMISSÃO BAIXADA : R$ ".@number_format(@$repasse2,2,",",".")."   |   ");
                            $comipendente = utf8_decode("   COMISSÃO PENDENTE : R$ ".@number_format(@$repasse,2,",",".")."   |   ");
                        }elseif($_SESSION['imunevacinas']['tipo'] == 2){
                            $comipendente = utf8_decode("   COMISSÃO PENDENTE : R$ ".@number_format(@$repasse,2,",",".")."   |   ");
                        }
                        elseif($_SESSION['imunevacinas']['tipo'] == 3){
                            $comipaga = utf8_decode("   COMISSÃO BAIXADA : R$ ".@number_format(@$repasse2,2,",",".")."   |   ");
                        }
                        elseif($_SESSION['imunevacinas']['tipo'] == 4){

                            $comipaga = utf8_decode("   COMISSÃO PAGA : R$ ".number_format($repasse2,2,",",".")."   |   ");
                        };
                        $pdf ->Cell("",1,"   SUBTOTAL =>".@$comipendente.@$comipaga,1,1,'L');
                        $repasse = 0;
                        $repasse2 = 0;
                        $basecalculo = 0;
                    }
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,"   SEGURADORA: ".utf8_decode($row['seguradora']),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(2,0.6,utf8_decode("Nº.APO"),1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(1,0.6,"PARC.",1,0,'C',1);
                    $pdf ->Cell(2,0.6,"DT. VENC.",1,0,'C',1);
                    $pdf ->Cell(2,0.6,"DT. BAIXA",1,0,'C',1);
                    $pdf ->Cell(2,0.6,utf8_decode("LÍQUIDO"),1,0,'C',1);
                    $pdf ->Cell(1,0.6,utf8_decode("%"),1,0,'C',1);
                    $pdf ->Cell(2,0.6,utf8_decode("COM. BRUTA"),1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"TAXA",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"REPASSE",1,0,'C',1);
                    $pdf ->Cell(8.7,0.6,"SEGURADO / OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    $pdf->SetTextColor(0,0,0);
                    $pdf ->Cell(2,0.6,$row['n_apo'],1,0,'C');
                    $pdf ->Cell(1.5,0.6,$row['apolice'],1,0,'C');
                    $pdf ->Cell(1,0.6,$row['parcela'],1,0,'C');
                    $pdf ->Cell(2,0.6,substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4),1,0,'C');
                    $pdf ->Cell(2,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".@number_format($row['pr_liquido']."%",2,",","."),1,0,'C');
                    $pdf ->Cell(1,0.6,@number_format($row['comissao']."%",2,",","."),1,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".number_format($row['valorbruto'],2,",","."),1,0,'C');
                    $pdf ->Cell(1.5,0.6,$row['repasse1']."%",1,0,'C');
                    $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['valorliquido'],2,",","."),1,0,'C');
                    $pdf ->Cell(8.7,0.6,substr(utf8_decode($row['cliente']),0,42),1,0,'C');
                    $pdf -> SetFont('Arial','B','8');
                    if($row['status'] == 1){
                        $pdf->SetFillColor(255,128,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"PEND.",1,1,'C',1);
                    }
                    else if($row['status'] == 3){
                        if($row['tipo'] == 4){
                            $pdf->SetFillColor(255,115,115);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"B /CANC.",1,1,'C',1);
                        }else{
                            $pdf->SetFillColor(0,140,0);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"BAIXADA",1,1,'C',1);
                        }
                    }
                    else if($row['status'] == 5){
                        if($row['tipo'] == 4){
                            $pdf->SetFillColor(255,115,115);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"B /CANC.",1,1,'C',1);
                        }else{
                            $pdf->SetFillColor(0,140,0);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"PAGO",1,1,'C',1);
                        }
                    }
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');

                    $seguradora = $row['seguradora'];
                }else{
                    $pdf->SetTextColor(0,0,0);
                    $pdf ->Cell(2,0.6,$row['n_apo'],1,0,'C');
                    $pdf ->Cell(1.5,0.6,$row['apolice'],1,0,'C');
                    $pdf ->Cell(1,0.6,$row['parcela'],1,0,'C');
                    $pdf ->Cell(2,0.6,substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4),1,0,'C');
                    $pdf ->Cell(2,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".@number_format($row['pr_liquido']."%",2,",","."),1,0,'C');
                    $pdf ->Cell(1,0.6,@number_format($row['comissao']."%",2,",","."),1,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".number_format($row['valorbruto'],2,",","."),1,0,'C');
                    $pdf ->Cell(1.5,0.6,$row['repasse1']."%",1,0,'C');
                    $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['valorliquido'],2,",","."),1,0,'C');
                    $pdf ->Cell(8.7,0.6,substr(utf8_decode($row['cliente']),0,42),1,0,'C');
                    $pdf -> SetFont('Arial','B','8');
                    if($row['status'] == 1){
                        $pdf->SetFillColor(255,128,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"PEND.",1,1,'C',1);
                    }
                    else if($row['status'] == 3){
                        if($row['tipo'] == 4){
                            $pdf->SetFillColor(255,115,115);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"B /CANC.",1,1,'C',1);
                        }else{
                            $pdf->SetFillColor(0,140,0);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"BAIXADA",1,1,'C',1);
                        }
                    }
                    else if($row['status'] == 5){
                        if($row['tipo'] == 4){
                            $pdf->SetFillColor(255,115,115);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"B /CANC.",1,1,'C',1);
                        }else{
                            $pdf->SetFillColor(0,140,0);
                            $pdf->SetTextColor(245,245,245);
                            $pdf ->Cell(1.5,0.6,"PAGO",1,1,'C',1);
                        }
                    }
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                }
                $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '1' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                $val = mysqli_query($con,$select);
                if($rr = mysqli_fetch_array($val)){
                    $basecalculo = $rr['basecalculo'];
                    $repasse = $rr['repasse'];
                }
                if($_SESSION['imunevacinas']['tipo'] == 4){
                    $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '5' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                    $val = mysqli_query($con,$select);
                    if($rr = mysqli_fetch_array($val)){
                        $basecalculo += $rr['basecalculo'];
                        $repasse2 = $rr['repasse'];
                    }
                }else{
                    $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '3' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                    $val = mysqli_query($con,$select);
                    if($rr = mysqli_fetch_array($val)){
                        @$basecalculo += $rr['basecalculo'];
                        $repasse2 = $rr['repasse'];
                    }
                }

                if($i+1 == mysqli_num_rows($valida)){
                    $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '1' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                    $val = mysqli_query($con,$select);
                    if($rr = mysqli_fetch_array($val)){
                        $basecalculo = $rr['basecalculo'];
                        $repasse = $rr['repasse'];
                    }
                    if($_SESSION['imunevacinas']['tipo'] == 4){
                        $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '5' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                        $val = mysqli_query($con,$select);
                        if($rr = mysqli_fetch_array($val)){
                            $basecalculo += $rr['basecalculo'];
                            $repasse2 = $rr['repasse'];
                        }
                    }else{
                        $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = '3' and apo2.seg_id = ".$row['seg_id']." and financeiro.conciliada = 0 group by apo2.seg_id";
                        $val = mysqli_query($con,$select);
                        if($rr = mysqli_fetch_array($val)){
                            $basecalculo += $rr['basecalculo'];
                            $repasse2 = $rr['repasse'];
                        }
                    }
                    if($_SESSION['imunevacinas']['tipo'] == 1){
                        $comipaga = utf8_decode("   COMISSÃO BAIXADA : R$ ".number_format($repasse2,2,",",".")."   |   ");
                        $comipendente = utf8_decode("   COMISSÃO PENDENTE : R$ ".number_format($repasse,2,",",".")."   |   ");
                    }elseif($_SESSION['imunevacinas']['tipo'] == 2){
                        $comipendente = utf8_decode("   COMISSÃO PENDENTE : R$ ".number_format($repasse,2,",",".")."   |   ");
                    }
                    elseif($_SESSION['imunevacinas']['tipo'] == 3){
                        $comipaga = utf8_decode("   COMISSÃO BAIXADA : R$ ".number_format($repasse2,2,",",".")."   |   ");
                    }
                    elseif($_SESSION['imunevacinas']['tipo'] == 4){
                        $comipaga = utf8_decode("   COMISSÃO PAGA : R$ ".number_format($repasse2,2,",",".")."   |   ");
                    };
                    $pdf ->Cell("",1,"   SUBTOTAL =>".@$comipendente.@$comipaga,1,1,'L');
                    $repasse = 0;
                    $repasse2 = 0;
                    $basecalculo = 0;
                }
                $i++;
            };
            if($_SESSION['imunevacinas']['tipo'] != 4){
                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   ADIANTAMENTO DE COMISSÃO"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse']*(-1),2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(217,0,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"DESC.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }

                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   DESCONTO DE COMISSÃO"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse'],2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(217,0,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"DESC.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }

                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   PREMIAÇÕES"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse'],2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(0,0,217);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"PREM.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }
            }else{
                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 1 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   ADIANTAMENTO DE COMISSÃO"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse']*(-1),2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(217,0,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"DESC.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }

                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 1 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   DESCONTO DE COMISSÃO"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse'],2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(217,0,0);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"DESC.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }

                $select = "	select financeiro.valorliquido as repasse, dt_baixa, dt_emi, id, obs, status from financeiro where  financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 5 and financeiro.ap = 2 order by id";
                $valida = mysqli_query($con,$select);
                if(mysqli_num_rows($valida) > 0){
                    $pdf->SetY($pdf->GetY() +0.3);
                    $pdf -> SetFont('Arial','B','10');
                    $pdf ->Cell("",0.7,utf8_decode("   PREMIAÇÕES"),1,1,'L');
                    $pdf -> SetFont('Arial','B','8');
                    $pdf->SetFillColor(26,96,175);
                    $pdf->SetTextColor(245,245,245);
                    $pdf ->Cell(1.5,0.6,utf8_decode("CÓD INT."),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,utf8_decode("DT. EMISSÃO"),1,0,'C',1);
                    $pdf ->Cell(3.5,0.6,"DT. PAGAMENTO",1,0,'C',1);
                    $pdf ->Cell(2.5,0.6,"VALOR",1,0,'C',1);
                    $pdf ->Cell(15.2,0.6,"OBS",1,0,'C',1);
                    $pdf ->Cell(1.5,0.6,"STATUS",1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf -> SetFont('Arial','','8');
                    while($row = mysqli_fetch_array($valida)){
                        $pdf ->Cell(1.5,0.6,$row['id'],1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4),1,0,'C');
                        $pdf ->Cell(3.5,0.6,substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4),1,0,'C');
                        $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['repasse'],2,",","."),1,0,'C');
                        $pdf ->Cell(15.2,0.6,substr($row['obs'],0,115),1,0,'C');
                        $pdf -> SetFont('Arial','B','8');
                        $pdf->SetFillColor(0,0,217);
                        $pdf->SetTextColor(245,245,245);
                        $pdf ->Cell(1.5,0.6,"PREM.",1,1,'C',1);
                        $pdf->SetTextColor(0,0,0);
                        $pdf -> SetFont('Arial','','8');
                    }
                }
            }
        }

        if($_SESSION['imunevacinas']['tipo'] != 4){
            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."'";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $base = $rr['basecalculo'];
                $rep = $rr['repasse'];
            }
            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 1";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $pendente = $rr['repasse'];
            }

            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $paga = $rr['repasse'];
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $adiantamento = $rr['repasse']*(-1);
            }

            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $desconto = $rr['repasse'];
            }


            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $premiacao = $rr['repasse'];
            }

            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_baixa, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00"."' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.conciliada = 0 and financeiro.status = 3";

            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $pagaant = $rr['repasse'];
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $descontoant = $rr['repasse'];
            }

            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $adiantamentoant = $rr['repasse']*(-1);
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $premiacaoant = $rr['repasse'];
            }
            $saldoant = @$pagaant + @$adiantamentoant + @$premiacaoant + @$descontoant;
            if($saldoant >= 0){
                $saldoant = 0;
            }
            $pdf -> SetFont('Arial','B','9');
            $pdf->SetFillColor(203,231,255);
            $pdf ->Cell("",0.7,"",0,1,'L');
            $pdf ->Cell(8,0.8,utf8_decode("   SALDO ANTERIOR: R$ ".number_format($saldoant,2,",",".")),0,0,'L',1);
            $pdf -> SetFont('Arial','','7');
            $pdf ->Cell("",0.8,utf8_decode("saldo anterior = total pago anterior - adiantamentos e descontos anteriores + premiações anteriores (caso exista comissões pendentes, elas não são inclusas no saldo anterior)."),0,1,'L',1);


            if($_SESSION['imunevacinas']['tipo']==1 || $_SESSION['imunevacinas']['tipo']==2){
                $tpendent = "   T. PENDENTE: R$".number_format($pendente,2,",",".")."   |";
            };
            $pdf -> SetFont('Arial','B','8');
            $pdf ->Cell("",0.8,"   TOTAL =>".@$tpendent."   T. BAIXADO: R$ ".number_format($paga,2,",",".")."   |   T. ADIANTAMENTO: R$ ".number_format($adiantamento,2,",",".").utf8_decode("   |   T. DESCONTOS: R$ ").number_format($desconto,2,",",".").utf8_decode("   |   T. PREMIAÇÃO: R$ ").number_format($premiacao,2,",","."),0,1,'L',1);

            if($_SESSION['imunevacinas']['tipo']==1 || $_SESSION['imunevacinas']['tipo']==2){
                $pdf ->Cell(10,0.8,utf8_decode("   SALDO APROVISIONADO: R$ ".number_format($pendente+$paga+$adiantamento+$premiacao+$desconto,2,",",".")),0,0,'L',1);
                $pdf -> SetFont('Arial','','7');
                $pdf ->Cell("",0.8,utf8_decode("saldo aprovisionado = saldo anterior + (comissao total - adiantamentos e descontos + premiações)"),0,1,'L',1);
            };

            $pdf -> SetFont('Arial','B','9');
            $pdf ->Cell(10,0.8,utf8_decode("   SALDO ATUAL: R$ ".number_format($saldoant+$paga+$adiantamento+$premiacao+$desconto,2,",",".")),0,0,'L',1);
            $pdf -> SetFont('Arial','','7');
            $pdf ->Cell("",0.8,utf8_decode("saldo real = saldo anterior + (total pago - adiantamentos e descontos + premiacões)"),0,1,'L',1);

        }else{
            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 5";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $base = $rr['basecalculo'];
                $rep = $rr['repasse'];
            }


            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_fat, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 5";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $paga = $rr['repasse'];
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 1";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $adiantamento = $rr['repasse']*(-1);
            }

            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 3 and financeiro.conciliada = 1";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $desconto = $rr['repasse'];
            }


            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' and financeiro.status = 5 and financeiro.ap = 2";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $premiacao = $rr['repasse'];
            }

            $select = "	select sum(apo2.comissao_bruta) as basecalculo, sum(financeiro.valorliquido) as repasse,apo2.id as apolice, apo2.ram_id, apo2.n_apo, apo2.n_pro, financeiro.dt_baixa, apo2.seg_id as seg_id, apo2.cli_id as cli_id, (select pessoa.nome from pessoa,apolice as apo3 where apo3.cli_id = pessoa.id and apo3.id = apo2.id) as cliente,(select pessoa.nome from pessoa,apolice as apo where apo.seg_id = pessoa.id and apo2.id = apo.id) as seguradora, apo2.comissao_bruta, pessoa.repasse1, financeiro.valorliquido, pessoa.nome as produtor, pessoa.cpf as cpf, financeiro.status, pessoa.titular, pessoa.banco, pessoa.agencia, pessoa.conta from financeiro, apolice as apo2,pessoa where apo2.status = 2 and apo2.id = financeiro.apo_id and pessoa.id = financeiro.pes_id and pessoa.id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00"."' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $pagaant = $rr['repasse'];
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $descontoant = $rr['repasse'];
            }

            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 3 and financeiro.conciliada = 0";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $adiantamentoant = $rr['repasse']*(-1);
            }
            $select = "	select sum(financeiro.valorliquido) as repasse from financeiro where financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$pid."' and financeiro.dt_baixa between '2006-01-01 00:00:00' and '".$_SESSION['imunevacinas']['dt_ini']."' and financeiro.status = 5 and financeiro.ap = 2";
            $val = mysqli_query($con,$select);
            if($rr = mysqli_fetch_array($val)){
                $premiacaoant = $rr['repasse'];
            }
            $saldoant = $pagaant + $adiantamentoant + $premiacaoant + $descontoant;
            if($saldoant >= 0){
                $saldoant = 0;
            }
            $pdf -> SetFont('Arial','B','9');
            $pdf->SetFillColor(203,231,255);
            $pdf ->Cell("",0.7,"",0,1,'L');

            $pdf -> SetFont('Arial','B','8');
            $pdf ->Cell("",0.8,"   TOTAL =>".@$tpendent."   T. PAGO: R$ ".number_format($paga,2,",",".")."   |   T. ADIANTAMENTO: R$ ".number_format($adiantamento,2,",",".").utf8_decode("   |   T. DESCONTOS: R$ ").number_format($desconto,2,",",".").utf8_decode("   |   T. PREMIAÇÃO: R$ ").number_format($premiacao,2,",","."),0,1,'L',1);
            $pdf -> SetFont('Arial','B','9');
            $pdf ->Cell(10,0.8,utf8_decode("   TOTAL PAGO: R$ ".number_format($saldoant+$paga+$adiantamento+$premiacao+$desconto,2,",",".")),0,0,'L',1);
            $pdf -> SetFont('Arial','','7');
            $pdf ->Cell("",0.8,"",0,1,'L',1);

            if($_SESSION['imunevacinas']['tipo']==1 || $_SESSION['imunevacinas']['tipo']==2){
                $pdf ->Cell(10,0.8,utf8_decode("   SALDO APROVISIONADO: R$ ".number_format($pendente+$paga+$adiantamento+$premiacao+$desconto,2,",",".")),0,0,'L',1);
                $pdf -> SetFont('Arial','','7');
                $pdf ->Cell("",0.8,utf8_decode("saldo aprovisionado = saldo anterior + (comissao total - adiantamentos e descontos + premiações)"),0,1,'L',1);
            };
        }
        /*if(mysqli_num_rows($valval) != 0){

        }else{

        }*/
    }
}

$pdf -> Output('Comissao'.date("d-m-Y").'.pdf','I');



?>