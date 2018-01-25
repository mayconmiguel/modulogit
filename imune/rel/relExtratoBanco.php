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


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION['imunevacinas']['relFrom']        = $_POST['from'];
    $_SESSION['imunevacinas']['relTo']          = $_POST['to'];
    $_SESSION['imunevacinas']['relEmpresa']     = @$_POST['empresa'];
    $_SESSION['imunevacinas']['relBanco']       = @$_POST['banco'];
    $_SESSION['imunevacinas']['dt_ini']         = substr($_SESSION['imunevacinas']['relFrom'],6,4)."-".substr($_SESSION['imunevacinas']['relFrom'],3,2)."-".substr($_SESSION['imunevacinas']['relFrom'],0,2)." 00:00:00";
    $_SESSION['imunevacinas']['dt_fim']       = substr($_SESSION['imunevacinas']['relTo'],6,4)."-".substr($_SESSION['imunevacinas']['relTo'],3,2)."-".substr($_SESSION['imunevacinas']['relTo'],0,2)." 23:59:59";
    $i              = 0;

}

$query = "select f.id,f.dt_emi,f.dt_fat,f.dt_baixa,f.dt_atu,f.qtd,f.parcela,concat(f.boleto,'',f.cheque) as numero,f.ban_id,f.valorbruto,f.jurosper,f.jurosreal,f.descper,f.descreal,f.valorliquido,f.obs,concat(banco.cod,' - ',banco.banco) as banco, banco.agencia, banco.conta, empresa.razao as empresa, pessoa.nome as pessoa, centrocusto.nome as centrocusto, natureza.nome as natureza, pagamento.nome as pagamento, f.obs, f.status from financeiro as f, empresa, pessoa,banco,pagamento,centrocusto,natureza where f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and  f.pes_id = pessoa.id and f.emp_id = empresa.id and f.ban_id = banco.id and f.cen_id = centrocusto.id and f.nat_id = natureza.id and f.pag_id = pagamento.id and f.conciliada = 1 and f.valorliquido > 0 and f.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."'";



//totalizadores

$total = $debitoTotal = $creditoTotal = $saldoAnteriorTotal = 0;
$totalCampo = $debitoCampo = $creditoCampo = 0;


$pdf=new PDF_AutoPrint('L','cm','A4');
$pdf->SetTitle(utf8_decode('RELATÓRIO FINANCEIRO - EXTRATO BANCÁRIO '));
$pdf->Open();

if(isset($_SESSION['imunevacinas']['relEmpresa'])){
    $empresa = $_SESSION['imunevacinas']['relEmpresa'];
    $query .= "and (";
    foreach($empresa as $emp){
        $query .= " f.emp_id = $emp or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};
if(isset($_SESSION['imunevacinas']['relBanco'])){
    $banco = $_SESSION['imunevacinas']['relBanco'];
    $query .= "and (";
    foreach($banco as $ban){
        $query .= " f.ban_id = $ban or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};



$query .= " order by banco asc, f.dt_baixa";
$titulo = "BANCO";
$campo  = 'banco';


$i = 0;
$ordenador = "";

$valida = mysqli_query($con,$query);
if(mysqli_num_rows($valida) > 0){
    while($row = mysqli_fetch_array($valida)){



        if($i == 0){
            $pdf->AddPage();
            $pdf ->Cell("",1,"",1,1,'L');
            $pdf->SetY($pdf->GetY() - 0.8);
            $pdf -> SetFont('Arial','I','12');
            $pdf -> Cell("",0.6,utf8_decode("RELATÓRIO FINANCEIRO - EXTRATO BANCÁRIO - PERÍODO: ".$_SESSION['imunevacinas']['relFrom']." À ".$_SESSION['imunevacinas']['relTo']),0,1,'C');
            $pdf -> SetFont('Arial','B','10');
            $pdf -> Cell(0.3,0.6,"",0,0,'L');
        }else{

        };
        if($ordenador != $row[$campo]){
            if($i == 0){

            }else{
                $saldoAnterior = $creditoAnterior - $debitoAnterior;
                $saldoAnteriorTotal += $saldoAnterior;
                $totalCampo = $saldoAnterior -($debitoCampo - $creditoCampo);
                $pdf -> SetFont('Arial','','8');
                $pdf ->Cell("",1,"",1,1,'C');
                $pdf ->SetY($pdf->GetY() - 0.8);
                $pdf->SetTextColor(2,2,152);
                $pdf ->Cell(3,0.6,"",0,0,'C');
                $pdf ->Cell(5.5,0.6,"SALDO ANTERIOR R$ ".number_format($saldoAnterior,2,",","."),0,0,'C');
                $pdf->SetTextColor(152,2,2);
                $pdf ->Cell(5.5,0.6,utf8_decode("DÉBITO(S): R$ ").number_format($debitoCampo,2,",","."),0,0,'C');
                $pdf->SetTextColor(2,92,2);
                $pdf ->Cell(5,0.6,utf8_decode("CRÉDITO(S): R$ ").number_format($creditoCampo,2,",","."),0,0,'C');
                if($totalCampo >= 0){
                    $pdf->SetTextColor(2,92,2);
                }else{
                    $pdf->SetTextColor(152,2,2);
                }
                $pdf ->Cell(5.5,0.6,"SALDO ATUAL: R$ ".number_format($totalCampo,2,",","."),0,0,'C');
                $pdf ->SetY($pdf->GetY() + 0.2);
                $pdf->SetTextColor(0,0,0);
                $totalCampo = $debitoCampo = $creditoCampo = $creditoAnterior = $debitoAnterior = $saldoAnterior = 0;
            }
            $pdf->SetY($pdf->GetY() +1);
            $pdf -> SetFont('Arial','B','10');
            if($campo == 'dt_fat' || $campo == 'dt_baixa'){
                $pdf ->Cell("",0.7,"   ".$titulo.": ".substr($row[$campo],8,2)."/".substr($row[$campo],5,2)."/".substr($row[$campo],0,4),1,1,'L');
            }else{
                $pdf ->Cell("",0.7,"   ".$titulo.": ".$row[$campo]."   |   AGENCIA: ".$row['agencia']."   |   CONTA: ".$row['conta'],1,1,'L');
            }
            $pdf -> SetFont('Arial','B','7');
            $pdf->SetFillColor(26,96,175);
            $pdf->SetTextColor(245,245,245);
            $pdf ->Cell(1,0.6,utf8_decode("Nº"),1,0,'C',1);
            $pdf ->Cell(1.5,0.6,utf8_decode("DATA"),1,0,'C',1);
            $pdf ->Cell(5,0.6,utf8_decode("NOME"),1,0,'C',1);
            $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
            $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
            $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            $pdf ->Cell(10,0.6,utf8_decode("OBS"),1,0,'C',1);
            $pdf ->Cell(1.9,0.6,utf8_decode("LÍQD."),1,0,'C',1);
            $pdf ->Cell(0.8,0.6,utf8_decode("C / D"),1,1,'C',1);


            // inserindo saldo anterior como primeiro item do detalhamento
            $cred = "select sum(valorliquido) as creditoAnterior from financeiro as f where  f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and f.ban_id = '".$row['ban_id']."' and f.conciliada = 1 and f.valorliquido > 0 and f.dt_baixa <  '".$_SESSION['imunevacinas']['dt_ini']."' and f.status = 4";
            $deb  = "select sum(valorliquido) as debitoAnterior from financeiro as f where f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and  f.ban_id = '".$row['ban_id']."' and f.conciliada = 1 and f.valorliquido > 0 and f.dt_baixa < '".$_SESSION['imunevacinas']['dt_ini']."' and f.status = 3";

            $valcred = mysqli_query($con,$cred);
            if($rcred = mysqli_fetch_array($valcred)){
                $creditoAnterior = $rcred['creditoAnterior'];
                $creditoAnteriorTotal = $rcred['creditoAnterior'];
            };

            $valdeb = mysqli_query($con,$deb);
            if($rdeb = mysqli_fetch_array($valdeb)){
                $debitoAnterior = $rdeb['debitoAnterior'];
                $debitoAnteriorTotal = $rdeb['debitoAnterior'];
            };
            $saldoAnterior = $creditoAnterior - $debitoAnterior;
            $pdf->SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','','7');
            $pdf ->Cell(1,0.6,"",1,0,'C');
            $pdf ->Cell(1.5,0.6,utf8_decode(substr($_SESSION['imunevacinas']['dt_ini'],8,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],5,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],0,4)),1,0,'C');
            $pdf ->Cell(5,0.6,"",1,0,'C');
            $pdf ->Cell(2.5,0.6,"",1,0,'C');
            $pdf ->Cell(2.5,0.6,"",1,0,'C');
            $pdf ->Cell(2.5,0.6,"",1,0,'C');
            $pdf ->Cell(10,0.6,"SALDO ANTERIOR",1,0,'C');
            if($saldoAnterior < 0){
                $pdf->SetTextColor(152,2,2);
                $valor = $saldoAnterior;
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'D';
                $pdf->SetFillColor(152,0,1);
            }else{
                $pdf->SetTextColor(2,92,2);
                $valor = $saldoAnterior;
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'C';
                $pdf->SetFillColor(0,92,1);
            };
            $pdf->SetTextColor(245,245,245);
            $pdf ->Cell(0.8,0.6,$status,1,1,'C',1);
            $pdf->SetTextColor(0,0,0);

            //DADOS RECUPERADOS DO BANCO DE DADOS
            $pdf->SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','','6.7');
            $pdf ->Cell(1,0.6,utf8_decode($row['id']),1,0,'C');
            $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
            $pdf ->Cell(5,0.6,substr(explode("-",$row['pessoa'])[0],0,30),1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,15).".",1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,15).".",1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,15).".",1,0,'C');
            $pdf ->Cell(10,0.6,substr($row['obs'],0,80)."...",1,0,'C');
            if($row['status'] == 3){
                $pdf->SetTextColor(152,2,2);
                $valor = $row['valorliquido']*(-1);
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'D';
                $pdf->SetFillColor(152,0,1);
            }else{
                $pdf->SetTextColor(2,92,2);
                $valor = $row['valorliquido'];
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'C';
                $pdf->SetFillColor(0,92,1);
            };
            $pdf->SetTextColor(245,245,245);
            $pdf ->Cell(0.8,0.6,$status,1,1,'C',1);
            $pdf->SetTextColor(0,0,0);
            $ordenador = $row[$campo];
        }else{


            //DADOS RECUPERADOS DO BANCO DE DADOS
            $pdf->SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','','6.7');
            $pdf ->Cell(1,0.6,utf8_decode($row['id']),1,0,'C');
            $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
            $pdf ->Cell(5,0.6,substr(explode("-",$row['pessoa'])[0],0,30),1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,15).".",1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,15).".",1,0,'C');
            $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,15).".",1,0,'C');
            $pdf ->Cell(10,0.6,substr($row['obs'],0,80)."...",1,0,'C');
            if($row['status'] == 3){
                $pdf->SetTextColor(152,2,2);
                $valor = $row['valorliquido']*(-1);
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'D';
                $pdf->SetFillColor(152,0,1);
            }else{
                $pdf->SetTextColor(2,92,2);
                $valor = $row['valorliquido'];
                $pdf ->Cell(1.9,0.6,"R$ ".number_format($valor,2,',','.'),1,0,'C');
                $status = 'C';
                $pdf->SetFillColor(0,92,1);
            };
            $pdf->SetTextColor(245,245,245);
            $pdf ->Cell(0.8,0.6,$status,1,1,'C',1);
            $pdf->SetTextColor(0,0,0);
        }
        if($row['status'] == 3){
            $debitoCampo += $row['valorliquido'];
            $debitoTotal += $row['valorliquido'];
        }else if($row['status'] == 4){
            $creditoCampo += $row['valorliquido'];
            $creditoTotal += $row['valorliquido'];
        };

        $cred = "select sum(valorliquido) as creditoAnterior from financeiro as f where f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and   f.ban_id = '".$row['ban_id']."' and f.conciliada = 1 and f.valorliquido > 0 and f.dt_baixa <  '".$_SESSION['imunevacinas']['dt_ini']."' and f.status = 4";
        $deb  = "select sum(valorliquido) as debitoAnterior from financeiro as f where f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and   f.ban_id = '".$row['ban_id']."' and f.conciliada = 1 and f.valorliquido > 0 and f.dt_baixa < '".$_SESSION['imunevacinas']['dt_ini']."' and f.status = 3";
        $valcred = mysqli_query($con,$cred);
        if($rcred = mysqli_fetch_array($valcred)){
            $creditoAnterior = $rcred['creditoAnterior'];
            $creditoAnteriorTotal = $rcred['creditoAnterior'];
        };

        $valdeb = mysqli_query($con,$deb);
        if($rdeb = mysqli_fetch_array($valdeb)){
            $debitoAnterior = $rdeb['debitoAnterior'];
            $debitoAnteriorTotal = $rdeb['debitoAnterior'];
        };

        if($i+1 == mysqli_num_rows($valida)){
            $saldoAnterior = $creditoAnterior - $debitoAnterior;
            $saldoAnteriorTotal += $saldoAnterior;
            $totalCampo = $saldoAnterior -($debitoCampo - $creditoCampo);
            $pdf -> SetFont('Arial','','8');
            $pdf ->Cell("",1,"",1,1,'C');
            $pdf ->SetY($pdf->GetY() - 0.8);
            $pdf->SetTextColor(2,2,152);
            $pdf ->Cell(3,0.6,"",0,0,'C');
            $pdf ->Cell(5.5,0.6,"SALDO ANTERIOR R$ ".number_format($saldoAnterior,2,",","."),0,0,'C');
            $pdf->SetTextColor(152,2,2);
            $pdf ->Cell(5.5,0.6,utf8_decode("DÉBITO(S): R$ ").number_format($debitoCampo,2,",","."),0,0,'C');
            $pdf->SetTextColor(2,92,2);
            $pdf ->Cell(5,0.6,utf8_decode("CRÉDITO(S): R$ ").number_format($creditoCampo,2,",","."),0,0,'C');
            if($totalCampo >= 0){
                $pdf->SetTextColor(2,92,2);
            }else{
                $pdf->SetTextColor(152,2,2);
            }
            $pdf ->Cell(5.5,0.6,"SALDO ATUAL: R$ ".number_format($totalCampo,2,",","."),0,0,'C');
            $pdf ->SetY($pdf->GetY() + 0.2);
            $pdf->SetTextColor(0,0,0);
            $totalCampo = $debitoCampo = $creditoCampo = $creditoAnterior = $debitoAnterior = $saldoAnterior = 0;
        }
        $i++;
    };
    $total = $saldoAnteriorTotal - ($debitoTotal - $creditoTotal);
    $pdf->SetFillColor(230,230,230);
    $pdf -> SetFont('Arial','B','10');
    $pdf ->Cell("",1,"",0,1,'C');
    $pdf ->Cell("",1,"",1,1,'C',1);
    $pdf ->SetY($pdf->GetY() - 0.8);
    $pdf->SetTextColor(2,2,152);
    $pdf ->Cell(3,0.6,"",0,0,'C');
    $pdf ->Cell(5.5,0.6,"SALDO ANTERIOR R$ ".number_format($saldoAnteriorTotal,2,",","."),0,0,'C');
    $pdf->SetTextColor(152,2,2);
    $pdf ->Cell(5.5,0.6,utf8_decode("DÉBITO(S): R$ ").number_format($debitoTotal,2,",","."),0,0,'C');
    $pdf->SetTextColor(2,92,2);
    $pdf ->Cell(5,0.6,utf8_decode("CRÉDITO(S): R$ ").number_format($creditoTotal,2,",","."),0,0,'C');
    if($total >= 0){
        $pdf->SetTextColor(2,92,2);
    }else{
        $pdf->SetTextColor(152,2,2);
    }
    $pdf ->Cell(5.5,0.6,"SALDO ATUAL: R$ ".number_format($total,2,",","."),0,0,'C');
    $pdf->SetTextColor(0,0,0);
    $pdf ->SetY($pdf->GetY() + 0.2);
}else{
    ?>
    <script>
        alert("<?php echo 'Nenhuma informação encontrada!';?>");
        window.close();
    </script>
    <?php
}

$pdf -> Output('Financeiro'.date("d-m-Y").'.pdf','I');


?>